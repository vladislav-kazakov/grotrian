<?
class Localization{

    public $locale;
    public $localize;
    
	function __construct($dictionary){
		$this->checkLocale();		
		$this->assignDictionary($dictionary,$this->locale);		
  	}
  	
  	public function assignDictionary($dictionary,$locale){
  		foreach ($dictionary as $key=>$value)	
	  		foreach ($value as $loc=>$val) if($loc==$locale) $localize[$key]=$val;  

	  	if (isset($localize)) $this->localize=$localize; else $this->assignDictionary($dictionary,"en");
  	}
  	

    function checkLocale(){    	
   	
    	if (isset($_COOKIE['lang']) || isset($_GET["lang"])){
    	
    		if (isset($_COOKIE['lang']))
    		{	
				$loc=$_COOKIE['lang'];			
				$this->locale=$loc;
				if(!isset($_GET["lang"])) header('location: /admin/'.$loc);
			} 
	
			if (isset($_GET["lang"]))
			{
				$local=$_GET['lang'];	
				if ($local=="en" || $local=="ru")
				{								 
	    			//setcookie( "lang", "", time() - 36000, "/" );     			
    				setcookie("lang","".$local."",time()+21772800, "/");
    				$this->locale=$local;
				} else header('location: /admin/');
			}
		
    	}
    	else 
		{		
			header('location: /admin/en');
			//setcookie("lang","en",time()+217728000);
			//$this->locale="en";			
		}
		
    }
    
/*    function setCook($value){
    	setcookie("lang",$value,time()+217728000);
    } */ 
}
?>
