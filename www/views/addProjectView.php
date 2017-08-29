<?php

class AddProjectView extends View {
        
    protected function displayContent() {

        /*
        Starting the div for the content for this page.
        */
    	$html .= '<div class="content" id="addEditProjectContent">'."\n";
        
        /*
        Checking straight away if the adminLoggedIn value is true since it
        is only admin that can view this page. If this value is false, then
        viewing a message to say that the user is not authorized to view this page.
        */
        if(!$this -> model -> adminLoggedIn) {
            $html .= '<p>Sorry, but this is a restricted page</p>';

            /*
            Returning $html stops the rest of the code from going into
            operation.
            */
            return $html;
        }
        
        $html .= '<h2>'.$this -> pageInfo['pageHeading'] .'</h2>';
        
           
        if($_POST['Add']) {
             /*
            If the "Add Project" button is pressed, then running the processAddProject
            function in the model class that validates all the inputted values before
            inserting the information into the database class.
            */            
            $result = $this -> model -> processAddProject();

        }       
        
        if($result['ok']) {
             /*
            If everything went ok redirect to the admin page
            */     
            header("location:index.php?page=admin&projectUpload=true");

            
        } else {
             /*
            If $result['ok'] isn't true, (which either means its the users first time
            to the page, or if they submitted the Add Project form and it didn't validate)
            then we'll display
            */ 
            $html .= $this -> displayProjectForm('Add', $result, $_POST);
        }
        
        
        return $html;  
      
    }

    	protected function displayProjectForm($mode, $result, $project) {
            /*
            If $result is an array, then this means that there are validation errors to display.
            By extracting the results, we take out the need to put $result at the start of each
            time we call an error message
            */ 
        if(is_array($result)) {
            extract($result);
        }
        
        /*
        $project will have values if we're editing a project. The values will then prepopulate
        all the input fields.
        */ 
        extract($project);


        if($_GET['projectID']) {
            $projectID = $_GET['projectID'];
        }
        
        /*
        generating the form.
        */ 
    	$html .= '<form id="edit_form" method="post" action="'.$_SERVER['REQUEST_URI'].'" enctype="multipart/form-data">'."\n";
    	$html .= '<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />';
        $html .= '<input type="hidden" name="projectID" value="'.$projectID.'" />';
        $html .= '<input type="hidden" name="projectImage" value="'.$projectImage.'" />';
        $html .= '<div id="addEditForm">'."\n";
    	$html .= '<p>'."\n";
    	$html .= '<label for="projectHeading">Project Heading</label>'."\n";
        /*
        ENT_QUOTES Will convert both double and single quotes to stop them escaping the string, stripslahes ensure that slashes that
        are inputted into the database to handle quotes and other characters are stripped to ensure the normal viewing of such characters,
        and htmlentities encapsulates the previous functions.

        */
    	$html .= '<input name="projectHeading" id="projectHeading" type="text" placeholder="Project Heading..." value="'.htmlentities(stripslashes($projectHeading),ENT_QUOTES).'" /> <br/>'."\n";
    	$html .= '</p>'."\n";

        /*
        If its been detected the user is using a Mobile, then by generating a clearing Div
        after each element, we make all the elements appear stacked and easier to display
        on a narrower screen.
        */
        if (!$this -> model -> mobileDetect && !$this -> model -> tabletDetect) {
            $html .= '<div class="clearDiv"></div>'."\n";
        }

        /*
        The error messages are stored in the span tags and are the values that have been extracted from $result
        */ 
        $html .= '<span>'.$pHeadingMsg.'</span>'."\n";

        if (!$this -> model -> mobileDetect && !$this -> model -> tabletDetect) {
            $html .= '<div class="clearDiv"></div>'."\n";
        }

    	$html .= '<p>'."\n";
    	$html .= '<label for="projectDescription">Project Description</label>'."\n";
    	$html .= '<textarea id="projectDescription" name="projectDescription" rows="6" cols="18">'.htmlentities(stripslashes($projectDescription),ENT_QUOTES).'</textarea> <br/>'."\n";
    	$html .= '</p>'."\n";

        if (!$this -> model -> mobileDetect && !$this -> model -> tabletDetect) {
            $html .= '<div class="clearDiv"></div>'."\n";
        }

        $html .= '<span>'.$pDescMsg.'</span>'."\n";

        if (!$this -> model -> mobileDetect && !$this -> model -> tabletDetect) {
            $html .= '<div class="clearDiv"></div>'."\n";
        }

        $html .= '<p>'."\n";

        $html .= '<label>Category</label>'."\n";
        $html .= '<select id="projectCategory" name="projectCategory">'."\n";
        $html .= '<option value="0">Please select...</option>'."\n";

        /*
        Pulling the categories from the database, then using a foreach loop in order
        to display the options in a dropdown box for the user to select.
        */
        $categories = $result = $this -> model -> getCategoryDetails();

        foreach($categories as $category) {
            $html .= '<option value = "'.$category['categoryID'].'"';

            /*
            If $projectCategoryis true, then this would mean that there is a project that is being
            edited, and when the current projects category matches its category that is being pulled
            from the database, the word "selected" will be generated and then that value will prepopulate
            when the user is editing the appropriate project.
            */
            if($category['categoryID'] == $projectCategory) {
                $html .= ' selected ';
            }

            $html .= '>'.$category['categoryName'].'</option>'."\n";
            
        }

        $html .= '</select>'."\n";
        $html .= '</p>'."\n";

        if (!$this -> model -> mobileDetect && !$this -> model -> tabletDetect) {
            $html .= '<div class="clearDiv"></div>'."\n";
        }

        $html .= '<span>'.$pCategoryMsg.'</span>'."\n";


    	$html .= '<p>'."\n";
        $html .= '<div class="clearDiv"></div>'."\n";
    	$html .= '<label>';

        /*
        If the user is editing an existing project, then highlighting the fact that there
        should already be a project photo stored and currently being displayed, and that if
        another image was uploaded this would indeed be a "New" image.
        */
        if($mode == 'Edit') {
            $html .= 'New ';
        }
        

        $html .= 'Project Image (5mb limit)</label>'."\n";

    	$html .= '<input name="projectImage" type="file" /> <br/>'."\n";

        /*
        Checking to see if the value $project['projectImage'] is true, which would
        mean that we are editing an existing project, so there must be an image to
        display, and the following code will display that image.
        */
    	if($project['projectImage']) {
            $html .= '<div class="clearDiv"></div>'."\n";
            $html .= '<div id="existingImage">';
            $html .= '<p>Existing Image</p>';
            $html .= '<img src="uploads/thumbnails/'.$projectImage.'" /></div>';
        } 

    	$html .= '</p>'."\n";
        $html .= '<div class="clearDiv"></div>'."\n";
        $html .= '<span>'.$pImageMsg.'</span>'."\n";
        $html .= '<span>'.$uploadMsg.'</span>'."\n";

        if (!$this -> model -> mobileDetect && !$this -> model -> tabletDetect) {
            $html .= '<div class="clearDiv"></div>'."\n";
        }

        

        $html .= '<div class="clearDiv"></div>'."\n";

        $html .= '</div>'."\n";
    	$html .= '<div id="submit">'."\n";
        /*
        Changing the value of the Button depending on what mode the user currently is in.
        */        
    	$html .= '<input id="'.$mode.'Btn" type="submit" name="'.$mode.'" value="'.$mode.'" />'."\n";
    	$html .= '</div>'."\n";
    	$html .= '<div class="clearDiv"></div>'."\n";
    	$html .= '</form>'."\n";

    	$html .= '</div>'."\n";

        
        return $html;
        
        
    }
            
        
}


?>