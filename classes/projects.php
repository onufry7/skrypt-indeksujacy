<?php

class Projects
{
	private $_listProjectss = null; //Lista projektów


	public function __construct()
	{
		$this->_listProjects = $this->projectsList();
	}


	//Wszystkie projekty
	public function getProjectsList()
	{
		return $this->_listProjects;
	}


	//Zwraca liczbę projektów
	public function countProjects()
	{
		$count = count($this->_listProjects);
		return $count;
	}


	//Wybrane projekty
	public function getFromToProjects($limit)
	{
		$result = [];
		for($i=$limit['from']; $i<=$limit['to']; $i++) 
		{
			$result[$i] = $this->_listProjects[$i];
		}
		return $result;
	}


	//Tworzy listę wszystkich projektów
	private function projectsList()
	{
		$marks = array("-","_"); // Znaki które zostana zamienione na spacje, w nazwie
		$i = 0; //Liczba projektów
		$list = [];

		foreach(glob('projects/*', GLOB_ONLYDIR) as $folder)
		{
			//Ustawienie opisu
			if(!file_exists("$folder".'/info.txt') || filesize("$folder".'/info.txt') <= 0) $list[$i]['info'] = '';
			else $list[$i]['info'] = rtrim(file_get_contents("$folder".'/info.txt'),"\n") ;
			
			//Ustawienie nazwy projektu
			$list[$i]['name'] = substr(str_replace($marks," ",$folder), 9);

			//Ustawienie linku
			$list[$i]['link'] = substr($folder, 9);
			
			$i++;

			clearstatcache();
		}	
		return $list;
	}
}

?>