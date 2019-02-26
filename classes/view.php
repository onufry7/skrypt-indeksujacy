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

//---------------------------------------------------------------------------------------------------
		//Widok głównej strony
		public function viewIndex($content, $page)
		{
			$list = $this->viewList($content);

			$find = ['{{ LISTA }}','{{ PAGINACJA }}'];
			$replace = [$list, $page];
			$view = str_replace($find, $replace, $this->_master);
			$this->renderView($view);
		}


		//Widok listy projektów
		private function viewList($content)
		{
			$view = '<table><tr><th>Nazwa projektu*</th><th>Opis</th></tr>';
			foreach ($content as $key => $value) 
			{
				$view .= '<tr><td><a href="'.$content[$key]['link'].'" title="Otwórz projekt" target="_blank">';
				$view .= '<img src="img/folder.png" width="22" height=22" alt="=>">';
				$view .= '<span>'.$content[$key]['name'].'</span></a></td>';
				$view .= '<td class="info">'.$content[$key]['info'].'</td></tr>';
			}
			$view .= '</table>';
			return $view;
		}


		//Widok Projektu
		private function viewProject($content)
		{
			;
		}


		//Widok panelu paginacji
		private function viewPagination()
		{
			;
		}


		//Widok panelu paginacji
		private function view404($err)
		{
			return $err;
		}

//---------------------------------------------------------------------------------------------------
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