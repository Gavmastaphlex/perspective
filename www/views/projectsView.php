<?php

class ProjectsView extends View {

    
            
    protected function displayContent() {
        /*
        Unsetting the value $_SESSION['projectID'] which would have been set had the
        user edited a project
        */
        unset($_SESSION['projectID']);

        /*
        If $_GET['confirmDelete'] is true, then the user has confirmed the deletion of a project and the processDeleteProject
        is run from the model class, and if it is successful and $deleteProject has a true value, a success message is generated
        for the user.
        */
        if($_GET['confirmDelete'] == 'true' && $this -> model -> adminLoggedIn) {
                    $deleteProject = $this -> model -> processDeleteProject($_GET['projectID']);
                    if ($deleteProject) {
                        $html .= '<div id="updateSuccess">'."\n";
                        $html .= '<h3>Your project has been deleted!</h3>'."\n";
                        $html .= '</div>'."\n";
                    }
                }

        $html .= '<div class="content" id="projectsContent">'."\n";

        $html .= '<div id="gallery">'."\n";
        $html .= '<div id="category">'."\n";
        /*
        Getting the categories from the database so as to generate the Navigation menus.
        */
        $categories = $result = $this -> model -> getCategoryDetails();

        /*
        Running a foreach loop in order to generate each category into a list item.
        */
        foreach($categories as $category) {
            $html .= '<a href="index.php?page=projects&amp;category='.$category['categoryID'].'#categoryHeading">'.$category['categoryNav'].'</a>'."\n";
        }

        $html .= '<div class="clearDiv"></div>'."\n";
        $html .= '</div>'."\n";
        
        /*
        If no category has been chosen, then we know that its the users first time visiting the page
        and therefore we automatically cause them to view the first category, which is bathrooms.
        */
        if(!$_GET['category']) {
            $category = '1';
        } else {
            $category = $_GET['category'];
        }

        $_SESSION['category'] = $category;

        /*
        Then we get the chosen categories name from the database to view that as the current pages heading.
        */
        $selectedCategory = $result = $this -> model -> getCategoryNameByID($category);

        $html .= '<h2 id="categoryHeading">'.$selectedCategory['categoryName'].' Photos</h2>'."\n";

        $html .= '<div id="projectPhotos">'."\n";

        //-----------------PAGINATION CODE BELOW-------------------------

            //instantiating the limit for the projects to display on the page
        if(!$this -> model -> mobileDetect) {
            $limit = 9;
        } else {
            $limit = 6;
        }

            if(isset($_GET['pageNum'])) {
                /*if $_GET['pageNum']) is set, by multiplying that page number with the limit we
                previously set we get the last project that will be displayed on that page, and then
                by subtracting the limit from that returned amount, we get the project number that
                is the first project to be displayed on that page*/
                $start = $_GET['pageNum'] * $limit - $limit;
                $page = $_GET['pageNum'];

            } else {
                /*if $_GET['pageNum']) is not set, then it must be the users first time coming to the
                the page, so we set the first project to be displayed as 0 and page number 1 to be the
                page to be displayed*/
                $start = 0;
                $page = 1;
            }

            //calling the function to see the total of number of projects in the database
            $projectCount = $this -> model -> countProjects($category);

            //storing that value in the $totalNumprojects variable
            $totalNumProjects = $projectCount[0]['count(projectID)'];

            /*
            using the variables that were instantiated previously to only return a range of projects that
            will then be displayed on the projects Page that is in line with the limit that was previously
            set
            */
            $this -> projects = $this -> model -> getProjects($start, $limit, $category);

            //Checking to see that there was projects to display, and then running the function to display the returned projects
            if(is_array($this -> projects)) {
                $projectInfo = $this -> projects;
                
                foreach($projectInfo as $project) {
                    
                        $html .= '<a href="index.php?page=project&amp;projectID='.$project['projectID'].'#projectContent" class="projectLink"><img src="uploads/thumbnails/'.$project['projectImage'].'" alt="'.$selectedCategory['categoryName'].' picture, '.htmlspecialchars($project['projectHeading']).'" class="projectPic" /></a>'."\n";
                }

            } else {
                //for some reason there was no projects returned, informing the user that this is the case

                $html .= '<div id="searchSummary">'."\n";
                $html .= '<h3>Sorry, there are no projects here! Please try another category.</h3>';
                $html .= '<img src="images/projects/noProjects.jpg" alt="No Projects Photo" id="noProjectsPhoto">'."\n";

            }

            $html .= '<div class="clearDiv"></div>'."\n";
            

            
            if(!$this -> model -> mobileDetect) {

                    if($totalNumProjects > 9) {
                        /*
                        If the user is not using a mobile phone then we set the limit of
                        projects to be displayed as 9.
                        */

                        $numProjectsSelected = count($projectsSelected);
                        $html .= $this -> displayPageNumbers($totalNumProjects, $category);

                        } else {
                            unset($_SESSION['pageNum']);
                        }

                    } else {
                        if($totalNumProjects > 6) {
                            /*
                            If the user is using a mobile phone then we set the limit of
                            projects to be displayed as 6, just to make the amount of
                            information we send to a phone to be more manageable.
                            */
                        $numProjectsSelected = count($projectsSelected);
                        $html .= $this -> displayPageNumbers($totalNumProjects, $category);

                        } else {
                            unset($_SESSION['pageNum']);
                        }
                }
            
            
            $html .= '</div>'."\n";
            $html .= '<div class="clearDiv"></div>'."\n";
            $html .= '</div>'."\n";
            $html .= '</div>'."\n";

           return $html;
    }


    private function displayPageNumbers($numProjects, $category) {

        /*
        Now we want to generate the page numbers so that when there is more than 12 projects to display
        the user can decide which range they want to view by selecting the page link.
        */

        //first we set the project limit for each page. (9 for non-mobile, or 6 for mobile)
        if(!$this -> model -> mobileDetect) {
            $limit = 9;
        } else {
            $limit = 6;
        }
        
        /*
        if $_GET['pageNum'] is false, then it will be the users first time to the page so we automatically write
        the code so that they end up naturally on the first page
        */
        if(!$_GET['pageNum']) {
            $pageNum = 1;

        } else {
            /*
            if $_GET['pageNum'] is true, then they have clicked one of the page numbers and we now need to use the number
            obtained from the $_GET array to make sure the user views the right page, so we store it in the $_SESSION since
            this will be a value that may change as they go between different pages, and having the value stored in the session
            array will mean that if the user goes into a project, we can keep track of what page they were on and thus have them
            go back to that page when the go back to the projects view
            */
            $pageNum = $_GET['pageNum'];
        }

        $_SESSION['pageNum'] = $pageNum;

        /*
        By dividing the variable $numprojects (that is a required parameter to run this function) by the limit that we have previously set,
        AND THEN run that through the preprogrammed "ceil" function (which rounds the answer up the nearest whole number) we obtain the
        total of number of pages that there is going to be.
        */
        $pageAmount = ceil($numProjects / $limit);

        $html .= '<div id="pageNumbers">'."\n";

        $html .= '<ul>'."\n";

        /*
        Coding the quicklink <<Previous. As long as the user isn't on the first page (because there is no page before page 1!) the
        word "Previous" will appear to the left of the generated page numbers and the pagenumber that it will link to will always
        be configured to be one less than the pageNum that the user is currently on.
        */
        if($pageNum != 1) {

            $previousPage = $pageNum - 1;
            $html .= '<li><a href="index.php?page=projects&amp;category='.$category.'&amp;pageNum='.$previousPage.'#categoryHeading">Previous</a></li>'."\n"; 
        
        }

        //initial, begin at 1 because you can't have 0 pages, always at least 1 page
        //conditional
        //incremental $i - goes up by one at a time ($i = $i + 2) - going up by two at a time
        for($i = 1; $i <= $pageAmount; $i++) {


                if($i == $pageNum) {
                    $html .= '<li>'.$i.'</li>'."\n";
                } else {
                    $html .= '<li><a href="index.php?page=projects&amp;category='.$category.'&amp;pageNum='.$i.'#categoryHeading">'.$i.'</a></li>'."\n";
                }

        }

        /*
        Coding the quicklink Next>>. As long as the user isn't on the last page (because there is no page after the last page) the
        word "Next" will appear to the right of the generated page numbers and the pagenumber that it will link to will always
        be configured to be one more than the pageNum that the user is currently on.
        */
        if($pageNum != $pageAmount) {
            $nextPage = $pageNum + 1;

                $html .= '<li><a href="index.php?page=projects&amp;category='.$category.'&amp;pageNum='.$nextPage.'#categoryHeading">Next</a></li>'."\n";
            
        }

        $html .= '</ul>'."\n";
        $html .= '</div>'."\n";

        return $html;
    }
            
        
}


?>