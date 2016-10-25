<?php
session_start();   
//print_r($_POST);
//print_r($_SESSION);
if(!defined("ADMIN")) die;  

// Начинаем сессию  
  
$access = array();  
$access = file("includes/loginpass.txt");  

$login = trim($access[0]);  
$passw = trim($access[1]);  
// print_r($access);
// Проверям были ли посланы данные  
if(!empty($_POST['enter']))  
{  
        $_SESSION['login'] = $_POST['login'];  
        $_SESSION['passw'] = $_POST['passw'];  
}  

// Если ввода не было, или они не верны  
// просим их ввести  
if(empty($_SESSION['login']) or  
   $login != $_SESSION['login'] or  
   $passw != $_SESSION['passw']    )  

{ header('location: /ru/login/');//bad auth!!
	//echo "bad auth!!";
}  //else echo "good auth!!";
?>