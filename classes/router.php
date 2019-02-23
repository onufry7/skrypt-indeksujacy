<?php

	class Router
	{
		protected $_host = 'projektownik.loc'; //adres strony


		public function __construct()
		{
			$url = $this->getUrl();
			//Sprawdzamy pobrany url
			if($this->checkUrl($url['host'], $url['uri']))
			{
				$date = $this->prepareUri($url['uri']);//Przygotowuje parametry dla f. loadClass
				$this->loadClass($date['class'], $date['methode'], $date['param']); //Wczytuje klase, metodę
			}
			else $this->loadClass('Controller', 'index', '1');	//Wczytuje zestaw danych domyślnej srony
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


		//Ładuje odpowiednią klasę i metodę z parametrami
		private function loadClass($class, $methode = null, $param = null)
		{
			$class = new $class;
			if($methode != null && $param != null)
			{
				$params[] = $param;
				call_user_func_array(array($class, $methode),$params);
			}
			else if($methode != null) $class->$methode();
		}
		

		//Przekształca url do tablicy z parametrami (klasa, metoda, parametry).
		//W zależności od otrzymanego urla tworzy odpowiedni zestaw danych.
		private function prepareUri($uri)
		{
			$uri = trim($uri, '/');
			if(count(explode('/', $uri))==1)
			{
				if(preg_match('/^[0-9]+$/', $uri)) 
					return array('class'=>'Controller', 'methode'=>'index', 'param'=>$uri);

				if(preg_match('/^[a-zA-Z0-9-_]+$/', $uri)) 
					return array('class'=>'Controller', 'methode'=>'project', 'param'=>$uri);
			}		
			return array('class'=>'Controller', 'methode'=>'error', 'param'=>'404');
		}

	}

?>