<?php

class Paginate
{
	private $_currentPage = 0; //Obecna strona
	private $_items = 0; //Liczba wszystkich rekordów
	private $_next = false; //Następna strona
	private $_previous = false; //Poprzednia strona
	private $_perPage = 3; //Liczba rekordów na strone
	private $_pages = 1; //Liczba stron
	private $_from = 0; //Od jakiego rekordu
	private $_to = 0; //Do jakiego rekordu

	public function __construct($items, $page = null)
	{
		$this->setItems($items);
		$this->setPages();
		$this->setCurrentPage($page);
		$this->setNextPrev();
		$this->setFromTo();
	}


	public function getCountProjects()
	{
		return $this->_items;
	}


	//Pobiera numery rekordów na stronę
	public function getFromTo()
	{
		return ['from'=>$this->_from, 'to'=>$this->_to];
	}


	//Ustawia liczbe wszystkich rekordów
	private function setItems($elements)
	{
		$this->_items = $elements;
	}


	//Ustawia przedział rekordów dla strony
	private function setFromTo()
	{
		//Nr min rekordu na bierzącej stronie
		if($this->_currentPage*$this->_perPage < 0) $this->_from = 0;
		else $this->_from = $this->_currentPage*$this->_perPage;

		//Nr max rekordu na bierzącej stronie
		if($this->_from+$this->_perPage-1 > $this->_items-1) $this->_to = $this->_items-1;
		else $this->_to = $this->_from+$this->_perPage-1;
	}


	//Ustawia liczbe wszystkich stron
	private function setPages()
	{
		$this->_pages = ceil($this->_items/$this->_perPage)-1;
	}


	//Ustawienie aktualnej strony
	private function setCurrentPage($page)
	{
		//Gdy nie podano strony lub poniżej min wartość
		if(is_null($page) || $page-1 < 0) $this->_currentPage = 0; 
		//Gdy przekroczy max wartość
		else if(($page-1) > $this->_pages) $this->_currentPage = $this->_pages; 
		//W innych przypadkach
		else $this->_currentPage = $page-1; 
	}


	//Ustawienie poprzedniej i następnej strony
	private function setNextPrev()
	{
		//Gdy ostatnia strona
		if($this->_currentPage == $this->_pages)
		{
			$this->_next = false;
			$this->_previous = $this->_currentPage-1;
		}
		//Gdy pierwsza strona
		else if($this->_currentPage == 0)
		{
			$this->_next = $this->_currentPage+1;
			$this->_previous = false;
		}
		//W innym przypadku
		else
		{
			$this->_next = $this->_currentPage+1;
			$this->_previous = $this->_currentPage-1;
		}
	}

}

?>