<?
require_once("locallist.php");
require_once("transitionlist.php");
require_once("atom.php");


class LevelList extends LocalList
{
	    
function Load($element_id)
	{
		/*$query = "SELECT class_levels.*, [Grotrian].[dbo].GetCfgType(class_levels.CONFIG) AS CONFIG_TYPE , class_elements.ID as elementID FROM class_levels
		JOIN links ON links.TO_ELEMENT_ID=class_levels.ID
		JOIN class_elements ON links.FROM_ELEMENT_ID=class_elements.ID
		WHERE class_elements.ID='$element_id' ORDER BY ID";*/

		//$query = "SELECT *, GetCfgType(CONFIG) AS config_type FROM LEVELS WHERE ID_ATOM='$element_id' ORDER BY ID";
		$query = "SELECT LEVELS.* , dbo.ConcatSourcesID(ID,'L') AS SOURCE_IDS FROM LEVELS WHERE  ID_ATOM='$element_id' ORDER BY ENERGY asc";
		$this->LoadFromSQL($query);
        $this->LoadCellConfigs('config_type');
	}

function LoadBase($element_id){
		$query = "SELECT LEVELS.* , dbo.ConcatSourcesID(ID,'L') AS SOURCE_IDS FROM LEVELS WHERE ID_ATOM='$element_id' AND (ENERGY=0 OR ENERGY_MHZ=0)";
		$this->LoadFromSQL($query);
        $this->LoadCellConfigs('config_type');
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

	function LoadCellConfigs($name)
    {
//        $items = $this->GetItemsArray();
        foreach ($this->items as &$item) {
            $config = $item['CONFIG'];
            if ($config == "(?)") $config = "?";

            //убираем с конца конфигурации, j и терма незначащие символы, такие как '?', ', "
            $config = preg_replace('/^(.*?)([^a-zA-Z\}\)]*)$/', '$1', $config);

            //убираем ~{...} c конца конфигурации
            $config = preg_replace('/^(.*)(~\{[^\{\}]*\})$/', '$1', $config);
            //убираем последнюю букву из конфигурации, если их там две
            $config = preg_replace('/^(.*[a-zA-Z])[a-zA-Z]$/', '$1', $config);

            //если заканчивается на @{число}, то в CELLCONFIG копируем CONFIG %@{%}
            //если не заканчивается на @{число}, то в CELLCONFIG заносим CONFIG с заменой последнего числа на 'n'
            $item[$name] = $config;

            if (!preg_match('/^(.*@\{.*\})$/', $config)) {
                if (preg_match('/^(.*?)(\d+)([a-z])$/', $config))
                    $item[$name] = preg_replace('/^(.*?)(\d+)([a-z])$/', '$1n$3', $config);
            }
/*            else{
                $item[$name] = preg_replace_callback('/^(.*?)(\d+)([a-z])@\{(\d+)\}$/',
                    function ($matches) {
                        if (($matches[4] - 1)  == 1) $index = '';
                        else $index = '@{' . ($matches[4] - 1) . '}';
                        $replacement = $matches[1] . $matches[2] . $matches[3] . $index . 'n' . $matches[3];
                        return $replacement;
                    },
                    $config
                );
            }
*/
            if ($config == null || $config == '')
                $item[$name] = $config = '?';
        }
    }

	function LoadGrouped($element_id, $min_energy = 0, $max_energy = 0, $options = [])
    {
        $query = "SELECT LEVELS.* FROM LEVELS WHERE ID_ATOM='$element_id'"
            . " AND ENERGY IS NOT NULL "
            . ($min_energy > 0 ? "AND ENERGY >= $min_energy ":"")
            . ($max_energy > 0 ? "AND ENERGY <= $max_energy ":"")
            . " ORDER BY ENERGY";

        $this->LoadFromSQL($query);
        $this->LoadCellConfigs('CELLCONFIG');
        $items = $this->GetItemsArray();

        foreach ($items as $i => &$item) {
            //проверяем nmax и lmax
            $configwoac = preg_replace('/\([^\(\)]*\)/', '', $item['CONFIG']);
            $configwoind = preg_replace('/\{[^\{\}]*\}/', '', $configwoac);
            $n = preg_replace('/^.*?(\d+)[^0-9]*$/', '$1', $configwoind);
            $l = preg_replace('/^.*?([a-z])[^a-z]*$/', '$1', $configwoind);

            if (isset($options['nmax']) && $n > $options['nmax']) {
                unset($items[$i]);
                continue;
            }
            if (isset($options['lmax']) && $l > $options['lmax'] && $l != 's' && $l != 'p' && $l != 'd' && $l != 'f') {
                unset($items[$i]);
                continue;
            }


            if ($item['TERMFIRSTPART'] == "(?)") $item['TERMFIRSTPART'] = "?";
            $item['FULL_CONFIG'] = $item['CONFIG'];

            if ($item['CONFIG'] == "(?)") $item['CONFIG'] = "?";
            //убираем с конца конфигурации, j и терма незначащие символы, такие как '?', ', "
            $item['CONFIG'] = preg_replace('/^(.*?)([^a-zA-Z\}\)]*)$/', '$1', $item['CONFIG']);
            //убираем ~{...} c конца конфигурации
            $item['CONFIG'] = preg_replace('/^(.*)(~\{[^\{\}]*\})$/', '$1', $item['CONFIG']);
            //убираем последнюю букву из конфигурации, если их там две
            $item['CONFIG'] = preg_replace('/^(.*[a-zA-Z])[a-zA-Z]$/', '$1', $item['CONFIG']);

            //устанавливаем поля с NULL в ''
            if ($item['TERMSECONDPART'] == null) $item['TERMSECONDPART'] = '';
            if ($item['TERMPREFIX'] == null) $item['TERMPREFIX'] = '';
            if ($item['TERMFIRSTPART'] == null || $item['TERMFIRSTPART'] == '') $item['TERMFIRSTPART'] = '?';

            //убираем с конца конфигурации, j и терма незначащие символы, такие как '?', ', "
            $item['J'] = preg_replace('/^(.*?)([^0-9]*)$/', '$1', $item['J']);
            $item['TERMFIRSTPART'] = preg_replace('/^(.*?)([^a-zA-Z0-9\)\}\]]*)$/', '$1', $item['TERMFIRSTPART']);
            $item['TERMSECONDPART'] = trim($item['TERMSECONDPART']);


            //если есть атомный остаток, то выносим его в отдельный атрибут (ATOMICCORE), из CONFIG убираем
            $regexp_ac = '/^(.*)\(([^\)]*)\)(\d+)([a-z])$/';
            $regexp_ac2 = '/^(.*)\(([^\)]*)\)(n[a-z])$/';
            //echo PHP_EOL . $item['CONFIG'] . " : ";
            if (preg_match($regexp_ac, $item['CONFIG'])) {
                $item['ATOMICCORE'] = preg_replace($regexp_ac, '$2', $item['CONFIG']);
                //echo $item['ATOMICCORE'] . " : ";
                $item['CONFIG'] = preg_replace($regexp_ac, '$1$3$4', $item['CONFIG']);
                $item['CELLCONFIG'] = preg_replace($regexp_ac2, '$1$3', $item['CELLCONFIG']);
                //echo $item['CONFIG'];
            } else $item['ATOMICCORE'] = '';

            if ($item['CONFIG'] == null || $item['CONFIG'] == '')
                $item['CONFIG'] = '?';

            if ($item['TERMFIRSTPART'] == null || $item['TERMFIRSTPART'] == '')
                $item['TERMFIRSTPART'] = '?';
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

        $ground_items = [];
        if ($items[0]['ENERGY'] == 0) $ground_config = $items[0]['CELLCONFIG'];//Поскольку у нас $items отсортирован, то первый элемент - с энергией 0;
        foreach($items as $i => &$item) {
            if ($item['CELLCONFIG'] == $ground_config) {
                $item['GROUNDCONFIG'] = 1;
                $ground_items[] = $item;
                unset($items[$i]);
            }
            else $item['GROUNDCONFIG'] = 0;
        }
        unset($item);

        $odd_items = [];
        $even_items = [];
        foreach($items as $item) {
            if ($item['TERMMULTIPLY'] == 1)
                $odd_items[] = $item;
            else
                $even_items[] = $item;
        }

        //Группируем элементы массива
        $ground_terms = $this->GroupArrayByKeys($ground_items, ['CELLCONFIG', 'GROUNDCONFIG', 'ATOMICCORE', 'TERMPREFIX', 'TERMMULTIPLY', 'TERMFIRSTPART', 'TERMSECONDPART', 'J'], 'level');
        $even_terms = $this->GroupArrayByKeys($even_items, ['CELLCONFIG', 'GROUNDCONFIG', 'ATOMICCORE', 'TERMPREFIX', 'TERMMULTIPLY', 'TERMFIRSTPART', 'TERMSECONDPART', 'J'], 'level');
        $odd_terms = $this->GroupArrayByKeys($odd_items, ['CELLCONFIG', 'GROUNDCONFIG', 'ATOMICCORE', 'TERMPREFIX', 'TERMMULTIPLY', 'TERMFIRSTPART', 'TERMSECONDPART', 'J'], 'level');
        $ground_groups = $this->GroupArrayByKeys($ground_terms, ['CELLCONFIG', 'ATOMICCORE', 'TERMPREFIX', 'TERMMULTIPLY'], 'group');
        $ground_atomiccores = $this->GroupArrayByKeys($ground_groups, ['CELLCONFIG', 'ATOMICCORE', 'TERMMULTIPLY'], 'term');
        $ground_columns = $this->GroupArrayByKeys($ground_atomiccores, ['CELLCONFIG', 'TERMMULTIPLY'], 'atomiccore');
        $odd_groups = $this->GroupArrayByKeys($odd_terms, ['CELLCONFIG', 'ATOMICCORE', 'TERMPREFIX', 'TERMMULTIPLY'], 'group');
        $odd_atomiccores = $this->GroupArrayByKeys($odd_groups, ['CELLCONFIG', 'ATOMICCORE', 'TERMMULTIPLY'], 'term');
        $odd_columns = $this->GroupArrayByKeys($odd_atomiccores, ['CELLCONFIG', 'TERMMULTIPLY'], 'atomiccore');
        $even_groups = $this->GroupArrayByKeys($even_terms, ['CELLCONFIG', 'ATOMICCORE', 'TERMPREFIX', 'TERMMULTIPLY'], 'group');
        $even_atomiccores = $this->GroupArrayByKeys($even_groups, ['CELLCONFIG', 'ATOMICCORE', 'TERMMULTIPLY'], 'term');
        $even_columns = $this->GroupArrayByKeys($even_atomiccores, ['CELLCONFIG', 'TERMMULTIPLY'], 'atomiccore');

        foreach($even_columns as &$column) {
            foreach ($column['atomiccore'] as &$atomiccore) {
                foreach ($atomiccore['term'] as &$term) {
                    $term['group'] = array_reverse($term['group']);
                }
                unset($term);
                $atomiccore['term'] = array_reverse($atomiccore['term']);
            }
            unset($atomiccore);
            $column['atomiccore'] = array_reverse($column['atomiccore']);
        }
        unset($column);
        $even_columns = array_reverse($even_columns);

        if ($ground_columns[0]['TERMMULTIPLY'] == 1) {
            foreach ($ground_columns as &$column) {
                foreach ($column['atomiccore'] as &$atomiccore) {
                    foreach ($atomiccore['term'] as &$term) {
                        $term['group'] = array_reverse($term['group']);
                    }
                    unset($term);
                    $atomiccore['term'] = array_reverse($atomiccore['term']);
                }
                unset($atomiccore);
                $column['atomiccore'] = array_reverse($column['atomiccore']);
            }
            unset($column);
            $ground_columns = array_reverse($ground_columns);
        }

        $columns = array_merge($odd_columns, $ground_columns, $even_columns);
        return $columns;
    }

    function LoadGroupedByMultiplet($element_id, $min_energy = 0, $max_energy = 0, $options = [])
    {
        $query = "SELECT LEVELS.* FROM LEVELS WHERE ID_ATOM='$element_id'"
            . " AND ENERGY IS NOT NULL "
            . ($min_energy > 0 ? "AND ENERGY >= $min_energy ":"")
            . ($max_energy > 0 ? "AND ENERGY <= $max_energy ":"")
            . " ORDER BY ENERGY";

        $this->LoadFromSQL($query);
        $this->LoadCellConfigs('CELLCONFIG');
        $items = $this->GetItemsArray();

        foreach ($items as $i => &$item) {
            //проверяем nmax и lmax
            $configwoac = preg_replace('/\([^\(\)]*\)/', '', $item['CONFIG']);
            $configwoind = preg_replace('/\{[^\{\}]*\}/', '', $configwoac);
            $n = preg_replace('/^.*?(\d+)[^0-9]*$/', '$1', $configwoind);
            $l = preg_replace('/^.*?([a-z])[^a-z]*$/', '$1', $configwoind);

            if (isset($options['nmax']) && $n > $options['nmax']) {
                unset($items[$i]);
                continue;
            }
            if (isset($options['lmax']) && $l > $options['lmax'] && $l != 's' && $l != 'p' && $l != 'd' && $l != 'f') {
                unset($items[$i]);
                continue;
            }

            if ($item['TERMFIRSTPART'] == "(?)") $item['TERMFIRSTPART'] = "?";
            $item['FULL_CONFIG'] = $item['CONFIG'];

            if ($item['CONFIG'] == "(?)") $item['CONFIG'] = "?";
            //убираем с конца конфигурации, j и терма незначащие символы, такие как '?', ', "
            $item['CONFIG'] = preg_replace('/^(.*?)([^a-zA-Z\}\)]*)$/', '$1', $item['CONFIG']);
            //убираем ~{...} c конца конфигурации
            $item['CONFIG'] = preg_replace('/^(.*)(~\{[^\{\}]*\})$/', '$1', $item['CONFIG']);
            //убираем последнюю букву из конфигурации, если их там две
            $item['CONFIG'] = preg_replace('/^(.*[a-zA-Z])[a-zA-Z]$/', '$1', $item['CONFIG']);

            //устанавливаем поля с NULL в ''
            if ($item['TERMSECONDPART'] == null) $item['TERMSECONDPART'] = '';
            if ($item['TERMPREFIX'] == null) $item['TERMPREFIX'] = '';
            if ($item['TERMFIRSTPART'] == null || $item['TERMFIRSTPART'] == '') $item['TERMFIRSTPART'] = '?';

            //убираем с конца конфигурации, j и терма незначащие символы, такие как '?', ', "
            $item['J'] = preg_replace('/^(.*?)([^0-9]*)$/', '$1', $item['J']);
            $item['TERMFIRSTPART'] = preg_replace('/^(.*?)([^a-zA-Z0-9\)\}\]]*)$/', '$1', $item['TERMFIRSTPART']);
            $item['TERMSECONDPART'] = trim($item['TERMSECONDPART']);


            //если есть атомный остаток, то выносим его в отдельный атрибут (ATOMICCORE), из CONFIG убираем
            $regexp_ac = '/^(.*)\(([^\)]*)\)(\d+[a-z])$/';
            $regexp_ac2 = '/^(.*)\(([^\)]*)\)(n[a-z])$/';
            //echo PHP_EOL . $item['CONFIG'] . " : ";
            if (preg_match($regexp_ac, $item['CONFIG'])){
                $item['ATOMICCORE'] = preg_replace($regexp_ac, '$2', $item['CONFIG']);
                //echo $item['ATOMICCORE'] . " : ";
                $item['CONFIG'] =  preg_replace($regexp_ac, '$1$3', $item['CONFIG']);
                $item['CELLCONFIG'] =  preg_replace($regexp_ac2, '$1$3', $item['CELLCONFIG']);
                //echo $item['CONFIG'];
            }
            else $item['ATOMICCORE'] = '';

            if ($item['CONFIG']  == null || $item['CONFIG']  == '')
                $item['CONFIG'] = '?';

            if ($item['TERMFIRSTPART'] == null || $item['TERMFIRSTPART'] == '')
                $item['TERMFIRSTPART'] = '?';
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

        if ($items[0]['ENERGY'] == 0) $ground_config = $items[0]['CELLCONFIG'];//Поскольку у нас $items отсортирован, то первый элемент - с энергией 0;
        foreach($items as $i => &$item) {
            if ($item['CELLCONFIG'] == $ground_config) {
                $item['GROUNDCONFIG'] = 1;
            }
            else $item['GROUNDCONFIG'] = 0;
        }
        unset($item);


        //1. Group by multiplet
        $ground_items = [];
        $odd_items = [];
        $even_items = [];
        $ground_terms = [];
        $even_terms = [];
        $odd_terms = [];
        $ground_groups = [];
        $ground_atomiccores = [];
        $ground_columns = [];
        $odd_groups = [];
        $odd_atomiccores = [];
        $odd_columns = [];
        $even_groups = [];
        $even_atomiccores = [];
        $even_columns = [];
        $multiplets = $this->GroupArrayByKeys($items, ['TERMPREFIX'], 'items');

        foreach($multiplets as $m_key => $multiplet) {
            $ground_items[$m_key] = [];
            $odd_items[$m_key] = [];
            $even_items[$m_key] = [];

            foreach ($multiplet['items'] as $i => &$item) {
                if ($item['GROUNDCONFIG'] == 1) {
                    $ground_items[$m_key][] = $item;
                    unset($multiplet['items'][$i]);
                }
            }
            unset($item);

            foreach ($multiplet['items'] as $item) {
                if ($item['TERMMULTIPLY'] == 1)
                    $odd_items[$m_key][] = $item;
                else
                    $even_items[$m_key][] = $item;
            }

            //Группируем элементы массива
            $ground_terms[$m_key] = $this->GroupArrayByKeys($ground_items[$m_key], ['CELLCONFIG', 'GROUNDCONFIG', 'ATOMICCORE', 'TERMPREFIX', 'TERMMULTIPLY', 'TERMFIRSTPART', 'TERMSECONDPART', 'J'], 'level');
            $even_terms[$m_key] = $this->GroupArrayByKeys($even_items[$m_key], ['CELLCONFIG', 'GROUNDCONFIG', 'ATOMICCORE', 'TERMPREFIX', 'TERMMULTIPLY', 'TERMFIRSTPART', 'TERMSECONDPART', 'J'], 'level');
            $odd_terms[$m_key] = $this->GroupArrayByKeys($odd_items[$m_key], ['CELLCONFIG', 'GROUNDCONFIG', 'ATOMICCORE', 'TERMPREFIX', 'TERMMULTIPLY', 'TERMFIRSTPART', 'TERMSECONDPART', 'J'], 'level');
            $ground_groups[$m_key] = $this->GroupArrayByKeys($ground_terms[$m_key], ['CELLCONFIG', 'ATOMICCORE', 'TERMPREFIX', 'TERMMULTIPLY'], 'group');
            $ground_atomiccores[$m_key] = $this->GroupArrayByKeys($ground_groups[$m_key], ['CELLCONFIG', 'ATOMICCORE', 'TERMMULTIPLY'], 'term');
            $ground_columns[$m_key] = $this->GroupArrayByKeys($ground_atomiccores[$m_key], ['CELLCONFIG', 'TERMMULTIPLY'], 'atomiccore');
            $odd_groups[$m_key] = $this->GroupArrayByKeys($odd_terms[$m_key], ['CELLCONFIG', 'ATOMICCORE', 'TERMPREFIX', 'TERMMULTIPLY'], 'group');
            $odd_atomiccores[$m_key] = $this->GroupArrayByKeys($odd_groups[$m_key], ['CELLCONFIG', 'ATOMICCORE', 'TERMMULTIPLY'], 'term');
            $odd_columns[$m_key] = $this->GroupArrayByKeys($odd_atomiccores[$m_key], ['CELLCONFIG', 'TERMMULTIPLY'], 'atomiccore');
            $even_groups[$m_key] = $this->GroupArrayByKeys($even_terms[$m_key], ['CELLCONFIG', 'ATOMICCORE', 'TERMPREFIX', 'TERMMULTIPLY'], 'group');
            $even_atomiccores[$m_key] = $this->GroupArrayByKeys($even_groups[$m_key], ['CELLCONFIG', 'ATOMICCORE', 'TERMMULTIPLY'], 'term');
            $even_columns[$m_key] = $this->GroupArrayByKeys($even_atomiccores[$m_key], ['CELLCONFIG', 'TERMMULTIPLY'], 'atomiccore');

            foreach ($even_columns[$m_key] as &$column) {
                foreach ($column['atomiccore'] as &$atomiccore) {
                    foreach ($atomiccore['term'] as &$term) {
                        $term['group'] = array_reverse($term['group']);
                    }
                    unset($term);
                    $atomiccore['term'] = array_reverse($atomiccore['term']);
                }
                unset($atomiccore);
                $column['atomiccore'] = array_reverse($column['atomiccore']);
            }
            unset($column);
            $even_columns[$m_key] = array_reverse($even_columns[$m_key]);

            if (isset($ground_columns[$m_key][0]) && $ground_columns[$m_key][0]['TERMMULTIPLY'] == 1) {
                foreach ($ground_columns[$m_key] as &$column) {
                    foreach ($column['atomiccore'] as &$atomiccore) {
                        foreach ($atomiccore['term'] as &$term) {
                            $term['group'] = array_reverse($term['group']);
                        }
                        unset($term);
                        $atomiccore['term'] = array_reverse($atomiccore['term']);
                    }
                    unset($atomiccore);
                    $column['atomiccore'] = array_reverse($column['atomiccore']);
                }
                unset($column);
                $ground_columns[$m_key] = array_reverse($ground_columns[$m_key]);
            }

            $columns[$m_key] = array_merge($odd_columns[$m_key], $ground_columns[$m_key], $even_columns[$m_key]);
            //echo "***";
            //print_r($ground_columns[$m_key]);
        }
        $final_columns = [];
        foreach($multiplets as $m_key => $multiplet){
            $final_columns = array_merge($final_columns, $columns[$m_key]);

        }
        return $final_columns;
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
                    if ($value[$key] != $newarrayvalue[$key]) {
                        $equal = false;
                        break;
                    }
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
				$level_config   = empty($post['level_config'][$i])     ? "''" : "'".$post['level_config'][$i]."'";
				$termSecondpart = ($post['termSecondpart'][$i] == "")  ? 'NULL' : "'" . $post['termSecondpart'][$i] . "'";
				$termPrefix     = ($post['termPrefix'][$i] == "")      ? 'NULL' : "'" . $post['termPrefix'][$i] . "'";
				$termFirstpart  = empty($post['termFirstpart'][$i])    ? " " : $post['termFirstpart'][$i];
				$termMultiply   = ($post['termMultiply'][$i]<>"")      ? 1 : 0;
				$j              = ($post['j'][$i] == "")               ? 'NULL' : "'".$post['j'][$i]."'";
                $f              = ($post['f'][$i] == "")               ? 'NULL' : "'".$post['f'][$i]."'";
				$energy         = ($post['energy'][$i] == "")          ? 'NULL' : $post['energy'][$i];
                $energy_mhz         = ($post['energy_mhz'][$i] == "")  ? 'NULL' : $post['energy_mhz'][$i];
				$lifetime       = ($post['lifetime'][$i] == "")        ? 'NULL' : $post['lifetime'][$i];
                $bibliolink       = ($post['bibliolink'][$i] == "")    ? 'NULL' :  "'" . iconv("UTF-8", "Windows-1251",$post['bibliolink'][$i]) .  "'";

            $query .= " UPDATE LEVELS SET [CONFIG] = " . $level_config
                . ", [ENERGY] = " . $energy
                . ", [ENERGY_MHZ] = " . $energy_mhz
                . ", [LIFETIME] = " . $lifetime
                . ", [J] = " . $j
                . ", [F] = " . $f
                . ", [TERMSECONDPART] = " . $termSecondpart
                . ", [TERMPREFIX] = " . $termPrefix
                . ", [TERMMULTIPLY] = " . $termMultiply
                . ", [TERMFIRSTPART] = '" . $termFirstpart . "'"
                . ", [BIBLIOLINK] = " . $bibliolink
                . " WHERE ID =" . $level_id;
			}
			//print_r($query);
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
        $atom = new Atom();
        $atom->Load($atom_id);
        $atom_sys = $atom->GetAllProperties();
        $energy_field = $atom_sys['ENERGY_DIMENSION']== "MHz"? "ENERGY_MHZ" : "ENERGY";

		//echo "levId=".$level_id;
		$position = ($position == 'lower') ? "<" : ">";
		if (empty($level_id)) $query = "SELECT LEVELS.* ,dbo.GetCfgType(CONFIG) AS config_type, dbo.ConcatSourcesID(ID,'L') AS SOURCE_IDS FROM LEVELS WHERE  ID_ATOM=".$atom_id." ORDER BY " . $energy_field. " asc";
		else $query = "SELECT LEVELS.* ,dbo.GetCfgType(CONFIG) AS config_type, dbo.ConcatSourcesID(ID,'L') AS SOURCE_IDS FROM LEVELS WHERE  ID_ATOM=".$atom_id."  AND TERMMULTIPLY != (Select TERMMULTIPLY FROM LEVELS WHERE ID = ".$level_id.") AND " . $energy_field. " ".$position." (Select " . $energy_field. " FROM LEVELS WHERE ID = ".$level_id.") ORDER BY " . $energy_field. " asc";
	
		//echo $query; 			
		$this->LoadFromSQL($query);
	}

	function LoadGroupForCircleSpectrum($element_id)
	{
		$query = "SELECT l.config, g.* FROM 
(SELECT config FROM LEVELS where ID_ATOM = $element_id 
GROUP BY config ) as l
cross apply
(SELECT top 1 * FROM LEVELS
	 WHERE config = l.config and ID_ATOM=$element_id order by energy) as g

ORDER BY g.energy
	 ";

		$this->LoadFromSQL($query);
	}


}
?>