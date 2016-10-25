<?
require_once("locallist.php");

class Source extends LocalList
{
	function Create()
	{		
		$query = "INSERT INTO SOURCES ([SOURCE_TYPE]) VALUES ('j_article') 
		SELECT TOP 1 ID AS ID FROM SOURCES ORDER BY ID DESC";
		$this->LoadFromSQL($query);				
	}
	
	function Load($source_id)
	{
		$query = "SELECT * FROM SOURCES WHERE SOURCES.ID =".$source_id;		
		$this->LoadFromSQL($query);
	}
	
	function Save($post){	
		
	$vol_first = empty($post['vol_first']) ? "NULL" : ($post['vol_first']);
	$vol_last = empty($post['vol_last']) ? "NULL" : ($post['vol_last']);
	$page_first = empty($post['page_first']) ? "NULL" : ($post['page_first']);
	$page_last = empty($post['page_last']) ? "NULL" : ($post['page_last']);
	$year = empty($post['year']) ? "NULL" : ($post['year']);
	$link = empty($post['link']) ? "" : (trim($post['link']));
/*	$name = empty($post['name']) ? "" : ("sdfsdf");
	$issue_name = empty($post['issue_name']) ? "" : ($post['issue_name']);
	$publisher = empty($post['publisher']) ? "" : ($post['publisher']);
	$city = empty($post['city']) ? "" : ($post['city']);
	$collection_type = empty($post['collection_type']) ? "" : ($post['collection_type']);*/
	
	$name = empty($post['name']) ? "" : (iconv("UTF-8", "Windows-1251", $post['name']));
	$issue_name = empty($post['issue_name']) ? "" : (iconv("UTF-8", "Windows-1251", $post['issue_name']));
	$publisher = empty($post['publisher']) ? "" : (iconv("UTF-8", "Windows-1251", $post['publisher']));
	$city = empty($post['city']) ? "" : (iconv("UTF-8", "Windows-1251", $post['city']));
	$collection_type = empty($post['collection_type']) ? "" : (iconv("UTF-8", "Windows-1251", $post['collection_type']));
	
	//$content_en = iconv("UTF-8", "Windows-1251", $post['atomDescription_en']);	
		
	$query = "UPDATE SOURCES SET [SOURCE_TYPE] = '".$post['source_type']."',[WORK_NAME] = '".$name."',[ISSUE_NAME] = '".$issue_name."',[PAGE_FIRST] = ".$page_first.",[PAGE_LAST] = ".$page_last.",[VOLUME_FIRST] = ".$vol_first.",[VOLUME_LAST] = ".$vol_last.",[PUBLISHER] = '".$publisher."',[CITY] = '".$city."',[YEAR] = ".$year.",[LINK] = '".$link."',[COLLECTION_TYPE] = '".$collection_type."' WHERE ID=".$post['source_id'];
	//print_r($query);
	$this->LoadFromSQL($query);
	}	
	
	function Delete($post){
		if (is_array($post['source_id']))
		foreach ($post['source_id'] as $key=>$source_id) {
			$query .= " DELETE FROM [SOURCES] WHERE ID =".$source_id;			
		} else $query = "DELETE FROM [SOURCES] WHERE ID =".$source_id;
		
		$this->LoadFromSQL($query);
	}

	function GetAuthors($source_id)
	{	
			$query = "SELECT AUTHORS.*, AUTHORS_SOURCES_LINKS.ROLE
  FROM AUTHORS, AUTHORS_SOURCES_LINKS WHERE 
   AUTHORS.ID = AUTHORS_SOURCES_LINKS.ID_AUTHOR 
  AND AUTHORS_SOURCES_LINKS.ID_SOURCE =".$source_id;
		
		$this->LoadFromSQL($query);
	}	

	function GetAutocompleteAuthors($q)
	{	
		$q = iconv("UTF-8", "Windows-1251", $q);	
		$query = "SELECT TOP 1000 [NAME] FROM [Grotrian_v2].[dbo].[AUTHORS] WHERE NAME LIKE '".$q."%'";
		
		$this->LoadFromSQL($query);
	}	
	
	
	function RemoveAuthor($source_id,$author_id)
	{	
		$query = "DELETE FROM [AUTHORS_SOURCES_LINKS] WHERE ID_SOURCE=".$source_id." AND ID_AUTHOR=".$author_id;		
		$this->LoadFromSQL($query);
	}
	
	function SaveAuthor($author_id,$source_id,$author_name,$author_role){
	
	$author_name = iconv("UTF-8", "Windows-1251", $author_name);	
		
	//$query = "UPDATE AUTHORS SET [NAME] = '".$name."' WHERE ID=".$author_id;
/*
	$query = "
	declare @a varchar(10)
declare @t varchar(10)

SET @a = (SELECT ID FROM AUTHORS WHERE NAME = '".$author_name."')
IF (isnull (@a, 0) = 0) 
BEGIN
INSERT INTO AUTHORS (NAME) VALUES ('".$author_name."') 
SET @a = (SELECT TOP 1 ID FROM AUTHORS ORDER BY ID DESC)
END

SELECT @a AS ID

SET @t = (SELECT ID_AUTHOR FROM AUTHORS_SOURCES_LINKS WHERE ID_SOURCE = ".$source_id." AND ID_AUTHOR = @a)

IF (isnull (@t, 0) <> @a) 
BEGIN
INSERT INTO AUTHORS_SOURCES_LINKS (ID_AUTHOR,ID_SOURCE,[ROLE]) VALUES (@a,".$source_id.",'author')
END

ELSE 
UPDATE AUTHORS_SOURCES_LINKS SET [ROLE] = '".$author_role."' WHERE ID_AUTHOR = @a AND ID_SOURCE=".$source_id;
*/

$query = "
declare @a varchar(10)

SET @a = (SELECT ID FROM AUTHORS WHERE NAME = '".$author_name."')
IF (isnull (@a, 0) = 0) 
BEGIN
INSERT INTO AUTHORS (NAME) VALUES ('".$author_name."') 
SET @a = (SELECT TOP 1 ID FROM AUTHORS ORDER BY ID DESC)
END

SELECT @a AS ID ";
		if (empty($author_id)) $query .="INSERT INTO AUTHORS_SOURCES_LINKS (ID_AUTHOR,ID_SOURCE,[ROLE]) VALUES (@a,".$source_id.",'".$author_role."')";
		else $query .="UPDATE AUTHORS_SOURCES_LINKS SET [ROLE] = '".$author_role."', [ID_AUTHOR] = @a WHERE ID_AUTHOR = ".$author_id." AND ID_SOURCE=".$source_id;	
		$this->LoadFromSQL($query);
	}

	
	function ApplySources($post){
		
		foreach ($post['row_id'] as $row_key=>$row_id){
			foreach ($post['source_id'] as $source_key=>$source_id)
			$query.=" IF ((SELECT ID_RECORD FROM BIBLIOLINKS WHERE [ID_RECORD]=".$row_id." AND [ID_SOURCE]=".$source_id." AND [RECORDTYPE] = ".$post['type'].")= NULL) BEGIN INSERT INTO BIBLIOLINKS ([RECORDTYPE],[ID_RECORD],[ID_SOURCE]) VALUES (".$post['type'].",".$row_id.",".$source_id.") END";
		}
		
		//echo $query;
		$this->LoadFromSQL($query);
	}

	function ApplyRemovingSources($post){ 
		foreach ($post['row_id'] as $row_key=>$row_id){
			foreach ($post['source_id'] as $source_key=>$source_id)
			$query.=" DELETE FROM [BIBLIOLINKS] WHERE [ID_RECORD]=".$row_id." AND [ID_SOURCE]=".$source_id." AND [RECORDTYPE]=".$post['type'];
		}
		//echo $query;
		$this->LoadFromSQL($query);
	}
	
	function GetSourceIDs($row_id,$type)
	{
		if ($type=="T") $froam = "TRANSITIONS"; else $froam = "LEVELS";
		$query = "SELECT dbo.ConcatSourcesID(ID,'".$type."') AS SOURCE_IDS FROM ".$froam." WHERE  ID=".$row_id." ORDER BY ID asc";		
		$this->LoadFromSQL($query);
	}	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}	
?>