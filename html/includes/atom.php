<?
require_once("localobject.php");

class Atom extends LocalObject
{
	function Load($element_id)
	{		
		if (ISLOCAL) $query = "SELECT IONIZATION,Z,ATOM_MASS,IONIZATION_POTENCIAL,ABBR,TABLEPERIOD,TABLEGROUP,NAME_EN,NAME_RU,NAME_RU_ALT,PERIODICTABLE.[TYPE] AS ELEMENT_TYPE,PERIODICTABLE.ID AS ELEMENT_ID, INTERFACE_CONTENT.* FROM  ATOMS,PERIODICTABLE,INTERFACE_CONTENT WHERE ATOMS.ID='$element_id' AND ATOMS.ID_ELEMENT = PERIODICTABLE.ID AND INTERFACE_CONTENT.ID=ATOMS.DESCRIPTION";
		else 		 $query = "SELECT IONIZATION,Z,ATOM_MASS,IONIZATION_POTENCIAL,ABBR,TABLEPERIOD,TABLEGROUP,NAME_EN,NAME_RU,NAME_RU_ALT,PERIODICTABLE.[TYPE] AS ELEMENT_TYPE,PERIODICTABLE.ID AS ELEMENT_ID, LIMITS, BREAKS, INTERFACE_CONTENT.* FROM  ATOMS,PERIODICTABLE,INTERFACE_CONTENT WHERE ATOMS.ID='$element_id' AND ATOMS.ID_ELEMENT = PERIODICTABLE.ID AND INTERFACE_CONTENT.ID=ATOMS.DESCRIPTION";
		$this->LoadFromSQL($query);
		
	}	

	function Create($element_id)
	{		
		$query = "INSERT INTO INTERFACE_CONTENT (ID,[TYPE]) SELECT MAX(ID)+1,'atom_description' FROM INTERFACE_CONTENT
INSERT INTO ATOMS (ID,ID_ELEMENT,IONIZATION,[DESCRIPTION]) SELECT MAX(ID)+1,".$element_id.",(SELECT MAX(IONIZATION)+1 FROM ATOMS WHERE ID_ELEMENT=".$element_id."), (SELECT MAX(ID) FROM INTERFACE_CONTENT WHERE [TYPE]='atom_description') FROM ATOMS
SELECT TOP 1 ID FROM ATOMS WHERE ID_ELEMENT=".$element_id." ORDER BY IONIZATION DESC
";
	$this->LoadFromSQL($query);
				
	}

	function Delete($element_id,$atom_id)
	{	
		$query = "DELETE FROM INTERFACE_CONTENT WHERE ID=( SELECT [DESCRIPTION] FROM ATOMS WHERE ID=".$atom_id.")
		DELETE FROM ATOMS WHERE ID=".$atom_id." SELECT TOP 1 ID FROM ATOMS WHERE ID_ELEMENT=".$element_id." ORDER BY IONIZATION DESC";
		$this->LoadFromSQL($query);		
	}
	
	function Save($post){
		
		$content_ru = iconv("UTF-8", "Windows-1251", $post['atomDescription_ru']);
		$content_en = iconv("UTF-8", "Windows-1251", $post['atomDescription_en']);
		
	$query = "UPDATE ATOMS SET [IONIZATION] = ".$post['atomIonization'].",[IONIZATION_POTENCIAL] = '".$post['atomIonizationPotencial']."'  WHERE ID = ".$post['atom_id']." 
	UPDATE INTERFACE_CONTENT SET [CONTAINMENT_ENG] ='".$content_en."',[CONTAINMENT_RUS] ='".$content_ru."' WHERE ID=(SELECT [DESCRIPTION] FROM ATOMS WHERE ID = ".$post['atom_id'].") ";
		
		$this->LoadFromSQL($query);
	}
	
	function makeDiagram($post)
	{		
		$query = "UPDATE ATOMS SET [LIMITS] = '".$post['atomLimits']."' , [BREAKS] =  '".$post['atomBreaks']."' , [CHANGED]= 1  WHERE ID = ".$post['atom_id'];
		//$query = "UPDATE ATOMS SET [CHANGED]= 1 WHERE ID = 2899";
		//echo	$query;	
		$this->LoadFromSQL($query);
	}
	
	
	function GetXML($atom_id)
	{		
		
		$query = "SELECT [XML] FROM [Grotrian_v2].[dbo].[ATOMS] WHERE ID = ".$atom_id;	
		$this->LoadFromSQL($query);
	}
	
}
?>