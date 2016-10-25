<?php

class RecordSet
{
	var $_resultType;
	var $_result;
	var $_rows;
	var $_current;

	function RecordSet($result, $resultType = mssql_ASSOC)
	{
		$this->_resultType = $resultType;
		$this->_result = $result;
		$this->_rows = null;
		$this->_current = 0;
	}

	function FirstRow()
	{
		if (mssql_num_rows($this->_result) > 0)
		{
			mssql_data_seek($this->_result, 0);
			$this->_current = 0;
		}
	}

	function NextRow()
	{
		if ($row = mssql_fetch_array($this->_result, $this->_resultType))
		{
			$this->_current++;
			return $row;
		}
		else
		{
			return null;
		}
	}

	function AllRows()
	{
		if (is_null($this->_rows))
		{
			$this->_rows = array();
			if (mssql_num_rows($this->_result) > 0)
			{
				mssql_data_seek($this->_result, 0);
			}
			while ($row = mssql_fetch_array($this->_result, $this->_resultType))
			{
				$this->_rows[] = $row;
			}
		}
		return $this->_rows;
	}

	function CurrentRow()
	{
		return $this->_current;
	}
}

?>