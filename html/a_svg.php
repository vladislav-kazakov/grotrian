<?
if(isset($_REQUEST['element_id']))
{
	$element_id = $_REQUEST['element_id'];
	echo '<embed wmode="transparent" id="diagram" type="image/svg+xml" src="/svg.php?element_id='.$element_id.'" pluginspage="http://www.adobe.com/svg/viewer/install/"/>';
}
?>