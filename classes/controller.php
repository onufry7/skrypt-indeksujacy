<?php

	class Controller
	{
		public function __construct($site)
		{
			list($methode, $params) = $site;
			//Wczytuje odpowiednią do strony metodę
			switch ($methode) 
			{
				case 'index':
					$this->index($params);
					break;
				case 'project':
					$this->project($params);
					break;
				default:
					$this->error($params);
					break;
			}
		}


		//Strona główna
		private function index($page)
		{
			if(is_null($page)) $page = 1;
			$projects = new Projects();
			$projectsList = $projects->getProjectsList();

			$pagin = new Paginate(count($projectsList), $page);
			list('from'=>$from, 'to'=>$to) = $pagin->getFromTo();
			$fromTo = $projects->getFromToProjects($from, $to);

			echo '<br><pre>';
			//echo '<br>'.$from.' '.$to.'<br>';
			echo '<br> ---------------------- <br>';
			print_r($fromTo);
			echo '<br> ---------------------- <br>';
			//print_r($projectsList);
			echo '</pre><br>';
		}


		//Strona projektu
		private function project($param)
		{
			
		}


		//Strona błędu
		private function error($param)
		{
			$err = new Errors($param);
			echo $err;//->getMessage();
		}
	}

?>