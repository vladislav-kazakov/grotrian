<?php
require_once("connection.php");

class Object
{

	// Members
	var $properties;

	// Constructor
	function Object($data = array(), $statement = null)
	{
		if (is_array($data))
		{
			$this->LoadFromArray($data);
		}
		else if (!is_null($statement))
		{
			$this->LoadFromSQLWithStatement($data, $statement);
		}
		else
		{
			$this->LoadFromArray(array());
		}
	}

	// LoadFromArray
	function LoadFromArray($data)
	{
		$this->properties = $data;
	}

	// AppendFromArray
	function AppendFromArray($data)
	{
		$this->properties = array_merge($this->properties, $data);
	}

	// AppendFromObject
	function AppendFromObject($object)
	{
		$this->properties = array_merge($this->properties, $object->properties);
	}

	// LoadFromSQL
	function LoadFromSQLWithStatement($query, $statement)
	{
		$data = $statement->FetchRow($query);
		$this->properties = is_array($data) ? $data : array();
	}

	// SetProperty
	function SetProperty($name, $value)
	{
		$this->properties[$name] = $value;
	}

	// GetProperty
	function GetProperty($name)
	{
		return isset($this->properties[$name]) ? $this->properties[$name] : null;
	}

	// GetPropertyForSQL
	function GetPropertyForSQL($name)
	{
		return Connection::GetSQLString(trim($this->GetProperty($name)));
	}

	// GetPropertyForURL
	function GetPropertyForURL($name)
	{
		return urlencode($this->GetProperty($name));
	}

	// GetIntProperty
	function GetIntProperty($name)
	{
		return intval($this->GetProperty($name));
	}

	// GetAllProperties
	function GetAllProperties()
	{
		return $this->properties;
	}

	// CountProperties
	function CountProperties()
	{
		return count($this->properties);
	}
	
	function SetErrorMessage($message)
	{
		$this->_error = $message;
	}
	
	function GetErrorMessage()
	{
		if ($this->_error)
		{
			return $this->_error;
		}
		else
		{
			return null;
		}
	}
	
	function GetStrProperty($name)
	{
		return Connection::GetSqlStr($this->GetProperty($name));
	}

	// ValidateNotEmpty
	function ValidateNotEmpty($name)
	{
		if (is_array($this->GetProperty($name)))
		{
			foreach ($this->GetProperty($name) as $k => $v)
			{
				if (strlen($v) > 0)
				{
					return true;
				}
			}
			return false; 
		}
		return strlen($this->GetProperty($name)) > 0;
	}

	// ValidateEmail
	function ValidateEmail($name)
	{
		return preg_match("/^[a-z,0-9]+([-_\.]?[a-z,0-9]+)+@[a-z,0-9]+([-_\.]?[a-z,0-9]+)+\.([a-z]{2,4})$/", $this->GetProperty($name));
	}
	
} // end of class
?>