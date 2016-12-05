<?php

require_once("recordset.php");


class Statement
{
	var $_dbLink;
	var $_resultType;
	var $_affectedRows;
	var $_lastInsertID;
	var $_numRows;
	var $_errorHandler;
	var $_errors;

	function Statement($dbLink, $resultType = mssql_ASSOC)
	{
		$this->_dbLink = $dbLink;
		$this->_resultType = $resultType;
		$this->_affectedRows = null;
		$this->_lastInsertID = null;
		$this->_numRows = null;
		$this->_errorHandler = null;
		$this->_errors = array();
	}

	function &Execute($query, $resultType = null)
	{
		$result = mssql_query($query, $this->_dbLink);
		$retVal = null;
		$this->_affectedRows = null;
		$this->_lastInsertID = null;
		$this->_numRows = null;

		if ($result === true)
		{
			// $this->_affectedRows = mssql_affected_rows($this->_dbLink);
			//$this->_lastInsertID = mssql_insert_id($this->_dbLink);
			$retVal = true;
		}
		elseif (is_resource($result))
		{
			$this->_numRows = mssql_num_rows($result);
			if (is_null($resultType))
				$retVal = new RecordSet($result, $this->_resultType);
			else
				$retVal = new RecordSet($result, $resultType);
		}
		else
		{
			if (!is_null($this->_errorHandler))
			{
				if (is_array($this->_errorHandler) && count($this->_errorHandler) == 2)
				{
					$object =& $this->_errorHandler[0];
					$method = $this->_errorHandler[1];
					if (is_object($object) && method_exists($object, $method))
						eval("\$object->".$method."(\$this->_ToLog(\$query), mssql_errno(\$this->_dbLink), mssql_error(\$this->_dbLink));");
				}
				elseif (is_scalar($this->_errorHandler))
				{
					if (function_exists($this->_errorHandler))
						eval($this->_errorHandler."(\$this->_ToLog(\$query), mssql_errno(\$this->_dbLink), mssql_error(\$this->_dbLink));");
				}
			}
			array_push($this->_errors, array('Query' => $this->_ToLog($query),
				'ErrNo' => mssql_errno($this->_dbLink), 'ErrStr' => mssql_error($this->_dbLink)));
			$retVal = false;
		}

		return $retVal;
	}

	function GetAffectedRows()
	{
		return $this->_affectedRows;
	}

	function GetLastInsertID()
	{
		return $this->_lastInsertID;
	}

	function GetNumRows()
	{
		return $this->_numRows;
	}

	function FetchList($query, $resultType = null)
	{
		$rs =& $this->Execute($query, $resultType);
		if (strtolower(get_class($rs)) == 'recordset')
			return $rs->AllRows();
		elseif ($rs === false)
			return false;
		else
			return null;
	}

	function FetchIndexedList($query, $field = 0, $resultType = mssql_BOTH)
	{
		$rs =& $this->Execute($query, $resultType);
		if (strtolower(get_class($rs)) == 'recordset')
		{
			$result = $rs->AllRows();
			$indexedResult = array();
			for ($i = 0; $i < count($result); $i++)
			{
				if (array_key_exists($field, $result[$i]))
					$indexedResult[$result[$i][$field]] = $result[$i];
			}
			return $indexedResult;
		}
		elseif ($rs === false)
		{
			return false;
		}
		else
		{
			return null;
		}
	}

	function FetchRow($query, $resultType = null)
	{
		$rs =& $this->Execute($query, $resultType);
		if (strtolower(get_class($rs)) == 'recordset')
			return $rs->NextRow();
		elseif ($rs === false)
			return false;
		else
			return null;
	}

	function FetchField($query, $field = 0)
	{
		$rs =& $this->Execute($query, MSSQL_BOTH);
		if (strtolower(get_class($rs)) == 'recordset')
		{
			$row = $rs->NextRow();
			if (is_array($row) && array_key_exists($field, $row))
				return $row[$field];
			else
				return false;
		}
		elseif ($rs === false)
		{
			return false;
		}
		else
		{
			return null;
		}
	}

	function SetErrorHandler($errorHandler)
	{
		$this->_errorHandler = $errorHandler;
	}

	function GetAllErrors()
	{
		return $this->_errors;
	}

	function GetLastError()
	{
		return end($this->_errors);
	}

	function _ToLog($query)
	{
		$query = str_replace("\r", '', $query);
		$query = str_replace("\n", '', $query);
		$query = preg_replace("/[\s]+/", " ", $query);
		return trim($query);
	}
}

?>