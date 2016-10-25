<?php
require_once($_SERVER['DOCUMENT_ROOT']."/import/configure.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/listotherbd.php");

if($_POST['import']){
	$method = $_POST['method'];
	$element = $_POST['element'];
	$ion = $_POST['ion'];
    $rangeenergy =$_POST['rangeenergy'];
    switch ($method) {
        case "level":
        require_once($_SERVER['DOCUMENT_ROOT']."/import/levels.php");
        echo import_nist_levels($element, $ion, $rangeenergy);
        break;
        case "line":
        require_once($_SERVER['DOCUMENT_ROOT']."/import/transitions.php");
        echo import_nist_lines($element, $ion);
        break;
        default:
        echo "<p>Все поломалось, зовите Каира! Метод не определен: $method</p>";
        break;
    }

}
if($_POST['save']){
    $method = $_POST['method'];
    $save = new Listotherbd();
    switch ($method) {
        case "level":
        $save->UpdateNewLevels($_POST['data_save']);
        break;
        case "line":
        $save->UpdateNewLines($_POST['data_save']);
        break;
        case "limits":
        $save->UpdateNewLimits($_POST['data_save']);
        break;
        default:
        echo "Все поломалось, зовите Каира! Метод не определен: $method";
        break;
    }
}
?>