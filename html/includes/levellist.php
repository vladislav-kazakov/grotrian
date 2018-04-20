<?
require_once("locallist.php");
require_once($_SERVER['DOCUMENT_ROOT']."/includes/transitionlist.php");

class LevelList extends LocalList
{
	    
function Load($element_id)
	{
		/*$query = "SELECT class_levels.*, [Grotrian].[dbo].GetCfgType(class_levels.CONFIG) AS CONFIG_TYPE , class_elements.ID as elementID FROM class_levels
		JOIN links ON links.TO_ELEMENT_ID=class_levels.ID
		JOIN class_elements ON links.FROM_ELEMENT_ID=class_elements.ID
		WHERE class_elements.ID='$element_id' ORDER BY ID";*/

		//$query = "SELECT *, GetCfgType(CONFIG) AS config_type FROM LEVELS WHERE ID_ATOM='$element_id' ORDER BY ID";
		$query = "SELECT LEVELS.* ,dbo.GetCfgType(CONFIG) AS config_type, dbo.ConcatSourcesID(ID,'L') AS SOURCE_IDS FROM LEVELS WHERE  ID_ATOM='$element_id' ORDER BY ENERGY asc";

		$this->LoadFromSQL($query);
	}

function LoadBase($element_id){
		$query = "SELECT LEVELS.* ,dbo.GetCfgType(CONFIG) AS config_type, dbo.ConcatSourcesID(ID,'L') AS SOURCE_IDS FROM LEVELS WHERE ID_ATOM='$element_id' AND ENERGY=0";
		$this->LoadFromSQL($query);
	}

	/*
    function Load($element_id)
        {

    $query = "ALTER VIEW cfg1 AS
    SELECT class_levels.*,[Grotrian].[dbo].GetCfgType(class_levels.CONFIG) AS CONFIG_TYPE , class_elements.ID as elementID FROM class_levels
            JOIN links ON links.TO_ELEMENT_ID=class_levels.ID
            JOIN class_elements ON links.FROM_ELEMENT_ID=class_elements.ID
            WHERE class_elements.ID='8728';

    ALTER VIEW cfg2 AS
    SELECT  CONFIG_TYPE, [Grotrian].[dbo].CountCfg(CONFIG_TYPE) AS CFGT
    FROM cfg1 GROUP BY  CONFIG_TYPE;


    SELECT cfg1.*, CASE WHEN (cfg2.CFGT=1) THEN  cfg1.CONFIG ELSE cfg1.CONFIG_TYPE END AS CFG_TYPE
    FROM  cfg1 LEFT JOIN  cfg2 ON  cfg1.CONFIG_TYPE= cfg2.CONFIG_TYPE";

            $this->LoadFromSQL($query);
        }

    */
	
	function LoadCount($element_id = null)
	{
		if ($element_id != null)
		{
			$stmt = GetStatement();
/*			$query = "SELECT count(class_levels.ID) FROM class_levels 
				JOIN links ON links.TO_ELEMENT_ID=class_levels.ID
				JOIN class_elements ON links.FROM_ELEMENT_ID=class_elements.ID
				WHERE class_elements.ID='$element_id' "; */
			
			$query = "SELECT count(ID) REPEATABLE FROM LEVELS WHERE ID_ATOM='$element_id' ";
			
			return $stmt->FetchField($query);
		}
		return $this->GetTotalRecords('LEVELS');
	}

	function LoadCountByIonization($ion = NULL, $operator = "=") //For statistics page
	{
		$stmt = GetStatement();
		$query = "SELECT COUNT(LEVELS.ID) FROM LEVELS JOIN ATOMS ON LEVELS.ID_ATOM = ATOMS.ID"
			. ($ion!== NULL ? " WHERE ATOMS.IONIZATION $operator $ion" : "" );
		//echo $query;
		return $stmt->FetchField($query);
	}

	function LoadClassifiedCountByIonization($ion = NULL, $operator = "=") //For statistics page
	{
		$stmt = GetStatement();
		$query = "SELECT COUNT(LEVELS.ID) FROM LEVELS JOIN ATOMS ON LEVELS.ID_ATOM = ATOMS.ID"
			. " WHERE LEVELS.CONFIG <> '' AND LEVELS.CONFIG IS NOT NULL AND LEVELS.CONFIG <> '(?)'"
			. ($ion!== NULL ? " AND ATOMS.IONIZATION $operator $ion" : "" );
		//echo $query;
		return $stmt->FetchField($query);
	}

	function LoadGrouped($element_id)
    {
    //    TERMPARITY,       TERMR,          TERMPREFIX, JJ, TERMSEQ
	//	  TERMMULTIPLY,     TERMFIRSTPART,  TERMPREFIX, J,  TERMSECONDPART



        $query = "SELECT LEVELS.* /*,dbo.GetCfgType(CONFIG) AS config_type*/, dbo.ConcatSourcesID(ID,'L') AS SOURCE_IDS 
                  FROM LEVELS 
                  WHERE ID_ATOM='$element_id' 
				  /*AND Levels.CONFIG NOT LIKE '%(%)%(%)%'*/  
                  AND Levels.CONFIG IS NOT NULL
				  AND Levels.CONFIG != '' 
				  AND ENERGY IS NOT NULL
				  ORDER BY ENERGY";
        $this->LoadFromSQL($query);

        $items = $this->GetItemsArray();
        //Генерируем атомные остатки
        foreach ($items as &$item) {
            $item['id'] = $item['ID'];
            $item['energy'] = $item['ENERGY'];

            $item['FULL_CONFIG'] = $item['CONFIG'];

            $item['TERMPARITY'] = $item['TERMMULTIPLY'];
            $item['TERMR'] = $item['TERMFIRSTPART'];
            $item['JJ'] = $item['J'];
            $item['TERMSEQ'] = $item['TERMSECONDPART'];


            //если есть атомный остаток, то выносим его в отдельный атрибут (ATOMICCORE), из CONFIG убираем
            if (preg_match('/^(.*)\(([^\)]*)\)([^\(\)]*)$/', $item['CONFIG'])){
                $item['ATOMICCORE'] = preg_replace('/^(.*)\(([^\)]*)\)([^\(\)]*)$/', '$2', $item['CONFIG']);
                $item['CONFIG'] = preg_replace('/^(.*)\(([^\)]*)\)([^\(\)]*)$/', '$1$3', $item['CONFIG']);
            }
            else $item['ATOMICCORE'] = '';

            //устанавливаем поля с NULL в ''
            if ($item['ATOMICCORE'] == null) $item['ATOMICCORE'] = '';
            if ($item['TERMSEQ'] == null) $item['TERMSEQ'] = '';
            if ($item['TERMPREFIX'] == null) $item['TERMPREFIX'] = '';
            if ($item['TERMR'] == null || $item['TERMR'] == '') $item['TERMR'] = '?';

            //убираем с конца конфигурации, j и терма незначащие символы, такие как '?', ', "
            $item['CONFIG'] = preg_replace('/^(.*?)([^a-zA-Z\}]*)$/', '$1', $item['CONFIG']);
            $item['JJ'] = preg_replace('/^(.*?)([^0-9]*)$/', '$1', $item['JJ']);
            $item['TERMR'] = preg_replace('/^(.*?)([^a-zA-Z0-9\)\}\]]*)$/', '$1', $item['TERMR']);
            $item['TERMSEQ'] = trim($item['TERMSEQ']);

            //убираем ~{...} c конца конфигурации
            $item['CONFIG'] = preg_replace('/^(.*)(~\{[^\{\}]*\})$/', '$1', $item['CONFIG']);
            //убираем последнюю букву из конфигурации, если их там две
            $item['CONFIG'] = preg_replace('/^(.*[a-zA-Z])[a-zA-Z]$/', '$1', $item['CONFIG']);
            //если заканчивается на @{число}, то в CELLCONFIG копируем CONFIG %@{%}
            //если не заканчивается на @{число}, то в CELLCONFIG заносим CONFIG с заменой последнего числа на 'n'
            if (!preg_match('/^(.*[@~]\{.*\})$/', $item['CONFIG'])) {
                if (preg_match('/^(.*?)(\d*)([a-zA-Z])$/', $item['CONFIG']))
                    $item['CELLCONFIG'] = preg_replace('/^(.*?)(\d*)([a-zA-Z])$/', '$1n$3', $item['CONFIG']);
                //непонятно, почему это здесь. Исправить
                if ($item['CONFIG'] == null || $item['CONFIG'] == '')
                    $item['CELLCONFIG'] = $item['CONFIG'] = '?';
            }
            else /*(preg_match('/^(.*@\{.*\})$/', $item['CONFIG']))*/
                $item['CELLCONFIG'] = $item['CONFIG'];
        }
        unset($item);
        //если у всех уровней с одинаковым CELLCONFIG совпадают и CONFIG, то CELLCONFIG = CONFIG
        $cellconfigs = [];

        foreach ($items as $item) {
            if (!isset($cellconfigs[$item['CELLCONFIG']])) $cellconfigs[$item['CELLCONFIG']] = [];
            if (!in_array($item['CONFIG'], $cellconfigs[$item['CELLCONFIG']]))
                $cellconfigs[$item['CELLCONFIG']][] = $item['CONFIG'];
        }

        $new_cellconfigs = [];
        foreach ($cellconfigs as $cellconfig => $configs) {
            if (count($configs) == 1)
                $new_cellconfigs[$configs[0]] = $configs;
            else $new_cellconfigs[$cellconfig] = $configs;
        }
        $cellconfigs = $new_cellconfigs;

        foreach ($items as &$item)
            foreach ($cellconfigs as $cellconfig => $configs)
                foreach ($configs as $config)
                    if ($item['CONFIG'] == $config)
                        $item['CELLCONFIG'] = $cellconfig;
        unset($item);

        //генерируем long
        $transitionList = new TransitionList();
        $transitionList->LoadWithLevels($element_id);
        $transitions =  $transitionList->GetItemsArray();

        foreach ($items as &$item){
            $item['long'] = 0;
            if ($item['ENERGY'] == 0) $item['long'] = 1;
            foreach($transitions as $transition){
                if ($transition['lower_level_id'] == $item['ID'] && $transition['lower_level_termmultiply'] != $transition['upper_level_termmultiply']) {
                    $item['long'] = 1;
                    break;
                }
            }

        }
        unset($item);

        //Группируем элементы массива
        $terms = $this->GroupArrayByKeys($items, ['CELLCONFIG', 'ATOMICCORE', 'TERMPREFIX', 'TERMPARITY', 'TERMR', 'TERMSEQ', 'JJ'], 'level');
        //print_r($terms);

        //Сортируем термы учитывая четность, основной терм, энергии
        usort($terms, function($a, $b)
        {
            if ($a['level'][0]['ENERGY'] == 0 ){
                if ($b['level'][0]['TERMPARITY'] == 1 ) {
                    return 1;
                }
                else {
                    return -1;
                }
            }
            if ($b['level'][0]['ENERGY'] == 0 ){
                if ($a['level'][0]['TERMPARITY'] == 1 ) {
                    return -1;
                }
                else {
                    return 1;
                }
            }

            if ($a['level'][0]['TERMPARITY'] > $b['level'][0]['TERMPARITY']){
                return -1;
            }
            if ($a['level'][0]['TERMPARITY'] < $b['level'][0]['TERMPARITY']){
                return 1;
            }
            else{
                if ($a['level'][0]['TERMPARITY'] == 1){
                    if ($a['level'][0]['ENERGY'] > $b['level'][0]['ENERGY']){
                        return 1;
                    }
                    if ($a['level'][0]['TERMPARITY'] < $b['level'][0]['TERMPARITY']){
                        return -1;
                    }
                    else{
                        return 0;
                    }
                }
                else{
                    if ($a['level'][0]['ENERGY'] < $b['level'][0]['ENERGY']){
                        return 1;
                    }
                    if ($a['level'][0]['TERMPARITY'] > $b['level'][0]['TERMPARITY']){
                        return -1;
                    }
                    else{
                        return 0;
                    }
                }

            }

        });

        $groups = $this->GroupArrayByKeys($terms, ['CELLCONFIG', 'ATOMICCORE', 'TERMPREFIX', 'TERMPARITY'], 'group');
        $atomiccores = $this->GroupArrayByKeys($groups, ['CELLCONFIG', 'ATOMICCORE', 'TERMPARITY'], 'term');
        $columns = $this->GroupArrayByKeys($atomiccores, ['CELLCONFIG', 'TERMPARITY'], 'atomiccore');

        $diagramArray = ['Diagram'=>['Levels'=>['column'=>$columns]]];
        return $diagramArray;
}

    function GroupArrayByKeys($array, $keys, $groupName)
    {
        $newarray = [];
        foreach($array as $value) {
            $found = false;
            foreach ($newarray as &$newarrayvalue){
                //проверяем совпадение $value и $newarrayvalue
                $equal = true;
                foreach ($keys as $key) {
                    //echo var_dump($value[$key]), " ", var_dump($newarrayvalue[$key]), "->";
                    if ($value[$key] != $newarrayvalue[$key]) {
                        //echo "not equal".PHP_EOL;
                        $equal = false;
                        break;
                    }
                    //echo PHP_EOL;
                }
                //если всё совпало добавляем туда элемент
                if ($equal) {
                    $newarrayvalue[$groupName][] = $value;
                    $found = true;
                    break;
                }
            }
            unset($newarrayvalue);
            //если не нашли совпадение создаем
            if (!$found){
                $newarrayvalue = [];
                foreach ($keys as $key)
                    $newarrayvalue[$key] = $value[$key];
                $newarrayvalue[$groupName][] = $value;
                $newarray[] = $newarrayvalue;
            }
        }
        return $newarray;
    }

	function Save($post){
		$count=$post['count'];
		$query="";
		for ($i=0; $i<$count; $i++) {
				$level_id = $post['row_id'][$i];
				$level_config   = empty($post['level_config'][$i])     ? "" : "'".$post['level_config'][$i]."'";
				$termSecondpart = ($post['termSecondpart'][$i] == "")  ? 'NULL' : "'".$post['termSecondpart'][$i]."'";
				$termPrefix     = ($post['termPrefix'][$i] == "")      ? 'NULL' : "'".$post['termPrefix'][$i]."'";
				$termFirstpart  = empty($post['termFirstpart'][$i])    ? " " : $post['termFirstpart'][$i];
				$termMultiply   = ($post['termMultiply'][$i]<>"")      ? 1 : 0;
				$j              = ($post['j'][$i] == "")               ? 'NULL' : "'".$post['j'][$i]."'";
				$energy         = ($post['energy'][$i] == "")          ? 'NULL' : $post['energy'][$i];
				$lifetime       = ($post['lifetime'][$i] == "")        ? 'NULL' : $post['lifetime'][$i];		
				
				$query .= " UPDATE LEVELS SET [CONFIG] = ".$level_config." ,[ENERGY] = ".$energy.",[LIFETIME] = ".$lifetime.", [J] = ".$j.", [TERMSECONDPART] = ".$termSecondpart." , [TERMPREFIX] = ".$termPrefix." ,[TERMMULTIPLY] = ".$termMultiply.", [TERMFIRSTPART] = '".$termFirstpart."' WHERE ID =".$level_id;
			}		
		$this->LoadFromSQL($query);
	}
	
/*	function Delete($post){
		$count=$post['count'];
		for ($i=0; $i<$count; $i++) {
				$level_id = $post['level_id'][$i];
				$query .= " DELETE FROM [LEVELS] WHERE ID =".$level_id;			
		}
		//echo $query
		$this->LoadFromSQL($query);
	}*/
	
	function Delete($post){
		$query = "";
		foreach ($post['row_id'] as $key=>$level_id) {
			$query .= " DELETE FROM [LEVELS] WHERE ID =".$level_id;			
		}
		$this->LoadFromSQL($query);
	}
	
/*	function Create($atom_id)
	{		
		$query = "INSERT INTO LEVELS ([ID],[ID_ATOM]) SELECT MAX(ID)+1,".$atom_id." FROM LEVELS
		SELECT MAX(ID) AS ID FROM LEVELS WHERE ID_ATOM=".$atom_id;
	 	$this->LoadFromSQL($query);				
	}*/


	function Create($atom_id)
	{	
		$query = "INSERT INTO LEVELS ([ID_ATOM]) VALUES (".$atom_id.")		
		SELECT MAX(ID) AS ID FROM LEVELS WHERE ID_ATOM=".$atom_id;
	 	$this->LoadFromSQL($query);				
	}
	
	
	
/*	function ApplySources($post){
		
		foreach ($post['level_id'] as $level_key=>$level_id){
			foreach ($post['source_id'] as $source_key=>$source_id)
			$query.=" IF ((SELECT ID_RECORD FROM BIBLIOLINKS WHERE [ID_RECORD]=".$level_id." AND [ID_SOURCE]=".$source_id." AND [RECORDTYPE] = ".$post['type'].")= NULL) BEGIN INSERT INTO BIBLIOLINKS ([RECORDTYPE],[ID_RECORD],[ID_SOURCE]) VALUES (".$post['type'].",".$level_id.",".$source_id.") END";
		}
		
		//echo $query;
		$this->LoadFromSQL($query);
	}

	function ApplyRemovingSources($post){ 
		foreach ($post['level_id'] as $level_key=>$level_id){
			foreach ($post['source_id'] as $source_key=>$source_id)
			$query.=" DELETE FROM [BIBLIOLINKS] WHERE [ID_RECORD]=".$level_id." AND [ID_SOURCE]=".$source_id." AND [RECORDTYPE]=".$post['type'];
		}
		//echo $query;
		$this->LoadFromSQL($query);
	}
	
	function GetSourceIDs($level_id)
	{
		$query = "SELECT dbo.ConcatSourcesID(ID,'L') AS SOURCE_IDS FROM LEVELS WHERE  ID=".$level_id." ORDER BY ID asc";		
		$this->LoadFromSQL($query);
	}*/	
	
	function LoadFiltered($atom_id,$position,$level_id)
	{		
		//echo "levId=".$level_id;
		$position = ($position == 'lower') ? "<" : ">";
		if (empty($level_id)) $query = "SELECT LEVELS.* ,dbo.GetCfgType(CONFIG) AS config_type, dbo.ConcatSourcesID(ID,'L') AS SOURCE_IDS FROM LEVELS WHERE  ID_ATOM=".$atom_id." ORDER BY ENERGY asc";
		else $query = "SELECT LEVELS.* ,dbo.GetCfgType(CONFIG) AS config_type, dbo.ConcatSourcesID(ID,'L') AS SOURCE_IDS FROM LEVELS WHERE  ID_ATOM=".$atom_id."  AND TERMMULTIPLY != (Select TERMMULTIPLY FROM LEVELS WHERE ID = ".$level_id.") AND ENERGY ".$position." (Select ENERGY FROM LEVELS WHERE ID = ".$level_id.") ORDER BY ENERGY asc";
	
		//echo $query; 			
		$this->LoadFromSQL($query);
	}

	function LoadGroupForCircleSpectrum($element_id)
	{
		$query = "SELECT l.config, g.* FROM 
(SELECT config FROM [Grotrian_v2].[dbo].[LEVELS] where ID_ATOM = $element_id 
GROUP BY config ) as l
cross apply
(SELECT top 1 * FROM [Grotrian_v2].[dbo].[LEVELS] 
	 WHERE config = l.config and ID_ATOM=$element_id order by energy) as g

ORDER BY g.energy
	 ";

		$this->LoadFromSQL($query);
	}


}
?>