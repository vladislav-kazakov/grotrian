<?

require_once("locallist.php");

class AtomList extends LocalList
{

	function LoadForSitemap()
	{
		$query = "SELECT ATOMS.ID, ATOMS.IONIZATION, ATOMS.SPECTRUM_IMG, PERIODICTABLE.NAME_EN, PERIODICTABLE.NAME_RU_ALT, PERIODICTABLE.ABBR FROM ATOMS JOIN PERIODICTABLE ON ATOMS.ID_ELEMENT=PERIODICTABLE.ID";
		$this->LoadFromSQL($query);
	}

	function LoadCountByIonization($ion = NULL, $operator = "=", $group = true) //For statistics page
	{
		$stmt = GetStatement();
		$query = "SELECT COUNT(ID_ELEMENT) FROM (SELECT ID_ELEMENT FROM ATOMS"
			. ($ion!== NULL ? " WHERE IONIZATION $operator $ion" : "" )
			. ($group ? " GROUP BY ID_ELEMENT" : "")
			. ") AS tbl1";
		return $stmt->FetchField($query);
	}

	function LoadCountByIonizationWithLevels($ion = NULL, $operator = "=", $group = true) //For statistics page
	{
		$stmt = GetStatement();
		$query = "SELECT COUNT(ID_ELEMENT) FROM (SELECT ID_ELEMENT FROM ATOMS"
			. " WHERE ID IN (SELECT ID_ATOM FROM LEVELS GROUP BY ID_ATOM)"
			. ($ion!== NULL ? " AND IONIZATION $operator $ion" : "" )
			. ($group ? " GROUP BY ID_ELEMENT" : "")
			. ") AS tbl1";
		return $stmt->FetchField($query);
	}


	function LoadCountByIonizationWithTransitions($ion = NULL, $operator = "=", $group = true) //For statistics page
	{
		$stmt = GetStatement();
		$query = "SELECT COUNT(ID_ELEMENT) FROM (SELECT ID_ELEMENT FROM ATOMS"
			. " WHERE ID IN (SELECT ID_ATOM FROM TRANSITIONS GROUP BY ID_ATOM)"
			. ($ion!== NULL ? " AND IONIZATION $operator $ion" : "" )
			. ($group ? " GROUP BY ID_ELEMENT" : "")
			. ") AS tbl1";
		return $stmt->FetchField($query);
	}

}
?>