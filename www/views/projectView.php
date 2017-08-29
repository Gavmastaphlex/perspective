<?php

class ProjectView extends View {
    
    protected function displayContent() {

        if($_SESSION['projectID']) {
            $_GET['projectID'] = $_SESSION['projectID'];
        } 

            $this -> project = $this -> model -> getProjectByID($_GET['projectID']);
            
            /*if an array is returned the query successfully ran and then that recipe information is returned so as to display it,
            but if it isn't an array, then the recipe wasn't found in the the database and an appropriate message is displayed.*/
            if(is_array($this -> project)) {                

                if($_GET['projectUpdate'] == true) {
                    $html .= '<div id="updateSuccess">'."\n";
                    $html .= '<h3>Your project has been updated!</h3>'."\n";
                    $html .= '</div>'."\n";
                }

                $html .= '<div class="content" id="projectContent">'."\n";

                $html .= '<h3>'.$this -> project['projectHeading'].'</h3>'."\n";

                $filename = 'uploads/'.$this -> project['projectImage'].'';

                /*
                If the user is using a mobile or a tablet, rather than sending them the full sized image
                which might be too much to handle, sending them just the thumbnail picture instead.
                */
                if (!$this -> model -> mobileDetect && !$this -> model -> tabletDetect) {
                    $html .= '<img src="uploads/'.$this -> project['projectImage'].'" alt="Bathroom Picture">'."\n";
                } else {
                    $html .= '<img src="uploads/thumbnails/'.$this -> project['projectImage'].'" alt="Bathroom Picture">'."\n";
                }

                /*
                Using the nl2br to decode the text for the about us page so that things like paragraph
                breaks can be flawlessly interpreted.
                */
                $projectDescription = nl2br($this -> project['projectDescription']);

                $html .= '<p>'.$projectDescription.'</p>'."\n";

                /*
                If the admin has clicked delete, a confirmation box is generated which gives the user the option to
                cancel the delete process or confirm it. 
                */
                if($_GET['delete'] && $this -> model -> adminLoggedIn) {
                    $html .= '<div id="deletionBox">'."\n";
                    $html .= '<h4>Are you sure you want to delete this project?</h4>'."\n";
                    $html .= '<a href="index.php?page=project&amp;projectID='.$_GET['projectID'].'#projectContent" id="cancelDeletionBtn">Cancel</a>'."\n";
                    $html .= '<a href="index.php?page=projects&amp;projectID='.$_GET['projectID'].'&amp;confirmDelete=true&amp;category='.$_SESSION['category'].'#categoryHeading" id="confirmDeletionBtn">Confirm Deletion</a>'."\n";
                    $html .= '<div class="clearDiv"></div>'."\n";
                    $html .= '</div>'."\n";
                }

                /*
                If the admin is logged on, two extra buttons will be visible to them that is not
                visible to any visitor to the page - an "Edit Button" and a "Delete Button"
                */
                if(!$_GET['delete'] && $this -> model -> adminLoggedIn) {
                    $html .= '<div id="adminOptionsBox">'."\n";
                    $html .= '<a href="index.php?page=editProject&amp;projectID='.$_GET['projectID'].'#addEditProjectContent" id="editProjectBtn">Edit Project</a>'."\n";
                    $html .= '<a href="index.php?page=project&amp;projectID='.$_GET['projectID'].'&amp;delete=true#deletionBox" id="deleteProjectBtn">Delete Project</a>'."\n";
                    $html .= '<div class="clearDiv"></div>'."\n";
                    $html .= '</div>'."\n";
                }

                /*
                This code generates a "Back to Projects" button as long as the Admin hasn't clicked the Delete Project button. There are two
                lines of code here, in case the user came from a Project Photos screen that was incorporating page numbers, to ensure that the
                user is directed back to the appropriate page number.
                */
                if(!$_GET['delete']) {
                    if(!$_SESSION['pageNum']) {
                        $html .= '<a href="index.php?page=projects&amp;category='.$_SESSION['category'].'#categoryHeading" id="backToProjectsBtn">Back to Projects</a>'."\n";
                    } else {
                        $html .= '<a href="index.php?page=projects&amp;category='.$_SESSION['category'].'&amp;pageNum='.$_SESSION['pageNum'].'#categoryHeading" id="backToProjectsBtn">Back to Projects</a>'."\n";
                    }
                }

                $html .= '</div>'."\n";
                $html .= '<div class="clearDiv"></div>'."\n";               

            } else {
                /*
                This code is in case anyone tries to view a project number that doesn't exist by altering the $_GET array.
                */
                $html = '<h2>Oh no!</h2>'."\n";
                $html .= '<div id="searchSummary">'."\n";
                $html .= '<p>Sorry, that project doesn\'t exist!</p>';
                $html .= '<a href="index.php?page=projects">Back to Projects</a>'."\n";
                $html .= '</div>'."\n";
            }
        
    
        return $html;
        
        
    }


}


?>
