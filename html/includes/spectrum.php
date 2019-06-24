<?php 
class Spectrum{

	public function wavelength2RGB($length){		//Функция генерирования RGB цвета по длине волны
	
		$gamma=1;								
		$Violet=380;
		$Blue=440;
		$Cyan=490;									//Опорные точки цвета
		$Green=510;
		$Yello=580;
		$Orange=645;
		$Red=780;

		switch ($length) {
    		case ($length >= $Violet AND $length < $Blue  ) :	 
    			$RGB['R']=-($length - $Blue) / ($Blue - $Violet); 
    			$RGB['G']=0; 
    			$RGB['B']=1; 
    		break;  

    		case ($length >= $Blue AND $length < $Cyan  ) : 
    			$RGB['R']=0; 
    			$RGB['G']=($length - $Blue) / ($Cyan - $Blue); 
    			$RGB['B']=1; 
    		break; 
	    	
	   		case ($length >= $Cyan AND $length < $Green) :
    			$RGB['R']=0; 
    			$RGB['G']=1; 
    			$RGB['B']=-($length - $Green) / ($Green - $Cyan); 
    		break;
    	
    		case ($length >= $Green AND $length < $Yello) :
    			$RGB['R']=($length - $Green) / ($Yello - $Green); 
    			$RGB['G']=1; 
    			$RGB['B']=0; 
    		break;

    		case ($length >= $Yello AND $length < $Orange) :
    			$RGB['R']=1; 
    			$RGB['G']=-($length - $Orange) / ($Orange - $Yello); 
    			$RGB['B']=0; 
    		break;
    	
    		case ($length >= $Orange AND $length < $Red):
    			$RGB['R']=1; 
    			$RGB['G']=0; 
    			$RGB['B']=0; 
    		break;
    	
    		default:
    			$RGB['R']=1;		//Белый цвет по умолчанию
    			$RGB['G']=1; 
    			$RGB['B']=1; 
		}
	
		switch ($length) {
    		case ($length >= $Violet AND $length < $Blue) : 
    			$correction= 0.3 + 0.7*($length - $Violet) / ($Blue - $Violet); 
    		break;  
		
    		case ($length >= 420 AND $length < 700) :
				$correction=1;
    		break;
    	
    		case ($length >= 700 AND $length < $Red) :
				$correction=0.3 + 0.7*($Red - $length) / ($Red - 700);
    		break;
    	
    		default:
				$correction=1; 
		}	
	
		$correction *=255;	
	
		$RGB['R']=intval($correction*$RGB['R'])*$gamma;
		$RGB['G']=intval($correction*$RGB['G']*$gamma);
		$RGB['B']=intval($correction*$RGB['B']*$gamma);
	
		return $RGB;
	}
	
	public function compressLengths($lengths,$accuracy){		//Функция компресси линий (соседние линии с определённой точностью сжимаются в одну)
		for($i=1; $i<count($lengths); $i++ ){
			if(round($lengths[$i-1],$accuracy) != round($lengths[$i],$accuracy)) $result[]=round($lengths[$i-1],$accuracy);			
		}
		return $result;
	}

	public function buildTerm($second_part, $prefix, $first_part, $multiply){
		$term = "";
		if ($second_part != "NULL") $term .= $second_part;
		if ($prefix != "") $term .= "<sup>$prefix</sup>";
		if ($first_part == "" || $first_part == " ") $term .= "(?)";
 		else $term .= "<span>$first_part</span>";
		if ($multiply == 1) $term .="<span>&deg;</span>";
		return $term;
	}

	public function buildTermWithJ($second_part, $prefix, $first_part, $multiply, $j){
		$term = "";
		if ($second_part != "NULL") $term .= $second_part;
		if ($prefix != "") $term .= "<sup>$prefix</sup>";
		if ($first_part == "" || $first_part == " ") $term .= "(?)";
		else $term .= "<span>$first_part</span>";
		if ($multiply == 1) $term .="<span>&deg;</span>";
		if ($j != "") $term .="<sub>$j</sub>";
		return $term;
	}

	public function getLevelsSVG($grouped_levels)
	{
		$obj = "{";
		foreach ($grouped_levels as $level=>$value) {
			$obj .= '"' . $value['ENERGY'] . '":"' . $value['CONFIG'] . '",';
		}
		if (strlen($obj) > 1) $obj = substr($obj, 0, -1);
		$obj.='}';

			return $obj;
	}

		public function getSpectraSVG($transitions,$min,$max) {		//функция из массива переходов генерирует массив вида [длина волны:цвет] в формате JSON
		$x=0;			
		$obj="{";
		//usort($transitions, function ($a, $b) { if ($a['INTENSITY'] == $b['INTENSITY']) { return 0; } return ($a['INTENSITY'] > $b['INTENSITY']) ? +1 : -1; });
		foreach ($transitions as $transition=>$value){
			$length=$value['WAVELENGTH'];
			$intensity=$value['INTENSITY'];
			if(empty($intensity))$intensity = 0;
			$l_i = "$length-$intensity-" . $value['lower_level_config']
					. "-" . $this->buildTermWithJ($value['lower_level_termsecondpart'], $value['lower_level_termprefix'], $value['lower_level_termfirstpart'], $value['lower_level_termmultiply']
					, $value['lower_level_j']) . "-" . $value['upper_level_config']
					. "-" . $this->buildTermWithJ($value['upper_level_termsecondpart'], $value['upper_level_termprefix'], $value['upper_level_termfirstpart'], $value['upper_level_termmultiply']
					, $value['upper_level_j'])
					. "-" . $value['lower_level_energy'] . "-" . $value['upper_level_energy'];
			if ($length>=$min && $length<=$max ){			
				$RGB=$this->wavelength2RGB(round($length/10));
				$obj.='"'.$l_i.'":"rgb('.$RGB['R'].','.$RGB['G'].','.$RGB['B'].')",';
			}
		}			
  		if (strlen($obj) > 1) $obj = substr($obj, 0, -1);
		$obj.='}';
		
		return $obj;
  	}

	public function export($transitions, $elname) {
		$xsams = '<?xml version="1.0" encoding="UTF-8"?>
<XSAMSData xmlns="http://vamdc.org/xml/xsams/1.0" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:cml="http://www.xml-cml.org/schema" xsi:schemaLocation="http://vamdc.org/xml/xsams/1.0 http://vamdc.org/xml/xsams/1.0">
	<Processes>
		<Radiative>';	
		foreach ($transitions as $transition) {
			$l = $transition['WAVELENGTH'];
			$xsams .= '
			<RadiativeTransition process="excitation">
				<EnergyWavelength>
					<Wavelength>
						<Value units="A">'.$l.'</Value>
					</Wavelength>
				</EnergyWavelength>
			</RadiativeTransition>';
		}
		$xsams .= '
		</Radiative>
	</Processes>
</XSAMSData>';
		header("Content-Type: application/xml");
        header('Content-Disposition: attachment; filename="'.$elname.'.xsams"');
		header('Content-Length: ' .mb_strlen($xsams) );
		echo $xsams;
		exit;
	}

	public function parse_file($file) {
		if (is_array($file))
			$file = $file['tmp_name'];
		else {
			if (!preg_match('~^https?://.+/.+\.(xsams|csv)$~i', $file) || strpos(current(get_headers($file)), '404') !== FALSE)
				return 0;
		}
	 
    	$f = file_get_contents($file);

		if (preg_match_all("/<Value units=\"A\">([\d\.]+)<\/Value>/", $f, $m) || preg_match_all('/\s*(\d+\.\d+),\s*(\d+(?:\.\d+)?)/', $f, $mm)) {
			$waves = '{';

           	if ($cnt = count($m[0])) {
				for ($i = 0; $i < $cnt; $i++) {
            		$l = $m[1][$i];
			   		$RGB=$this->wavelength2RGB(round($l / 10));
		       		$waves .= ($i ? ',' : '').'"'.$l.'":"rgb('.$RGB['R'].','.$RGB['G'].','.$RGB['B'].')"';
           		}
           	}else {
           		$cnt = count($mm[0]);

           		for ($i = 0; $i < $cnt; $i++)
           			$waves .= ($i ? ',' : '').'"'.$mm[1][$i].'":'.$mm[2][$i];		
           	}

	       	$waves .= '}';

		   	return $waves;

        }else
	        return false;
	} 
}
?>