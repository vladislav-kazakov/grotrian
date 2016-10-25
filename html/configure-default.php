<?
function getMicroTime()
{
	  return microtime(true);
}

 function numberToRoman($num)
 {
     $n = intval($num);
     $result = '';
 
     $lookup = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
     'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
     'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
 
     foreach ($lookup as $roman => $value)
     {
         $matches = intval($n / $value);
         $result .= str_repeat($roman, $matches);
         $n = $n % $value;
     }
 
     return $result;
 }


define ('SMARTY_DIR','./includes/Smarty/');
require(SMARTY_DIR.'Smarty.class.php');

$smarty = new Smarty;
$smarty->template_dir = './templates/';
$smarty->compile_dir = './templates_c/';
$smarty->config_dir = './configs/';
$smarty->cache_dir = './cache/';

$smarty->left_delimiter = "{#";
$smarty->right_delimiter = "#}";

if (($_SERVER['HTTP_HOST'] == "grotrian") OR ($_SERVER['HTTP_HOST'] == "10.2.5.16:8080")) define("ISLOCAL", TRUE); else define("ISLOCAL", FALSE); 

$DBserverName = "10.2.5.111";
error_reporting(E_ERROR | E_WARNING | E_PARSE);

define("DB_SERVER", $DBserverName);
define("DB_USERNAME", "");
define("DB_PASSWORD", "");
define("DB_NAME", "");
define("ADMIN", TRUE);  


require_once("includes/genlib.php");

?>
