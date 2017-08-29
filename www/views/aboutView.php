<?php

class AboutView extends View {
        
    protected function displayContent() {

        /*
        If the admin has updated the text on the about us page and then clicked the finalizing
        button, first checking if the new text is exactly the same as the text originally
        retrieved from the database. If it is, then nothing needs to go through the database. But
        if it doesn't match then calling the function on the model class to do the necessary validating
        and then afterwards checking to see  what the result was.
        */
    	if($_POST['updateAbout']) {

	    		if($this -> pageInfo['pageContent'] == $_POST['aboutText']) {
	    			header("location:index.php?page=about#aboutContent");
	    		}

    			$result = $this -> model -> processUpdatePage($_GET['page'], $_POST['aboutText']);
			
				if(is_array($result)) {
		            extract($result);
		       	}

			    if($ok) {
			    	header("location:index.php?page=about#aboutContent");
			    }
		    }

        /*
        Using the nl2br to decode the text for the about us page so that things like paragraph
        breaks can be flawlessly interpreted.
        */
        $pageContent = nl2br($this -> pageInfo['pageContent']);

        /*
        Calling the page heading from the database
        */
        $html = '<h2>'.$this -> pageInfo['pageHeading'].'</h2>'."\n";
        $html .= '<div class="content" id="aboutContent">'."\n";
        $html .= '<br />'."\n";

        /*
        If the admin has chosen to edit the content, instructions as well as a textbox
        containing the editable text are generated, and also an "Update" button and a
        "Cancel" button.
        */
        if($_GET['edit'] && !$_POST['cancelAbout']) {

        $html .= '<p>Feel free to edit the content below, but remember that where there is a &lt;h3&gt; tag, this determines a heading, and where there is a &lt;p&gt; tag, this determines a paragraph.</p>'."\n";
        $html .= '<br />'."\n";
        $html .= '<p>To make another heading follow this format:</p>'."\n";
        $html .= '<br />'."\n";
        $html .= '<p>&lt;h3&gt;enter heading here&lt;/h3&gt;.</p>'."\n";
        $html .= '<br />'."\n";$html .= '<p>To make another paragraph follow this format:</p>'."\n";
        $html .= '<br />'."\n";
        $html .= '<p>&lt;p&gt;enter paragraph here&lt;/p&gt;.</p>'."\n";
        $html .= '<br />'."\n";

        $html .= '<form id="updateAboutContent" method="post" action="'.$_SERVER['REQUEST_URI'].'">'."\n";

	        if(!$_POST['updateAbout']) {
	        	$html .= '<textarea id="aboutText" name="aboutText" rows="6" cols="18">'.htmlentities(stripslashes($this -> pageInfo['pageContent']),ENT_QUOTES).'</textarea> <br/>'."\n";
	        } else {
	        	$html .= '<textarea id="aboutText" name="aboutText" rows="6" cols="18">'.htmlentities(stripslashes($_POST['aboutText']),ENT_QUOTES).'</textarea> <br/>'."\n";
	        }
    	
    	$html .= '<p class="errorMsg">'.$errorMsg.'</p>'."\n";
    	$html .= '<div id="updateButtons">'."\n";
    	$html .= '<input id="aboutUpdateBtn" type="submit" name="updateAbout" value="Update" />'."\n";
    	$html .= '<a href="index.php?page=about#aboutContent" id="cancelAboutUpdate">Cancel</a>'."\n";
    	$html .= '</div>'."\n";
    	$html .= '</form>'."\n";
    	$html .= '<div class="clearDiv"></div>'."\n";

	    } else {

            /*
            This code is carried out if the user isn't editing the page,
            which shows the content of the page that is stored in the
            database.
            */
	    	$html .= '<div>'.$pageContent.'</div>'."\n";
	    	$html .= '<div class="clearDiv"></div>'."\n";
	    }

        /*
        If the admin is logged in, displaying a button that allows him to edit the content of the page.
        */
		if($this -> model -> adminLoggedIn && !$_GET['edit']) {
            $html .= '<a href="index.php?page=about&amp;edit=true#updateAboutContent" id="editAboutContent">Edit Content</a>'."\n";
        } 

        $html .= '</div>'."\n";
                
        return $html;        
    }  
        
}

?>