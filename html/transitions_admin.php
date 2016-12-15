<?
header('Content-Type: text/html; charset=windows-1251');
global $smarty;
require_once("configure.php");
require_once("includes/transitionlist.php");
require_once("includes/bibliolist.php");
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
	$transition = new TransitionList();
	$source_list = new BiblioList;
	
	switch ($action){	
		
		case "saveTransitions": {
			//print_r($_POST);
			$transition->Save($_POST);
			break;
		}
		
		case "deleteTransitions": {			
			$transition->Delete($_POST);
			break;
			}
			
		case "createTransition": {
			$transition->Create($atom_id);
			$trans=$transition->GetItemsArray();
			echo $trans[0]['ID'];
			break;
			//$transition->GetProperty('ID'); break;							
			}					
			
		case "setUpperLevel": {			
			$transition->setUpperLevel($_POST['transition_id'],$_POST['level_id']);
			$level=$transition->GetItemsArray();
			$level = $level[0];

			$str = ($level['CONFIG']==" " || $level['CONFIG']=="") ? $level['ENERGY'] : $level['CONFIG'];
			$str .= ($level['TERMSECONDPART']!="NULL") ? $level['TERMSECONDPART'] : "";
			$str .= (!empty($level['TERMPREFIX'])) ? "<sup>".$level['TERMPREFIX']."</sup>" : "";
			$str .= (!empty($level['TERMFIRSTPART'])) ? $level['TERMFIRSTPART'] : "";
			$str .= ($level['TERMMULTIPLY']==1) ? "<sup>0</sup>" : "<sup></sup>";
			$str .= (!empty($level['J'])) ? "<sub>".$level['J']."</sub>" : "";

			print_r ($str);
			break;
			}		
		
		case "setLowerLevel": {			
			$transition->setLowerLevel($_POST['transition_id'],$_POST['level_id']);
			$level=$transition->GetItemsArray();
			$level = $level[0];

			$str = ($level['CONFIG']==" " || $level['CONFIG']=="") ? $level['ENERGY'] : $level['CONFIG'];
			$str .= ($level['TERMSECONDPART']!="NULL") ? $level['TERMSECONDPART'] : "";
			$str .= (!empty($level['TERMPREFIX'])) ? "<sup>".$level['TERMPREFIX']."</sup>" : "";
			$str .= (!empty($level['TERMFIRSTPART'])) ? $level['TERMFIRSTPART'] : "";
			$str .= ($level['TERMMULTIPLY']==1) ? "<sup>0</sup>" : "<sup></sup>";
			$str .= (!empty($level['J'])) ? "<sub>".$level['J']."</sub>" : "";

			print_r ($str);
			break;
			}
			
		
		}
		
		

	} //else print_r($_POST);

?>