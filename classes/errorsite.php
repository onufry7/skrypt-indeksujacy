<?php

class ErrorSite extends Site
{
	private $_title = 'Błąd strony';
	private $_header = 'Nieznany błąd!';
	private $_message = 'Nieoczekiwany błąd skryptu!';


	public function __construct($nr)
	{
		switch ($nr) 
		{
			case 404:
				$this->error404();
				$content = $this->createErr404();
				$page = $this->getMasterView($content);
				$view = new View;
				$view->renderView($page);
				break;
			
			default:
				parent::__construct($this->_header, $this->_title);
				$content = $this->createErr();
				$page = $this->getMasterView($content);
				$view = new View;
				$view->renderView($page);
				break;
		}
	}


	private function error404()
	{
		header("HTTP/1.0 404 Not Found");
		$this->_title = 'Błąd 404';
		$this->_header = 'Błąd 404 - Brak Strony !';
		$this->_message = 'Nie udało się odnaleźć strony pod tym adresem!';
		parent::__construct($this->_header, $this->_title);
	}


	private function createErr404()
	{
		$replace = [$this->_message];
		$search = ['{{ CONTENT }}'];
		$view = new View;
		$page = $view->getView('error404');
		$content = str_replace($search, $replace, $page);
		return $content;
	}


	private function createErr()
	{
		$replace = [$this->_message];
		$search = ['{{ CONTENT }}'];
		$view = new View;
		$page = $view->getView('error');
		$content = str_replace($search, $replace, $page);
		return $content;
	}

}

?>