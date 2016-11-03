<?php
require_once("object.php");

class LocalObject extends Object
{
	var $_error;
	// Constructor
	function LocalObject($data = array())
	{
		if (is_array($data))
		{
			$this->Object($data);
		}
		else
		{
			$this->Object($data, GetStatement());
		}
	}
	
	function LoadFromSQL($query)
	{
		Object::LoadFromSQLWithStatement($query, GetStatement());
	}

}
?>