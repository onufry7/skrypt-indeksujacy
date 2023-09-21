<?php 

	 class IndexSite extends Site
	 {
	 	private $_title = 'Burnejko - Portfolio';
	 	private $_header = 'Moje Projekty';
	 	private $_pagin;

	 	public function __construct($page)
	 	{
	 		parent::__construct($this->_header, $this->_title);

	 		$this->_pagin = new Paginate();
	 		$projectsList = $this->getProjectsList($page);

			if(!empty($projectsList))
			{
				$pagination = $this->_pagin->getPanel();
				$list = $this->createViewList($projectsList);
				$content = $this->createViewIndex($list, $pagination);
			}  
			else $content = $this->createViewEmpty();

			$view = new View;
			$view->renderView($this->getMasterView($content));
	 	}


	 	//Pobiera listę projektów
	 	private function getProjectsList($page)
	 	{
	 		$projects = new Projects;
			$count = $projects->countProjects();
			if(is_null($page)) $page = 1;
			$this->_pagin->generatePagination($count, $page);
			$projectsList = $projects->getFromToProjects($this->_pagin->getFromTo());
			return $projectsList;
	 	}


	 	//Tworzy widok listy projektów
	 	private function createViewList($projectsList)
	 	{
	 		$view = new View;
	 		$listView = $view->getView('project-list');
	 		$search = ['{{ LINK }}', '{{ NAME }}', '{{ INFO }}'];
	 		$content = '';

	 		foreach ($projectsList as $key => $value) 
	 		{
	 			$replace = [
	 				$projectsList[$key]['link'], 
	 				$projectsList[$key]['name'], 
	 				$projectsList[$key]['info']
	 			];
	 			$content .= str_replace($search, $replace, $listView);
	 		}
			return $content;
	 	}



	 	//Tworzy widok braku projektów
	 	private function createViewEmpty()
	 	{
	 		$view = new View;
			$emptyView = $view->getView('empty-list');
			$message = 'Obecnie brak projektów!';
			$content = str_replace('{{ CONTENT }}', $message, $emptyView);
			return $content;
	 	}


	 	//Tworzy widok głównego kontentu
	 	private function createViewIndex($list, $pagination)
	 	{
			$view = new View;
			$listView = $view->getView('index-list');
			$search = ['{{ LIST }}', '{{ PAGINATION }}'];
			$replace = [$list, $pagination];
			$content = str_replace($search, $replace, $listView);
			return $content;
	 	}

	 }

?>