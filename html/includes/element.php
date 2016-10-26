<?
require_once("localobject.php");

class Element extends LocalObject
{
/*    function Load()
	{
		$query = "SELECT ID.*,ABBR.* FROM class_elements";
		$this->LoadFromSQL($query);
	}
	*/
	function Load($element_id)
	{
		$query = "SELECT * FROM class_elements WHERE ID='$element_id'";
		$this->LoadFromSQL($query);
	}
		
}
?>