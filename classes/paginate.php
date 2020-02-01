<?php

class Paginate
{
	private $_currentPage = 1; //Obecna strona
	private $_items = 0; //Liczba wszystkich rekordów
	private $_next = false; //Następna strona
	private $_previous = false; //Poprzednia strona
	private $_perPage = 10; //Liczba rekordów na strone
	private $_pages = 1; //Liczba stron
	private $_from = 0; //Od jakiego rekordu
	private $_to = 0; //Do jakiego rekordu
	private $_panel = ''; //Panel z paginacją


	public function generatePagination($items, $page = null)
	{
		$this->setItems($items);
		$this->setPages();
		$this->setCurrentPage($page);
		$this->setNextPrev();
		$this->setFromTo();
		$this->setPanel();
	}


	public function getPanel()
	{
		return $this->_panel;
	}

	private function setPanel()
	{
		$panel = $this->createPanel();
		$this->_panel = $panel;
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

	//Ustawia przedział rekordów dla strony
	private function setFromTo()
	{
		//Nr min rekordu na bierzącej stronie
		if(($this->_currentPage-1)*$this->_perPage < 0) $this->_from = 0;
		else $this->_from = ($this->_currentPage-1)*$this->_perPage;

		//Nr max rekordu na bierzącej stronie
		if($this->_from+$this->_perPage-1 > $this->_items-1) $this->_to = $this->_items-1;
		else $this->_to = $this->_from+$this->_perPage-1;
	}


	//Ustawia liczbe wszystkich rekordów
	private function setItems($elements)
	{
		$this->_items = $elements;
	}


	//Ustawia liczbe wszystkich stron
	private function setPages()
	{
		$this->_pages = ceil($this->_items/$this->_perPage);
	}


	//Ustawienie aktualnej strony
	private function setCurrentPage($page)
	{
		//Gdy nie podano strony lub poniżej min wartość
		if(is_null($page) || $page < 1) $this->_currentPage = 1; 
		//Gdy przekroczy max wartość
		else if($page > $this->_pages) $this->_currentPage = $this->_pages; 
		//W innych przypadkach
		else $this->_currentPage = $page;
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



	//Tworzy panel z linkami
	private function createPanel()
	{
		$view = new View;
		$content = $view->getViewSrc('pagin-panel');
		$panel = '';
		$page = 5; //Zakres wyświetlanych stron po lewej i prawej od obecnej

		if($this->_currentPage > ($page+1)) $panel .= $content[0];

		for($i=1; $i<=$this->_pages; $i++)
		{
			if($i >= ($this->_currentPage-$page) && $i <= ($this->_currentPage+$page))
			{
				$src = ($i==$this->_currentPage) ? $content[2] : $content[1];
				$panel .= str_replace('{{ PAGE }}', $i, $src);
			}
		}

		if($this->_currentPage <= $this->_pages-($page+1)) 
			$panel .= str_replace('{{ PAGE }}', $this->_pages, $content[3]);

		return $panel;
	}

}

?>