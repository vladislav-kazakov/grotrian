<?
require_once($_SERVER['DOCUMENT_ROOT']."/includes/locallist.php");

class Listotherbd extends locallist
{
	function SearchIdAtom($atom, $ion){
// 		$query = "SELECT NAME_RU, LIMITS, BREAKS, INTERFACE_CONTENT.ID 
// FROM  ATOMS,PERIODICTABLE,INTERFACE_CONTENT 
// WHERE ATOMS.ID_ELEMENT = (SELECT ID FROM PERIODICTABLE WHERE ABBR = '$element_id') AND ATOMS.IONIZATION = $ion AND ATOMS.ID_ELEMENT = PERIODICTABLE.ID AND INTERFACE_CONTENT.ID=ATOMS.DESCRIPTION";

		$query = "SELECT ID FROM ATOMS WHERE IONIZATION = '$ion' AND ID_ELEMENT = (SELECT ID FROM PERIODICTABLE WHERE ABBR = '$atom')";	
		$this->LoadFromSQL($query);
	}

	function CreateLevels($levels, $atom){	
		// $query = "DELETE FROM LEVELS_OTHER_BD ";
		foreach ($levels as $level){
			$c = $level['CONFIG'];
			$e = $level['ENERGY'];
			$l = $level['LIFETIME'];
			$j = $level['J'];
			$tp = $level['TERMPREFIX'];
			$tm = $level['TERMMULTIPLY'];
			$tf = $level['TERMFIRSTPART'];
			$ts = $level['TERMSECONDPART'];
			$s = $level['SOURCE_BD'];
			$query .= "INSERT INTO [LEVELS_OTHER_BD] ([ID_ATOM], [CONFIG] ,[ENERGY] ,[LIFETIME] ,[J] ,[TERMPREFIX] ,[TERMMULTIPLY] ,[TERMFIRSTPART] ,[TERMSECONDPART] ,[SOURCE_BD]) 
			VALUES ('$atom' ,'$c', '$e', '$l', '$j', '$tp', '$tm', '$tf', '$ts', '$s') ";
			
		}
		$count = count($levels);
		$query .= "SELECT TOP $count [ID] FROM [LEVELS_OTHER_BD] ORDER BY [ID] DESC";
		$this->LoadFromSQL($query);
	}

	function CreateLines($lines, $atom){
		//$query .= "DELETE FROM [TRANSITIONS_OTHER_BD] "; // временно
		foreach ($lines as $line){
			if(isset($line['LOWER_LEVEL_ENERGY'], $line['LOWER_LEVEL_CONFIG'], $line['UPPER_LEVEL_ENERGY'], $line['UPPER_LEVEL_CONFIG'])){
				$lle = $line['LOWER_LEVEL_ENERGY'];
				$llc = $line['LOWER_LEVEL_CONFIG'];
				$ule = $line['UPPER_LEVEL_ENERGY'];
				$ulc = $line['UPPER_LEVEL_CONFIG'];
				$s = $line['SOURCE_BD'];
				$level1 = "SELECT ID FROM LEVELS_OTHER_BD WHERE ENERGY = '$lle' AND SOURCE_BD = '$s' AND CONFIG = '$llc' AND ID_ATOM = '$atom'";
				$level2 = "SELECT ID FROM LEVELS_OTHER_BD WHERE ENERGY = '$ule' AND SOURCE_BD = '$s' AND CONFIG = '$ulc' AND ID_ATOM = '$atom'";
				if(isset($line['LOWER_LEVEL_J'])){
					$llj = $line['LOWER_LEVEL_J'];
					$level1 .= " AND J = '$llj'";
				}
				if(isset($line['LOWER_LEVEL_TERMPREFIX'])){
					$lltp = $line['LOWER_LEVEL_TERMPREFIX'];
					$level1 .= " AND TERMPREFIX = '$lltp'";
				}
				if(isset($line['LOWER_LEVEL_TERMFIRSTPART'])){
					$lltf = $line['LOWER_LEVEL_TERMFIRSTPART'];
					$level1 .= " AND TERMFIRSTPART = '$lltf'";
				}
				if(isset($line['LOWER_LEVEL_TERMSECONDPART'])){
					$llts = $line['LOWER_LEVEL_TERMSECONDPART'];
					$level1 .= " AND TERMSECONDPART = '$llts'";
				}
				if(isset($line['LOWER_LEVEL_TERMMULTIPLY'])){
					$lltm = $line['LOWER_LEVEL_TERMMULTIPLY'];
					$level1 .= " AND TERMMULTIPLY = '$lltm'";
				}

				if(isset($line['UPPER_LEVEL_J'])){
					$ulj = $line['UPPER_LEVEL_J'];
					$level2 .= " AND J = '$ulj'";
				}
				if(isset($line['UPPER_LEVEL_TERMPREFIX'])){
					$ultp = $line['UPPER_LEVEL_TERMPREFIX'];
					$level2 .= " AND TERMPREFIX = '$ultp'";
				}
				if(isset($line['UPPER_LEVEL_TERMFIRSTPART'])){
					$ultf = $line['UPPER_LEVEL_TERMFIRSTPART'];
					$level2 .= " AND TERMFIRSTPART = '$ultf'";
				}
				if(isset($line['UPPER_LEVEL_TERMSECONDPART'])){
					$ults = $line['UPPER_LEVEL_TERMSECONDPART'];
					$level2 .= " AND TERMSECONDPART = '$ults'";
				}
				if(isset($line['UPPER_LEVEL_TERMMULTIPLY'])){
					$ultm = $line['UPPER_LEVEL_TERMMULTIPLY'];
					$level2 .= " AND TERMMULTIPLY = '$ultm'";
				}

				$w = $line['WAVELENGTH'];
				$i = $line['INTENSITY'];
				$a = $line['PROBABILITY'];
				$f = $line['OSCILLATOR_F'];

				// if(isset($lle, $ule, $llc, $ulc, $lltp, $lltf, $lltp, $lltm, $ultp, $ultf, $ultp, $ultm)){
				$query .= "INSERT INTO TRANSITIONS_OTHER_BD(ID_ATOM, ID_LOWER_LEVEL, ID_UPPER_LEVEL, WAVELENGTH, INTENSITY, PROBABILITY, OSCILLATOR_F, SOURCE_BD) VALUES ('$atom' , ($level1), ($level2), '$w', '$i', '$a', '$f', '$s') ";	

				// }
			}

		}
		$query .= "SELECT TRANSITIONS_OTHER_BD.*, 
		lower_level.ID_LEVEL AS LOWER_LEVEL, upper_level.ID_LEVEL AS UPPER_LEVEL, 
		lower_level.CONFIG AS LOWER_CONFIG,
		lower_level.ENERGY AS LOWER_ENERGY,
		lower_level.J AS LOWER_J,
		lower_level.TERMFIRSTPART AS LOWER_TERMFIRSTPART,
		lower_level.TERMMULTIPLY AS LOWER_TERMMULTIPLY,
		lower_level.TERMPREFIX AS LOWER_TERMPREFIX,
		lower_level.TERMSECONDPART AS LOWER_TERMSECONDPART, 

		upper_level.CONFIG AS UPPER_CONFIG,
		upper_level.ENERGY AS UPPER_ENERGY,
		upper_level.J AS UPPER_J,
		upper_level.TERMFIRSTPART AS UPPER_TERMFIRSTPART,
		upper_level.TERMMULTIPLY AS UPPER_TERMMULTIPLY,
		upper_level.TERMPREFIX AS UPPER_TERMPREFIX,
		upper_level.TERMSECONDPART AS UPPER_TERMSECONDPART
		FROM TRANSITIONS_OTHER_BD 
		LEFT JOIN LEVELS_OTHER_BD AS lower_level ON TRANSITIONS_OTHER_BD.ID_LOWER_LEVEL=lower_level.ID 
		LEFT JOIN LEVELS_OTHER_BD AS upper_level ON TRANSITIONS_OTHER_BD.ID_UPPER_LEVEL=upper_level.ID 
		WHERE TRANSITIONS_OTHER_BD.SOURCE_BD = '$s' AND TRANSITIONS_OTHER_BD.ID_ATOM = '$atom'  AND TRANSITIONS_OTHER_BD.ID_LINE is null";
		$this->LoadFromSQL($query);
	}

	function LoadLines($atom){

		$query = "SELECT TRANSITIONS.*, 
		lower_level.ID AS LOWER_LEVEL, upper_level.ID AS UPPER_LEVEL,
		lower_level.CONFIG AS LOWER_CONFIG,
		lower_level.ENERGY AS LOWER_ENERGY,
		lower_level.J AS LOWER_J,
		lower_level.TERMFIRSTPART AS LOWER_TERMFIRSTPART,
		lower_level.TERMMULTIPLY AS LOWER_TERMMULTIPLY,
		lower_level.TERMPREFIX AS LOWER_TERMPREFIX,
		lower_level.TERMSECONDPART AS LOWER_TERMSECONDPART, 

		upper_level.CONFIG AS UPPER_CONFIG,
		upper_level.ENERGY AS UPPER_ENERGY,
		upper_level.J AS UPPER_J,
		upper_level.TERMFIRSTPART AS UPPER_TERMFIRSTPART,
		upper_level.TERMMULTIPLY AS UPPER_TERMMULTIPLY,
		upper_level.TERMPREFIX AS UPPER_TERMPREFIX,
		upper_level.TERMSECONDPART AS UPPER_TERMSECONDPART
		FROM TRANSITIONS 
		LEFT JOIN LEVELS AS lower_level ON TRANSITIONS.ID_LOWER_LEVEL=lower_level.ID 
		LEFT JOIN LEVELS AS upper_level ON TRANSITIONS.ID_UPPER_LEVEL=upper_level.ID 
		WHERE TRANSITIONS.ID_ATOM = '$atom'";
		$this->LoadFromSQL($query);
	}

	function CreateLinesTemp($atom, $source){

		$query = "SELECT TRANSITIONS_OTHER_BD.*, 
		lower_level.ID_LEVEL AS LOWER_LEVEL, upper_level.ID_LEVEL AS UPPER_LEVEL 
		FROM TRANSITIONS_OTHER_BD 
		LEFT JOIN LEVELS_OTHER_BD AS lower_level ON TRANSITIONS_OTHER_BD.ID_LOWER_LEVEL=lower_level.ID 
		LEFT JOIN LEVELS_OTHER_BD AS upper_level ON TRANSITIONS_OTHER_BD.ID_UPPER_LEVEL=upper_level.ID 
		WHERE TRANSITIONS_OTHER_BD.SOURCE_BD = '$source' AND TRANSITIONS_OTHER_BD.ID_ATOM = '$atom'";
		$this->LoadFromSQL($query);
	}

	function LoadLevelsNIST($id_atom, $source){
		$query = "SELECT * FROM LEVELS_OTHER_BD WHERE ID_ATOM = $id_atom AND SOURCE_BD = '$source'";
		$this->LoadFromSQL($query);
	}

	function LoadLinesNIST($id_atom, $source){
		$query = "SELECT * FROM TRANSITIONS_OTHER_BD WHERE ID_ATOM = $id_atom AND SOURCE_BD = '$source'";
		// $query = "SELECT TRANSITIONS_OTHER_BD.*, lower_level.energy AS LOWER_LEVEL_ENERGY, upper_level.energy AS UPPER_LEVEL_ENERGY FROM TRANSITIONS_OTHER_BD LEFT JOIN LEVELS_OTHER_BD AS lower_level ON TRANSITIONS_OTHER_BD.ID_LOWER_LEVEL=lower_level.ID LEFT JOIN LEVELS_OTHER_BD AS upper_level ON TRANSITIONS_OTHER_BD.ID_UPPER_LEVEL=upper_level.ID 
		// WHERE TRANSITIONS_OTHER_BD.ID_ATOM='$id_atom' ORDER BY WAVELENGTH";
		$this->LoadFromSQL($query);
	}

	function UpdateNewLevels($array){
		foreach ($array as $value) {
			$method = $value['value'];
			$edit = $value['edit'];
			$id_source = $value['id_source'];
			$levels = $value['data'];
			$level = explode("-", $levels);
			if(isset($method, $id_source, $levels)){
				switch ($method) {
					case 'saveasnew':
					$pq = "FROM LEVELS_OTHER_BD WHERE ID = '$level[0]'";
					$query .= "INSERT INTO LEVELS (ID_ATOM,CONFIG,ENERGY,J,TERMPREFIX,TERMMULTIPLY,TERMFIRSTPART,TERMSECONDPART) 
					VALUES ('$id_source',(SELECT CONFIG $pq),(SELECT ENERGY $pq),(SELECT J $pq),(SELECT TERMPREFIX $pq),(SELECT TERMMULTIPLY $pq),(SELECT TERMFIRSTPART $pq),(SELECT TERMSECONDPART $pq)) ";
					$query .= "UPDATE LEVELS_OTHER_BD SET ID_LEVEL = (SELECT MAX(ID) AS ID FROM LEVELS) WHERE ID = '$level[0]'; ";
					break;
					case 'skip':
					$query .= "UPDATE LEVELS_OTHER_BD SET ID_LEVEL = 'NULL' WHERE ID = '$level[0]'; ";
					break;
					case 'save':
					if(isset($edit)){
						$edit = explode(" ", $edit);
						unset($quantum_numbers);
						foreach ($edit as $val) {
							switch ($val) {
								case "config":
								$quantum_numbers[] = 'CONFIG';
								break;
								case "term":
								$quantum_numbers[] = 'TERMSECONDPART';
								$quantum_numbers[] = 'TERMPREFIX';
								$quantum_numbers[] = 'TERMFIRSTPART';
								$quantum_numbers[] = 'TERMMULTIPLY';
								break;
								case "j":
								$quantum_numbers[] = 'J';
								break;
								case "energy":
								$quantum_numbers[] = 'ENERGY';
								break;
							}
						}
					}
					$test = 0;
					$comma = ',';
					$parametrs = '';
					$query .= "UPDATE [LEVELS_OTHER_BD] SET [ID_LEVEL] = '$level[1]' WHERE [ID] = '$level[0]'; ";
					if(isset($edit)){						
						foreach ($quantum_numbers as $quantum) {
							$test++;
							if($test == count($quantum_numbers)){
								$comma = '';
							}
							$parametrs .= "[$quantum] = (SELECT [$quantum] FROM [LEVELS_OTHER_BD] WHERE [ID] = '$level[0]')$comma ";
						}
						$query .= "UPDATE [LEVELS] SET $parametrs WHERE [ID] = '$level[1]'; ";
					}
					break;
				}
			}
		}

		
		echo $query;
		$this->LoadFromSQL($query);
	}

	
	function UpdateNewLines($array){
		// var_dump($array);
		foreach ($array as $value) {
			$method = $value['value'];
			$edit = $value['edit'];
			$id_source = $value['id_source'];
			$lines = $value['data'];
			$line = explode("-", $lines);
			if(isset($method, $id_source, $lines)){
				switch ($method) {
					case 'saveasnew':
					$pq = "FROM TRANSITIONS_OTHER_BD WHERE ID = '$line[0]'";
					$query .= "INSERT INTO TRANSITIONS (ID_ATOM,ID_LOWER_LEVEL,ID_UPPER_LEVEL,WAVELENGTH,PROBABILITY,OSCILLATOR_F,CROSSECTION,INTENSITY) 
					VALUES ('$id_source',(SELECT ID_LEVEL FROM LEVELS_OTHER_BD WHERE ID = (SELECT ID_LOWER_LEVEL $pq)),(SELECT ID_LEVEL FROM LEVELS_OTHER_BD WHERE ID = (SELECT ID_UPPER_LEVEL $pq)),(SELECT WAVELENGTH $pq),(SELECT PROBABILITY $pq),(SELECT OSCILLATOR_F $pq),(SELECT CROSSECTION $pq),(SELECT INTENSITY $pq)) ";
					$query .= "UPDATE TRANSITIONS_OTHER_BD SET ID_LINE = (SELECT MAX(ID) AS ID FROM TRANSITIONS) WHERE ID = '$line[0]'; ";
					break;
					case 'skip':
					$query .= "UPDATE TRANSITIONS_OTHER_BD SET ID_LINE = NULL WHERE ID = '$line[0]'; ";
					break;
					case 'save':
					if(isset($edit)){
						$edit = explode(" ", $edit);
						unset($quantum_numbers);
						foreach ($edit as $val) {
							switch ($val) {
								case "wavelength":
								$quantum_numbers[] = 'WAVELENGTH';
								break;
								case "intensity":
								$quantum_numbers[] = 'INTENSITY';
								break;
								case "probability":
								$quantum_numbers[] = 'PROBABILITY';
								break;
								case "oscillator":
								$quantum_numbers[] = 'OSCILLATOR_F';
								break;
							}
						}
					}
					$test = 0;
					$comma = ',';
					$parametrs = '';
					$query .= "UPDATE TRANSITIONS_OTHER_BD SET ID_LINE = '$line[1]' WHERE ID = '$line[0]'; ";
					if(isset($edit)){						
						foreach ($quantum_numbers as $quantum) {
							$test++;
							if($test == count($quantum_numbers)){
								$comma = '';
							}
							$parametrs .= "$quantum = (SELECT $quantum FROM TRANSITIONS_OTHER_BD WHERE ID = '$line[0]')$comma ";
						}
						$query .= "UPDATE TRANSITIONS SET $parametrs WHERE ID = '$line[1]'; ";
					}
					break;
				}
			}
			// $this->LoadFromSQL($query);
			// $query = NULL;
		}

		
		echo $query;
		// echo mb_strlen($query, '8bit');
		//$this->LoadFromSQL($query);
	}

	function UpdateNewLimits($limits, $id_source){

	}

	function LoadLimits($id_atom){
		$query = "SELECT *  FROM ATOMS WHERE ID = '$id_atom'";
		$this->LoadFromSQL($query);
	}

	function LoadJournal($newhash, $id_atom, $source, $type){
		if(isset($newhash)){
			$query = "SELECT HASH  FROM JOURNAL WHERE ID_ATOM = '$id_atom' AND SOURCE = '$source' AND HASH = '$newhash' AND TYPE = '$type'";
		}else{
			$query = "SELECT HASH  FROM JOURNAL WHERE ID_ATOM = '$id_atom' AND SOURCE = '$source' AND TYPE = '$type'";
		}
		$this->LoadFromSQL($query);
	}
	
	function CreateJournal($hash, $type, $source, $id_atom){		
		$datetime = date("Y-m-d H:i:s");
		$query = "INSERT INTO JOURNAL (HASH,TYPE,SOURCE,DATETIME,ID_ATOM) VALUES ('$hash','$type','$source','$datetime','$id_atom') ";
		$query .= "SELECT TOP 1 ID FROM JOURNAL ORDER BY ID DESC";
		$this->LoadFromSQL($query);
	}

	function LoadLevelsSkip($id_atom){
		$query = "SELECT * FROM LEVELS_OTHER_BD WHERE ID_ATOM = $id_atom AND ID_LEVEL is null ";
		$this->LoadFromSQL($query);
	}

	function LoadLinesSkip($id_atom){
		$query = "SELECT TRANSITIONS_OTHER_BD.*, 
		lower_level.ID_LEVEL AS LOWER_LEVEL, upper_level.ID_LEVEL AS UPPER_LEVEL, 
		lower_level.CONFIG AS LOWER_CONFIG,
		lower_level.ENERGY AS LOWER_ENERGY,
		lower_level.J AS LOWER_J,
		lower_level.TERMFIRSTPART AS LOWER_TERMFIRSTPART,
		lower_level.TERMMULTIPLY AS LOWER_TERMMULTIPLY,
		lower_level.TERMPREFIX AS LOWER_TERMPREFIX,
		lower_level.TERMSECONDPART AS LOWER_TERMSECONDPART, 

		upper_level.CONFIG AS UPPER_CONFIG,
		upper_level.ENERGY AS UPPER_ENERGY,
		upper_level.J AS UPPER_J,
		upper_level.TERMFIRSTPART AS UPPER_TERMFIRSTPART,
		upper_level.TERMMULTIPLY AS UPPER_TERMMULTIPLY,
		upper_level.TERMPREFIX AS UPPER_TERMPREFIX,
		upper_level.TERMSECONDPART AS UPPER_TERMSECONDPART
		FROM TRANSITIONS_OTHER_BD 
		LEFT JOIN LEVELS_OTHER_BD AS lower_level ON TRANSITIONS_OTHER_BD.ID_LOWER_LEVEL=lower_level.ID 
		LEFT JOIN LEVELS_OTHER_BD AS upper_level ON TRANSITIONS_OTHER_BD.ID_UPPER_LEVEL=upper_level.ID 
		WHERE TRANSITIONS_OTHER_BD.ID_ATOM = '$id_atom' AND TRANSITIONS_OTHER_BD.ID_LINE is null ";
		$this->LoadFromSQL($query);
	}

}
?>