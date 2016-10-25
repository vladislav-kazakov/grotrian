<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.biblolink.php
 * Type:     function
 * Name:     biblolink
 * Purpose:  outputs a biblolink
 * -------------------------------------------------------------
 */
function smarty_function_bibliolink($params, &$smarty)
{
	
	if (empty($params['biblioarray'])) {
        $smarty->trigger_error("biblolink: missing 'biblioarray' parameter");
        return;
    } else {
        $bib = $params['biblioarray'];
     }
    
		$author = $bib['MAIN_AUTHOR'];
		$authors = $bib['AUTHORS'];		
		$article_title = $bib['WORK_NAME'];  // !!!!
		$title = $bib['ISSUE_NAME'];
		//$page_count = $publication->page_count;
		$page_fist = $bib['PAGE_FIRST'];
		$page_last = empty($bib['PAGE_LAST']) ? '' : ('-'.$bib['PAGE_LAST']);
		$page_range = $page_fist.$page_last; 
		$location = $bib['CITY'];
		$publish = $bib['PUBLISHER'];
		$year = $bib['YEAR']; 		
		$volume_fist = $bib['VOLUME_FIRST'];
		$volume_last = empty($bib['VOLUME_LAST']) ? '' : ('-'.$bib['VOLUME_LAST']);	
		$tome = $volume_fist.$volume_last;		
		$publish_number = $bib['VOLUME_FIRST']; // !!!!
		//$month = $publication->month; // !!!!
		$publish_type = $bib['COLLECTION_TYPE'];

		if (!empty($bib['EDITOR_TYPE'])){
		
		$editor=$bib['EDITOR'];
		
			switch ($bib['EDITOR_TYPE']){
				case 'editor': $editor_type = "ред.";
				case 'main_editor': $editor_type = "гл. ред.";	
			}
		} 

        $link = $bib['LINK'];
    
    
	$page_abbr = 'с.';
	$release_abbr = 'вып.';
	$uprelease_abbr = 'Вып.';	
	
	if ( ereg('[a-zA-Z]',$bib['AUTHORS'])) {
		$page_abbr = 'p.';
		$release_abbr = 'rel.';
		$release_abbr = 'Rel.';
	}    
    
    switch ($bib['SOURCE_TYPE']){

    	
    	case 'book':
			$author = $author.' ';
			$authors = empty($authors) ? '' : (' / '.$authors);
			$location = empty($location) ? '' : (' &ndash; '.$location);
			$publish = empty($publish) ? '' : (': '.$publish);
			$year = empty($year) ? '' : (', '.$year.'. '); 
			$page_abbr = empty($page_range) ? '' : (' &ndash; '. $page_range.' '.$page_abbr);		
			$result = $author.$title.$authors.$location.$publish.$year.$page_abbr;
            break;
		
		case 'j_article':	
			$author = $author.' ';
			$authors = empty($authors) ? '' : (' / '.$authors);
			$title = empty($title) ? '' :(" // ".$title.".");
			$year = empty($year) ? '' : (' &ndash; '.$year.'.');
			$tome= empty($tome) ? '' :  (' &ndash; T. '.$tome.'.');
			$publish_number = empty($publish_number) ? '' : (' &ndash; '.$uprelease_abbr.' '.$publish_number.'.'); 
			$month = empty($month) ? '' : (' &ndash; '.$month.'.'); 
			$page_abbr = empty($page_range) ? '' : (' &ndash; '.strtoupper($page_abbr).' '.$page_range.'.');	
			$result = $author.$article_title.$authors.$title.$year.$tome.$publish_number.$month.$page_abbr;
			break;
			
		case 'c_article':	
			$author = $author.' ';
			$authors = empty($authors) ? '' : (' / '.$authors);
			$title = " // ".$title;
			$publish_type = empty($publish_type) ? '' : (' : '.$publish_type); 
			$editor_type = empty($editor_type) ? '' : (' / '.$editor_type); 
			$editor = empty($editor_type) ? '' : (' '.$editor); 
			$location = empty($location) ? '' : (' &ndash; '.$location);
			$publish = empty($publish) ? '' : (' : '.$publish);			
			$year = empty($year) ? '' : (', '.$year.'.');			
			$tome= empty($tome) ? '' :  (' &ndash; T. '.$tome.'.');
			$publish_number = empty($publish_number) ? '' : (' &ndash; '.$uprelease_abbr.' '.$publish_number.'.'); 			
			$page_abbr = empty($page_range) ? '' : (' &ndash; '.strtoupper($page_abbr).' '.$page_range.'.');	
			
			$result = $author.$article_title.$authors.$title.$publish_type.$editor_type.$editor.$location.$publish.$year.$tome.$publish_number.$page_abbr;
			break;		
			
		case 'collection':
			$publish_type = empty($publish_type) ? '' : (' : '.$publish_type); 
			$editor_type = empty($editor_type) ? '' : (' / '.$editor_type); 
			$editor = empty($editor_type) ? '' : (' '.$editor); 
			$location = empty($location) ? '' : (' - '.$location);
			$publish = empty($publish) ? '' : (' : '.$publish);	
			$year = empty($year) ? '' : (', '.$year.'.');
			$tome= empty($tome) ? '' :  (' &ndash; T. '.$tome.'.');
			$publish_number = empty($publish_number) ? '' : (' &ndash; '.$uprelease_abbr.' '.$publish_number.'.');
			$page_abbr = empty($page_range) ? '' : (' &ndash; '.strtoupper($page_abbr).' '.$page_range.'.');      
			
            $result = $title.$publish_type.$editor_type.$editor.$location.$publish.$year.$tome.$publish_number.$page_abbr;
            break;
		
		case 'journal':
            $year = empty($year) ? '' : (' &ndash; '.$year.'.');
			$tome= empty($tome) ? '' :  (' &ndash; T. '.$tome.'.');
			$publish_number = empty($publish_number) ? '' : (' &ndash; '.$uprelease_abbr.' '.$publish_number.'.'); 
			$month = empty($month) ? '' : (' &ndash; '.$month.'.'); 
			$page_abbr = empty($page_range) ? '' : (' &ndash; '.strtoupper($page_abbr).' '.$page_range.'.');	
			$result = $title.$year.$tome.$publish_number.$month.$page_abbr;
            break;
	   /*
        case 'Труды конференции':
			$publish_type = empty($publish_type) ? '' : (': '.$publish_type);
			$location = empty($location) ? '' : (' &ndash; '.$location);
			$publish = empty($publish) ? '' : (' : '.$publish);
			$year = empty($year) ? '' : (', '.$year.'.');
			$page_abbr = empty($page_range) ? '' : (' &ndash; '.strtoupper($page_abbr).' '.$page_range.'.');
			
            $result = $title.$publish_type.$location.$publish.$year.$page_abbr;
            break;
			
		case 'Из материалов конференции':
			$author = $author.' ';
			$authors = empty($authors) ? '' : (' / '.$authors);
			$title = " // ".$title;
			$publish_type = empty($publish_type) ? '' : (': '.$publish_type);
			$location = empty($location) ? '' : (' &ndash; '.$location);
			$publish = empty($publish) ? '' : (' : '.$publish);
			$year = empty($year) ? '' : (', '.$year.'.');
			$page_abbr = empty($page_range) ? '' : (' &ndash; '.strtoupper($page_abbr).' '.$page_range.'.');
			
            $result = $author.$article_title.$authors.$title.$publish_type.$location.$publish.$year.$page_abbr;
            break;
		*/
		case 'web':
			$author = $author.' ';
			$title = empty($title) ? '' : (' // '.$title);
			$link = empty($link) ? '' :  (': '.$link);
            $result = $author.$title.$title.$link;
			break;
			
        default:
            $result = $title;
            break; 
    	
    } 
	
    return $result;
    
}
?>