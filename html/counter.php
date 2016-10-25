<?
// require_once($_SERVER['DOCUMENT_ROOT']."/includes/counter.php");

require_once("configure.php");
require_once("includes/counter.php");

if(isset($_POST['uri'], $_POST['user_agent'])){
	$counter = new Counter();
	$counter->Create($_POST['uri'], $_POST['user_agent']);
}
?>