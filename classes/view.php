<?php

	class View
	{
		private $_master = 'master'; //Nazwa głównego szablonu

		//Pobiera kod widoku
		public function getView($view = null)
		{
			if($view == null) $view = $this->_master;
			$template = $this->getTemplate($view);
			return $template;
		}


		//Pobiera kod widoku do tablicy
		public function getViewSrc($view)
		{
			$template = $this->getTemplate($view, true);
			return $template;
		}


		//Sprawdza czy plik widoku istnieje 
		//Zwraca kod widoku lub generuje błąd
		private function getTemplate($file, $array = false)
		{
			$file = 'templates/'.$file.'.html';
			if(file_exists($file))
			{
				if($array) $content = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
				else $content = file_get_contents($file);
			}
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