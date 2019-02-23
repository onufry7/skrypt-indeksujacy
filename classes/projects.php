<?php

class Projects
{
	private $_listProjects = null; //Lista projektów


	public function __construct()
	{
		$this->_listProjects = $this->projectsList();

		/*echo '<br><pre>';
		print_r($this->_listProjects) ;
		echo '<br></pre>';*/

	}


	//Pojedyńczy projekt
	public function project($name)
	{
		echo 'Klasa Projects -> project <br>';
		if($name != null) echo $name;
	}


	//Wszystkie projekty
	public function allProjects($page)
	{
		$paginate = new Paginate(count($this->_listProjects), $page);
		//echo '<br>'.$page.' - '.count($this->_listProjects).'<br>';
	}


	//Tworzy listę wszystkich projektów
	protected function projectsList()
	{
		$marks = array("-","_"); // Znaki które zostana zamienione na spacje, w nazwie
		$i = 0; //Liczba projektów

		foreach(glob('projects/*', GLOB_ONLYDIR) as $folder)
		{
			//Ustawienie opisu
			if(!file_exists("$folder".'/info.txt') || filesize("$folder".'/info.txt') <= 0) $list[$i]['info'] = '';
			else $list[$i]['info'] = rtrim(file_get_contents("$folder".'/info.txt'),"\n") ;
			
			//Ustawienie nazwy projektu
			$list[$i]['name'] = str_replace($marks," ",$folder);

			//Ustawienie linku
			$list[$i]['link'] = $folder;
			
			$i++;

			clearstatcache();
		}	
		return $list;
	}
}

?>