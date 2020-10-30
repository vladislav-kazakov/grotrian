<?
require_once($_SERVER['DOCUMENT_ROOT']."/includes/locallist.php");

class Listotherbd extends locallist
{
	function SearchIdAtom($atom, $ion){
		$query = "SELECT [ID] FROM ATOMS WHERE [IONIZATION] = '$ion' AND [ID_ELEMENT] = (SELECT [ID]  FROM PERIODICTABLE WHERE [ABBR] = '$atom')";
		$this->LoadFromSQL($query);
	}

	function CreateLevels($levels, $atom){	
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
			$query .= "INSERT INTO LEVELS_OTHER_BD ([ID_ATOM], [CONFIG] ,[ENERGY] ,[LIFETIME] ,[J] ,[TERMPREFIX] ,[TERMMULTIPLY] ,[TERMFIRSTPART] ,[TERMSECONDPART] ,[SOURCE_BD]) 
			VALUES ('$atom' ,'$c', '$e', '$l', '$j', '$tp', '$tm', '$tf', '$ts', '$s') ";
			
		}
		$count = count($levels);
		$query .= "SELECT TOP $count [ID] FROM LEVELS_OTHER_BD ORDER BY [ID] DESC";
		$this->LoadFromSQL($query);
	}

	function CreateLines($lines, $atom){
		foreach ($lines as $line){
			$w = $line['WAVELENGTH'];
			$i = $line['INTENSITY'];
			$a = $line['A_KI'];
			$f = $line['F_IK'];
			$ll = $line['LOWER_LEVEL_ENERGY'];
			$ul = $line['UPPER_LEVEL_ENERGY'];
			$s = $line['SOURCE_BD'];

			$id_level = new Listotherbd();
			$id_level->SearchLevel($ll, $atom, $s);
			$id_level1 = $id_level->GetItemsArray();
			$id_level1 = $id_level1[0]['ID'];
			$id_level->SearchLevel($ul, $atom, $s);
			$id_level2 = $id_level->GetItemsArray();
			$id_level2 = $id_level2[0]['ID'];

			if(isset($id_level1, $id_level2)){
				$query .= "INSERT INTO TRANSITIONS_OTHER_BD([ID_ATOM], [ID_UPPER_LEVEL], [ID_LOWER_LEVEL], [WAVELENGTH], [INTENSITY], [A_KI], [F_IK], [SOURCE_BD])
				VALUES ('$atom' ,'$id_level1', '$id_level2', '$w', '$i', '$a', '$f', '$s') ";
			}else{
				echo "Нет соответствующих уровней в базе: $w; $i; $a; $f; $l; $u; $s <br>";
			}
			
		}
		$count = count($levels);
		$query .= "SELECT TOP $count [ID] FROM TRANSITIONS_OTHER_BD ORDER BY [ID] DESC";
		$this->LoadFromSQL($query);
	}

	function LoadLevelsNIST($id_atom){
		$query = "SELECT * FROM LEVELS_OTHER_BD WHERE [ID_ATOM] = $id_atom";
		$this->LoadFromSQL($query);
	}

	function LoadLinesNIST($id_atom){
		// $query = "SELECT * FROM TRANSITIONS_OTHER_BD WHERE [ID_ATOM] = $id_atom ";
		$query = "SELECT TRANSITIONS_OTHER_BD.*, lower_level.energy AS LOWER_LEVEL_ENERGY, upper_level.energy AS UPPER_LEVEL_ENERGY FROM TRANSITIONS_OTHER_BD LEFT JOIN LEVELS_OTHER_BD AS lower_level ON TRANSITIONS_OTHER_BD.ID_LOWER_LEVEL=lower_level.ID LEFT JOIN LEVELS_OTHER_BD AS upper_level ON TRANSITIONS_OTHER_BD.ID_UPPER_LEVEL=upper_level.ID 
		WHERE TRANSITIONS_OTHER_BD.ID_ATOM='$id_atom' ORDER BY WAVELENGTH";
		$this->LoadFromSQL($query);
	}

	function SearchLevel($level, $id_atom, $sourse_bd){
		$query = "SELECT [ID] FROM LEVELS_OTHER_BD WHERE [ENERGY] = '$level' AND [SOURCE_BD] = '$sourse_bd'";
		$this->LoadFromSQL($query);
	}

}
?>