<?
require_once($_SERVER['DOCUMENT_ROOT']."/includes/localobject.php");

class Counter extends LocalObject
{
	function Create($uri, $user_agent)
	{
		$ip = $_SERVER["REMOTE_ADDR"];
		// $ref = $_SERVER["HTTP_REFERER"];
		$datetime = date("Y-m-d H:i:s");
		$query = "INSERT INTO [COUNTER] ([IP],[URI],[USER_AGENT],[DATETIME]) VALUES('$ip','$uri','$user_agent','$datetime') SELECT MAX(ID) AS ID FROM COUNTER";
		$this->LoadFromSQL($query);

	}

}
?>