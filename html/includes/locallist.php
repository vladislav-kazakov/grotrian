<?php
require_once("objectslist.php");
require_once("genlib.php");

class LocalList extends ObjectsList
{

	var $_error;

	// Constructor
	function LocalList($data = array())
	{
		if (is_array($data))
		{
			$this->ObjectsList($data);
		}
		else
		{
			$this->ObjectsList($data, GetStatement());
		}
	}

	// LoadFromSQL
	function LoadFromSQL($query)
	{
		ObjectsList::LoadFromSQL($query, GetStatement());
	}

	function GetCounter()
	{
		return $this->counter;
	}

	/**
	 * Returns total records from given table
	 *
	 * @param string $tableName
	 * @param Authorization $auth
	 * @return int
	 */
	function GetTotalRecords($tableName)
	{
		$stmt = GetStatement();
		return $stmt->FetchField("SELECT COUNT(*) FROM ".$tableName);
	}
	
	function SetErrorMessage($message)
	{
		$this->_error = $message;
	}

	function GetErrorMessage()
	{
		return $this->_error ? $this->_error : null;
	}
}
?>