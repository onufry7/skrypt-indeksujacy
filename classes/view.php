<?php

	class View
	{
		private $_master = 'master'; //Nazwa głównego szablonu

		public function __construct()
		{
			//$this->_master = $this->getTemplate('master');
			//$this->_master = str_replace('{{ COUNT-PROJECTS }}', $count, $this->_master);
		}


		//Pobiera kod widoku
		public function getView($view = null)
		{
			if($view == null) $view = $this->_master;
			$template = $this->getTemplate($view);
			return $template;
		}


		//Sprawdza czy plik widoku istnieje 
		//Zwraca kod widoku lub generuje błąd
		private function getTemplate($file)
		{
			$file = 'templates/'.$file.'.html';
			if(file_exists($file)) $content = file_get_contents($file);
			else throw new Exception('Nie udało się wczytać pliku widoku strony!');
			return $content;
		}


		//Wyświetla stronę
		public function renderView($view)
		{
			echo $view;
		}
	}

?>