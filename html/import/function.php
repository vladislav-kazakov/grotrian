<?php
require_once($_SERVER['DOCUMENT_ROOT']."/includes/listotherbd.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/levellist.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/transitionlist.php");
set_time_limit(0);

$main_id = new Listotherbd();
// $atom = 'Fe';
// $ion = 2;
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

function parsing_levels($html){
	preg_match_all("|<TABLE BGCOLOR=\"#FFFEEE\" BORDER=\"0\" frame=\"box\" rules=\"groups\" CELLSPACING=\"0\" CELLPADDING=\"1\">(.*)</TBODY>.</TABLE>|is", $html, $matches); 
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

function levels_nist($xml_levels){
	$new_config = true;
	$i = 0;
	$t = 0;
	foreach ($xml_levels as $xml_level){
		if ($xml_level -> attributes() -> type) $type = $xml_level -> attributes() -> type;
		else $type = '';	    	

		if ($type == "break") $new_config = true; 
		else{
			if ($new_config && $xml_level->td[0]){
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
			$level_list[$i]["TERMPREFIX"]     = (int)$level_term_array[1];
			$level_list[$i]["TERMFIRSTPART"]   = (string)$level_term_array[2];
			$level_list[$i]["TERMSECONDPART"]  = (string)$level_term_array[0];		
			$level_list[$i]["TERMMULTIPLY"]    = (int)$level_term_multiply;

			$j = (string)$xml_level->td[2];
			$j = preg_replace('/@{/',  '', $j);
			$j = preg_replace('/}/' ,  '', $j);
			$j = preg_replace('/~{/',  '', $j);
			$j = preg_replace('/}/' ,  '', $j);

			$level_list[$i]["J"] = $j;

			$level_list[$i]["ENERGY"] = (float)$xml_level->td[3];
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

function lines_nist($xml_transitions){
	$i = 0;
	foreach ($xml_transitions as $xml_transition){
		// if(isset($xml_transition->td[9], $xml_transition->td[10], $xml_transition->td[11], $xml_transition->td[12], $xml_transition->td[13], $xml_transition->td[14]))
		// {
		$transition_list[$i]['ID'] = $i;		

		if ((string)$xml_transition->td[0] != "")	$transition_list[$i]['WAVELENGTH'] = (string)$xml_transition->td[0];		
		else $transition_list[$i]['WAVELENGTH'] = (string)($xml_transition->td[1]);

		$transition_list[$i]['INTENSITY'] = (string)$xml_transition->td[2];

		if ((string)$xml_transition->td[3] != ""){
			$transition_list[$i]['A_KI'] = (float)$xml_transition->td[3];
		} else $transition_list[$i]['A_KI'] = NULL;

		if ((string)$xml_transition->td[4] != ""){
			$transition_list[$i]['F_IK'] = (float)$xml_transition->td[4];
		} else $transition_list[$i]['F_IK'] = NULL;

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

function testLevelsNIST($new_levels, $id_element){
	$levels = new Listotherbd();
	$levels->LoadLevelsNIST($id_element);
	$levels = $levels->GetItemsArray();
	if(empty($levels)){
		return $new_levels;
	}
	$k = $test = 0;
	foreach ($new_levels as $new_level) {
		$new_c = preg_replace('/ /', '', $new_level['CONFIG']);
		$new_e = preg_replace('/ /', '', $new_level['ENERGY']);
		$new_l = preg_replace('/ /', '', $new_level['LIFETIME']);
		$new_j = preg_replace('/ /', '', $new_level['J']);
		$new_tp = preg_replace('/ /', '', $new_level['TERMPREFIX']);
		$new_tm = preg_replace('/ /', '', $new_level['TERMMULTIPLY']);
		$new_tf = preg_replace('/ /', '', $new_level['TERMFIRSTPART']);
		$new_ts = preg_replace('/ /', '', $new_level['TERMSECONDPART']);
		foreach ($levels as $level){
			$c = preg_replace('/ /', '', $level['CONFIG']);
			$e = preg_replace('/ /', '', $level['ENERGY']);
			$l = preg_replace('/ /', '', $level['LIFETIME']);
			$j = preg_replace('/ /', '', $level['J']);
			$tp = preg_replace('/ /', '', $level['TERMPREFIX']);
			$tm = preg_replace('/ /', '', $level['TERMMULTIPLY']);
			$tf = preg_replace('/ /', '', $level['TERMFIRSTPART']);
			$ts = preg_replace('/ /', '', $level['TERMSECONDPART']);
			if($c == $new_c and $e == $new_e and $l == $new_l and $j == $new_j and $tp == $new_tp and $tm == $new_tm and $tf ==$new_tf and $ts == $new_ts){
				$test = 1;
			}
		}
		if($test == 0){
			$peeled[$k] = $new_level;
			$k++;
		}
		$test = 0;

	}
	return $peeled;
}

function testLinesNIST($new_lines, $id_element){
	$lines = new Listotherbd();
	$lines->LoadLinesNIST($id_element);
	$lines = $lines->GetItemsArray();
	if(empty($lines)){
		return $new_lines;
	}
	$k = $test = 0;
	foreach ($new_lines as $new_line) {
		$new_w = preg_replace('/ /', '', $new_line['WAVELENGTH']);
		$new_i = preg_replace('/ /', '', $new_line['INTENSITY']);
		$new_a = preg_replace('/ /', '', $new_line['A_KI']);
		$new_f = preg_replace('/ /', '', $new_line['F_IK']);
		$new_ll = preg_replace('/ /', '', $new_line['LOWER_LEVEL_ENERGY']);
		$new_ul = preg_replace('/ /', '', $new_line['UPPER_LEVEL_ENERGY']);
		foreach ($lines as $line){
			$w = preg_replace('/ /', '', $line['WAVELENGTH']);
			$i = preg_replace('/ /', '', $line['INTENSITY']);
			$a = preg_replace('/ /', '', $line['A_KI']);
			$f = preg_replace('/ /', '', $line['F_IK']);
			$ll = preg_replace('/ /', '', $line['LOWER_LEVEL_ENERGY']);
			$ul = preg_replace('/ /', '', $line['UPPER_LEVEL_ENERGY']);
			if($w == $new_i and $i == $new_i and $a == $new_a and $f == $new_f and $ll == $new_ll and $ul == $new_ul){
				$test = 1;
			}
		}
		if($test == 0){
			$peeled[$k] = $new_line;
			$k++;
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

function LoadLines($lines_list, $id_source){
	$lines = new Listotherbd();
	$lines->CreateLines($lines_list, $id_source);
	$lines_list = $lines->GetItemsArray();
	return $lines_list;;
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

function create_tbody2($array1, $array2 = NULL){
	$td1 = "<td>NIST</td>";
	$td2 = "<td>ЭСА</td>";
	$td3 = "<td></td>";
	$id1 = $array1['ID'];
	$id2 = $array2['ID'];
	$txt = $array1['text'];
	list($config1, $term1, $j1, $energy1, $bibliography1) = quantum_numbers($array1);
	$td1 .= "<td class='config'>$config1</td><td class='term'>$term1</td><td class='j'>$j1</td><td class='energy'>$energy1</td><td class='bibliography'>$bibliography1</td>";

	if(isset($array2)){
		list($config2, $term2, $j2, $energy2, $bibliography2) = quantum_numbers($array2);		
		$td2 .= "<td class='config'>$config2</td><td class='term'>$term2</td><td class='j'>$j2</td><td class='energy'>$energy2</td><td class='bibliography'>$bibliography2</td>";

		$parametr = 'config';
		$button_edit = "<td><div class='onoffswitch'><input type='checkbox' id='edit-$parametr-$id1-$id2' class='edit-level'><label class='onoffswitch-label' for='edit-$parametr-$id1-$id2'><span class='onoffswitch-inner'></span><span class='onoffswitch-switch'></span></label></div></td>";
		$td3 .= (($config1 != NULL and $config1 != $config2) ? $button_edit : "<td></td>");

		$parametr = 'term';
		$button_edit = "<td><div class='onoffswitch'><input type='checkbox' id='edit-$parametr-$id1-$id2' class='edit-level'><label class='onoffswitch-label' for='edit-$parametr-$id1-$id2'><span class='onoffswitch-inner'></span><span class='onoffswitch-switch'></span></label></div></td>";
		$td3 .= (($term1 != NULL and $term1 != $term2) ? $button_edit : "<td></td>");

		$parametr = 'j';
		$button_edit = "<td><div class='onoffswitch'><input type='checkbox' id='edit-$parametr-$id1-$id2' class='edit-level'><label class='onoffswitch-label' for='edit-$parametr-$id1-$id2'><span class='onoffswitch-inner'></span><span class='onoffswitch-switch'></span></label></div></td>";
		$td3 .= (($j1 != NULL and $j1 != $j2) ? $button_edit : "<td></td>");

		$parametr = 'energy';
		$button_edit = "<td><div class='onoffswitch'><input type='checkbox' id='edit-$parametr-$id1-$id2' class='edit-level'><label class='onoffswitch-label' for='edit-$parametr-$id1-$id2'><span class='onoffswitch-inner'></span><span class='onoffswitch-switch'></span></label></div></td>";
		$td3 .= (($energy1 != NULL and $energy1 != $energy2) ? $button_edit : "<td></td>");		
		
		$parametr = 'bibliography';
		$button_edit = "<td><div class='onoffswitch'><input type='checkbox' id='edit-$parametr-$id1-$id2' class='edit-level'><label class='onoffswitch-label' for='edit-$parametr-$id1-$id2'><span class='onoffswitch-inner'></span><span class='onoffswitch-switch'></span></label></div></td>";
		$td3 .= (($bibliography1 != NULL and $bibliography1 != $bibliography2) ? $button_edit : "<td></td>");		
		
		$test = (($config1 != NULL and $config1 != $config2) or ($term1 != NULL and $term1 != $term2) or ($energy1 != NULL and $energy1 != $energy2) or ($j1 != NULL and $j1 != $j2) or ($bibliography1 != NULL and $bibliography1 != $bibliography2) ? 1 : 0);	

	}
	$td_total = (isset($array2) ? "<td>Итог</td><td class='config'>$config2</td><td class='term'>$term2</td><td class='j'>$j2</td><td class='energy'>$energy2</td><td class='bibliography'>$bibliography2</td>" : "<td>Итог</td><td class='config'>$config1</td><td class='term'>$term1</td><td class='j'>$j1</td><td class='energy'>$energy1</td><td class='bibliography'>$bibliography1</td>");

	$buttonSave = "<input type='button' value='Сохранить' class='buttonSave' id='linksave-$id1'>";
	$buttonNotLinkSave = "<input type='button' value='Не привязывать и сохранить' class='buttonNotLinkSave' id='linksave-$id1'>";
	$checkboxForAll ="<input type='checkbox' id='checkbox-$id1'>Применить изменения ко всем аналогичным уровням<br>";

	if(isset($array2)){
		$td1 .= "<td rowspan=2>$txt</td>";
		$tr1 = "<tr id='$id1'>$td1</tr>";
		$tr2 = "<tr id='$id2'>$td2</tr>";
		if($test == 1){
			$td3 .= "<td rowspan=2>$checkboxForAll $buttonSave $buttonNotLinkSave</td>";
			$tr3_4 = "<tr>$td3</tr><tr id='total-$id1-$id2'>$td_total</tr>";
		}else{
			$td_total .= "<td>$checkboxForAll $buttonSave $buttonNotLinkSave</td>";
			$tr3_4 = "<tr id='total-$id1-$id2'>$td_total</tr>";
		}		
		$tbody = "<tbody id='$id1'>$tr1$tr2$tr3_4</tbody>";
	}else{
		$td1 .= "<td>$txt</td>";
		$tr1 = "<tr id='$id1'>$td1</tr>";
		$td_total .= "<td>$checkboxForAll $buttonSave</td>";
		$tr2 = "<tr id='total-$id1-new'>$td_total</tr>";
		$tbody = "<tbody id='$id1'>$tr1$tr2</tbody>";
	}

	return $tbody;
}

function create_tbody($array1, $array2 = NULL, $type){
	if($type == 'level'){
		$parametr[] = 'CONFIG';
		$parametr[] = 'ENERGY';
		$parametr[] = 'J';
		$parametr[] = 'TERMSECONDPART';
		$parametr[] = 'TERMPREFIX';
		$parametr[] = 'TERMFIRSTPART';
		$parametr[] = 'TERMMULTIPLY';
	}
	$td1 = "<td>NIST</td>";
	$td2 = "<td>ЭСА</td>";
	$td3 = "<td></td>";
	$id1 = $array1['ID'];
	$id2 = $array2['ID'];
	$td4 = '<td>Итог</td>';
	$txt = $array1['text'];

	foreach ($parametr as $key){		
		$td1 .= "<td class='$key'>$array1[$key]</td>";
		if(isset($array2)){
			$td2 .= "<td class='$key'>$array2[$key]</td>";
			$td4 .= "<td class='$key' id='$id2'>$array2[$key]</td>";
			if($array1[$key] != NULL and $array1[$key] != $array2[$key]){
				$test = 1;
				$td3 .= "<td><div class='onoffswitch'><input type='checkbox' id='edit-$key-$id1-$id2' class='edit-level'><label class='onoffswitch-label' for='edit-$key-$id1-$id2'><span class='onoffswitch-inner'></span><span class='onoffswitch-switch'></span></label></div></td>";
			}else{
				$td3 .= "<td></td>";
			}
		}else{
			$td4 .= "<td class='$key' id='$id1'>$array1[$key]</td>";
		}
	}
	$buttonSave = "<input type='button' value='Сохранить' class='buttonSave' id='linksave-$id1'>";
	$buttonNotLinkSave = "<input type='button' value='Не привязывать и сохранить' class='buttonNotLinkSave' id='linksave-$id1'>";
	$checkboxForAll ="<input type='checkbox' id='checkbox-$id1'>Сохранить все уровни такого статуса<br>";

	
	if(isset($array2)){
		$td1 .= "<td rowspan=2>$txt</td>";
		$tr1 = "<tr id='$id1'>$td1</tr>";
		$tr2 = "<tr id='$id2'>$td2</tr>";
		if($test == 1){
			$td3 .= "<td rowspan=2>$checkboxForAll $buttonSave $buttonNotLinkSave</td>";
			$tr3_4 = "<tr>$td3</tr><tr id='total-$id1-$id2'>$td4</tr>";
		}else{
			$td4 .= "<td>$checkboxForAll $buttonSave $buttonNotLinkSave</td>";
			$tr3_4 = "<tr id='total-$id1-$id2'>$td4</tr>";
		}		
		$tbody = "<tbody id='$id1'>$tr1$tr2$tr3_4</tbody>";
	}else{
		$td1 .= "<td>$txt</td>";
		$tr1 = "<tr id='$id1'>$td1</tr>";
		$td4 .= "<td>$checkboxForAll $buttonSave</td>";
		$tr2 = "<tr id='total-$id1-new'>$td4</tr>";
		$tbody = "<tbody id='$id1'>$tr1$tr2</tbody>";
	}
	return $tbody;
}

function clear_array($array, $name = NULL){
	$n = count($array);
	$repeat = 0;
	$null = 0;
	echo "<br>Исходная размерность $name: $n<br>";
	for($j = 0; $j < $n; $j++){
		$l1 = $array[$j]['CONFIG'].$array[$j]['ENERGY'].$array[$j]['J'].$array[$j]['TERMPREFIX'].$array[$j]['TERMMULTIPLY'].$array[$j]['TERMFIRSTPART'].$array[$j]['TERMSECONDPART'];
		$l1 = preg_replace('/ /', '', $l1);
		$l1 = preg_replace('/0/', '', $l1);
		for($i = 0; $i < $n; $i++){
			if(isset($array[$i]['ID'])){
				if($i != $j){
					$l2 = $array[$i]['CONFIG'].$array[$i]['ENERGY'].$array[$i]['J'].$array[$i]['TERMPREFIX'].$array[$i]['TERMMULTIPLY'].$array[$i]['TERMFIRSTPART'].$array[$i]['TERMSECONDPART'];
					$l2 = preg_replace('/ /', '', $l2);
					$l2 = preg_replace('/0/', '', $l2);
					if($l2 == ''){
						// if($i != 0){
						// $table .= generate_tr($array[$i]);
						unset($array[$i]);
							// echo $array[$i]['ID']." $l2 <br>";
						$null++;
						// }
					}
					if($l1 == $l2 and $l1 != ''){
						// echo $array[$j]['ID']." $l1 == ".$array[$i]['ID']." $l2 <br>";
						// $table .= generate_tr($array[$i]);
						unset($array[$i]);	
						$repeat++;		
					}
				}
			}
			
		}
	}
	$m = count($array);
	echo "Конечная размерность $name: $m<br>";
	echo "Итог удалено: дублирующиеся - $repeat; нулевых - $null<br>";
	// $head_table = '<tr><td>ID</td><td>WAVELENGTH</td><td>INTENSITY</td><td>PROBABILITY</td><td>lower energy</td><td>upper energy</td><td>lower config</td><td>lower termprefix</td><td>lower termfirstpart</td><td>lower termsecondpart</td><td>lower termmultiply</td><td>lower j</td><td>upper config</td><td>upper termprefix</td><td>upper termfirstpart</td><td>upper termsecondpart</td><td>upper termmultiply</td><td>upper j</td></tr>';
	// echo '<table border=1 cellpadding=7 id="table_match_lines">'.$head_table.$table.'</table><hr>';
	return $array;
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

function config_analys($config1, $config2){
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


	$config12 =  preg_replace('/\((.*?)\)/i', '', $config1);	
	$config22 =  preg_replace('/\((.*?)\)/i', '', $config2);
	$pos1 = strripos($config12, $config22);
	$pos2 = strripos($config22, $config12); 
	// var_dump($out);
	
	if($config1 != $config2 and $config12 != $config22 and (!$pos1 or !$pos2) and !$resultresidue){
		$result['status'] = 'a';
		$result['text'] = "различная запись конфигурации и атомного остатка";
		return $result;
	}elseif($config1 != $config2 and $config12 == $config22 and !$resultresidue){
		$result['status'] = 'b';
		if($config1 == $config12){
			$notresidue = "(импортированный уровень без атомного остатка)";
			$result['status'] .= 'd';
		}
		if($config2 == $config22){
			$notresidue .= "(уровень ЭСА без атомного остатка)";
			$result['status'] .= 'f';
		}
		$result['text'] = "различная запись атомного остатка $notresidue";
		return $result;
	}elseif($pos1 !== false or $pos2 !== false){
		$result['status'] = 'c';
		$result['text'] = "различная запись конфигурации";
		return $result;
	}else{
		return NULL;
	}
}

function analysis_levels($new_levels_list, $id_source){
	$levels_list = new LevelList;
	$levels_list->Load($id_source);
	$levels_list = $levels_list->GetItemsArray();
	// $levels_list = clear_array($levels_list, 'ЭСА');
	$k = 0;
	$new_levels_list = clear_space($new_levels_list);
	$levels_list = clear_space($levels_list);
	$parametr[] = 'CONFIG';
	$parametr[] = 'ENERGY';
	$parametr[] = 'J';
	$parametr[] = 'TERMPREFIX';
	$parametr[] = 'TERMFIRSTPART';
	$parametr[] = 'TERMMULTIPLY';
	$parametr[] = 'TERMSECONDPART';
	foreach ($new_levels_list as $import_level){
		$energy_min = 1;
		unset($found_level);
		unset($limit_energy);
		unset($limit_energy_conf);
		$i = 0;
		foreach ($levels_list as $level){
			if(!$level["found"]){
				$config = $term = $j = $energy = $multiply = false;

				$term_level 	= preg_replace( '/ /', '', $import_level['TERMPREFIX'].$import_level['TERMFIRSTPART'].$import_level['TERMSECONDPART'].$import_level["TERMMULTIPLY"]);
				$new_term_level	= preg_replace( '/ /', '', $level['TERMPREFIX'].$level['TERMFIRSTPART'].$level['TERMSECONDPART'].$level["TERMMULTIPLY"]);

				$config_analys = config_analys($import_level['CONFIG'], $level['CONFIG']);

				if($import_level["CONFIG"] == $level["CONFIG"]){
					$config = true;
				}
				if($term_level == $new_term_level){
					$term = true;			
				}
				// if($import_level["TERMMULTIPLY"] == $level["TERMMULTIPLY"]){
				// 	$multiply = true;
				// }
				if($import_level["J"] == $level["J"]){
					$j = true;		
				}
				if($import_level["ENERGY"] == $level["ENERGY"]){
					$energy = true;		
				}

				if($config and $term and $j and $energy){
					$level["text"] = "Уровень найден";
					$level["status"] = "abs";
					// if(!$multiply){
					// 	$level["text"] .= "<br>Ошибки: ";
					// 	$level["status"] .= "abs";
					// }
					$found_level = $level;
					$levels_list[$i]["found"] = true;
					break;
				}elseif($config_analys != NULL and $term and $j and $energy){
					$level["text"] = "Уровень найден. Ошибки: ".$config_analys['text'];
					$level["status"] = "abs".$config_analys['status'];
					$found_level = $level;
					$levels_list[$i]["found"] = true;
					break;
				}else{
					$difference = abs($import_level["ENERGY"] - $level["ENERGY"]);
					if($difference < $energy_min and $term and $j){
						$energy_min = $difference;
						if($config){
							$level["text"] = "Уровень найден. Ошибки: погрешность в энергии";
							$level["status"] = "abs2";
							$found_level = $level;
							$levels_list[$i]["found"] = true;
							break;
						}elseif($config_analys != NULL){
							$level["text"] = "Уровень найден. Ошибки: погрешность в энергии и ".$config_analys['text'];
							$level["status"] = "abs".$config_analys['status'];
							$found_level = $level;
							$levels_list[$i]["found"] = true;
							break;
						}
					}
				}
			}
			$i++;
		}
		if(isset($found_level)){
			$new_levels_list[$k]["foundLevel"] = $found_level["ID"];
			$new_levels_list[$k]["text"] = $found_level["text"];
			$new_levels_list[$k]["status"] = $found_level["status"];
			$print_t .= create_tbody2($new_levels_list[$k], $found_level);
		}
		$k++;
	}
	$k = 0;
	foreach ($new_levels_list as $import_level){
		if(empty($import_level["foundLevel"])){
			$energy_min = 1;
			unset($limit_energy);
			unset($limit_energy_conf);
			$i = 0;
			foreach ($levels_list as $level){
				if(!$level["found"]){
					$config_analys = config_analys($import_level["CONFIG"], $level["CONFIG"]);
					$difference = abs($import_level["ENERGY"] - $level["ENERGY"]);
					if($difference < $energy_min){
						$match = $stat = 0;
						foreach($parametr as $key){
							if($import_level[$key] == $level[$key]){
								$stat .= $match;
							}
							$match++;
						}
						if($config_analys != NULL){
							$level["text"] = "Может быть этот уровень: совпадение по конфигурации и близко по энергии";
							$level["status"] = "mtl$stat".$config_analys['status'];
							$limit_energy_conf = $level;
						}else{
							$level["text"] = "Может быть этоот уровень: близко по энергии";
							$level["status"] = "mtl2$stat";
							$limit_energy = $level;
						}
					}
				}
			}
			if(isset($limit_energy_conf)){
				$new_levels_list[$k]["foundLevel"] = $limit_energy_conf["ID"];
				$new_levels_list[$k]["text"] = $limit_energy_conf["text"];
				$new_levels_list[$k]["status"] = $limit_energy_conf["status"];
				$print_t .= create_tbody2($new_levels_list[$k], $limit_energy_conf);
			}elseif(isset($limit_energy)){
				$new_levels_list[$k]["foundLevel"] = $limit_energy["ID"];
				$new_levels_list[$k]["text"] = $limit_energy["text"];
				$new_levels_list[$k]["status"] = $limit_energy_conf["status"];
				$print_t .= create_tbody2($new_levels_list[$k], $limit_energy);
			}else{
				$new_levels_list[$k]['foundLevel'] = 'new';
				$new_levels_list[$k]["text"] = 'Новый уровень';
				$new_levels_list[$k]["status"] = $limit_energy_conf["status"];
				$print_t .= create_tbody2($new_levels_list[$k], NULL);
			}
		}
		$k++;
	}

	echo '<table cellpadding="0" cellspacing="0" border="0" class="display view" id="levels_table">
	<tbody><tr>
		<th>БД</th>
		<th>Конфигурация</th>
		<th>Терм</th>
		<th>J</th>
		<th>Энергия</th>
		<th>Библиоссылка</th>
		<th>Примечания</th>
	</tr></tbody>'.$print_t.'</table><hr>';
	return json_encode($new_levels_list);
}

function import_nist_levels($name, $ion = NULL){
	if(empty($ion)) $ion = 1;
	$ion_roman = number_to_roman($ion);
	$element = "$name $ion_roman";
	echo "$element<br>";
	$ion--;

	$id_source = new Listotherbd();
	$id_source->SearchIdAtom($name, $ion);
	$id_source = $id_source->GetItemsArray();
	$id_source = $id_source[0]['ID'];

	$html = curl_import_levels_nist($element);
	file_put_contents('file/file.htm', $html);
	// $html = file_get_contents('file/file.htm');
	$table = parsing_levels($html);
	$xml_levels = xml_object($table, 'level');
	list($nist_levels, $nist_limit) = levels_nist($xml_levels);
	if(empty($nist_levels)){
		echo "<p>По заданному запросу нет данных</p>";
	}
	if(isset($id_source)){
		$nist_levels = testLevelsNIST($nist_levels, $id_source);
		if(empty($nist_levels)){
			echo "<p>Нет новых уровней</p>";
		}
		$nist_levels = LoadLevels($nist_levels, $id_source);
		$levels_json = analysis_levels($nist_levels, $id_source);
		var_dump($nist_limit);
	}elseif(isset($nist_levels)){
		echo "Такого элемента $element нет в базе ЭСА<br>";
		foreach ($nist_levels as $levels) {
			$tbody .= generate_tr($levels);
		}
		echo "<table border=1 cellpadding=7 >$tbody</table>";
	}
	return array($levels_json, $id_source, $element);
}

function analysis_lines($nist_lines, $id_source){
	// $lines_list = new TransitionList();
	// $lines_list->LoadWithLevels($id_source);
	// $lines_list = $lines_list->GetItemsArray();
	$lines_list = new Listotherbd();
	$lines_list->LoadLines($id_source);
	$lines_list = $lines_list->GetItemsArray();
	echo "<br> Кол-во переходов НИСТ: ".count($nist_lines).";<br>Кол-во переходов ЭСА: ".count($lines_list)."<br>";
	$j = 0;
	foreach ($nist_lines as $nist_line){
		$i = 0;
		$test = false;
		$testUnclass = ($nist_line['LOWER_LEVEL'] != NULL and $nist_line['UPPER_LEVEL'] != NULL ? 1 : 0);
		if($testUnclass == 1){
			foreach ($lines_list as $line){
				if($line['found'] != true){
					if($nist_line['LOWER_LEVEL'] == $line['ID_LOWER_LEVEL'] and $nist_line['UPPER_LEVEL'] == $line['ID_UPPER_LEVEL']){
						$lines_list[$i]['found'] = true;
						$test = true;
						echo "Равны: ".$nist_line['LOWER_LEVEL']." == ".$line['ID_LOWER_LEVEL']." and ".$nist_line['UPPER_LEVEL']." == ".$line['ID_UPPER_LEVEL']."<br>";
						$foundLines++;
					}
				}
				$i++;
			}
		}else{
			$unclassified++;
		}

		if(!$test and $testUnclass == 1){
			echo "Новые переходы: ".$nist_line['LOWER_LEVEL']." > ".$nist_line['UPPER_LEVEL']." |".$nist_line['WAVELENGTH']."  ".$nist_line['INTENSITY']."<br>";
			$newLines++;
		}
		$j++;
	}
	$foundLines = ($foundLines > 0 ? $foundLines : 'отсутствуют');
	echo "Итого найдено: $foundLines <br>";
	$unclassified = ($unclassified > 0 ? $unclassified : 'отсутствуют');
	echo "Неклассифицированные переходы НИСТ: $unclassified <br>";
	$newLines = ($newLines > 0 ? $newLines : 'отсутствуют');
	echo "Новые переходы: $newLines<br>";
}

function import_nist_lines($name, $ion = NULL){
// function import_nist_lines($id_source, $element){
	if(empty($ion)) $ion = 1;
	$ion_roman = number_to_roman($ion);
	$element = "$name+$ion_roman";
	$ion--;

	$id_source = new Listotherbd();
	$id_source->SearchIdAtom($name, $ion);
	$id_source = $id_source->GetItemsArray();
	$id_source = $id_source[0]['ID'];
	//*******************************
	$html = curl_import_lines_nist($element);
	file_put_contents('file/file.htm', $html);
	// $html = file_get_contents('file/file.htm');
	$table = parsing_lines($html);
	$xml_transitions = xml_object($table, 'transition');
	$nist_lines = lines_nist($xml_transitions);
	$nist_lines = clear_space($nist_lines);
	//*******************************
	//$nist_lines = testLinesNIST($nist_lines, $id_source);
	// if(empty($nist_lines)){
	// 	echo "<p>Нет новых переходов</p>";
	// 	return 0;
	// }
	$nist_lines = LoadLines($nist_lines, $id_source);
	//*******************************
	// $id_source = 141269;
	// $lines = new Listotherbd();
	// $lines->CreateLinesTemp($id_source, 'NIST');
	// $nist_lines = $lines->GetItemsArray();
	//*******************************
	analysis_lines($nist_lines, $id_source);
}
// import_nist_lines($atom);
// function import_xsams_levels(){}
// function import_xsams_levels(){}

 // import_nist_lines('He');
?>