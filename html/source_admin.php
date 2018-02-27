<?
header('Content-Type: text/html; charset=windows-1251');
require_once("configure.php");
require_once("includes/elementlist.php");
require_once("includes/source.php");
require_once("includes/sourcelist.php");
$source = new Source();
$source_list = new SourceList;

function compare($v1, $v2)
{
   if ($v1['ID_SOURCE'] == $v2['ID_SOURCE']) return 0;
   return ($v1['ID_SOURCE'] < $v2['ID_SOURCE'])?-1:1;
}

if(isset($_GET['q'])){
	$source->GetAutocompleteAuthors($_GET['q']);
	$sourceItem = $source->GetItemsArray();
	$s=$sourceItem[0]['NAME'];
	
	foreach ($sourceItem as $key=>$value) {
		echo $value['NAME']."\n";
	}	 
}


if(isset($_POST['action'])){
	
	
	$action=$_POST['action'];
	if(isset($_POST['source_id'])) $source_id = $_POST['source_id'];
	
	switch ($action){
		
		case "manageSources": {
			$source_list->LoadAll();			
			$smarty->assign('SourceList',$source_list->GetItemsArray());			
			$smarty->display("edit/add_sources.tpl");				
    		break;
    	}
    	
		case "removeSources": {	
			
			$final_source_list = array();
			$row_id = array();
			if (isset($_POST['row_id'])) $row_id = $_POST['row_id'];
			//print_r($_POST);
			//print_r($element_id);
			
			foreach($row_id as $id){			
				$source_list->LoadSources($id);
				$sources=$source_list->GetItemsArray();
				
				foreach ($sources as $key=>$source){		
					$flag=0;			
					//in_array($source,$final_source_list)					
					
					
					foreach ($final_source_list as $sourceKey=>$sourceArray) {
						if ($sourceArray['ID_SOURCE'] == $source['ID_SOURCE']) $flag=1;
						//if ($source['ID_SOURCE']>$sourceArray['ID_SOURCE']) $flag=1;
						//if ($source['ID_SOURCE']<$sourceArray['ID_SOURCE']) $flag=2;  
					}			
					
					if ($flag!=1) { 
						array_push($final_source_list,$source);
						//$lastsource = end($final_source_list);
						//if ($source['ID_SOURCE']>$lastsource['ID_SOURCE']) array_push($final_source_list,$source);
						//else array_unshift($final_source_list,$source);
						
					}
					usort($final_source_list, 'compare');
					//if ($flag==2) array_unshift($final_source_list,$source);
					//print_r($source['ID_SOURCE']);
					
				}
			}	

			//print_r($final_source_list);
			$smarty->assign('Sourcelist',$final_source_list);

			/*
			$source_list->LoadAll();			
			$smarty->assign('BiblioList',$source_list->GetItemsArray());
			*/
			$smarty->display("edit/remove_sources.tpl");	
			
    		break;
    	}
    	
		case "getSourceIDs" : {  
			//print_r($_POST);  		
			$source->GetSourceIDs($_POST["row_id"],$_POST["type"]);
			$ids=$source->GetItemsArray();
			//print_r($ids[0]);
			if ($ids[0]['SOURCE_IDS']) {
				$smarty->assign('IDS',$ids[0]);
				$smarty->display("edit/sources.tpl");
			}else return FALSE;
			
			break;  		
    	}
    	
    	
    	case "applySources" : {    		
			$source->ApplySources($_POST);
			break;  		
    	}
    	
		case "applyRemovingSources" : {    
			$source->ApplyRemovingSources($_POST);
			break;  		
    	}
    	
		case "createSource": {				
			$source->Create();					
			//echo $source->GetProperty('ID'); break;	
			$sourceItem = $source->GetItemsArray();		
			echo($sourceItem[0]['ID']);	break;						
		}
		
		case "saveSource": {			
			$source->Save($_POST);
			break;
			//print_r($_POST);				
		}	
			
		case "deleteSources": {
			$source->Delete($_POST);
			break;
		}

		case "editSource": {	
			$source_types= array( "j_article"=>"Статья из журнала","c_article"=>"Статья из сборника","e_book"=>"Электронное издание","book"=>"Книга","journal"=>"Журнал","collection"=>"Сборник", "bibtex"=>"bibtex");
			$collection_types= array("сб.","сб. стат.","сб. науч. тр.","межвуз. сб. науч. тр.","спец. выпуск","сб. мат.","сб. тезисов и докл.","монография","биограф. справка");
			$author_roles= array( "author"=>"автор","main_author"=>"основной автор","editor"=>"редактор");
			
			$smarty->assign('source_types',$source_types);	
			$smarty->assign('collection_types',$collection_types);
			$smarty->assign('author_roles',$author_roles);			
			//print_r($source_id);
			$source->Load($source_id);			
			$sourceItem = $source->GetItemsArray();
			//print_r($sourceItem[0]);
			$smarty->assign('SourceItem',$sourceItem[0]);
				
			$source->GetAuthors($source_id);
			$smarty->assign('Authors',$source->GetItemsArray());				
						
			$smarty->display("edit/edit_source.tpl");	
			
    		break;
    	}
    	
		case "save_author": {
			//print_r($_POST);			
			$source->SaveAuthor($_POST['author_id'],$_POST['source_id'],$_POST['author_name'],$_POST['author_role']);
			$sourceItem = $source->GetItemsArray();		
			print_r ($sourceItem[0]['ID']);		
			break;	
		}
    	
		case "deleteAuthor": {
			$source->RemoveAuthor($source_id,$_POST['author_id']);
			break;	
		}
    	
		
	}
}

?>