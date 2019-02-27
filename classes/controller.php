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
				default:
					new ErrorSite($params);
					break;
			}
		}
	}

?>