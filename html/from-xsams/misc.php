<?php
    function wavelength2RGB($length) {		
        $gamma = 1;								
		$Violet = 380;
		$Blue = 440;
		$Cyan = 490;
		$Green = 510;
		$Yello = 580;
		$Orange = 645;
		$Red = 780;
        
        $rgb = array(1, 1, 1);
        
        if ($length >= $Violet && $length < $Blue)
            $rgb = array(-($length - $Blue) / ($Blue - $Violet), 0, 1);
        elseif ($length >= $Blue && $length < $Cyan)
            $rgb = array(0, ($length - $Blue) / ($Cyan - $Blue), 1);
        elseif ($length >= $Cyan && $length < $Green)
            $rgb = array(0, 1, -($length - $Green) / ($Green - $Cyan));
        elseif ($length >= $Green && $length < $Yello)
            $rgb = array(($length - $Green) / ($Yello - $Green), 1, 0);
        elseif ($length >= $Yello && $length < $Orange)
            $rgb = array(1, -($length - $Orange) / ($Orange - $Yello), 0);
        elseif ($length >= $Orange && $length < $Red)
            $rgb = array(1, 0, 0);
            
        $correction = 1;
            
        if ($length >= $Violet && $length < $Blue)
            $correction = 0.3 + 0.7 * ($length - $Violet) / ($Blue - $Violet);
        elseif ($length >= 700 && $length < $Red)
            $correction = 0.3 + 0.7 * ($Red - $length) / ($Red - 700);	
	
		$correction *= 255;	
	
		return intval($correction * $rgb[0]) * $gamma.','.intval($correction * $rgb[1] * $gamma).','.intval($correction * $rgb[2] * $gamma); 
    }
    
    $err = 0;

    if (!empty($_FILES)) {
        if ($_FILES['file']['name']) {
            $f = file_get_contents($_FILES['file']['tmp_name']);
            if (preg_match_all("/<Wavelength.{1,150}Value units=\"A\">([\d\.]+)<\/Value>(?:.{1,200}<TransitionProbabilityA><Value units=\"1\/s\">([\d\.]+)<\/Value>)?(?:.{1,100}<OscillatorStrength.{1,100}Value units=\"unitless\">([\d\.]+)<\/Value>)?/",
                    str_replace("\n", '', $f), $m)) {

                $waves = '[';

				$cnt = count($m[0]);

    			for ($i = 0; $i < $cnt; $i++) {
                    $l = $m[1][$i] / 10;
					$waves .= ($i ? ',' : '').'{"length":'.$l.',"rgb":"'.wavelength2RGB($l).'","propability":"'.$m[2][$i].'","oscillator":"'.$m[3][$i].'"}';
                }

				$waves .= ']';

            }else
                $err = 'Неверный формат файла';
        }else {
            $err = 'Файл не выбран';
        }
    }

?>