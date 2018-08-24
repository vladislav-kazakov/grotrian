<?
require_once("locallist.php");
require_once("atom.php");

class TransitionList extends LocalList
{
    function Load($element_id)
	{	
		$query = "SELECT class_transitions.*, class_elements.ID as elementID FROM class_transitions
				  JOIN links ON links.TO_ELEMENT_ID=class_transitions.ID
			 	  JOIN class_elements ON links.FROM_ELEMENT_ID=class_elements.ID
				  WHERE class_elements.ID='$element_id' ORDER BY ID";
		$this->LoadFromSQL($query);
	}
	
	function LoadWithLevels($element_id)
	{	
	/*	$query = "SELECT trans.*,low.TERMPARITY as low_termpa,low.CONFIG as low_config,low.TERMR as low_termr,low.TERMPREFIX as low_termpr,low.JJ as low_jj,low.TERMSEQ as low_termseq,
		high.TERMPARITY as high_termpa,high.CONFIG as high_config,[Grotrian].[dbo].GetCfgType(high.CONFIG) AS high_CONFIG_TYPE,high.TERMR as high_termr,high.TERMPREFIX as high_termpr,high.JJ as high_jj,high.TERMSEQ as high_termseq, class_elements.id as elementID		
		 FROM class_transitions AS trans LEFT JOIN class_levels AS low ON trans.LOW_LEVEL=low.ID LEFT JOIN class_levels AS high ON trans.HIGH_LEVEL=high.ID 
		JOIN links ON links.TO_ELEMENT_ID=trans.ID
			 	  JOIN class_elements ON links.FROM_ELEMENT_ID=class_elements.ID
		WHERE class_elements.ID='$element_id' ORDER BY WAVE_LENGTH";
		*/
		$query = "SELECT TRANSITIONS.*,lower_level.ID AS lower_level_id,lower_level.energy AS lower_level_energy,lower_level.termmultiply AS lower_level_termmultiply, lower_level.CONFIG AS lower_level_config,lower_level.J AS lower_level_j,lower_level.TERMPREFIX AS lower_level_termprefix,lower_level.TERMMULTIPLY AS lower_level_termmultiply,lower_level.TERMFIRSTPART AS lower_level_termfirstpart,lower_level.TERMSECONDPART AS lower_level_termsecondpart,
upper_level.ID AS upper_level_id,upper_level.energy AS upper_level_energy, upper_level.termmultiply as upper_level_termmultiply, upper_level.CONFIG AS upper_level_config,upper_level.J AS upper_level_j,upper_level.TERMPREFIX AS upper_level_termprefix,upper_level.TERMMULTIPLY AS upper_level_termmultiply,upper_level.TERMFIRSTPART AS upper_level_termfirstpart,upper_level.TERMSECONDPART AS upper_level_termsecondpart,
[Grotrian_v2].[dbo].GetCfgType(upper_level.CONFIG) AS upper_level_config_type, dbo.ConcatSourcesID(TRANSITIONS.ID,'T') AS SOURCE_IDS
FROM TRANSITIONS LEFT JOIN LEVELS AS lower_level ON TRANSITIONS.ID_LOWER_LEVEL=lower_level.ID LEFT JOIN LEVELS AS upper_level ON TRANSITIONS.ID_UPPER_LEVEL=upper_level.ID 
WHERE TRANSITIONS.ID_ATOM='$element_id' ORDER BY WAVELENGTH";
		
		
		$this->LoadFromSQL($query);
		
	}

	function LoadForDiagram($element_id){
        $atom = new Atom();
        $atom->Load($element_id);
        $atom_data = $atom->GetAllProperties();

        $query = "SELECT TRANSITIONS.*,
                    lower_level.ID AS lower_level_id,
                    lower_level.energy AS lower_level_energy,
                    lower_level.termmultiply AS lower_level_termmultiply,
                    lower_level.CONFIG AS lower_level_config,
                    lower_level.J AS lower_level_j,
                    lower_level.TERMPREFIX AS lower_level_termprefix,
                    lower_level.TERMMULTIPLY AS lower_level_termmultiply,
                    lower_level.TERMFIRSTPART AS lower_level_termfirstpart,
                    lower_level.TERMSECONDPART AS lower_level_termsecondpart,
                    upper_level.ID AS upper_level_id,
                    upper_level.energy AS upper_level_energy,
                    upper_level.termmultiply as upper_level_termmultiply,
                    upper_level.CONFIG AS upper_level_config,
                    upper_level.J AS upper_level_j,
                    upper_level.TERMPREFIX AS upper_level_termprefix,
                    upper_level.TERMMULTIPLY AS upper_level_termmultiply,
                    upper_level.TERMFIRSTPART AS upper_level_termfirstpart,
                    upper_level.TERMSECONDPART AS upper_level_termsecondpart,
                    [Grotrian_v2].[dbo].GetCfgType(upper_level.CONFIG) AS upper_level_config_type,
                    dbo.ConcatSourcesID(TRANSITIONS.ID,'T') AS SOURCE_IDS
                    FROM TRANSITIONS 
                    LEFT JOIN LEVELS AS lower_level ON TRANSITIONS.ID_LOWER_LEVEL=lower_level.ID
                    LEFT JOIN LEVELS AS upper_level ON TRANSITIONS.ID_UPPER_LEVEL=upper_level.ID 
                    WHERE TRANSITIONS.ID_ATOM='$element_id' 
                    ORDER BY WAVELENGTH";
        $this->LoadFromSQL($query);

        $items = $this->GetItemsArray();

        foreach ($items as &$item) {
            if ($item['lower_level_termprefix'] != $item['upper_level_termprefix'] //and it must be LS-coupling!
                && $item['lower_level_termfirstpart'][0] >='A' && $item['lower_level_termfirstpart'][0] <='Z'
                && $item['upper_level_termfirstpart'][0] >='A' && $item['upper_level_termfirstpart'][0] <='Z'
                )
                $item['prohibited'] = 'multiplicity';
            if ($item['lower_level_termmultiply'] == $item['upper_level_termmultiply']) $item['prohibited'] = 'parity';

            if ($item['WAVELENGTH']>=4000 && $item['WAVELENGTH'] <=8000)
                $item['rating'] = 3;
            elseif ($item['WAVELENGTH']>8000)
                $item['rating'] = 2;
            else
                $item['rating'] = 1;
            if ($item['lower_level_energy'] == 0
//            &&  $item['upper_level_energy'] < $atom_data['IONIZATION_POTENCIAL']
            )
                $item['rating'] += 4;

            foreach($items as $item2)
                if ($item['lower_level_energy'] === $item2['upper_level_energy']) {
                    $item['rating']++;
                    break;
                }
        }
        unset($item);
        usort($items, function ($a, $b) {
            return $b['rating'] - $a['rating'];
        });
        return $items;
    }

	function LoadForCircleSpectrum($element_id)
	{
		$query = "SELECT TRANSITIONS.*,lower_level.ID AS lower_level_id,lower_level.energy AS lower_level_energy,lower_level.termmultiply AS lower_level_termmultiply, lower_level.CONFIG AS lower_level_config,lower_level.J AS lower_level_j,lower_level.TERMPREFIX AS lower_level_termprefix,lower_level.TERMMULTIPLY AS lower_level_termmultiply,lower_level.TERMFIRSTPART AS lower_level_termfirstpart,lower_level.TERMSECONDPART AS lower_level_termsecondpart,
upper_level.ID AS upper_level_id,upper_level.energy AS upper_level_energy, upper_level.termmultiply as upper_level_termmultiply, upper_level.CONFIG AS upper_level_config,upper_level.J AS upper_level_j,upper_level.TERMPREFIX AS upper_level_termprefix,upper_level.TERMMULTIPLY AS upper_level_termmultiply,upper_level.TERMFIRSTPART AS upper_level_termfirstpart,upper_level.TERMSECONDPART AS upper_level_termsecondpart,
[Grotrian_v2].[dbo].GetCfgType(upper_level.CONFIG) AS upper_level_config_type, dbo.ConcatSourcesID(TRANSITIONS.ID,'T') AS SOURCE_IDS
FROM TRANSITIONS LEFT JOIN LEVELS AS lower_level ON TRANSITIONS.ID_LOWER_LEVEL=lower_level.ID LEFT JOIN LEVELS AS upper_level ON TRANSITIONS.ID_UPPER_LEVEL=upper_level.ID 
WHERE TRANSITIONS.ID_ATOM='$element_id' AND upper_level.energy < 200000 ORDER BY ROUND(lower_level.energy, -3), upper_level.energy";


		$this->LoadFromSQL($query);

	}

	function LoadGroupForCircleSpectrum($element_id)
	{
		$query = "SELECT MAX(TRANSITIONS.wavelength) as WAVELENGTH, SUM(TRANSITIONS.intensity) as INTENSITY, MAX(lower_level.ID) AS lower_level_id, MAX(lower_level.energy) AS lower_level_energy,
  ROUND(MAX(lower_level.energy), -3) AS round_lower_level_energy,
MAX(lower_level.termmultiply) AS lower_level_termmultiply, lower_level.CONFIG AS lower_level_config, MAX(lower_level.J) AS lower_level_j, 
MAX(lower_level.TERMPREFIX) AS lower_level_termprefix, MAX(lower_level.TERMMULTIPLY) AS lower_level_termmultiply, MAX(lower_level.TERMFIRSTPART) AS lower_level_termfirstpart, 
MAX(lower_level.TERMSECONDPART) AS lower_level_termsecondpart, MAX(upper_level.ID) AS upper_level_id, MAX(upper_level.energy) AS upper_level_energy, 
MAX(upper_level.termmultiply) as upper_level_termmultiply, upper_level.CONFIG AS upper_level_config, MAX(upper_level.J) AS upper_level_j,
MAX(upper_level.TERMPREFIX) AS upper_level_termprefix, MAX(upper_level.TERMMULTIPLY) AS upper_level_termmultiply, MAX(upper_level.TERMFIRSTPART) AS upper_level_termfirstpart,
MAX(upper_level.TERMSECONDPART) AS upper_level_termsecondpart,
MAX([Grotrian_v2].[dbo].GetCfgType(upper_level.CONFIG)) AS upper_level_config_type, MAX(dbo.ConcatSourcesID(TRANSITIONS.ID,'T')) AS SOURCE_IDS
FROM TRANSITIONS LEFT JOIN LEVELS AS lower_level ON TRANSITIONS.ID_LOWER_LEVEL=lower_level.ID LEFT JOIN LEVELS AS upper_level ON TRANSITIONS.ID_UPPER_LEVEL=upper_level.ID
 
WHERE TRANSITIONS.ID_ATOM='$element_id' AND upper_level.energy < 200000 GROUP BY lower_level.config, upper_level.config ORDER BY round_lower_level_energy, upper_level_energy";

		$this->LoadFromSQL($query);

	}

	function LoadCount($element_id = null)
	{
		if ($element_id != null)
		{
			$stmt = GetStatement();
/*			$query = "SELECT count(class_transitions.ID) FROM class_transitions 
				JOIN links ON links.TO_ELEMENT_ID=class_transitions.ID
				JOIN class_elements ON links.FROM_ELEMENT_ID=class_elements.ID
				WHERE class_elements.ID='$element_id' ";*/
			$query = "SELECT count(ID) FROM TRANSITIONS WHERE ID_ATOM='$element_id' ";
			return $stmt->FetchField($query);
		}
		return $this->GetTotalRecords('TRANSITIONS');
	}

	function LoadCountByIonization($ion = NULL, $operator = "=") //For statistics page
	{
		$stmt = GetStatement();
		$query = "SELECT COUNT(TRANSITIONS.ID) FROM TRANSITIONS JOIN ATOMS ON TRANSITIONS.ID_ATOM = ATOMS.ID"
			. ($ion!== NULL ? " WHERE ATOMS.IONIZATION $operator $ion" : "" );
		//echo $query;
		return $stmt->FetchField($query);
	}

	function LoadClassifiedCountByIonization($ion = NULL, $operator = "=") //For statistics page
	{
		$stmt = GetStatement();
		$query = "SELECT COUNT(TRANSITIONS.ID) FROM TRANSITIONS JOIN ATOMS ON TRANSITIONS.ID_ATOM = ATOMS.ID"
			. " WHERE TRANSITIONS.ID_UPPER_LEVEL IS NOT NULL AND TRANSITIONS.ID_LOWER_LEVEL IS NOT NULL"
			. ($ion!== NULL ? " AND ATOMS.IONIZATION $operator $ion" : "" );
		//echo $query;
		return $stmt->FetchField($query);
	}

	function Save($post){
		$count=$post['count'];
        $query="";

		for ($i=0; $i<$count; $i++) {
            $transition_id = $post['row_id'][$i];
            $wavelength = empty($post['wavelength'][$i]) ? "NULL" : $post['wavelength'][$i];
            $intensity = empty($post['intensity'][$i]) ? "NULL" : $post['intensity'][$i];
            $f_ik = empty($post['f_ik'][$i]) ? "NULL" : $post['f_ik'][$i];
            $a_ki = empty($post['a_ki'][$i]) ? "NULL" : ($post['a_ki'][$i]*100000000);
            $excitation = empty($post['excitation'][$i]) ? "NULL" : $post['excitation'][$i];
            $bibliolink       = ($post['bibliolink'][$i] == "")    ? 'NULL' :  "'" . $post['bibliolink'][$i] .  "'";

            $query .= " UPDATE TRANSITIONS SET [WAVELENGTH] = " . $wavelength
                . " ,[PROBABILITY] = " . $a_ki
                . ", [OSCILLATOR_F] = " . $f_ik
                . ",[CROSSECTION] = " . $excitation
                . ",[INTENSITY] = " . $intensity
                . ", [BIBLIOLINK] = " . $bibliolink
                . " WHERE ID =".$transition_id;
            echo $query;
		}
		
		$this->LoadFromSQL($query);
	}
	
	function setUpperLevel($transition_id,$level_id){
		$query = "UPDATE TRANSITIONS SET [ID_UPPER_LEVEL] = ".$level_id." WHERE ID =".$transition_id." 
		SELECT * FROM [LEVELS] WHERE ID = ".$level_id;	
		//echo $query;			
		$this->LoadFromSQL($query);
	}
	
	function setLowerLevel($transition_id,$level_id){
		$query = "UPDATE TRANSITIONS SET [ID_LOWER_LEVEL] = ".$level_id." WHERE ID =".$transition_id." 
		SELECT * FROM LEVELS WHERE ID = ".$level_id;				
		$this->LoadFromSQL($query);
	}
	
	function Delete($post){
		foreach ($post['row_id'] as $key=>$transition_id) {
			$query .= " DELETE FROM TRANSITIONS WHERE ID =".$transition_id;			
		}
		$this->LoadFromSQL($query);
	}
	
/*	function Create($atom_id)
	{		
		$query = "INSERT INTO TRANSITIONS ([ID],[ID_ATOM]) SELECT MAX(ID)+1,".$atom_id." FROM TRANSITIONS
		SELECT MAX(ID) AS ID FROM TRANSITIONS WHERE ID_ATOM=".$atom_id;
	 	$this->LoadFromSQL($query);				
	}*/

	function Create($atom_id)
	{	
		$query = "INSERT INTO TRANSITIONS ([ID_ATOM]) VALUES (".$atom_id.")		
		SELECT MAX(ID) AS ID FROM TRANSITIONS WHERE ID_ATOM=".$atom_id;
	 	$this->LoadFromSQL($query);				
	}
	
}
?>