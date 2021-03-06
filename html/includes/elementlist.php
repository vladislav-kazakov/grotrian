<?

require_once("locallist.php");

class ElementList extends LocalList
{
/*     function LoadABBR()
	{
		$query = "SELECT ID.*,ABBR.* FROM class_elements";
		$this->LoadFromSQL($query);
	} */
	function LoadABBR()
	{
//		$query = "SELECT ID, ABBR
//				  FROM class_elements WHERE ABBR NOT LIKE 'old%' AND ABBR NOT LIKE 'new%' ORDER BY ABBR";
		$query = "SELECT ID, ABBR  FROM class_elements ORDER BY ABBR";
		$this->LoadFromSQL($query);
	}
	
	
	function LoadABBRForDiagram()
	{
		$query = "SELECT ID, ABBR  FROM class_elements WHERE ABBR NOT LIKE 'old%' AND ABBR NOT LIKE 'new%' AND DATALENGTH(LIMITS) != 0 ORDER BY ABBR";
		$this->LoadFromSQL($query);
	}
	
	
	function LoadState()
	{
		$query = "SELECT result1.ID, result1.ABBR, result1.LEVEL_COUNT, COUNT(class_transitions.id) AS TRANSITION_COUNT 
      			   FROM (SELECT class_elements.id, class_elements.abbr, COUNT(class_levels.id) AS level_count
							 FROM class_elements 
							 LEFT OUTER JOIN links ON class_elements.id = links.from_element_id
							 LEFT OUTER JOIN class_levels ON class_levels.id = links.to_element_id
							 WHERE class_elements.abbr NOT LIKE 'old%' AND abbr NOT LIKE 'new%' 
							 GROUP BY class_elements.id, class_elements.abbr)
					    AS result1
	 				    
						LEFT OUTER JOIN links AS links_1 ON result1.id = links_1.from_element_id
						LEFT OUTER JOIN class_transitions ON class_transitions.id = links_1.to_element_id
      					GROUP BY result1.id, result1.abbr, result1.level_count";
		$this->LoadFromSQL($query);
	}
	
		function Loadions($element_id)
	{
		$query = "SELECT ATOMS.ID, ABBR AS 'ELNAME', IONIZATION AS 'IVAL', MASS_NUMBER FROM ATOMS,PERIODICTABLE WHERE ID_ELEMENT = PERIODICTABLE.ID AND PERIODICTABLE.ID = (SELECT ID_ELEMENT FROM ATOMS WHERE ID = '$element_id');";
		if (!$this->LoadFromSQL($query)) return FALSE;
	}
	
	function LoadPereodicTable($lang,$ionization)
	{

		switch ($lang){		
			case "ru":  $name="NAME_RU"; break;    	
	    	case "en": $name="NAME_EN"; break;
	    	default:  $name="NAME_EN"; 
		}

		//$query = "SELECT ATOMS.ID, Z, ABBR, TABLEPERIOD, [TABLEGROUP], ".$name." AS name, NAME_RU_ALT, TYPE  FROM  PERIODICTABLE,ATOMS WHERE ID_ELEMENT = PERIODICTABLE.ID AND ATOMS.IONIZATION LIKE '0' ORDER BY PERIODICTABLE.ID DESC";
		$query = "SELECT ATOMS.ID, Z, ABBR, TABLEPERIOD, [TABLEGROUP], ".$name." AS name, NAME_RU_ALT, [TYPE] , (SELECT COUNT(LEVELS.ID) FROM LEVELS WHERE LEVELS.ID_ATOM = ATOMS.ID ) AS LEVELS_NUM , (SELECT COUNT(TRANSITIONS.ID) FROM TRANSITIONS WHERE TRANSITIONS.ID_ATOM = ATOMS.ID ) AS TRANSITIONS_NUM FROM  PERIODICTABLE,ATOMS WHERE ID_ELEMENT = PERIODICTABLE.ID AND ATOMS.IONIZATION LIKE ".$ionization." AND ATOMS.MASS_NUMBER IS NULL ORDER BY PERIODICTABLE.ID DESC";
		$this->LoadFromSQL($query);
	}
	
	function LoadMaxLevelsNUM($ionization)
	{
		$query = "SELECT TOP 1 ATOMS.ID, (SELECT COUNT(LEVELS.ID) FROM LEVELS WHERE LEVELS.ID_ATOM = ATOMS.ID ) AS MAXLEVELS_NUM  FROM  PERIODICTABLE,ATOMS WHERE ID_ELEMENT = PERIODICTABLE.ID AND ATOMS.IONIZATION LIKE '".$ionization."' ORDER BY MAXLEVELS_NUM DESC";
		$this->LoadFromSQL($query);
	}
	
	function LoadMaxTransitionsNUM($ionization)
	{
		$query = "SELECT TOP 1 ATOMS.ID, (SELECT COUNT(LEVELS.ID) FROM LEVELS WHERE LEVELS.ID_ATOM = ATOMS.ID ) AS LEVEL_NUM , (SELECT COUNT(TRANSITIONS.ID) FROM TRANSITIONS WHERE TRANSITIONS.ID_ATOM = ATOMS.ID ) AS TRANSITIONS_NUM  FROM  PERIODICTABLE,ATOMS WHERE ID_ELEMENT = PERIODICTABLE.ID AND ATOMS.IONIZATION LIKE '".$ionization."' ORDER BY LEVEL_NUM DESC";
		$this->LoadFromSQL($query);
	}
	
	
	function Save($post){	
		
	$element_id = $post['element_id'];
	$Z = empty($post['Z']) ? "NULL" : $post['Z'];
	$Abbr = empty($post['Abbr']) ? "NULL" : $post['Abbr'];
	$tablePeriod = empty($post['tablePeriod']) ? "NULL" : $post['tablePeriod'];
	$tableGroup = empty($post['tableGroup']) ? "NULL" : $post['tableGroup'];
	
	$name_ru = empty($post['Name_ru']) ? "NULL" : (iconv("UTF-8", "Windows-1251", $post['Name_ru'])); 	
	$name_ru_alt = empty($post['Name_ru']) ? "NULL" : (iconv("UTF-8", "Windows-1251", $post['Name_ru_alt']));
	$name_en = empty($post['Name_en']) ? "NULL" : $post['Name_en'];
	$atom_Mass = empty($post['atom_Mass']) ? "NULL" : $post['atom_Mass'];
	$Type = empty($post['Type']) ? "NULL" : $post['Type'];

		

		
	$query = "UPDATE PERIODICTABLE SET [Z] = ".$Z." ,[ABBR] = '".$Abbr."',[TABLEPERIOD] = ".$tablePeriod.",[TABLEGROUP] = ".$tableGroup." ,[NAME_RU] = '".$name_ru."',[NAME_RU_ALT] = '".$name_ru_alt."',[NAME_EN] = '".$name_en."',[ATOM_MASS] = ".$atom_Mass." ,[TYPE] = '".$Type."'   WHERE ID = ".$element_id;
		
		$this->LoadFromSQL($query);
	}
	
	
}
?>