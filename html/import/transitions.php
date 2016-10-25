<?php
require_once($_SERVER['DOCUMENT_ROOT']."/includes/listotherbd.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/levellist.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/transitionlist.php");
set_time_limit(0);

$main_id = new Listotherbd();
function number_to_roman($value){
	if($value < 0) return "";
	if(!$value) return "0";
	$thousands = (int)($value / 1000);
	$value -= $thousands * 1000;
	$result = str_repeat("M", $thousands);
	$table = array(
		900 => "CM", 500 => "D", 400 => "CD", 100 => "C",
		90 => "XC", 50 => "L", 40 => "XL", 10 => "X",
		9 => "IX", 5 => "V", 4 => "IV", 1 => "I");
	while($value) {
		foreach($table as $part => $fragment) if($part <= $value) break;
		$amount = (int)($value/$part);
		$value -= $part*$amount;
		$result .= str_repeat($fragment,$amount);
	}
	return $result;
}

function curl_import_lines_nist($element){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://physics.nist.gov/cgi-bin/ASD/lines1.pl");
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
	curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'spectra='.$element.'&encodedlist=XXT1XXR0q0qVqVIII&show_obs_wl=1&show_calc_wl=1&show_av=2&f_out=on&intens_out=on&allowed_out=1&forbid_out=1&enrg_out=on&J_out=on&conf_out=on&term_out=on&submit=Retrieve+Data');
	// curl_setopt($ch, CURLOPT_POSTFIELDS, 'spectra='.$element.'&encodedlist=XXT1XXR0q0qVqVIII&unit=0&line_out=0&order_out=0&bibrefs=0&show_obs_wl=1&show_calc_wl=1&show_av=2&A_out=0&f_out=1&intens_out=1&allowed_out=1&forbid_out=1&enrg_out=1&submit=Retrieve%20Data');
	$html = curl_exec($ch);
	curl_close($ch);
	return ($html);
}

function journal($content, $id_atom, $source, $type){
	if(isset($content)){
		$newhash = crc32($content);
	// $newhash = md5_file($content);
		$oldhash = new Listotherbd();
		$oldhash->LoadJournal($newhash, $id_atom, $source, $type);
		$oldhash = $oldhash->GetItemsArray();

		$test = (isset($oldhash) ? $oldhash[0]['HASH'] : NULL);
		if(isset($test)){
			return (true);
		}
		$hash = new Listotherbd();
		$hash->CreateJournal($newhash, $type, $source, $id_atom);
		return (false);
	}else{
		$oldhash = new Listotherbd();
		$oldhash->LoadJournal(NULL, $id_atom, $source, $type);
		$oldhash = $oldhash->GetItemsArray();

		$test = ($oldhash[0]['HASH'] == NULL ? false : true);
		return $test;
	}
}

function parsing_lines($html){
	preg_match_all("|<table bgcolor=\"#FFFEEE\" border=\"1\" frame=\"box\" rules=\"groups\" cellspacing=\"0\" cellpadding=\"1\">(.*)</tbody>.</table>|is", $html, $matches); 
	$patterns = array();
	$replacements = array(); 
	$patterns[] = '/<table[^>]*>/is';
	$patterns[] = '/<\/table>/is';    
	$patterns[] = '/<tbody>[\n]<tr valign="baseline" bgcolor="#177A9C">(?U).*<\/tbody>/is';
	$patterns[] = '/<colgroup[^>]*>/is';   
	$patterns[] = '/<[\/]?tbody[^>]*>/is';
	$replacements[] = '<root>';
	$replacements[] = '</root>';	
	$html = $matches[0][0];
	$text = preg_replace($patterns, $replacements, $html);

	unset($patterns);
	unset($replacements);

	$patterns = array();
	$patterns[] = '/<td[^>]*>/is';
	$patterns[] = '/<tr[^>]*>/is';
	$patterns[] = '/<\/tr>/is';
	$patterns[] = '/<sup>([^<]*)<\/sup>\/<sub>([^<]*)<\/sub>/is';
	$patterns[] = '/<sup>([^<]*)<\/sup>/is';
	$patterns[] = '/<sub>([^<]*)<\/sub>/is';	
	$patterns[] = '/&deg;/s';

	$patterns[] = '/<a(.*?)>(.*?)<\/a>/is';		
	$patterns[] = '/(<br>)/is';

	$patterns[] = '/<font[^>]*>/is';
	$patterns[] = '/<\/font>/is';
	$patterns[] = '/<i[^>]*>/is';
	$patterns[] = '/<\/i>/is';
	$patterns[] = '/<b[^>]*>/is';
	$patterns[] = '/<\/b>/is';	
	$patterns[] = '/&nbsp;/is';
	$patterns[] = '/\s/is';
	// $patterns[] = '/,/is';
	$patterns[] = '/(<transition>[<td><\/td>\s?]*<\/transition>)/is';
	$patterns[] = '/\.(?!\d)/';

	$replacements = array();
	$replacements[] = '<td>';
	$replacements[] = '<transition>';
	$replacements[] = '</transition>';
	$replacements[] = '$1/$2';
	$replacements[] = '@{$1}';
	$replacements[] = '~{$1}';
	$replacements[] = '#';
	$replacements[] = '$2';

	$output_text = preg_replace($patterns, $replacements, $text);
	return $output_text;
}

function xml_object($content, $type = NULL){
	$output_handle = "file/tmp_file.xml";
	$fp = fopen($output_handle, "w");
	fwrite($fp, $content);
	fclose($fp);

	$xml_object = simplexml_load_file($output_handle);
	$xml = $xml_object->$type;
	return $xml;
}

function lines_nist($xml_transitions){
	$i = 0;
	foreach ($xml_transitions as $xml_transition){
		// if(isset($xml_transition->td[9], $xml_transition->td[10], $xml_transition->td[11], $xml_transition->td[12], $xml_transition->td[13], $xml_transition->td[14]))
		// {
		$transition_list[$i]['ID'] = $i;		

		if ((string)$xml_transition->td[0] != "")	$transition_list[$i]['WAVELENGTH'] = (string)$xml_transition->td[0];		
		else $transition_list[$i]['WAVELENGTH'] = (string)($xml_transition->td[1]);

		$transition_list[$i]['INTENSITY'] = (string)$xml_transition->td[2];
		$transition_list[$i]['INTENSITY'] = preg_replace("/[^0-9]/", '', $transition_list[$i]['INTENSITY']);

		if ((string)$xml_transition->td[3] != ""){
			$transition_list[$i]['PROBABILITY'] = (float)$xml_transition->td[3];
		} else $transition_list[$i]['PROBABILITY'] = NULL;

		if ((string)$xml_transition->td[4] != ""){
			$transition_list[$i]['OSCILLATOR_F'] = (float)$xml_transition->td[4];
		} else $transition_list[$i]['OSCILLATOR_F'] = NULL;

		$transition_list[$i]['LOWER_LEVEL_ENERGY'] = (float)$xml_transition->td[6];	

		$transition_list[$i]['UPPER_LEVEL_ENERGY'] = (float)$xml_transition->td[8];


		/***********************************************************/
		$level_term = (string)$xml_transition->td[10];
		$level_term = preg_replace('/\@{/i', '%', $level_term);
		$level_term = preg_replace('/}/i', '%',    $level_term);			

		if (preg_match('/#/', $level_term)){
			$level_term = preg_replace('/#/', '',   $level_term);
			$level_term_multiply = 1; 
		}else $level_term_multiply = 0;	

		$level_term_array = preg_split("/%/", $level_term);	

		$transition_list[$i]["LOWER_LEVEL_TERMPREFIX"]     = (int)$level_term_array[1];
		$transition_list[$i]["LOWER_LEVEL_TERMFIRSTPART"]   = (string)$level_term_array[2];
		$transition_list[$i]["LOWER_LEVEL_TERMSECONDPART"]  = (string)$level_term_array[0];		
		$transition_list[$i]["LOWER_LEVEL_TERMMULTIPLY"]    = (int)$level_term_multiply;	

		$level_term = (string)$xml_transition->td[13];
		$level_term = preg_replace('/\@{/i', '%', $level_term);
		$level_term = preg_replace('/}/i', '%',    $level_term);			

		if (preg_match('/#/', $level_term)){
			$level_term = preg_replace('/#/', '',   $level_term);
			$level_term_multiply = 1; 
		} else $level_term_multiply = 0;

		unset($level_term_array);	

		$level_term_array = preg_split("/%/", $level_term);	

		$transition_list[$i]["UPPER_LEVEL_TERMPREFIX"]     = (int)$level_term_array[1];
		$transition_list[$i]["UPPER_LEVEL_TERMFIRSTPART"]   = (string)$level_term_array[2];
		$transition_list[$i]["UPPER_LEVEL_TERMSECONDPART"]  = (string)$level_term_array[0];		
		$transition_list[$i]["UPPER_LEVEL_TERMMULTIPLY"]    = (int)$level_term_multiply;	
		/***********************************************************/

		$transition_list[$i]['LOWER_LEVEL_CONFIG'] = (string)$xml_transition->td[9];
		$transition_list[$i]['UPPER_LEVEL_CONFIG'] = (string)$xml_transition->td[12];

		$transition_list[$i]['LOWER_LEVEL_J'] = (string)$xml_transition->td[11];
		$transition_list[$i]['UPPER_LEVEL_J'] = (string)$xml_transition->td[14];
		$transition_list[$i]['SOURCE_BD'] = 'NIST';

		$llj = preg_split("/,/", $transition_list[$i]['LOWER_LEVEL_J']);
		$ulj = preg_split("/,/", $transition_list[$i]['UPPER_LEVEL_J']);
		if(count($llj) > 1 or count($ulj) > 1){
			$double_source_transition = $transition_list[$i];
			foreach ($llj as $j1) {
				foreach ($ulj as $j2) {
					$transition_list[$i] = $double_source_transition;
					$transition_list[$i]['LOWER_LEVEL_J'] = $j1;
					$transition_list[$i]['UPPER_LEVEL_J'] = $j2;
					$i++;
				}
			}
		}else{
			$i++;
		}

	}
	// }
	return $transition_list;
}

function testLinesNIST($new_lines, $id_element, $source){
	$lines = new Listotherbd();
	$lines->LoadLinesNIST($id_element, $source);
	$lines = $lines->GetItemsArray();
	if(empty($lines)){
		return $new_lines;
	}
	$test = 0;
	foreach ($new_lines as $new_line) {
		$new_w = $new_line['WAVELENGTH'];
		$new_i = $new_line['INTENSITY'];
		$new_a = $new_line['PROBABILITY'];
		$new_f = $new_line['OSCILLATOR_F'];
		foreach ($lines as $line){
			$w = $line['WAVELENGTH'];
			$i = $line['INTENSITY'];
			$a = $line['PROBABILITY'];
			$f = $line['OSCILLATOR_F'];
			if($w == $new_w and $i == $new_i and $a == $new_a and $f == $new_f){
				$test = 1;
			}
		}
		if($test == 0){
			$peeled[] = $new_line;
		}
		$test = 0;

	}
	return $peeled;
}

function LoadLines($lines_list, $id_source){
	$lines = new Listotherbd();
	$lines->CreateLines($lines_list, $id_source);
	$lines_list = $lines->GetItemsArray();
	return $lines_list;;
}

function quantum_numbers($array){
	$config = $array['LOWER_CONFIG'];
	$energy = $array['LOWER_ENERGY'];
	$j = $array['LOWER_J'];

	$deg = ($array['LOWER_TERMMULTIPLY'] == 1 ? '&deg;' : '');
	$prefix = ($array['LOWER_TERMPREFIX'] != 0 ? '<sup>'.$array['LOWER_TERMPREFIX'].'</sup>' : '');
	$term = $array['LOWER_TERMSECONDPART'].$prefix.$array['LOWER_TERMFIRSTPART'].$deg;
	// $term = preg_replace('/ /', '', $term);

	$config = preg_replace('/\@{([1-9])}/i', '<sup>$1</sup>', $config);
	$config = preg_replace('/\~{(.*?)}/i', '<sub>$1</sub>', $config);

	$config = preg_replace('/\@{([0])}/i', '&deg;', $config);

	$td1 = "<td>[$config]&nbsp;[$term]&nbsp;[$j]</td><td>$energy</td>";

	$config = $array['UPPER_CONFIG'];
	$energy = $array['UPPER_ENERGY'];
	$j = $array['UPPER_J'];

	$deg = ($array['UPPER_TERMMULTIPLY'] == 1 ? '&deg;' : '');
	$prefix = ($array['UPPER_TERMPREFIX'] != 0 ? '<sup>'.$array['UPPER_TERMPREFIX'].'</sup>' : '');
	$term = $array['UPPER_TERMSECONDPART'].$prefix.$array['UPPER_TERMFIRSTPART'].$deg;
	// $term = preg_replace('/ /', '', $term);

	$config = preg_replace('/\@{([1-9])}/i', '<sup>$1</sup>', $config);
	$config = preg_replace('/\~{(.*?)}/i', '<sub>$1</sub>', $config);

	$config = preg_replace('/\@{([0])}/i', '&deg;', $config);

	$td2 = "<td>[$config]&nbsp;[$term]&nbsp;[$j]</td><td>$energy</td>";

	return array($td1, $td2);
}

function create_tbody($array1, $array2 = NULL, $text = NULL){
	$td1_line = "<td>NIST</td>";
	$td2_line = "<td>ЭСА</td>";
	// $txt = $array1['text'];
	$id1 = $array1['ID'];
	list($td1, $td2) = quantum_numbers($array1);
	$wavelength1 = $array1['WAVELENGTH'];
	$intensity1 = $array1['INTENSITY'];
	$probability1 = $array1['PROBABILITY'];
	$oscillator_f1 = $array1['OSCILLATOR_F'];
	$td1_line .= "<td class='wavelength'>$wavelength1</td><td class='intensity'>$intensity1</td><td class='probability'>$probability1</td><td class='oscillator'>$oscillator_f1</td>$td1<td>→</td>$td2";

	$radioSave = "<input type='radio' name='methodsave-$id1' value='save'>Сохранить<br>";
	$radioNotLinkSave = "<input type='radio' name='methodsave-$id1' value='saveasnew'>Сохранить<br>";
	$radioSkip = "<input type='radio' name='methodsave-$id1' value='skip'>Пропустить<br>";
	$buttonFinish = "<input type='button' value='Завершить' class='buttonSave' id='save-$id1'>";
	$checkboxForAll ="<input type='checkbox' id='checkbox-$id1'>Применить ко всем аналогичным уровням<br>";

	if(isset($array2)){
		list($td1, $td2) = quantum_numbers($array2);
		$id2 = $array2['ID'];
		$wavelength2 = $array2['WAVELENGTH'];
		$intensity2 = $array2['INTENSITY'];	
		$probability2 = $array2['PROBABILITY'];
		$oscillator_f2 = $array2['OSCILLATOR_F'];	
		$td2_line .= "<td class='wavelength'>$wavelength2</td><td class='intensity'>$intensity2</td><td class='probability'>$probability2</td><td class='oscillator'>$oscillator_f2</td>$td1<td>→</td>$td2";
		$td3_line = '<td></td>';

		$parametr = 'wavelength';
		$button_edit = "<td><div class='onoffswitch'><input type='checkbox' id='edit-$parametr-$id1-$id2' class='edit'><label class='onoffswitch-label' for='edit-$parametr-$id1-$id2'><span class='onoffswitch-inner'></span><span class='onoffswitch-switch'></span></label></div></td>";
		$td3_line .= (($wavelength1 != NULL and $wavelength1 != $wavelength2) ? $button_edit : "<td></td>");

		$parametr = 'intensity';
		$button_edit = "<td><div class='onoffswitch'><input type='checkbox' id='edit-$parametr-$id1-$id2' class='edit'><label class='onoffswitch-label' for='edit-$parametr-$id1-$id2'><span class='onoffswitch-inner'></span><span class='onoffswitch-switch'></span></label></div></td>";
		$td3_line .= (($intensity1 != NULL and $intensity1 != $intensity2) ? $button_edit : "<td></td>");

		$parametr = 'probability';
		$button_edit = "<td><div class='onoffswitch'><input type='checkbox' id='edit-$parametr-$id1-$id2' class='edit'><label class='onoffswitch-label' for='edit-$parametr-$id1-$id2'><span class='onoffswitch-inner'></span><span class='onoffswitch-switch'></span></label></div></td>";
		$td3_line .= (($probability1 != NULL and $probability1 != $probability2) ? $button_edit : "<td></td>");

		$parametr = 'oscillator';
		$button_edit = "<td><div class='onoffswitch'><input type='checkbox' id='edit-$parametr-$id1-$id2' class='edit'><label class='onoffswitch-label' for='edit-$parametr-$id1-$id2'><span class='onoffswitch-inner'></span><span class='onoffswitch-switch'></span></label></div></td>";
		$td3_line .= (($oscillator_f1 != NULL and $oscillator_f1 != $oscillator_f2) ? $button_edit : "<td></td>");

		$input = '<br>'.$checkboxForAll.$radioSave.$radioSkip.$buttonFinish;
		$td3_line .= "<td colspan=5 rowspan=2><div id='text-$id1'>$text</div><div id='divbutton-$id1'>$input</div></td>";

		$td4_line .= "<td>Итого</td><td class='wavelength'>$wavelength2</td><td class='intensity'>$intensity2</td><td class='probability'>$probability2</td><td class='oscillator'>$oscillator_f2</td>";

		$tbody = "<tbody id='$id1'><tr id='$id1'>$td1_line</tr><tr id='$id2'>$td2_line</tr><tr id='editbutton-$id1'>$td3_line</tr><tr id='total-$id1-$id2'>$td4_line</tr></tbody>";
	}else{
		$input = '<br>'.$checkboxForAll.$radioNotLinkSave.$radioSkip.$buttonFinish;
		$td2_line = "<td>Итого</td><td class='wavelength'>$wavelength1</td><td class='intensity'>$intensity1</td><td class='probability'>$probability1</td><td class='oscillator'>$oscillator_f1</td>";
		$td2_line .= "<td colspan=5 rowspan=2><div id='text-$id1'>Новый переход</div><div id='divbutton-$id1'>$input</div></td>";
		$tbody = "<tbody id='$id1'><tr id='$id1'>$td1_line</tr><tr id='total-$id1'>$td2_line</tr></tbody>";
	}

	return $tbody;
}

function clear_space($array1){
	$i = 0;
	foreach ($array1 as $level){
		foreach ($level as $key => $value) {
			$array2[$i][$key] =  trim($value);
		}
		$i++;
	}
	return $array2;
}
function order_number($number){
	$number = explode('.', $number);
	$order = strlen($number[1]);
	return $order;
}

function number_analys($a, $b, $name, $runame, $delta = 1){
	$result['status'] = $name;
	$result['match'] = true;
	$a = (float)$a;
	$b = (float)$b;

	if($a == $b){
		$result['text'] = NULL;
		$result['status'] .= '0';
		return $result;
	}elseif($a == NULL and $b != NULL){
		$result['text'] = "<li>$runame - импортированное значение пусто";
		$result['status'] .= '4';
		$result['match'] = false;
		return $result;
	}elseif($a != NULL and $b == NULL){
		$result['text'] = "<li>$runame - значение ЭСА пусто";
		$result['status'] .= '5';
		$result['match'] = false;
		return $result;
	}

	if(abs($a - $b) < $delta){
		$delta = abs($a - $b);
		if(strlen($a) == strlen($b) and ($a != $b)){
			$result['text'] = "<li>$runame отличаются, но близки";
			$result['status'] .= '1';
			return $result;
		}
		$number1 = (strlen($a) > strlen($b) ? $a : $b);
		$number2 = (strlen($a) < strlen($b) ? $a : $b);
		$order = order_number($number2);
		$down = round(floor($number1 * pow(10, $order)) / pow(10, $order),$order); 
		$up = round(ceil($number1 * pow(10, $order)) / pow(10, $order),$order); 

		if($down == $number2 or $up == $number2){
			$result['text'] = "<li>$runame округлена";
			$result['status'] .= '2';
			return $result;

		}else{
			$result['text'] = "<li>$runame отличаются, но близки";
			$result['status'] .= '3';
			return $result;		
		}
	}else{		
		$result['text'] = "<li>$runame отличаются";
		$result['status'] .= '6';
		$result['match'] = false;
		return $result;
	}

}

function analysis_lines($nist_lines, $id_source, $skip){
	$lines_list = new Listotherbd();
	$lines_list->LoadLines($id_source);
	$lines_list = $lines_list->GetItemsArray();

	$lines_list = clear_space($lines_list);
	$nist_lines = clear_space($nist_lines);

	$foundLines = $unclassified = $newLines = $j = 0;
	foreach ($nist_lines as $nist_line){
		$i = 0;
		$test = false;
		$testUnclass = ($nist_line['ID_LOWER_LEVEL'] != NULL and $nist_line['ID_UPPER_LEVEL'] != NULL ? 1 : 0);
		if($testUnclass == 1){
			foreach ($lines_list as $line){
				if($line['found'] != true){
					if($nist_line['LOWER_LEVEL'] == $line['ID_LOWER_LEVEL'] and $nist_line['UPPER_LEVEL'] == $line['ID_UPPER_LEVEL']){
						$lines_list[$i]['found'] = true;
						$test = true;
						$wavelength = number_analys($nist_line['WAVELENGTH'], $line['WAVELENGTH'], 'wavelength', 'Длина волн');
						$intensity = number_analys($nist_line['INTENSITY'], $line['INTENSITY'], 'intensity', 'Интенсивности');
						$probability = number_analys($nist_line['PROBABILITY'], $line['PROBABILITY'], 'probability', 'Вероятности');
						$oscillator = number_analys($nist_line['OSCILLATOR_F'], $line['OSCILLATOR_F'], 'oscillator', 'Осцилляторы');

						$status = 'abs'.$wavelength['status'].$intensity['status'].$probability['status'].$oscillator['status'];
						$error = $wavelength['text'].$intensity['text'].$probability['text'].$oscillator['text'];
						$error = ($error != NULL ? "Ошибки:".$error : '');
						$text = "Переход совпал".$error;

						$tbody_match .= create_tbody($nist_line, $line, $error);
						$nist_lines[$j]["data"] = $line["ID"];
						$nist_lines[$j]["status"] = $status;
						$foundLines++;
						break;
					}
				}
				$i++;
			}
		}else{
			$tbody_unclass .= create_tbody($nist_line);
			$nist_lines[$j]["status"] = 'mtl';
			$unclassified++;
			// unset($nist_lines[$j]);
		}

		if(!$test and $testUnclass == 1){
			$tbody_new .= create_tbody($nist_line);
			$nist_lines[$j]["status"] = 'new';
			$newLines++;
		}
		$j++;
	}
	
	$foundLines = ($foundLines > 0 ? $foundLines : 'отсутствуют');
	$unclassified = ($unclassified > 0 ? $unclassified : 'отсутствуют');
	$newLines = ($newLines > 0 ? $newLines : 'отсутствуют');
	$count_esa = count($lines_list);
	$count_nist = count($nist_lines);
	$number_over = $foundLines + $newLines;
	$datajs .= "lengthabs = $foundLines;";
	$datajs .= "lengthmtl = $unclassified;";
	$datajs .= "lengthnew = $newLines;";
	$datajs .= "lengthover = $number_over;";
	$datajs .= "data_json = ".json_encode($nist_lines).";";
	$datajs .= "id_source = $id_source;";

	$text_skip = ($skip ? "<div class='alert alert-info'>Был произведен сравнительный анализ по пропущенным уровням.</div>" : '');
	$data = "$text_skip<h3>Результаты поиска следующие:</h3> 
	<ul  class='list-group'>
	<li class='list-group-item'>Количество переходов ИС ЭСА: $count_esa
	<li class='list-group-item'>Количество переходов NIST: $count_nist
	<li class='list-group-item'>Итого найдено: $foundLines
	<li class='list-group-item'>Неклассифицированные переходы НИСТ: $unclassified
	<li class='list-group-item'>Новые переходы: $newLines
	</ul>";
	$result .= "<div class='res' id='resultsummary'>$data</div>";
	$panelmenu .= '<li><a class="btnres" id="resultsummary">Общие сведения</a></li>';


	$head_table = "<tr><th>БД</th><th>Длина волны</th><th>Интенсивность</th><th>Вероятность</th><th>Осциллятор</th><th>Параметры</th><th>Энергия</th><th></th><th>Параметры</th><th>Энергия</th></tr>";
	if($foundLines > 0){ 
		$data = '<h3>Таблица найденых переходов NIST и ИС ЭСА</h3>';
		$data .="<table class='table table-striped'>$head_table$tbody_match</table>";
		$result .= "<div class='res' id='resultabs' style='display: none'>$data</div>";
		$panelmenu .= '<li><a class="btnres" id="resultabs">Найденые переходы</a></li>';
	}
	if($unclassified > 0 and $unclassified < 1000) {
		$data = '<h3>Таблица неклассифицированных переходов NIST</h3>';
		$data .="<table class='table table-striped'>$head_table$tbody_unclass</table>";
		$result .= "<div class='res' id='resultmtl' style='display: none'>$data</div>";
		$panelmenu .= '<li><a class="btnres" id="resultmtl">Неклассифицированные</a></li>';
	}

	if($newLines > 0){
		$data = '<h3>Таблица новых переходов NIST</h3>';
		$data .="<table class='table table-striped'>$head_table$tbody_new</table>";
		$result .= "<div class='res' id='resultnew' style='display: none'>$data</div>";
		$panelmenu .= '<li><a class="btnres" id="resultnew">Новые переходы</a></li>';
	}
	return array($panelmenu, $result, $datajs);
}

function import_nist_lines($name, $ion = NULL){
	if(empty($ion)) $ion = 1;
	$ion_roman = number_to_roman($ion);
	$element = "$name $ion_roman";
	$ion--;
	$source = 'NIST';

	$id_source = new Listotherbd();
	$id_source->SearchIdAtom($name, $ion);
	$id_source = $id_source->GetItemsArray();
	$id_source = $id_source[0]['ID'];

	if($id_source == null){
		$result= "<div class='alert alert-info'>Такого элемента $element нет в базе ЭСА</div>";
		return $result;		
	}

	// Проверка на существования уровней
	if(!journal(NULL, $id_source, $source, 'level')){
		$result = "<div class='alert alert-info'>Уровни этого элемента еще не импортировались. Осуществите сперва импорт уровней</div>";
		return $result;	
	}
	// Проверка на существования пропущеных
	$lines_skip = new Listotherbd();
	$lines_skip->LoadLinesSkip($id_source);
	$lines_skip = $lines_skip->GetItemsArray();

	if($lines_skip != null){
		$nist_lines = $lines_skip;	
		$skip = true;	
	}else{
		$html = curl_import_lines_nist($element);
		file_put_contents('file/file.htm', $html);
		// $html = file_get_contents('file/file.htm');
		$table = parsing_lines($html);
		if(journal($table, $id_source, $source, 'line')){
			$result = "<div class='alert alert-info'>Элемент &laquo;$element&raquo; уже импортировался с NIST, изменений и новых переходов нет</div>";
			return $result;	
		}else{
			$xml_transitions = xml_object($table, 'transition');
			$nist_lines = lines_nist($xml_transitions);
			$nist_lines = clear_space($nist_lines);
			$nist_lines = testLinesNIST($nist_lines, $id_source, $source);
			if(empty($nist_lines)){
				$result = "<div class='alert alert-info'>По заданному запросу нет данных</div>";
				return $result;	
			}
			$nist_lines = LoadLines($nist_lines, $id_source);
			$skip = false;	
		}
	}

	list($panelmenu, $result, $datajs) = analysis_lines($nist_lines, $id_source, $skip);
	file_put_contents('js/data.js', $datajs);
	$panelmenu = "<hr><ul class='nav nav-justified'>$panelmenu</ul><hr>";
	$result = $panelmenu.$result.'<script type="text/javascript" src="js/data.js"></script>';
	return $result;
}
?>