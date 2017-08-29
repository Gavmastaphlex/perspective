<?php

class HomeView extends View {
        
    protected function displayContent() {


    	if($this -> pageInfo['pageContent'] == $_POST['homeText']) {
            /*
            If the user has edited the home page text, but its the same that originally came
            from the database, then just refresh the home page, theres nothing to process
            through the database
            */
    		header("location:index.php#homeContent");
    		}

    	if($_POST['updateHome']) {
            /*
            If the user has clicked the Update Content button on the home page then
            call the processUpdatePage in the model class to carry out the necessary
            validation, and subsequent insertion into the database.
            */
    		$result = $this -> model -> processUpdatePage($_GET['page'], $_POST['homeText']);

            /*
            If theres been error messages thats been generated in the validation process, then
            extract them so they can be displayed for the user.
            */
	    	if($result['errorMsg']) {
    			if(is_array($result)) {
	            extract($result);
	        	}

		    } else {
		    	header("location:index.php#homeContent");
		    }

    	}

        /*
        Using the nl2br to decode the text for the about us page so that things like paragraph
        breaks can be flawlessly interpreted.
        */
    	$pageContent = nl2br($this -> pageInfo['pageContent']);
    	$html = '';

        $html .= '<div id="homePic"></div>'."\n";

        if($_GET['edit'] && !$_POST['cancelHome']) {
            $html .= '<form id="updateHomeContent" method="post" action="'.$_SERVER['REQUEST_URI'].'">'."\n";
            /*
            If the admin has chosen to edit the content, a textbox containing the editable text are generated,
            and also an "Update" button and a "Cancel" button.
            */
            $html .= '<div id="homeContent">'."\n";
            $html .= '<p>Feel free to edit the content below, but remember that where there is a &lt;p&gt; tag, this determines a paragraph.</p>'."\n";
            $html .= '<br />'."\n";
            $html .= '<p>To make another paragraph follow this format:</p>'."\n";
            $html .= '<br />'."\n";
            $html .= '<p>&lt;p&gt;enter paragraph here&lt;/p&gt;.</p>'."\n";
            $html .= '<br />'."\n";
            $html .= '</div>'."\n";
            if(!$_POST['updateHome']) {
            	$html .= '<textarea id="homeText" name="homeText" rows="6" cols="18">'.htmlentities(stripslashes($this -> pageInfo['pageContent']),ENT_QUOTES).'</textarea> <br/>'."\n";
            } else {
            	$html .= '<textarea id="homeText" name="homeText" rows="6" cols="18">'.htmlentities(stripslashes($_POST['homeText']),ENT_QUOTES).'</textarea> <br/>'."\n";
            }
        	
        	$html .= '<p class="errorMsg">'.$errorMsg.'</p>'."\n";
        	$html .= '<div id="updateButtons">'."\n";
        	$html .= '<input id="homeUpdateBtn" type="submit" name="updateHome" value="Update" />'."\n";
        	$html .= '<a href="index.php?page=home#homeContent" id="cancelHomeUpdate">Cancel</a>'."\n";
        	$html .= '</div>'."\n";
        	$html .= '</form>'."\n";
        	$html .= '<div class="clearDiv"></div>'."\n";
        	$html .= '<div class="clearDiv"></div>'."\n";

	    } else {
	    	$html .= '<div id="homeContent">'.$pageContent.'</div>'."\n";
	    }

        /*
        If the admin is logged in, displaying a button that allows him to edit the content of the page.
        */
		if($this -> model -> adminLoggedIn && !$_GET['edit']) {
            $html .= '<a href="index.php?page=home&amp;edit=true#updateHomeContent" id="editHomeContent">Edit Content</a>'."\n";
        } 

        return $html;       
        
    }
            
        
}


?>