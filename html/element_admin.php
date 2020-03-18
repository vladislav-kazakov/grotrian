<?
require_once("configure.php");
require_once("includes/auth.php");
require_once("includes/elementlist.php");
require_once("includes/atom.php");

if(isset($_POST['action']) && (isset($_POST['element_id']) || isset($_POST['atom_id']))){
	if (isset($_POST['element_id'])) $element_id = $_POST['element_id'];
	if (isset($_POST['atom_id'])) $atom_id = $_POST['atom_id'];
	$action=$_POST['action'];
	$atom = new Atom();	
	$element = new ElementList();	
	switch ($action){	
			case "saveElement": {				
				$element->Save($_POST);
				break;
			}
			
			case "createAtom": {				
				$atom->Create($element_id);					
				echo $atom->GetProperty('ID');
				break;
			}
			
			case "deleteAtom": {				
				$atom->Delete($element_id,$atom_id);
				echo $atom->GetProperty('ID');
				break;
			}
			
			case "saveAtom": {				
				$atom->Save($_POST);				
				break;
			}
			
			case "makeDiagram": {				
				$atom->makeDiagram($_POST);				
				break;
			}
			case "makeSpectrogram": {
				$atom->makeSpectrogram($_POST);
				break;
			}
			
		}
	}

?>