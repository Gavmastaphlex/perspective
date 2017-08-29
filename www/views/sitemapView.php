<?php

class SitemapView extends View {
        
    protected function displayContent() {

        /*
        Displaying the page name thats come from the database.
        */
    	$html = '<h2>'.$this -> pageInfo['pageHeading'].'</h2>'."\n";

    	$html .= '<div id="sitemapContainer">'."\n";
    	$html .= '<ul>'."\n";
        $html .= '<a href="index.php"><li>Home</li></a>'."\n";
        /*
        Pulling the category names from the database in order to generate quick
        links to each category page.
        */
        $categories = $result = $this -> model -> getCategoryDetails();

        foreach($categories as $category) {
            $html .= '<a href="index.php?page=projects&amp;category='.$category['categoryID'].'#categoryHeading"><li>Projects - '.$category['categoryNav'].'</li></a>'."\n";
        }

        $html .= '<a href="index.php?page=about"><li>About Us</li></a>'."\n";
        $html .= '<a href="index.php?page=contact"><li>Contact Us</li></a>'."\n";

        $html .= '</ul>'."\n";

        $html .= '</div>'."\n";
                
        return $html;
    }
            
        
}


?>