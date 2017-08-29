<?php

/*
including the addProjectView class and extending the AddProjectView since we want to
use the same form that is being generated for the Add Project View, and we pass the mode
as "Edit" rather than "Add" so that then certain parts that are preprogrammed on the
addProjectView are already adjusted.
*/
include 'views/addProjectView.php';
class EditProjectView extends AddProjectView {
    
    protected function displayContent() {
        /*
        Unsetting the $_SESSION['projectID'] which might still be active
        from a previous project we've edited
        */
        unset($_SESSION['projectID']);

        $html = '<div class="content" id="addEditProjectContent">'."\n";
        
        /*
        Checking to see if the adminLoggedIn value is true, as if it is
        false, then the user is not authorized to view the page.
        */
        if(!$this -> model -> adminLoggedIn) {
            $html .= '<p>Sorry, but this is a restricted page.</p>';
            return $html;
        }
        
        $html .= '<h2>'.$this -> pageInfo['pageHeading'].'</h2>';
        
        if($_POST['Edit']) {
            /*
            If the user has clicked the Edit button, storing the values from $_POST into
            the $project variable so that then the values can be prepopulated in the case that
            there was validation errors (this is how we make the form sticky), and then calling
            the processUpdateProject function that is in the model class to validate the inputs
            before they're inserted into the database
            */
            $project = $_POST;
            $result = $this -> model -> processUpdateProject();


            if($result['ok']) {
                /*
                If everything went ok, then storing the projectID into $_SESSION, so that
                when the user is redirected to the Project view, we can display the project
                details straight after it has been updated.
                */
                $_SESSION['projectID'] = $_GET['projectID'];
                header("location:index.php?page=project&projectUpdate=true#updateSuccess");
            }
        
        //otherwise grab the information from the database
        } else {
            /*
            If $_POST['Edit'] is false then we know that this is the first time the user
            has visited the Edit page of a particular product, therefore we need to go about
            pulling all the project details from the database in order to prepopulate all the
            input fields with the current project details.
            */
            $project = $this -> model -> getProjectByID($_GET['projectID']);
        }
        
            /*
            Calling the displayProjectForm function that was originally initiated in the
            addProjectView, and passing it the mode (in this case Edit since we want to
            call the Edit Project Form) $result (which is any validation errors that have
            come up in attempting to edit the project) and $project (which is either all
            the project details that have come straight from the database on the first time
            the user has opened the page, or the values that have been passed)
            */
        $html .= $this -> displayProjectForm('Edit', $result, $project);
        return $html;
    }
    
}


?>