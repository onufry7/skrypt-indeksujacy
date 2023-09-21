<?php 

	class Site 
	{
		private $_masterTemplate = '';

		public function __construct($header, $title = 'Projekty - Szymon B.')
		{
			$projects = new Projects();
			$count = $projects->countProjects();

			$search = ['{{ TITLE }}', '{{ HEADER }}', '{{ COUNT-PROJECTS }}', '{{ YEAR }}'];
			$replace = [$title, $header, $count, date("Y")];

			$view = new View;
			$template = $view->getView();
			
			$masterTemplate = str_replace($search, $replace, $template);

			$this->setMasterTemplate($masterTemplate);
		}



		//Ustawia główny szablon
		private function setMasterTemplate($src)
		{
			$this->_masterTemplate = $src;
		}



		//Pobiera główny szablon
		private function getMasterTemplate()
		{
			return $this->_masterTemplate;
		}


		//Zwraca widok głównej strony
	 	protected function getMasterView($content)
	 	{
			$masterView = $this->getMasterTemplate();
			return str_replace('{{ CONTENT }}', $content, $masterView);
	 	}

	} 

?>