<?php
require_once($_SERVER['DOCUMENT_ROOT']."/includes/listotherbd.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/levellist.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/atom.php");
set_time_limit(0);

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

function curl_import_levels_nist($element){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://physics.nist.gov/cgi-bin/ASD/energy1.pl");
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
	curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'spectrum='.$element.'&encodedlist=XXT2&submit=Retrieve%20Data&units=0&format=0&output=0&page_size=15&multiplet_ordered=0&conf_out=on&term_out=on&level_out=on&j_out=on&lande_out=on&perc_out=on&biblio=on');
	
	$html = curl_exec($ch);
	curl_close($ch);
	return ($html);
}

function journal($content, $id_atom, $source, $type){
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
}

function parsing_levels($html){
	preg_match_all("|<TABLE BGCOLOR=\"#FFFEEE\" BORDER=\"1\" frame=\"box\" rules=\"groups\" CELLSPACING=\"0\" CELLPADDING=\"1\">(.*)</TBODY>.</TABLE>|is", $html, $matches); 
	foreach ($matches[0] as $table){
		preg_match_all("|<TBODY>.<TR class=\"bsl\">(.*)</TBODY>.</TABLE>|is", $table, $matches); 
		foreach ($matches[0] as $tbody){
			$tbody = preg_replace('/<\/TABLE>/', '',   $tbody);
			$tbody = preg_replace('/&deg;/', '°',   $tbody);
			$tbody = preg_replace('/TR>/', 'tr>',   $tbody);
			$tbody = preg_replace('/TBODY>/', 'tbody>',   $tbody);
			$tbody = preg_replace('/BODY>/', 'body>',   $tbody);
		}
	}

	$patterns = array();
	$patterns[] = '/tbody/is';
	$patterns[] = '/<td[^>]*>/is';
	$patterns[] = '/<tr[^>]*>/is';
	$patterns[] = '/<\/tr>/is';
	$patterns[] = '/<sup>([^<]*)<\/sup>\/<sub>([^<]*)<\/sub>/is';
	$patterns[] = '/<sup>([^<]*)<\/sup>/is';
	$patterns[] = '/<sub>([^<]*)<\/sub>/is';	
	$patterns[] = '/°/s';
	$patterns[] = '/<a(.*?)>(.*?)<\/a>/is';	
	$patterns[] = '/(<br>)/is';
	$patterns[] = '/<font[^>]*>/is';
	$patterns[] = '/<\/font>/is';
	$patterns[] = '/<i[^>]*>/is';
	$patterns[] = '/<\/i>/is';
	$patterns[] = '/<b[^>]*>/is';
	$patterns[] = '/<\/b>/is';	
	$patterns[] = '/&nbsp;/is';
	// $patterns[] = '/\[|\]/is';
	$replacements = array();
	$replacements[] = 'root';
	$replacements[] = '<td>';
	$replacements[] = '<level>';
	$replacements[] = '</level>';
	$replacements[] = '$1/$2';
	$replacements[] = '@{$1}';
	$replacements[] = '~{$1}';
	$replacements[] = '#';
	$replacements[] = '$2';


	$output_text = preg_replace($patterns, $replacements, $tbody);
	$patterns = array();
	$patterns[] = '/(<level>[<td><\/td>\s?]*<\/level>)/is';
	$replacements = array();
	$replacements[] = '<level type="break"></level>';
	$output_text = preg_replace($patterns, $replacements, $output_text);

	return $output_text;
}

function xml_object($content, $type = NULL){
	$output_handle = $_SERVER['DOCUMENT_ROOT']."/import/file/tmp_file.xml";
	$fp = fopen($output_handle, "w");
	fwrite($fp, $content);
	fclose($fp);

	$xml_object = simplexml_load_file($output_handle);
	$xml = $xml_object->$type;
	return $xml;
}

function levels_nist($xml_levels){
	$new_config = true;
	$i = 0;
	$t = 0;
	foreach ($xml_levels as $xml_level){
		if ($xml_level -> attributes() -> type) $type = $xml_level -> attributes() -> type;
		else $type = '';
		if ($type == "break") $new_config = true; 
		else{
			if ($new_config && (string)$xml_level->td[0] != ""){
			// var_dump($new_config);
			// var_dump((string)$xml_level->td[0]);
			// echo "<hr>";
				$level_config = (string)$xml_level->td[0];
				$level_term = $xml_level->td[1];
				$level_term = preg_replace('/\@{/i', '%', $level_term);
				$level_term = preg_replace('/}/i', '%',    $level_term);			

				if (preg_match('/#/', $level_term)){
					$level_term = preg_replace('/#/', '',   $level_term);
					$level_term_multiply = 1; 
				} else $level_term_multiply = 0;				

				$level_term_array = preg_split("/%/", $level_term);
				$new_config       = false;
			} 
			// $level_list[$i]["CONFIG"] = preg_replace('/#/', '&deg;', $level_config);	
			$level_list[$i]["CONFIG"] = preg_replace('/#/', '@{0}', $level_config);	
			$level_list[$i]["TERMPREFIX"]     = (string)$level_term_array[1];
			$level_list[$i]["TERMFIRSTPART"]   = (string)$level_term_array[2];
			$level_list[$i]["TERMSECONDPART"]  = (string)$level_term_array[0];		
			$level_list[$i]["TERMMULTIPLY"]    = (int)$level_term_multiply;

			$j = (string)$xml_level->td[2];
			$j = preg_replace('/@{/',  '', $j);
			$j = preg_replace('/}/' ,  '', $j);
			$j = preg_replace('/~{/',  '', $j);
			$j = preg_replace('/}/' ,  '', $j);

			$level_list[$i]["J"] = $j;

			// $level_list[$i]["ENERGY"] = (string)($xml_level->td[3]);
			// $level_list[$i]["ENERGY"] = (float)preg_replace('/\[|\]/is', '', $xml_level->td[3]);//($xml_level->td[3]);
			$level_list[$i]["EXSTRA"] = ($xml_level->td[3] == preg_replace('/\[|\]/is', '', $xml_level->td[3]) ? false : true);
			$level_list[$i]["ENERGY"] = (float)preg_replace('/\[|\]|\(|\)/is', '', $xml_level->td[3]);
			$level_list[$i]["BIBLIOGRAPHY"] = (string)$xml_level->td[5];
			$level_list[$i]["SOURCE_BD"] = "NIST";

			$j = explode(",", $level_list[$i]["J"]);
			if(count($j) > 1){
				$tmp_level = $level_list[$i];
				foreach ($j as $value){
					$level_list[$i]= $tmp_level;
					$level_list[$i]["J"] = $value;
					// var_dump($level_list[$i]);
					$i++;
				}
				$i--;
			}

			$nan = acos(substr($level_list[$i]["CONFIG"], 0, 1));

			if($xml_level->td[1] == "Limit" and !is_nan($nan)){
				$level_limit_list[$t] = $level_list[$i];
				unset($level_list[$i]);
				$t++;
			}else $i++;
		}
	}
	return array ($level_list, $level_limit_list);
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

function testLevelsNIST($new_levels, $id_element, $source){
	$levels = new Listotherbd();
	$levels->LoadLevelsNIST($id_element, $source);
	$levels = $levels->GetItemsArray();
	$levels = clear_space($levels);
	$new_levels = clear_space($new_levels);
	if(empty($levels)){
		return $new_levels;
	}
	$test = 0;
	foreach ($new_levels as $new_level) {
		$srtlevel1 = $new_level['CONFIG'].$new_level['ENERGY'].$new_level['J'].$new_level['TERMPREFIX'].$new_level['TERMMULTIPLY'].$new_level['TERMFIRSTPART'].$new_level['TERMSECONDPART'];
		foreach ($levels as $level){
			$srtlevel2 = $level['CONFIG'].$level['ENERGY'].$level['J'].$level['TERMPREFIX'].$level['TERMMULTIPLY'].$level['TERMFIRSTPART'].$level['TERMSECONDPART'];
			if($srtlevel1 == $srtlevel2){
				$test = 1;
			}
		}
		if($test == 0){
			$peeled[] = $new_level;
		}
		$test = 0;

	}
	return $peeled;
}

function LoadLevels($levels_list, $id_source){
	$levels = new Listotherbd();
	$levels->CreateLevels($levels_list, $id_source);
	$id = $levels->GetItemsArray();
	$id = array_reverse($id);
	for($i = 0; $i < count($id); $i++){
		$levels_list[$i]['ID'] = $id[$i]['ID'];
	}
	return $levels_list;
}

function quantum_numbers($array){
	$config = $array['CONFIG'];
	$energy = $array['ENERGY'];
	$biblionumber = preg_replace("/[^0-9]/", '', $array['BIBLIOGRAPHY']);
	$biblioname = $array['BIBLIOGRAPHY'];
	$bibliography = "<a href='http://physics.nist.gov/cgi-bin/ASBib1/get_ASBib_ref.cgi?db=el&db_id=$biblionumber&comment_code=&element=I&spectr_charge=1&ref=3674&type=E'>$biblioname</a>";
	$j = $array['J'];

	$deg = ($array['TERMMULTIPLY'] == 1 ? '&deg;' : '');
	$prefix = ($array['TERMPREFIX'] != 0 ? '<sup>'.$array['TERMPREFIX'].'</sup>' : '');
	$term = $array['TERMSECONDPART'].$prefix.$array['TERMFIRSTPART'].$deg;

	// $config = preg_replace('/\@{0}/i', '&deg;', $config);
	$config = preg_replace('/\@{([1-9])}/i', '<sup>$1</sup>', $config);
	$config = preg_replace('/\~{(.*?)}/i', '<sub>$1</sub>', $config);

	$config = preg_replace('/\@{([0])}/i', '&deg;', $config);
	// $config = preg_replace('/}/i', '</sup>', $config);


	return array($config, $term, $j, $energy, $bibliography);
}

function create_tbody($array1, $array2 = NULL){
	$td1 = "<td>NIST</td>";
	$td2 = "<td>ЭСА</td>";
	$td3 = "<td></td>";
	$id1 = $array1['ID'];
	$id2 = $array2['ID'];
	$txt = $array1['text'];
	list($config1, $term1, $j1, $energy1, $bibliography1) = quantum_numbers($array1);
	$energyExstra = ($array1['EXSTRA'] ? '&nbsp;<a class="exstra">*</a>' : '');

	$td1 .= "<td class='config'>$config1</td><td class='term'>$term1</td><td class='j'>$j1</td><td class='energy'>$energy1 $energyExstra</td><td class='bibliography'>$bibliography1</td>";

	if(isset($array2)){
		list($config2, $term2, $j2, $energy2, $bibliography2) = quantum_numbers($array2);		
		$td2 .= "<td class='config'>$config2</td><td class='term'>$term2</td><td class='j'>$j2</td><td class='energy'>$energy2</td><td class='bibliography'>$bibliography2</td>";

		$parametr = 'config';
		$button_edit = "<td><div class='onoffswitch'><input type='checkbox' id='edit-$parametr-$id1-$id2' class='edit'><label class='onoffswitch-label' for='edit-$parametr-$id1-$id2'><span class='onoffswitch-inner'></span><span class='onoffswitch-switch'></span></label></div></td>";
		$td3 .= (($config1 != NULL and preg_replace('/\?/', '', $config1) != preg_replace('/\?/', '', $config2)) ? $button_edit : "<td></td>");

		$parametr = 'term';
		$button_edit = "<td><div class='onoffswitch'><input type='checkbox' id='edit-$parametr-$id1-$id2' class='edit'><label class='onoffswitch-label' for='edit-$parametr-$id1-$id2'><span class='onoffswitch-inner'></span><span class='onoffswitch-switch'></span></label></div></td>";
		$td3 .= (($term1 != NULL and preg_replace('/\?/', '', $term1) != preg_replace('/\?/', '', $term2)) ? $button_edit : "<td></td>");

		$parametr = 'j';
		$button_edit = "<td><div class='onoffswitch'><input type='checkbox' id='edit-$parametr-$id1-$id2' class='edit'><label class='onoffswitch-label' for='edit-$parametr-$id1-$id2'><span class='onoffswitch-inner'></span><span class='onoffswitch-switch'></span></label></div></td>";
		$td3 .= (($j1 != NULL and $j1 != $j2) ? $button_edit : "<td></td>");

		$parametr = 'energy';
		$button_edit = "<td><div class='onoffswitch'><input type='checkbox' id='edit-$parametr-$id1-$id2' class='edit'><label class='onoffswitch-label' for='edit-$parametr-$id1-$id2'><span class='onoffswitch-inner'></span><span class='onoffswitch-switch'></span></label></div></td>";
		$td3 .= (($energy1 != NULL and $energy1 != $energy2) ? $button_edit : "<td></td>");		
		
		$parametr = 'bibliography';
		$button_edit = "<td><div class='onoffswitch'><input type='checkbox' id='edit-$parametr-$id1-$id2' class='edit'><label class='onoffswitch-label' for='edit-$parametr-$id1-$id2'><span class='onoffswitch-inner'></span><span class='onoffswitch-switch'></span></label></div></td>";
		$td3 .= (($bibliography1 != NULL and $bibliography1 != $bibliography2) ? $button_edit : "<td></td>");		
		
		$test = (($config1 != NULL and $config1 != $config2) or ($term1 != NULL and $term1 != $term2) or ($energy1 != NULL and $energy1 != $energy2) or ($j1 != NULL and $j1 != $j2) or ($bibliography1 != NULL and $bibliography1 != $bibliography2) ? 1 : 0);	

	}
	$td_total = (isset($array2) ? "<td>Итог</td><td class='config'>$config2</td><td class='term'>$term2</td><td class='j'>$j2</td><td class='energy'>$energy2</td><td class='bibliography'>$bibliography2</td>" : "<td>Итог</td><td class='config'>$config1</td><td class='term'>$term1</td><td class='j'>$j1</td><td class='energy'>$energy1</td><td class='bibliography'>$bibliography1</td>");

	// $buttonSave = "<input type='button' value='Сохранить' class='buttonSave' id='linksave-$id1'>";
	// $buttonNotLinkSave = "<input type='button' value='Сохранить как новый' class='buttonNotLinkSave' id='notlinksave-$id1'>";
	// $buttonSkip = "<input type='button' value='Пропустить' class='buttonSkip' id='skiplevel-$id1'>";
	$radioSave = "<input type='radio' name='methodsave-$id1' value='save'>Сохранить<br>";
	$radioNotLinkSave = "<input type='radio' name='methodsave-$id1' value='saveasnew'>Сохранить как новый<br>";
	$radioSkip = "<input type='radio' name='methodsave-$id1' value='skip'>Пропустить<br>";
	$buttonFinish = "<input type='button' value='Завершить' class='buttonSave' id='save-$id1'>";
	$checkboxForAll ="<input type='checkbox' id='checkbox-$id1'>Применить ко всем аналогичным уровням<br>";

	if(isset($array2)){
		$td1 .= "<td rowspan=2 id='text-$id1'>$txt</td>";
		$tr1 = "<tr id='$id1'>$td1</tr>";
		$tr2 = "<tr id='$id2'>$td2</tr>";
		if($test == 1){
			$td3 .= "<td rowspan=2 id='tdbutton-$id1'><div id='divbutton-$id1'>$checkboxForAll $radioSave $radioNotLinkSave $radioSkip $buttonFinish</div></td>";
			$tr3_4 = "<tr id='editbutton-$id1'>$td3</tr><tr id='total-$id1-$id2'>$td_total</tr>";
		}else{
			$td_total .= "<td id='tdbutton-$id1'><div id='divbutton-$id1'>$checkboxForAll $radioSave $radioNotLinkSave $radioSkip $buttonFinish</div></td>";
			$tr3_4 = "<tr id='total-$id1-$id2'>$td_total</tr>";
		}		
		$tbody = "<tbody id='$id1'>$tr1$tr2$tr3_4</tbody>";
	}else{
		$td1 .= "<td id='text-$id1'>$txt</td>";
		$tr1 = "<tr id='$id1'>$td1</tr>";
		$td_total .= "<td id='tdbutton-$id1'><div id='divbutton-$id1'>$checkboxForAll $radioNotLinkSave $radioSkip $buttonFinish</div></td>";
		$tr2 = "<tr id='total-$id1-new'>$td_total</tr>";
		$tbody = "<tbody id='$id1'>$tr1$tr2</tbody>";
	}

	return $tbody;
}

function config_analys($array1, $array2){
	$config1 = preg_replace('/\?/', '', $array1['CONFIG']);
	$config2 = preg_replace('/\?/', '', $array2['CONFIG']);
	$emptyconfig = preg_replace('/\(|\)/', '', $config2);
	if($emptyconfig == NULL){
		$result['status'] = 'e';
		$result['match'] = false;
		$result['text'] = "<li>Конфигурация отсутствует";
		return $result;
	}
	preg_match_all("/\((.*?)\)/is", $config1, $matchresidue1);
	preg_match_all("/\((.*?)\)/is", $config2, $matchresidue2);

	$resultresidue = true;
	foreach ($matchresidue1[1] as $residue1) {
		$test = false;
		foreach ($matchresidue2[1] as $residue2) {
			$test = ($residue1 == $residue2 ? true : $test);
		}
		$resultresidue = (!$test ? false : $resultresidue);
	}

	// без атомного остатка
	$config12 =  preg_replace('/\((.*?)\)/i', '', $config1);	
	$config22 =  preg_replace('/\((.*?)\)/i', '', $config2);

	$pos1 = strripos(preg_replace('/\d+/is', '{$0}', $config12), preg_replace('/\d+/is', '{$0}', $config22));
	$pos2 = strripos(preg_replace('/\d+/is', '{$0}', $config22), preg_replace('/\d+/is', '{$0}', $config12)); 
	$pos = (($pos1 or $pos2)? true : false);
	$result['match'] = true;

	if($config1 == $config2){
		$result['status'] = 'a';
		$result['text'] = NULL;
		return $result;
	}elseif($config12 == $config22){
		$result['status'] = 'c';
		if($config1 == $config12){
			$result['text'] = "<li>Импортированный уровень без атомного остатка";
			$result['status'] .= 'd';
		}elseif($config2 == $config22){
			$result['text'] .= "<li>Уровень ЭСА без атомного остатка";
			$result['status'] .= 'f';
		}elseif(!$resultresidue){
			$result['text'] = "<li>Различная запись атомного остатка";
		}
		return $result;
	}elseif($pos and $config12 != $config22 and $resultresidue){
		if($pos1){
			$result['status'] = 'c0';
			$result['text'] = "<li>Конфигурация импортированного уровня менее сокращена";
			return $result;
		}else{
			$result['status'] = '0c';
			$result['text'] = "<li>Конфигурация ЭСА менее сокращена";
			return $result;			
		}
		return $result;
	}elseif($config12 != $config22 and !$resultresidue and $pos){
		$result['status'] = 'c';
		if($config1 == $config12){
			$result['text'] = "<li>Импортированный уровень без атомного остатка";
			$result['status'] .= 'd';
		}elseif($config2 == $config22){
			$result['text'] .= "<li>Уровень ЭСА без атомного остатка";
			$result['status'] .= 'f';
		}elseif(!$resultresidue){
			$result['text'] = "<li>Различная запись атомного остатка";
		}
		if($pos1){
			$result['status'] .= 'b0';
			$result['text'] .= "<li>Конфигурация импортированного уровня менее сокращена";
			return $result;
		}else{
			$result['status'] .= '0b';
			$result['text'] .= "<li>Конфигурация ЭСА менее сокращена";
			return $result;			
		}
		// $result['status'] = 'b';
		// $result['status'] = ($pos1 ? '01' : '10');
		// $result['text'] = "<li>Различная сокращенная запись конфигурации и атомного остатка";
		// return $result;
	}else{
		$result['match'] = false;
		$result['text'] = "<li>Различная запись конфигураций";
		return $result;
	}
}

function term_analys($array1, $array2){
	$parametr[] = 'TERMSECONDPART';
	$parametr[] = 'TERMFIRSTPART';
	$parametr[] = 'TERMPREFIX';
	$parametr[] = 'TERMMULTIPLY';
	$parametr[] = 'J';
	$status = 'term';
	$s = 4;
	$result['match'] = true;
	$term1_gen = $array1['TERMSECONDPART'].$array1['TERMPREFIX'].$array1['TERMFIRSTPART'].$array1['TERMMULTIPLY'].$array1['J'];
	$term2_gen = $array2['TERMSECONDPART'].$array2['TERMPREFIX'].$array2['TERMFIRSTPART'].$array2['TERMMULTIPLY'].$array2['J'];
	if($term1_gen == $term2_gen){
		$result['status'] = 43210;
		$result['match'] = true;
		return $result;
	}
	$term1_gen = $array1['TERMSECONDPART'].$array1['TERMPREFIX'].$array1['TERMFIRSTPART'];
	$term2_gen = $array2['TERMSECONDPART'].$array2['TERMPREFIX'].$array2['TERMFIRSTPART'];
	$term1_gen = preg_replace('/\(|\)|\?/', '', $term2_gen);
	$term2_gen = preg_replace('/\(|\)|\?/', '', $term2_gen);


	foreach ($parametr as $value) {
		$term1 = preg_replace('/0|\(|\)|\?/', '', $array1[$value]);
		$term2 = preg_replace('/0|\(|\)|\?/', '', $array2[$value]);
		if($term1 == $term2){
			$status .= $s;
		}else{
			switch ($s) { 
				case '4':
				$result['match'] = true;
				if($array1['TERMSECONDPART'] == NULL){
					$result['text'] .= '<li>Импортированный уровень без префиксного терма';
					$staterm .= '0a';
				}elseif($array2['TERMSECONDPART'] == NULL){
					$result['text'] .= '<li>Уровень ЭСА без префиксного терма';
					$staterm .= 'a0';
				}else{
					$result['text'] .= '<li>Различные префиксные термы';
					$staterm .= 'aa';
				}
				break;
				case '1':
				if($array1['TERMMULTIPLY'] == 0){
					$result['text'] .= '<li>Импортированный терм нечетный';
					$staterm .= '0b';
				}else{
					$result['text'] .= '<li>Терм ЭСА нечетный';
					$staterm .= 'b0';
				}
				break;
				case '0':
				$result['match'] = false;
				if($array1['J'] == NULL){
					$result['text'] .= '<li>Импортированный терм без J';
					$staterm .= '0a';
				}elseif($array2['J'] == NULL){
					$result['text'] .= '<li>Терм ЭСА без J';
					$staterm .= 'a0';
				}else{
					$result['text'] .= '<li>Разница J';
					$staterm .= 'aa';
				}
				break;
				
				default:
				if($term2_gen == NULL){					
					$result['text'] = '<li>Терм отсутствует у ЭСА';
					$result['match'] = true;
				}elseif($term1_gen == NULL){
					$result['text'] = '<li>Импортированный терм отсутствует';
					$result['match'] = true;
				}else{					
					$result['text'] = '<li>Разница терма';
					$result['match'] = false;
					$status .= 'n';					
				}
				break;
			}
		}
		$s--;
	}
	$result['status'] = $status.$staterm;
	return $result;
}

function order_number($number){
	$number = explode('.', $number);
	$order = strlen($number[1]);
	return $order;
}

function energy_analys($array1, $array2, $delta){
	$a = $array1['ENERGY'];
	$b = $array2['ENERGY'];
	$result['status'] = 'energy';
	$result['match'] = true;

	if($a == $b){
		$result['text'] = NULL;
		$result['status'] .= '0';
		return $result;
	}

	if(abs($a - $b) < $delta){
		if(strlen($a) == strlen($b) and ($a != $b)){
			if(abs($a - $b) <= 1){
				$result['text'] = '<li>Различные энергии, но близки';
				$result['status'] .= '1';
				return $result;
			}else{
				$result['text'] = '<li>Различные энергии, но входят в диапазон погрешности';
				$result['status'] .= '2';
				return $result;
			}
		}
		
		if(strlen($a) > strlen($b)){
			$number1 = $a;
			$number2 = $b;
			$result['status'] = 'a0';
		}else{
			$number1 = $b;
			$number2 = $a;
			$result['status'] = '0a';			
		}
		$order = order_number($number2);
		$down = round(floor($number1 * pow(10, $order)) / pow(10, $order),$order); 
		$up = round(ceil($number1 * pow(10, $order)) / pow(10, $order),$order); 

		if($down == $number2 or $up == $number2){
			$result['text'] = '<li>Погрешность энергии (округлена)';
			$result['text'] .= ($result['status'] == 'a0' ? '. Импортированная энергия точней' : '. Энергия ЭСА точней');
			$result['status'] .= '3';
			return $result;

		}else{
			if(abs($a - $b) <= 1){
				$result['text'] = '<li>Различные энергии, но близки';
				$result['status'] .= '1';
				return $result;
			}else{
				$result['text'] = '<li>Различные энергии, но входят в диапазон погрешности';
				$result['status'] .= '2';
				return $result;
			}	
		}
	}else{		
		$result['text'] = '<li>Различные энергии';
		$result['status'] .= '4';
		$result['match'] = false;
		return $result;
	}
}

function analysis_levels($new_levels_list, $id_source, $rangeenergy, $skip){
	$levels_list = new LevelList;
	$levels_list->Load($id_source);
	$levels_list = $levels_list->GetItemsArray();
	$number_abs = $number_mb = $number_new = $k = 0;
	$levels_list = clear_space($levels_list);
	$new_levels_list = clear_space($new_levels_list);
	foreach ($new_levels_list as $import_level){
		$energy_min = $rangeenergy;
		unset($found_level);
		unset($limit_energy);
		unset($limit_energy_conf);
		
		$i = 0;
		foreach ($levels_list as $level){
			if(!$level["found"]){			
				$config = config_analys($import_level, $level);
				$term = term_analys($import_level, $level);
				$energy = energy_analys($import_level, $level, $energy_min);

				if($config['match'] and $term['match'] and $energy['match']){
					$level["status"] = "abs".$config['status'].$term['status'].$energy['status'];
					$error = $config['text'].$term['text'].$energy['text'];

					if($import_level['EXSTRA']){
						$level["status"] .= 'ee';
					}		

					$error = ($error != NULL ? ".<br>Ошибки:".$error : '');					
					$level['text'] = "Уровень найден".$error;
					$found_level = $level;
					$levels_list[$i]["found"] = true;
					$new_levels_list[$k]["data"] = $found_level["ID"];
					$new_levels_list[$k]["text"] = $found_level["text"];
					$new_levels_list[$k]["status"] = $found_level["status"];
					$print_t_abs .= create_tbody($new_levels_list[$k], $level);
					$number_abs++;
					break;
					
				}
			}
			$i++;
		}
		// if(isset($found_level)){
		// 	$new_levels_list[$k]["data"] = $found_level["ID"];
		// 	$new_levels_list[$k]["text"] = $found_level["text"];
		// 	$new_levels_list[$k]["status"] = $found_level["status"];
		// 	$print_t_abs .= create_tbody($new_levels_list[$k], $found_level);
		// 	$number_abs++;
		// }
		$k++;
	}
	$k = 0;
	foreach ($new_levels_list as $import_level){
		if(empty($import_level["data"])){
			$energy_min = $rangeenergy;
			unset($limit_energy);
			unset($limit_energy_conf);
			$i = 0;
			$prev_term = 0;
			foreach ($levels_list as $level){
				if(!$level["found"]){					
					$energy = energy_analys($import_level, $level, $energy_min);
					$term = term_analys($import_level, $level);
					$num_term = preg_replace("/[^0-9]/", '', $term['status']);

					if($energy['match'] and $num_term > $prev_term){
						$prev_term = $num_term;
						$config = config_analys($import_level, $level);
						$level["status"] = "mtl".$config['status'].$term['status'].$energy['status'];
						$error = $config['text'].$term['text'].$energy['text'];

						$error = ($error != NULL ? "<br>Ошибки:".$error : '');					
						$level['text'] = "Может быть этот уровень?".$error;
						
						if($config['match']){
							$limit_energy_conf = $level;
						}else{
							$limit_energy = $level;
						}
					}
				}
			}
			if(isset($limit_energy_conf)){
				$new_levels_list[$k]["data"] = $limit_energy_conf["ID"];
				$new_levels_list[$k]["text"] = $limit_energy_conf["text"];
				$new_levels_list[$k]["status"] = $limit_energy_conf["status"];
				$print_t_mb .= create_tbody($new_levels_list[$k], $limit_energy_conf);
				$number_mb++;
			}elseif(isset($limit_energy)){
				$new_levels_list[$k]["data"] = $limit_energy["ID"];
				$new_levels_list[$k]["text"] = $limit_energy["text"];
				$new_levels_list[$k]["status"] = $limit_energy["status"];
				$print_t_mb .= create_tbody($new_levels_list[$k], $limit_energy);
				$number_mb++;
			}else{
				$new_levels_list[$k]['data'] = 'new';
				$new_levels_list[$k]["text"] = 'Новый уровень';
				$new_levels_list[$k]["status"] = 'new';//$limit_energy_conf["status"];
				$print_t_new .= create_tbody($new_levels_list[$k], NULL);
				$number_new++;
			}
		}
		$k++;
	}

	$number_over = $number_abs + $number_mb + $number_new;
	$datajs .= "lengthabs = $number_abs;";
	$datajs .= "lengthmtl = $number_mb;";
	$datajs .= "lengthnew = $number_new;";
	$datajs .= "lengthover = $number_over;";
	$datajs .= "data_json = ".json_encode($new_levels_list).";";
	$datajs .= "id_source = $id_source;";

	$count_esa = count($levels_list);
	$count_nist = count($new_levels_list);

	$text_skip = ($skip ? "<div class='alert alert-info'>Был произведен сравнительный анализ по пропущенным уровням.</div>" : '');
	$data = "$text_skip<h3>Результаты поиска следующие:</h3> 
	<ul  class='list-group'>
		<li class='list-group-item'>Дельта погрешность: $rangeenergy
			<li class='list-group-item'>Количество уровней ИС ЭСА: $count_esa
				<li class='list-group-item'>Количество уровней NIST: $count_nist
					<li class='list-group-item'>Число совпавших уровней: $number_abs
						<li class='list-group-item'>Число возможно совпавших уровней: $number_mb
							<li class='list-group-item'>Новые уровни: $number_new
							</ul>";
							$result .= "<div class='res' id='resultsummary'>$data</div>";
							$panelmenu .= '<li><a class="btnres" id="resultsummary">Общие сведения</a></li>';

							if($number_abs > 0){
								$data = '<h3>Таблица найденых уровней NIST и ИС ЭСА</h3>';
								$data .= '<table class="table table-striped">
								<tbody><tr>
									<th>БД</th>
									<th>Конфигурация</th>
									<th>Терм</th>
									<th>J</th>
									<th>Энергия</th>
									<th>Библиоссылка</th>
									<th>Примечания</th>
								</tr></tbody>'.$print_t_abs.'</table>';
								$result .= "<div class='res' id='resultabs' style='display: none'>$data</div>";
								$panelmenu .= '<li><a class="btnres" id="resultabs">Найденые уровни</a></li>';
							}
							if($number_mb > 0){
								$data = '<h3>Таблица возможно найденых уровней NIST и ИС ЭСА</h3>';
								$data .= '<table class="table table-striped">
								<tbody><tr>
									<th>БД</th>
									<th>Конфигурация</th>
									<th>Терм</th>
									<th>J</th>
									<th>Энергия</th>
									<th>Библиоссылка</th>
									<th>Примечания</th>
								</tr></tbody>'.$print_t_mb.'</table>';
								$result .= "<div class='res' id='resultmtl' style='display: none'>$data</div>";
								$panelmenu .= '<li><a class="btnres" id="resultmtl">Возможно найденые уровни</a></li>';
							}
							if($number_new > 0){

								$data = '<h3>Таблица новых уровней с NIST</h3>';
								$data .= '<table class="table table-striped">
								<tbody><tr>
									<th>БД</th>
									<th>Конфигурация</th>
									<th>Терм</th>
									<th>J</th>
									<th>Энергия</th>
									<th>Библиоссылка</th>
									<th>Примечания</th>
								</tr></tbody>'.$print_t_new.'</table>';
								$result .= "<div class='res' id='resultnew' style='display: none'>$data</div>";
								$panelmenu .= '<li><a class="btnres" id="resultnew">Новые уровни</a></li>';
							}
							return array($panelmenu, $result, $datajs);
						}

						function import_nist_levels($name, $ion = NULL, $rangeenergy){
							if(empty($ion)) $ion = 1;
							$ion_roman = number_to_roman($ion);
							$element = "$name $ion_roman";
							$ion--;
							$source = 'NIST';


							$id_source = new Listotherbd();
							$id_source->SearchIdAtom($name, $ion);
							$id_source = $id_source->GetItemsArray();
							$id_source = $id_source[0]['ID'];

	// $test = new Atom();
	// var_dump($id_source);
	// $test->Load($id_source);
	// $test = $test->GetAllProperties();
	// //$test = $test[0]['LIMITS'];

	// var_dump($test);
// exit();
							if($id_source == null){
								$result = "<p>Такого элемента $element нет в базе ЭСА</p>";
								return $result;		
							}

							$levels_skip = new Listotherbd();
							$levels_skip->LoadLevelsSkip($id_source);
							$levels_skip = $levels_skip->GetItemsArray();

							if($levels_skip != null){//
								$nist_levels = $levels_skip;	
								$skip = true;	
							}else{
								$html = curl_import_levels_nist($element); 	
		 //file_put_contents('file/file.htm', $html);
		//$html = file_get_contents('file/file.htm');
								$table = parsing_levels($html);
		if(false){//journal($table, $id_source, $source, 'level')
		$result = "<div class='alert alert-info'><strong>Heads up!</strong> Элемент &laquo;$element&raquo; уже импортировался с NIST, изменений и новых уровней нет.</div>";
		return $result;
	}else{
		$xml_levels = xml_object($table, 'level');
		list($nist_levels, $nist_limit) = levels_nist($xml_levels);

			// $result['data_json'] = $nist_limit;
			// return json_encode($result);

		$nist_levels = testLevelsNIST($nist_levels, $id_source, $source);
		if(empty($nist_levels)){
			$result = "<p>По заданному запросу нет данных</p>";
			return $result;
		}
		$nist_levels = LoadLevels($nist_levels, $id_source);
		$skip = false;	
	}
}

list($panelmenu, $result, $datajs) = analysis_levels($nist_levels, $id_source, $rangeenergy, $skip);

if(isset($nist_limit)){
		// $oldlimits = new Listotherbd();
		// $oldlimits->LoadLimits($id_source);
		// $oldlimits = $oldlimits->GetItemsArray();
		// $oldlimits = $oldlimits[0]['LIMITS'];
		// $oldlimits = preg_replace('/<limits>|<\/limits>/', '', $limits[0]['LIMITS']);

	$i = 1;
	foreach ($nist_limit as $value) {
		$limit = $value['ENERGY'];
		$newlimits .= '\r\n<limit id="l'.$i.'">'.$limit.'</limit>';
		$i++;
	}
		// $generallimits = $oldlimits;
		// $generallimits = "<limits>".$oldlimits."\r\n".$newlimits."\r\n</limits>";
		// // $result['table'][] = "Пределы ЭСА<br>".$oldlimits."<br>Пределы NIST<br>$newlimits<br>Результат<br><textarea id='limits'>$generallimits</textarea><br><input type='button' value='Сохранить' id='saveLimits'>";
		// $result['table'][] = "<textarea id='limits'>".$oldlimits."</textarea>";
		// $result['table_title'][] = '';
		// $result['table_menu'][] = '';

	$data = '<h3>Пределы с NIST</h3>';
	$data .= "<textarea id='limits'>".$newlimits."</textarea>";
	$result .= "<div class='res' id='resultlimits' style='display: none'>$data</div>";
	$panelmenu .= '<li><a class="btnres" id="resultlimits">Пределы</a></li>';
}
file_put_contents($_SERVER['DOCUMENT_ROOT'] .'/import/file/data.js', $datajs);
$panelmenu = "<hr><ul class='nav nav-justified'>$panelmenu</ul><hr>";
$result = $panelmenu.$result.'<script type="text/javascript" src="file/data.js"></script>';
return $result;
}

// import_nist_levels('He', 1);
// echo 1;

?>