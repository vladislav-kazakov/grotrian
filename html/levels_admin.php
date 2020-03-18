<?
header('Content-Type: text/html; charset=windows-1251');
global $smarty;
require_once("configure.php");
require_once("includes/auth.php");
require_once("includes/levellist.php");
require_once("includes/sourcelist.php");
require_once("includes/atom.php");



function compare($v1, $v2)
{
   if ($v1['ID_SOURCE'] == $v2['ID_SOURCE']) return 0;
   return ($v1['ID_SOURCE'] < $v2['ID_SOURCE'])?-1:1;
}

if(!empty($_POST['action'])){

//print_r($_POST);	
//print_r($_POST);

	if (!empty($_POST['atom_id'])) $atom_id=$_POST['atom_id'];
	
	$action=$_POST['action'];	
	$level_list = new LevelList();
	$source_list = new SourceList;
	
	switch ($action){	
		
		case "saveLevels": {
			//print_r($_POST);
			$level_list->Save($_POST);
			break;
		}
		
		case "deleteLevels": {			
			$level_list->Delete($_POST);				
			//print_r($_POST);
			break;
			}
			
		case "createLevel": {
			//print_r($_POST);
			$level_list->Create($atom_id);
			$lev=$level_list->GetItemsArray();
			echo $lev[0]['ID'];
			break;				
			//$level->GetProperty('ID'); break;							
			}
			
		case "manageLevel": {				

			if (isset($_POST['position'])){
				
				$level_list->LoadFiltered($atom_id,$_POST['position'],$_POST['level']);
				
			} else $level_list->Load($atom_id);
				
			//$level_list->Load($atom_id);			
			$smarty->assign('level_list',$level_list->GetItemsArray());
			$smarty->display("edit/add_levels.tpl");		
    		break;
    	}
			
			
		/*case "manageSources": {	
							
			//$level_id=$_REQUEST["level_id"][0];
			//print_r($_POST);
			//print_r($element_id);
			//$source_list->LoadSources($level_id);				
			//$smarty->assign('Sourcelist',$source_list->GetItemsArray());

			$source_list->LoadAll();			
			$smarty->assign('BiblioList',$source_list->GetItemsArray());
			
			$smarty->display("edit/manage_sources.tpl");	
			
    		break;
    	}
    	
		case "removeSources": {	
			
			$final_source_list = array();
			$level_id=$_REQUEST["level_id"][0];
			//print_r($_POST);
			//print_r($element_id);
			
			foreach($_POST["level_id"] as $level_id){			
				$source_list->LoadSources($level_id);
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


			$smarty->display("edit/remove_sources.tpl");	
			
    		break;
    	}
    	
		case "getSourceIDs" : {    		
			$level->GetSourceIDs($_POST["level_id"]);
			$ids=$level->GetItemsArray();
			//print_r($ids[0]);
			if ($ids[0]['SOURCE_IDS']) {
				$smarty->assign('IDS',$ids[0]);
				$smarty->display("edit/sources.tpl");
			}else return FALSE;
			
			break;  		
    	}
    	
    	
    	case "applySources" : {    		
			$level->ApplySources($_POST);  
			break;  		
    	}
    	
		case "applyRemovingSources" : {    
			$level->ApplyRemovingSources($_POST);  
			break;  		
    	}
    	
	*/	
	}
/*			
			case "createAtom": {
				$atom = new Atom();
				$atom->Create($element_id);					
				echo $atom->GetProperty('ID'); break;							
			}
			
			case "deleteAtom": {
				$atom = new Atom();
				$atom->Delete($element_id,$atom_id);
				echo $atom->GetProperty('ID'); break;
			}
			
			case "saveAtom": {
				$atom = new Atom();
				$atom->Save($_POST);
										
			}
			
			
		}
		*/
	} else print_r($_POST);

?>