<?php 
class Spectrum{

	private function wavelength2RGB($length){		//������� ������������� RGB ����� �� ����� �����		
	
		$gamma=1;								
		$Violet=380;
		$Blue=440;
		$Cyan=490;									//������� ����� �����
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
    			$RGB['R']=1;		//����� ���� �� ���������
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
	
	public function compressLengths($lengths,$accuracy){		//������� ��������� ����� (�������� ����� � ����������� ��������� ��������� � ����)
		for($i=1; $i<count($lengths); $i++ ){
			if(round($lengths[$i-1],$accuracy) != round($lengths[$i],$accuracy)) $result[]=round($lengths[$i-1],$accuracy);			
		}
		return $result;
	}

	public function getSpectraSVG($transitions,$min,$max) {		//������� �� ������� ��������� ���������� ������ ���� [����� �����:����] � ������� JSON		
		$x=0;			
		$obj="{";
		
		foreach ($transitions as $transition=>$value){
			$length=$value['WAVELENGTH'];
			
			if ($length>=$min && $length<=$max ){			
				$RGB=$this->wavelength2RGB(round($length/10));
				$obj.='"'.$length.'":"rgb('.$RGB['R'].','.$RGB['G'].','.$RGB['B'].')",';
			}
		}			
  		$obj=substr($obj, 0, -1);
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
		header("Content-Type: application/xml");
        header('Content-Disposition: attachment; filename="'.$elname.'.xsams"');
		echo $xsams .= '
		</Radiative>
	</Processes>
</XSAMSData>';
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