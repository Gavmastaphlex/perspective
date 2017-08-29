<?php

class AccessView extends View {
        
    protected function displayContent() {

        /*
        Pulling the page name from the database.
        */
    	$html = '<h2>'.$this -> pageInfo['pageHeading'].'</h2>'."\n";
    	$html .= '<div class="content" id="accessContent">'."\n";
    	
        /*
        Storing the content of the page into $html.
        */
    	$html .= '<p>Press ALT+[key] on a PC, or CTRL+[key] on a Mac to be taken to the appropriate page</p>'."\n";

    	$html .= '<ul>'."\n";
		$html .= '<li>0 - Navigate to Home page.</li>'."\n";
		$html .= '<li>1 - Navigate to Project Photos page.</li>'."\n";
		$html .= '<li>2 - Navigate to About Us page.</li>'."\n";
		$html .= '<li>3 - Navigate to Contact page.</li>'."\n";
		$html .= '<li>4 - Navigate to Sitemap page.</li>'."\n";
		$html .= '<li>5 - Navigate to Accessibility page.</li>'."\n";
		$html .= '</ul>'."\n";

    	$html .= '</div>'."\n";

        /*
        Returning the value of $html which will contain all the content of the page.
        */  
        return $html;        
    }
            
        
}


?>