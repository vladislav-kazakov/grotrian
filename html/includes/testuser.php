<?php
if(isset($_POST['testuser'])){
	require_once("includes/counter.php");
	$counter = new Counter;
	$counter->Create();
}
?>