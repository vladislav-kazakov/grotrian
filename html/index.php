<?
if (isset ($_REQUEST['pagetype']) && $_REQUEST['pagetype'] == "spectrumpng"){
	header("Content-type: image/png;");
	require_once("configure.php");
	require_once("includes/atom.php");
	$atom = new Atom;
	$element_id=$_REQUEST['element_id'];
	$atom->Load($element_id);
	$atom_sys = $atom->GetAllProperties();
	echo $atom_sys['SPECTRUM_IMG'];
	exit;
}
	header('Content-Type: text/html; charset=windows-1251'); 
	global $smarty, $dictionary, $element_types;
	//session_start();

	require_once("configure.php");
	require_once("includes/elementlist.php");
	require_once("includes/atom.php");
	require_once("includes/atomlist.php");
	require_once("includes/levellist.php");
	require_once("includes/transitionlist.php");
	require_once("includes/sourcelist.php");
	require_once("includes/spectrum.php");
	require_once("includes/user.class.php");

	// require_once("includes/counter.php");
	// $counter = new Counter;
	// $counter->Create();
	///

	//print_r($result);
	
	//Подключаем класс локализации
	require_once("includes/localization.class.php");
	//Подключаем словарь
	require_once("dictionary/dictionary.inc");
	
	$l10n = new Localization($dictionary);
	$elements = new ElementList;
	//загружаем таблицу элементов с локализованными именами и ст. ионизацией = 0;	
	$elements->LoadPereodicTable($l10n->locale,0);
	$table=$elements->GetItemsArray();
	$smarty->assign('periodic_table',$table);
	
	//загружаем макс. количество уровней  ст. ионизацией = 0;	
	//$elements->LoadMaxLevelsNUM(0);
	//$maxLevels=$elements->GetItemsArray();
	//$smarty->assign('MaxLevels',$maxLevels[0]["MAXLEVELS_NUM"]);
	
	
	//print_r($l10n->locale);
	//print_r($l10n->dictionary);
	//print_r($_COOKIE);
	//если в строке запроса есть id элемента и это число
	//print_r($_REQUEST);

	if((isset($_REQUEST['pagetype'])) && ($_REQUEST['pagetype']!="articles") 
	&& ($_REQUEST['pagetype']!="bibliography") && ($_REQUEST['pagetype']!="sources") 
	&& (isset($_REQUEST['element_id'])) && (is_numeric($_REQUEST["element_id"])))	
	{	
		$element_id=$_REQUEST['element_id'];
		
		//Ионы
		$ion_list = new ElementList;
		$ion_list->Loadions($element_id);		

		//если удаётся получить массив ионов
		$ions=$ion_list->GetItemsArray();
		if ($ions)	{
			//получаем имя элемента
			$elname=$ions[0]['ELNAME'];		

			//получаем массив типов элементов(из словаря) и загоняем его в smarty()			
			
			$smarty->assign('element_types', $element_types);
			//берём масив данных о элементе и передаём его смарти

			$atom = new Atom;
			$atom->Load($element_id);

			$atom_sys = $atom->GetAllProperties();
			$atom_name = $elname;
			if ($atom_name !='H' && $atom_name !='D' && $atom_name !='T' )
				$atom_name .= ' ' . numberToRoman(intval($atom_sys['IONIZATION']) + 1);
			$smarty->assign('atom', $atom_sys);
			
			$ichi = '1S/'.$elname;
			$ichi .= !empty($atom_sys['IONIZATION']) ? "/q+".$atom_sys['IONIZATION'] : "";
			//$ichi_key = hash('sha256',$ichi);
			
			$smarty->assign('ichi', $ichi);
			//$smarty->assign('ichi_key', $ichi_key);

			$e_count = intval($atom_sys['Z']) - intval($atom_sys['IONIZATION']);
			$smarty->assign('e_count', $e_count);

            $isotop = FALSE;
			if (isset($atom_sys['MASS_NUMBER']) and $atom_sys['MASS_NUMBER']!= "") $isotop = TRUE;
            $smarty->assign('isotop', $isotop);

			//Уровни
			$level_list = new LevelList;
			// отдаём в смарти число уровней
			$level_count = $level_list->LoadCount($element_id);			
			$smarty->assign('level_count', $level_count);

		
			//Переходы
			$transition_list = new TransitionList;
			// отдаём в смарти число переходов
			$transition_count = $transition_list->LoadCount($element_id);
			$smarty->assign('transition_count', $transition_count);			
			
			//Получаем библиоссылки
//			$smarty->assign('book_count', 0);		
		
			$smarty->assign("bodyclass","elements");	
			
	
		}
	}

	//Если мы получили тип страницы
	if(isset($_REQUEST['pagetype'])){
	$pagetype=$_REQUEST['pagetype'];

	//Если есть информация об интерфейсе и он - админский 
	if(isset($_REQUEST['interface'])){
		include "includes/auth.php"; 	
		$interface = "edit";	
		$page_type = "view";					
	
	}	else $interface="view";
	
	//Если есть информация об элементе
	if (isset($elname))		
	//в зависимости от типа страницы готовимся вывести результат
	switch ($pagetype) 
	{
		case "element": {

			// 	берём массив переходов	
			$transition_list->LoadWithLevels($element_id);
			$transitions = $transition_list->GetItemsArray();

			$page_type = "view_element.tpl";
			$head = "element_description";
			$title = "element_description";
			$headline = "element_description";
			$bodyclass = "element";
			$header_type = "header.tpl";
			$footer_type = "footer.tpl";


			if (isset($_POST['export'])) {
				$spectrum = new Spectrum();
				$spectrum->export($transitions, $elname);
			}
    		
    		break;
    	}

		case "compare" : {
			// 	берём массив переходов	
			$transition_list->LoadWithLevels($element_id);
			$transitions=$transition_list->GetItemsArray();
			// берём json объект длин волн и отдаём его в смарти
			$spectrum= new Spectrum();			
			$smarty->assign('spectrum_json',$spectrum->getSpectraSVG($transitions,0,1599900000));

			$spectrum_json_uploaded = 0;
			
			if ((isset($_FILES['file']) && !$_FILES['file']['error']) || isset($_REQUEST['standard_file'])) {
				if (isset($_REQUEST['standard_file'])) {
					$file = $_REQUEST['standard_file'];

					switch ($file) {
						case 1:
							$_FILES['file']['tmp_name'] = 'files/hghe500.csv';
							break;
						case 2:
							$_FILES['file']['tmp_name'] = 'files/Cu-Zn-hollow cathode-300msec.csv';
							break;
						case 3:
							$_FILES['file']['tmp_name'] = 'files/DDS030-170msec.csv';
							break;
						case 4:
							$_FILES['file']['tmp_name'] = 'files/DDS030-36msec.csv';
							break;
						case 5:
							$_FILES['file']['tmp_name'] = 'files/DDS030-470msec.csv';
							break;
						case 6:
							$_FILES['file']['tmp_name'] = 'files/DVS25-1000msec.csv';
							break;
						case 7:
							$_FILES['file']['tmp_name'] = 'files/DVS25-245msec.csv';
							break;
						case 8:
							$_FILES['file']['tmp_name'] = 'files/DVS25-500msec.csv';
							break;
						case 9:
							$_FILES['file']['tmp_name'] = 'files/Hg-hollowcathode-21msec.csv';
							break;
						case 10:
							$_FILES['file']['tmp_name'] = 'files/Home-125msec.csv';
							break;
						case 11:
							$_FILES['file']['tmp_name'] = 'files/Home-25msec.csv';
							break;
						case 12:
							$_FILES['file']['tmp_name'] = 'files/Na-1700msec.csv';
							break;
						case 13:
							$_FILES['file']['tmp_name'] = 'files/Na-170msec.csv';
							break;
						case 14:
							$_FILES['file']['tmp_name'] = 'files/Ta-hollow cathode-62msec.csv';
							break;
						case 15:
							$_FILES['file']['tmp_name'] = 'files/Ta-Kortek-hollowcathode-90msec.csv';
							break;
						case 16:
							$_FILES['file']['tmp_name'] = 'files/Cz - 50 ms.csv';
							break;
						case 17:
							$_FILES['file']['tmp_name'] = 'files/Cz - 100 ms.csv';
							break;
						case 18:
							$_FILES['file']['tmp_name'] = 'files/Cz - 1000 ms.csv';
							break;
					}

				}  

				$spectrum_json_uploaded = $spectrum->parse_file($_FILES['file']);
			}

			$level_list = new LevelList;
			$level_list->LoadBase($element_id);
			$levels_array = $level_list->GetItemsArray();
			$smarty->assign('base_level', $levels_array[0]['CONFIG']);

			$smarty->assign('spectrum_json_uploaded', $spectrum_json_uploaded);  

    		$page_type="compare_element.tpl";
			$head="Compare_spectra";
			$title="Compare_spectra";
			$headline="Compare_spectra";
			$bodyclass="compare";
    		$header_type="header.tpl";
    		$footer_type="footer.tpl";

			break;
		}

	    case "levels": {
	    
	    	//отдаём в смарти массив уровней
			$level_list->Load($element_id);
			
			$smarty->assign('level_list',$level_list->GetItemsArray());
				    
	    	//указываем имя шаблона и название страницы    		
			$page_type="view_levels.tpl"; 
    		$head="Atomic_levels";
    		$title="Atomic_levels";
    		$headline="Atomic_levels";
    		$bodyclass="levels"; 
    		$header_type="header.tpl";
    		$footer_type="footer.tpl";
    		break;
    	}
    	
		case "addlevels": {
			if ($interface != "edit") exit;
	    //print_r($_GET);
			if (isset($_GET['attribute2']) || isset($_GET['attribute3'])){
				$level_list->LoadFiltered($element_id,$_GET['attribute2'], isset($_GET['attribute3'])?$_GET['attribute3']:null);
			} else $level_list->Load($element_id);
			
	    	//отдаём в смарти массив уровней		
			//$level_list->Load($element_id);
			if (isset($_GET['attribute1']))	$smarty->assign('transition_id',$_GET['attribute1']);
			if (isset($_GET['attribute2']))	$smarty->assign('position',$_GET['attribute2']);
			
			//print_r($level_list->GetItemsArray());
			$smarty->assign('level_list',$level_list->GetItemsArray());
				    
	    	//указываем имя шаблона и название страницы    		
			$page_type="add_levels.tpl"; 
    		$head="Atomic_levels";
    		$title="Atomic_levels";
    		$headline="Atomic_levels";
    		$bodyclass="levels"; 
    		$header_type="iframe_header.tpl";
    		$footer_type="iframe_footer.tpl";
    		break;
    	}
    	
		case "transitions": {

		    // отдаём в смарти массив переходов	
			$transition_list->LoadWithLevels($element_id);
			$smarty->assign('transition_list',$transition_list->GetItemsArray());
				
    		//указываем имя шаблона и название страницы    		
			$page_type="view_transitions.tpl"; 
    		$head="Atomic_transitions";
    		$title="Atomic_transitions";
    		$headline="Atomic_transitions";
    		$bodyclass="transitions"; 
    		$header_type="header.tpl";
    		$footer_type="footer.tpl";
    		break;    		

    	}    	

    	case "diagram":
        case "newdiagram":
            ob_start();
            include "svg.php";
            $svg = ob_get_contents();
            ob_end_clean();
            $smarty->assign('svg', $svg);
            if (isset($_REQUEST['enmin'])) $smarty->assign('enmin', $_REQUEST['enmin']);
            if (isset($_REQUEST['enmax'])) $smarty->assign('enmax', $_REQUEST['enmax']);
            if (isset($_REQUEST['wlmin'])) $smarty->assign('wlmin', $_REQUEST['wlmin']);
            if (isset($_REQUEST['wlmax'])) $smarty->assign('wlmax', $_REQUEST['wlmax']);
	        if (isset($_REQUEST['nmax'])) $smarty->assign('nmax', $_REQUEST['nmax']);
    	    if (isset($_REQUEST['lmax'])) $smarty->assign('lmax', $_REQUEST['lmax']);
            if (isset($_REQUEST['width'])) $smarty->assign('width', $_REQUEST['width']);
            if (isset($_REQUEST['groupbyMu'])) $smarty->assign('groupbyMu', true);
            if (isset($_REQUEST['prohibitedbyMuOff'])) $smarty->assign('prohibitedbyMuOff', true);
            if (isset($_REQUEST['prohibitedbyParOff'])) $smarty->assign('prohibitedbyParOff', true);
            if (isset($_REQUEST['autoStatesOff'])) $smarty->assign('autoStatesOff', true);
            if (isset($_REQUEST['grouping'])) $smarty->assign('grouping', $_REQUEST['grouping']);

            $head="Grotrian_Charts";
            $title="Grotrian_Charts";
            $headline="Atomic_charts";
            //указываем имя шаблона и название страницы
        	if ($pagetype == "diagram") {
                $page_type = "view_diagram.tpl";
                $bodyclass = "diagram";
                $header_type = "header.tpl";
                $footer_type = "footer.tpl";
                $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $url = str_replace("diagram", "newdiagram", $url);
                $smarty->assign('new_window_url', $url);
            }
			if ($pagetype == "newdiagram") {
				$page_type = "view_new_diagram.tpl";
				$bodyclass = "new_diagram";
				$header_type = "top_header.tpl";
				$footer_type = "bottom_footer.tpl";
			}
    		break;
        case "json":
            header('Content-Type: application/json');
            $transition_list->LoadWithLevels($element_id);
            $transitions=$transition_list->GetItemsArray();
            $spectrum = new Spectrum();
            foreach ($transitions as &$transition) {
                $transition['color'] = $spectrum->wavelength2RGB(round($transition['WAVELENGTH']/10));
			}
            unset($transition);
            //$data = $spectrum->getSpectraSVG($transitions,0,1599900000);
            echo json_encode($transitions);
            break;
        case "jsonlevels":
            header('Content-Type: application/json');
            $level_list->Load($element_id);
            $levels = $level_list->GetItemsArray();
            echo json_encode($levels);
            break;
        case "spectrum": {
            $transition_list->LoadWithLevels($element_id);
            $transitions=$transition_list->GetItemsArray();
            // берём json объект длин волн и отдаём его в смарти
            $spectrum= new Spectrum();
            if (isset($_REQUEST['auto'])){
                $smarty->assign('auto', true);
                $atomNext = new Atom;
                $atomNext->LoadNext($element_id);
                $atomNext_sys = $atomNext->GetAllProperties();
                $smarty->assign('next_element_id', $atomNext_sys['ID']);
            }
            $smarty->assign('spectrum_json',$spectrum->getSpectraSVG($transitions,0,1599900000));

            $level_list = new LevelList;
            $level_list->LoadBase($element_id);
            $levels_array = $level_list->GetItemsArray();
            if (isset($levels_array[0]['CONFIG']))
            	$smarty->assign('base_level', $levels_array[0]['CONFIG']);

            //указываем имя шаблона и название страницы
            $page_type="view_spectrum.tpl";
            $head="Spectrogram";
            $title="Spectrogram";
            $headline="Spectrogram";
            $bodyclass="spectrum";
            $header_type="header.tpl";
            $footer_type="footer.tpl";
            break;
        }
		case "circle": {
			$transition_list->LoadGroupForCircleSpectrum($element_id);
			$transitions=$transition_list->GetItemsArray();
			// берём json объект длин волн и отдаём его в смарти
			$spectrum= new Spectrum();
			if (isset($_REQUEST['auto'])){
				$smarty->assign('auto', true);
				$atomNext = new Atom;
				$atomNext->LoadNext($element_id);
				$atomNext_sys = $atomNext->GetAllProperties();
				$smarty->assign('next_element_id', $atomNext_sys['ID']);
			}

			$grouped_levels = new LevelList();
			$grouped_levels->Load($element_id);
			$grouped_levels_arr=$grouped_levels->GetItemsArray();
			$smarty->assign('levels_json',$spectrum->getLevelsSVG($grouped_levels_arr));
			$smarty->assign('spectrum_json',$spectrum->getSpectraSVG($transitions,0,1599900000));

			$level_list = new LevelList;
			$level_list->LoadBase($element_id);
			$levels_array = $level_list->GetItemsArray();
			$smarty->assign('base_level', $levels_array[0]['CONFIG']);

			//указываем имя шаблона и название страницы
			$page_type="view_circle.tpl";
			$head="Spectrogram";
			$title="Spectrogram";
			$headline="Spectrogram";
			$bodyclass="circle";
			$header_type="header.tpl";
			$footer_type="footer.tpl";
			break;
		}
        case "cf": {
            $atom->Load($element_id);
            $atom_sys = $atom->GetAllProperties();
            unset($atom_sys['SPECTRUM_IMG']);
            foreach (array_keys($atom_sys) as $key) {
                $atom_sys[$key] = iconv("Windows-1251", "UTF-8", $atom_sys[$key]);
            }
            $smarty->assign('atom_json', json_encode($atom_sys, JSON_UNESCAPED_UNICODE));

            $transition_list->LoadWithLevels($element_id);
            $transitions = $transition_list->GetItemsArray();
            $spectrum = new Spectrum();

            foreach ($transitions as &$transition) {
                $transition['color'] = $spectrum->wavelength2RGB(($transition['WAVELENGTH']/10));
            } unset($transition);

            $smarty->assign('transitions_json',json_encode($transitions));

            $level_list->Load($element_id);
            $levels = $level_list->GetItemsArray();
            $smarty->assign('levels_json',json_encode($levels));

            //указываем имя шаблона и название страницы
            $page_type="view_cf.tpl";
            $head="Kvantogram";
            $title="Kvantogram";
            $headline="Kvantogram";
            $bodyclass="cf";
            $header_type="header.tpl";
            $footer_type="footer.tpl";
            break;
        }
	    case "newdiagram": {
    		//указываем имя шаблона и название страницы
			$page_type="view_new_diagram.tpl";
    		$head="Grotrian_Charts";
    		$title="Grotrian_Charts";
    		$headline="Atomic_charts";
    		$bodyclass="new_diagram";
    		$header_type="top_header.tpl";
    		$footer_type="bottom_footer.tpl";
    		break;
    	}

    	default: {
			header("HTTP/1.0 404 Not Found");
			exit;
    		//Уровни
    		$level_list = new LevelList;
    		// отдаём в смарти число уровней
    		$level_count = $level_list->LoadCount();
    		$smarty->assign('level_count', $level_count);
    		
    		
    		//Переходы
    		$transition_list = new TransitionList;
    		// отдаём в смарти число переходов
    		$transition_count = $transition_list->LoadCount();
    		$smarty->assign('transition_count', $transition_count);
    		
    		$page_type=$l10n->locale."/index.tpl"; 
    		$head="Information_system_Electronic_structure_of_atoms";
    		$title="About_project";
    		$headline="About_project";
    		$bodyclass="index"; 
    		$header_type="index_header.tpl";
    		$footer_type="footer.tpl";
    		break;
    	}
	} else
	//Если нет информации об элементе
	switch ($pagetype) {
        case "stats": {

            $atom_list = new AtomList;

            $atom_count = $atom_list->LoadCountByIonization();
            echo "Всего атомных систем описано: " . $atom_count . "<br>\r\n";

            $atom_count = $atom_list->LoadCountByIonization(0);
            echo "Нейтральных атомов описано: " . $atom_count . "<br>\r\n";

            $atom_count = $atom_list->LoadCountByIonization(0, ">");
            echo "Ионов описано: " . $atom_count . "<br>\r\n";

            $atom_count = $atom_list->LoadCountByIonizationWithLevels();
            echo "Атомных систем с уровнями описано: " . $atom_count . "<br>\r\n";

            $atom_count = $atom_list->LoadCountByIonizationWithLevels(0);
            echo "Нейтральных атомов с уровнями  описано: " . $atom_count . "<br>\r\n";

            $atom_count = $atom_list->LoadCountByIonizationWithLevels(0, ">");
            echo "Ионов описано с уровнями: " . $atom_count . "<br>\r\n";

            $atom_count = $atom_list->LoadCountByIonizationWithTransitions();
            echo "Атомных систем с переходами описано: " . $atom_count . "<br>\r\n";

            $atom_count = $atom_list->LoadCountByIonizationWithTransitions(0);
            echo "Нейтральных атомов с переходами  описано: " . $atom_count . "<br>\r\n";

            $atom_count = $atom_list->LoadCountByIonizationWithTransitions(0, ">");
            echo "Ионов описано с переходами: " . $atom_count . "<br>\r\n";

            $level_list = new LevelList;
            $level_count = $level_list->LoadCountByIonization();
            echo "Всего уровней: " . $level_count . "<br>\r\n";

            $level_count = $level_list->LoadCountByIonization(0);
            echo "Уровней нейтральных атомов: " . $level_count . "<br>\r\n";

            $level_count = $level_list->LoadCountByIonization(0, ">");
            echo "Уровней ионов: " . $level_count . "<br>\r\n";

            $level_count = $level_list->LoadClassifiedCountByIonization();
            echo "Всего классифицированных уровней: " . $level_count . "<br>\r\n";

            $level_count = $level_list->LoadClassifiedCountByIonization(0);
            echo "Классифицированных уровней нейтральных атомов: " . $level_count . "<br>\r\n";

            $level_count = $level_list->LoadClassifiedCountByIonization(0, ">");
            echo "Классифицированных уровней ионов: " . $level_count . "<br>\r\n";

            $transition_list = new TransitionList;
            $transition_count = $transition_list->LoadCountByIonization();
            echo "Всего переходов: " . $transition_count . "<br>\r\n";

            $transition_count = $transition_list->LoadCountByIonization(0);
            echo "Переходов нейтральных атомов: " . $transition_count . "<br>\r\n";

            $transition_count = $transition_list->LoadCountByIonization(0, ">");
            echo "Переходов ионов: " . $transition_count . "<br>\r\n";

            $transition_count = $transition_list->LoadClassifiedCountByIonization();
            echo "Всего классифицированных переходов: " . $transition_count . "<br>\r\n";

            $transition_count = $transition_list->LoadClassifiedCountByIonization(0);
            echo "Классифицированных переходов нейтральных атомов: " . $transition_count . "<br>\r\n";

            $transition_count = $transition_list->LoadClassifiedCountByIonization(0, ">");
            echo "Классифицированных переходов ионов: " . $transition_count . "<br>\r\n";

            exit;
            break;
        }
        case "json":
            header('Content-Type: application/json');
            $atom_list = new AtomList;
            $atom_list->Load();
            $atom_array = $atom_list->GetItemsArray();
            foreach ($atom_array as &$array){
                foreach (array_keys($array) as $key) {
                    $array[$key] = iconv("Windows-1251", "UTF-8", $array[$key]);
                }
    		}
    		unset($array);
            echo json_encode($atom_array, JSON_UNESCAPED_UNICODE);
            break;
		case "index": {
	    	
	    	//Уровни
	    	$level_list = new LevelList;
	    	// отдаём в смарти число уровней
	    	$level_count = $level_list->LoadCount();
	    	$smarty->assign('level_count', $level_count);
	    	
	    	
	    	//Переходы
	    	$transition_list = new TransitionList;
	    	// отдаём в смарти число переходов
	    	$transition_count = $transition_list->LoadCount();
	    	$smarty->assign('transition_count', $transition_count);
	    	
    		$page_type=$l10n->locale."/index.tpl"; 
    		$head="Information_system_Electronic_structure_of_atoms";
    		$title="About_project";
    		$headline="About_project";
    		$bodyclass="index"; 
    		$header_type="header.tpl";
    		$footer_type="footer.tpl";
    		break;
    	}
    	
		case "links": {
    		//указываем имя шаблона и название страницы    		
			$page_type=$l10n->locale."/links.tpl";
    		$head="Other_resources_for_atomic_spectroscopy";
    		$title="Other_resources_for_atomic_spectroscopy";
    		$headline="Other_resources_for_atomic_spectroscopy";
    		$bodyclass="links";
    		$header_type="index_header.tpl";
    		$footer_type="footer.tpl";
    		break;
    	}
    	
		case "team": {
    		//указываем имя шаблона и название страницы    		
			$page_type=$l10n->locale."/team.tpl";
    		$head="Project_team";
    		$title="Project_team";
    		$headline="Project_team";
    		$bodyclass="team";
    		$header_type="index_header.tpl";
    		$footer_type="footer.tpl";
    		break;
    	}
    	
    	
		case "sponsors": {
    		//указываем имя шаблона и название страницы    		
			$page_type=$l10n->locale."/sponsors.tpl";
    		$head="Sponsors";
    		$title="Sponsors";
    		$headline="Sponsors";
    		$bodyclass="sponsors";
    		$header_type="index_header.tpl";
    		$footer_type="footer.tpl";
    		break;
    	}
    	
		case "awards": {
    		//указываем имя шаблона и название страницы    		
			$page_type=$l10n->locale."/awards.tpl";
    		$head="Awards";
    		$title="Awards";
    		$headline="Awards";
    		$bodyclass="awards";
    		$header_type="index_header.tpl";
    		$footer_type="footer.tpl";
    		break;
    	}   

    	case "periodictable": {
    		//указываем имя шаблона и название страницы    	
    			
			$page_type="view_periodictable.tpl";
    		$head="Periodic_Table";
    		$title="Periodic_Table";
    		$headline="Periodic_Table";
    		$bodyclass="periodictable";
    		$header_type="header.tpl";
    		$footer_type="footer.tpl";
    		break;
    	} 

		case "login": {
    		//указываем имя шаблона и название страницы    		
			$page_type="login.tpl";
    		$head="Information_system_Electronic_structure_of_atoms";
    		$title="About_project";
    		$headline="About_project";
    		$bodyclass="index"; 
    		$header_type="index_header.tpl";
    		$footer_type="footer.tpl";
    		break;
    	}

		case "logout": {
			session_start();
			session_destroy();
			header("Location: /");
			break;
		}

		case "bibliography": {	
			$source_list = new SourceList;	
			
			if(isset($_REQUEST['element_id']) && is_numeric($_REQUEST["element_id"])){
				$source_id=$_REQUEST["element_id"];

				$source_list->Load($source_id);			
				$BiblioItem = $source_list->GetItemsArray();
				$smarty->assign('BiblioItem',$BiblioItem[0]);	
				$source_list->GetAuthors($source_id);
				$smarty->assign('Authors',$source_list->GetItemsArray());				
				$page_type="view_bibliolink.tpl"; 
			} else {		
				
				//$source_list->LoadAll();
				$smarty->assign('SourceList',$source_list->GetItemsArray());   		
				$page_type="view_bibliography.tpl"; 
    			$head="Bibliography";
    			$title="Bibliography";
    			$headline="Bibliography";
    			$bodyclass="bibliography";
    			$header_type="header.tpl";
    			$footer_type="footer.tpl";
			}
    		break;
    	}  	
    	
		case "articles": {
    		//указываем имя шаблона и название страницы    		
			$page_type=$l10n->locale."/articles.tpl"; 
    		$head="Articles";
    		$title="Articles";
    		$headline="Articles";
    		$bodyclass="index";
    		$header_type="index_header.tpl";
    		$footer_type="footer.tpl";
			
    		if(isset($_REQUEST['element_id']) && is_numeric($_REQUEST["element_id"])){
    			$page_type=$l10n->locale."/articles/".$_REQUEST["element_id"].".tpl";
				if (!empty($page_type)){ 
    				$header_type="index_header.tpl";
    				$footer_type="footer.tpl";

    				if($_REQUEST["element_id"]>2)
					{
						header("HTTP/1.0 404 Not Found");
						exit;
						header('location: /'.$l10n->locale.'/articles');
					}
				}
			}
    		break;
    	}

		default: {
			header("HTTP/1.0 404 Not Found");
			exit;
			//Уровни
			$level_list = new LevelList;
			// отдаём в смарти число уровней
			$level_count = $level_list->LoadCount();
			$smarty->assign('level_count', $level_count);
			
			
			//Переходы
			$transition_list = new TransitionList;
			// отдаём в смарти число переходов
			$transition_count = $transition_list->LoadCount();
			$smarty->assign('transition_count', $transition_count);
			
    		$page_type=$l10n->locale."/index.tpl"; 
    		$head="Information_system_Electronic_structure_of_atoms";
    		$title="About_project";
    		$headline="About_project";
    		$bodyclass="index"; 
    		$header_type="index_header.tpl";
    		$footer_type="footer.tpl";
    		break;
    	}
	}		
		$localDictionary=$l10n->localize;
		//регестрируем функцию перевода десятичных чисел в римские как модификатор
		$smarty->register_modifier("toRoman","numberToRoman");
		
		$smarty->assign('interface',$l10n->interface);
		$smarty->assign('locale',$l10n->locale);		
		$smarty->assign('l10n',$localDictionary);

		$smarty->assign('cur_en_date', date("F j, Y"));
		$smarty->assign('cur_year', date("Y"));

		if(isset($head))$smarty->assign('head',$localDictionary[$head]);
		// var_dump($localDictionary);
		//if(isset($title))$smarty->assign("title",$localDictionary[$title]);
		// var_dump($title . '_title');
		if(isset($title))$smarty->assign("title",$localDictionary[$title . '_title'] . (isset($elname)?(" — ". $atom_name):("")));
		
		if(isset($headline))$smarty->assign('headline',$localDictionary[$headline]);		
		
		if (isset($element_id)) $smarty->assign('layout_element_id',$element_id);	
		if (isset($elname)) $smarty->assign('layout_element_name',$elname);
		if (isset($elname)) $smarty->assign('atom_name', $atom_name);
		if (isset($ions)) $smarty->assign('ions',$ions);
		
		if (isset($bodyclass))	$smarty->assign("bodyclass",$bodyclass);
		if (isset($pagetype))	$smarty->assign("pagetype",$pagetype);	
		
				
		if(isset($header_type)) $smarty->display("$interface/".$header_type);

		switch ($pagetype) {
			case 'json': break;
            case 'jsonlevels': break;
			case 'diagram':
			case 'spectrum':
			case 'compare':
            case 'circle':
            case 'cf':
			case 'links':
			case 'team':
			case 'sponsors':
			case 'awards':
			case 'articles':
			case 'periodictable':
			case 'index':
				$smarty->display("view/".$page_type);
				break;
			case 'element':
			case 'levels':
			case 'transitions':
			case 'bibliography':
			default:
				$smarty->display("$interface/".$page_type);
		}



		//print_r($_REQUEST);
		if(isset($footer_type)) $smarty->display("$interface/".$footer_type);
	}
?>
