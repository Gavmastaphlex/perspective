<?php

session_start();

include 'views/viewClass.php';
include 'classes/modelClass.php';

class PageSelector {
	//this class decides what page information to display via index.php

	//check to see if the user has decided which page to go to

		public function run() {

		if(!$_GET['page']) {
			$_GET['page'] = 'home';
		}

		
		/*If $_GET['page'] is false, then that signifies that there is nothing
		in the $_GET variable due to the user not selecting a link that would then
		fill that variable, so we can safely assume that the user has visited the site
		for the first time in this session and thus we will display the home page*/

		$model = new Model;

		$pageInfo = $model -> getPageInfo($_GET['page']);
		
			switch($_GET['page']) {

				case 'home':
					include 'views/homeView.php';
					$view = new HomeView($pageInfo, $model);
					break;
				case 'projects':
					include 'views/projectsView.php';
					$view = new ProjectsView($pageInfo, $model);
					break;
				case 'about':
					include 'views/aboutView.php';
					$view = new AboutView($pageInfo, $model);
					break;
				case 'contact':
					include 'views/contactView.php';
					$view = new ContactView($pageInfo, $model);
					break;
				case 'sitemap':
					include 'views/sitemapView.php';
					$view = new SitemapView($pageInfo, $model);
					break;
				case 'project':
					include 'views/projectView.php';
					$view = new ProjectView($pageInfo, $model);
					break;
				case 'addProject':
					include 'views/addProjectView.php';
					$view = new AddProjectView($pageInfo, $model);
					break;
				case 'editProject':
					include 'views/editProjectView.php';
					$view = new EditProjectView($pageInfo, $model);
					break;
				case 'login':
				case 'logout':
				case 'admin':
					include 'views/adminView.php';
					$view = new AdminView($pageInfo, $model);
					break;
				case 'access':
					include 'views/accessView.php';
					$view = new AccessView($pageInfo, $model);
					break;
			}

			echo $view -> displayPage();
	}

}

$pageSelect = new PageSelector();
$pageSelect -> run();

?>