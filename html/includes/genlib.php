<?php

require_once("statement.php");
require_once("connection.php");
// GetConnection
function GetConnection()
{
	static $connection;
	if (!$connection)
	{
		$connection = new Connection(DB_SERVER, DB_NAME, DB_USERNAME, DB_PASSWORD);
	}
	return $connection;
}

// GetStatement
function GetStatement()
{
	$connection = GetConnection();
	return $connection->CreateStatement();
}

?>