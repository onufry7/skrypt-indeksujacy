<?php

	class Router
	{
		private $_host = 'portfolio.loc'; //adres strony


		public function __construct()
		{
			$url = $this->getUrl();
			//Sprawdzamy pobrany url
			if($this->checkUrl($url['host'], $url['uri']))
				$date = $this->prepareUri($url['uri']);//Porównanie urla z wzorcami stron
			else $date = ['index', null];	//Wczytuje zestaw danych domyślnej srony
			new Controller($date); //Wczytanie odpowiedniej funkcji kontrolera
		}
		

		//Pobiera adres url
		private function getUrl()
		{			
			$url['host'] = $_SERVER['HTTP_HOST'];
			$url['uri'] = $_SERVER['REQUEST_URI'];
			return $url;
		}


		//Sprawdza pobrany url
		private function checkUrl($host, $uri)
		{
			if($host == $this->_host && !empty($uri) && $uri != '/') return true;
			else return false;
		}


		//Przekształca url do tablicy z parametrami (metoda, parametry).
		//W zależności od otrzymanego urla tworzy odpowiedni zestaw danych.
		private function prepareUri($uri)
		{
			$uri = trim($uri, '/');
			if(count(explode('/', $uri))==1)
			{
				if(preg_match('/^[0-9]+$/', $uri)) return array('index', $uri);
				if(preg_match('/^blad404$/', $uri)) return array('error', 404);
				if(preg_match('/^blad$/', $uri)) return array('error', $uri);
			}
			return header('Location: https://'.$this->_host.'/blad404');	
		}

	}

?>