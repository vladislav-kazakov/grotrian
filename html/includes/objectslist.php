<?php
class ObjectsList
{

	// Members
	var $items, $counter;
	var $totalItems;
	var $itemsPerPage;
	
	// Constructor
	function ObjectsList($data = array(), $statement = null)
	{
		if (is_array($data))
		{
			$this->LoadFromArray($data);
		}
		else
		{
			$this->LoadFromSQLWithStatement($data, $statement);
		}
		$this->counter = 0;
	}

	// LoadFromArray
	function LoadFromArray($data)
	{
		$this->items = array_values($data);
	}

	// LoadFromSQL
	function LoadFromSQLWithStatement($query, $statement)
	{
		$this->items = $statement->FetchList($query);
	}

	// GetItemsArray
	function GetItemsArray()
	{
		return $this->items;
	}

	// CountItems
	function CountItems()
	{
		return count($this->items);
	}

	// FirstItem
	function FirstItem()
	{
		$this->counter = 0;
	}

	// NextItem
	function NextItem()
	{
		if (isset($this->items[$this->counter]))
		{
			return $this->CreateItem($this->items[$this->counter++]);
		}
		return null;
	}

	// CreateItem
	function CreateItem($data)
	{
		echo("\nDefine CreateItem in child class to use iteration over items!\n");
		return null;
	}
	
	// GetPagesListing
	function GetPagesListing($startPosition = 1, $pagesFromCentral = 5, $startPages = 3)
	{
//		echo $this->totalItems." !!! ".$onList;
//		if ($this->totalItems > $onList) return null;
		
		$counter = 0;
		$startPosition = intval($startPosition);
		if (isset($this->totalItems) && isset($this->itemsPerPage) )
		{
			$maxPage = ceil($this->totalItems/$this->itemsPerPage);
			if ($maxPage == 1) return false;
		}
		else
		{
			return false;
		}

		$returnValue[$counter]["PAGESTR"] = "&lt;";
		if ($startPosition > 1)
		{
			$returnValue[$counter]["PAGEVALUE"] = min($startPosition-1, $maxPage);
		}
		$counter++;

		for ($i = 1; $i < min($startPages+1, $startPosition-$pagesFromCentral); $i++)
		{
			$returnValue[$counter]["PAGESTR"] = $i;
			$returnValue[$counter]["PAGEVALUE"] = $i;
			$counter++;
		}

		if ($i < $startPosition-$pagesFromCentral)
		{
			$returnValue[$counter]["PAGESTR"] = "...";
			$returnValue[$counter]["PAGEVALUE"] = min(floor(($i-1+$startPosition-$pagesFromCentral)/2), floor(($i-1+$maxPage)/2));
			$counter++;
		}

		for ($i = max(1, $startPosition-$pagesFromCentral); $i <= min($startPosition+$pagesFromCentral, $maxPage); $i++)
		{
			$returnValue[$counter]["PAGESTR"] = $i;
			$returnValue[$counter]["PAGEVALUE"] = ($i==$startPosition)?"selected":$i;
			$counter++;
		}

		if ($i <= $maxPage-$startPages)
		{
			$returnValue[$counter]["PAGESTR"] = "...";
			$returnValue[$counter]["PAGEVALUE"] = ceil(($i-1+$maxPage-$startPages)/2);
			$counter++;
		}

		for ($i = max($startPosition+$pagesFromCentral+1, $maxPage-$startPages+1); $i <= $maxPage; $i++)
		{
			$returnValue[$counter]["PAGESTR"] = $i;
			$returnValue[$counter]["PAGEVALUE"] = $i;
			$counter++;
		}

		$returnValue[$counter]["PAGESTR"] = "&gt;";
		if ($startPosition < $maxPage)
		{
			$returnValue[$counter]["PAGEVALUE"] = $startPosition+1;
		}
		return $returnValue;

	}

}
?>