<?php 

	 class IndexSite extends Site
	 {
	 	private $_title = 'Burnejko - lista projektów';
	 	private $_header = 'Moje Projekty';

	 	public function __construct($page)
	 	{
	 		parent::__construct($this->_header, $this->_title);

	 		$projectsList = $this->getProjectsList($page);

			if(!empty($projectsList))
			{
				$list = $this->createViewList($projectsList);
				$pagination = '<< < 1 | 2 | 3 > >>';
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
			$pagin = new Paginate();
			$pagin->generatePagination($count, $page);
			$projectsList = $projects->getFromToProjects($pagin->getFromTo());
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