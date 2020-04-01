<?php
header('Access-Control-Allow-Origin: *');
$errors = array();
if($_POST['ABBR'] == "")    $errors[] = "error!";
if($_POST['IONIZATION'] == "")   $errors[] = "error!";


if(empty($errors)){

    $new = $_POST['NEW'];
    $id = 0;
    $atom_arr = '';

    if ($new == 0){
        echo 0;
    }
    else {
        $symbol = $_POST['ABBR'];
        $ion = $_POST['IONIZATION'];

        $url = "http://grotrian.nsu.ru/ru/json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//для возврата результата в виде строки, вместо прямого вывода в браузер
        $returned = curl_exec($ch);
        curl_close($ch);

        $array = json_decode($returned, true);

        foreach ($array as $value){

            $array =  json_encode($value);
            $array = json_decode($array);

            if($array -> ABBR == $symbol && $array -> IONIZATION == $ion && $array -> MASS_NUMBER == ''){
                $id = $array -> ID;
                $atom_arr = $array;
                break;
            }
        }

        $url = "http://grotrian.nsu.ru/ru/json/".$id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//для возврата результата в виде строки, вместо прямого вывода в браузер
        $returned = curl_exec($ch);
        curl_close($ch);
        $returned = json_decode($returned, true);

        $url = "http://grotrian.nsu.ru/ru/jsonlevels/".$id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//для возврата результата в виде строки, вместо прямого вывода в браузер
        $levels = curl_exec($ch);
        curl_close($ch);
        $levels = json_decode($levels, true);

        echo json_encode(array(
            'atom' => $atom_arr,
            'transitions' => $returned,
            'levels' => $levels,
        ));
    }
}
else{
// если были ошибки, то выводим их
    $msg_box = "";
    foreach($errors as $one_error){
        $msg_box .= "<span style='color: red;'>$one_error</span><br/>";
    }
    echo $msg_box;
}