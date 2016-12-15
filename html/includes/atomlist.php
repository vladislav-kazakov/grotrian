<?

require_once("locallist.php");

class AtomList extends LocalList
{

	function LoadForSitemap()
	{
		$query = "SELECT ATOMS.ID, ATOMS.IONIZATION, ATOMS.SPECTRUM_IMG, PERIODICTABLE.NAME_EN, PERIODICTABLE.NAME_RU_ALT, PERIODICTABLE.ABBR FROM ATOMS JOIN PERIODICTABLE ON ATOMS.ID_ELEMENT=PERIODICTABLE.ID";
		$this->LoadFromSQL($query);
	}


	
}
?>