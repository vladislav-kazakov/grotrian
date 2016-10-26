<?
	global $smarty, $dictionary;
//session_start();
	require_once("configure.php");
	require_once("includes/elementlist.php");
	require_once("includes/element.php");
	require_once("includes/levellist.php");
	require_once("includes/transitionlist.php");
	require_once("includes/spectrum.php");
	
	//print_r($result);
	
	//Подключаем класс локализации
	require_once("includes/admin/localization.class.php");
	//Подключаем словарь
	require_once("dictionary/dictionary.inc");
	
	$l10n = new Localisation($dictionary);
	
	$elements = new ElementList;
	//загружаем таблицу элементов с локализованными именами			
	$elements->LoadPereodicTable($l10n->locale);
	$table=$elements->GetItemsArray();
	$smarty->assign('periodic_table',$table);
	
	//print_r($l10n->locale);
	//print_r($l10n->dictionary);
	//print_r($_COOKIE);
	//если в строке запроса есть id элемента и это число
	if((isset($_REQUEST['pagetype'])) && ($_REQUEST['pagetype']!="articles") && (isset($_REQUEST['element_id'])) && (is_numeric($_REQUEST["element_id"])))
	{	
		$element_id=$_REQUEST['element_id'];
		//Ионы
		$ion_list = new ElementList;
		$ion_list->Loadions($element_id);		

		//если удаётся получить массив ионов
		$elname=$ion_list->GetItemsArray();
		if ($elname)	{
			//получаем имя элемента
			$elname=$elname[0]['ELNAME'];		
			
			//берём масив данных о элементе и передаём его смарти			
			//$element = new Element;
			//$element->Load($element_id);
			
			//$el=$element->GetAllProperties();
			//$rep= array("<root>", "</root>");
			//$el['DESCRIPTION']= str_replace($rep, "", $el['DESCRIPTION']);
			//$smarty->assign('element', $el);

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
			$smarty->assign('book_count', 0);		
		
//			$smarty->assign("bodyclass","elements");
			$smarty->assign('layout_element_id',$element_id);		
		}
	}

//Если мы получили тип страницы
if(isset($_REQUEST['pagetype'])){
	$pagetype=$_REQUEST['pagetype'];

	//Если есть информация об интерфейсе и он - админский 
	if(isset($_REQUEST['interface'])){
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
			$transitions=$transition_list->GetItemsArray();
			// берём json объект длин волн и отдаём его в смарти
			$spectrum= new Spectrum();			
			$smarty->assign('spectrum_json',$spectrum->getSpectraSVG($transitions,0,1599900000));

    		$page_type="view_element.tpl"; 
    		$head="element_description";
    		$title="element_description";
    		$headline="element_description";
    		$bodyclass="element"; 
    		$header_type="header.tpl";
    		$footer_type="footer.tpl";

    		
    		break;
    	}
	
		case "element": {
		
			// 	берём массив переходов	
			$transition_list->LoadWithLevels($element_id);
			$transitions=$transition_list->GetItemsArray();
			// берём json объект длин волн и отдаём его в смарти
			$spectrum= new Spectrum();			
			$smarty->assign('spectrum_json',$spectrum->getSpectraSVG($transitions,0,1599900000));

    		$page_type="view_element.tpl"; 
    		$head="element_description";
    		$title="element_description";
    		$headline="element_description";
    		$bodyclass="element"; 
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

    	case "diagramm": {
    		//указываем имя шаблона и название страницы    		
			$page_type="view_diagramm.tpl"; 
    		$head="Grotrian_Charts";
    		$title="Grotrian_Charts";
    		$headline="Atomic_charts";
    		$bodyclass="diagramm";
    		$header_type="header.tpl";
    		$footer_type="footer.tpl";
    		break;
    	}

	    case "newdiagramm": {
    		//указываем имя шаблона и название страницы    		
			$page_type="view_new_diagramm.tpl"; 
    		$head="Grotrian_Charts";
    		$title="Grotrian_Charts";
    		$headline="Atomic_charts";
    		$bodyclass="new_diagramm";
    		$header_type="top_header.tpl";
    		$footer_type="bottom_footer.tpl";
    		break;
    	}
		
    	default: {
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
	    case "index": {
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
    		$bodyclass="index";
    		$header_type="index_header.tpl";
    		$footer_type="footer.tpl";
    		break;
    	}
    	
		case "team": {
    		//указываем имя шаблона и название страницы    		
			$page_type="ru/team.tpl"; 
    		$head="Project_team";
    		$title="Project_team";
    		$headline="Project_team";
    		$bodyclass="index";
    		$header_type="index_header.tpl";
    		$footer_type="footer.tpl";
    		break;
    	}
    	
    	
		case "sponsors": {
    		//указываем имя шаблона и название страницы    		
			$page_type="ru/sponsors.tpl"; 
    		$head="Sponsors";
    		$title="Sponsors";
    		$headline="Sponsors";
    		$bodyclass="index";
    		$header_type="index_header.tpl";
    		$footer_type="footer.tpl";
    		break;
    	}
    	
		case "awards": {
    		//указываем имя шаблона и название страницы    		
			$page_type="ru/awards.tpl"; 
    		$head="Awards";
    		$title="Awards";
    		$headline="Awards";
    		$bodyclass="awards";
    		$header_type="index_header.tpl";
    		$footer_type="footer.tpl";
    		break;
    	}
    	
		case "bibliography": {
    		//указываем имя шаблона и название страницы    		
			$page_type="ru/bibliography.tpl"; 
    		$head="Bibliography";
    		$title="Bibliography";
    		$headline="Bibliography";
    		$bodyclass="index";
    		$header_type="index_header.tpl";
    		$footer_type="footer.tpl";
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

    				if($_REQUEST["element_id"]>2) header('location: /'.$l10n->locale.'/articles');
				}
			}
    		break;
    	}
    	
    	    	
		default: {
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
		
		$smarty->assign('locale',$l10n->locale);		
		$smarty->assign('l10n',$localDictionary);
		
		if(isset($head))$smarty->assign('head',$localDictionary[$head]);
		if(isset($title))$smarty->assign("title",$localDictionary[$title]);
		if(isset($headline))$smarty->assign('headline',$localDictionary[$headline]);		
		
		if(isset($elname)) $smarty->assign('layout_element_name',$elname);	
		if (isset($bodyclass))	$smarty->assign("bodyclass",$bodyclass);	
		
				
		if(isset($header_type)) $smarty->display("$interface/".$header_type);		
		$smarty->display("$interface/".$page_type);
		print_r($_REQUEST);
		if(isset($header_type)) $smarty->display("$interface/".$footer_type);	
}
		
		




?>
