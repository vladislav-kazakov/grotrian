<?php

function field_validator($field_descr, $field_data, 
  $field_type, $min_length="", $max_length="", 
  $field_required=1) {  
    global $validateMessage;
    
        
    if(!$field_data && !$field_required){ return; }

    $email_regexp="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|";
    $email_regexp.="(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$";

   // "fullname"=>"^[а-яА-ЯёЁa-zA-Z ]+$"
    $data_types=array(
        "email"=>$email_regexp,
    	"fullname"=>'/^[^\d\+\=\_\)\(\*\&\^\%\$\#\@\!\,\/\'\"\;\:\\\|\`\~]+$/',    
        "login"=>"^[a-zA-Z0-9]+$",
        "digit"=>"^[0-9]$",
        "number"=>"^[0-9]+$",
        "alpha"=>"^[a-zA-Z]+$",
        "alpha_space"=>"^[a-zA-Z ]+$",
        "alphanumeric"=>"^[a-zA-Z0-9_]+$",
        "alphanumeric_space"=>"^[a-zA-Z0-9 ]+$",       
    );
    
    //$field_ok = mb_ereg_match($data_types[$field_type], $field_data);  
	$field_ok = ereg($data_types[$field_type], $field_data);
   
   if(($field_data=="fullname") AND ($field_ok ==false)) $field_ok = true;
    
    if ($field_required && empty($field_data)) {
        $validateMessage = "Пожалуйста введите $field_descr";
        return;
    }
    
    if ($field_required && $field_data==$field_descr) {
        $validateMessage = "Пожалуйста введите $field_descr";
        return;
    }

   if (!$field_ok) {
        $validateMessage = "Пожалуйста, введите корректно $field_descr.";
        return;
    }
    
    if ($field_ok && $min_length) {
        if (strlen($field_data) < $min_length) {
            $validateMessage = "$field_descr не верного формата, его длина должна быть не менее ".$min_length."х символов.";
            return;
        }
    }
    
    if ($field_ok && $max_length) {
        if (strlen($field_data) > $max_length) {
            $validateMessage = "$field_descr не верного формата, его длина должна быть не более ".$max_length."и символов.";
            return;
        }
    }
}

?>