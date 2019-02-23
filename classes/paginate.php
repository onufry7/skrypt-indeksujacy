<?php

class Paginate
{
	//private $_currentOffset;
	private $_currentPage = 0; //Obecna strona
	private $_items = 0; //Liczba wszystkich rekordów
	//private $_parts;
	private $_next = false; //Następna strona
	private $_previous = false; //Poprzednia strona
	private $_perPage = 2; //Liczba rekordów na strone
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
		


echo '<br>----------------------------------------------<br>';
echo 'Klasa Paginate -> constructor <br>';
if($page != null) echo 'Page: '.$page;
if($items != null) echo '<br>Items: '.$items;
echo '<br>----------------------------------------------<br>';
//echo 'currentOffset: '.$this->_currentOffset.'<br>';
echo 'currentPage: '.$this->_currentPage.'<br>';
echo 'items: '.$this->_items.'<br>';
//echo 'parts: '.$this->_parts.'<br>';
echo 'next: '.$this->_next.'<br>';
echo 'previous: '.$this->_previous.'<br>';
echo 'perPage: '.$this->_perPage.'<br>';
echo 'pages: '.$this->_pages.'<br>';
echo 'from: '.$this->_from.'<br>';
echo 'to: '.$this->_to.'<br>';
echo '<br>----------------------------------------------<br>';
	}

	//Ustawia liczbe wszystkich rekordów
	private function setItems($elements)
	{
		$this->_items = $elements;
	}


	//Ustawia liczbe wszystkich stron
	private function setPages()
	{
		$this->_pages = ceil($this->_items/$this->_perPage)-1;
	}

	//Ustawia przedział rekordów dla strony
	private function setFromTo()
	{
		//Nr min rekordu na bierzącej stronie
		if($this->_currentPage*$this->_perPage < 0) $this->_from = 0;
		else $this->_from = $this->_currentPage*$this->_perPage;

		//Nr max rekordu na bierzącej stronie
		if($this->_from+$this->_perPage-1 > $this->_items) $this->_to = $this->_items;
		else $this->_to = $this->_from+$this->_perPage-1;
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