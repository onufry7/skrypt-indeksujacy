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
					new IndexSite($params);
					break;
				case 'project':
					$this->project($params);
					break;
				default:
					$this->error($params);
					break;
			}
		}


	// 	//Strona projektu
	// 	private function project($param)
	// 	{
			
	// 	}


	// 	//Strona błędu
	// 	private function error($param)
	// 	{
	// 		$err = new Errors($param);
	// 		return $err;
	// 	}
	}

?>