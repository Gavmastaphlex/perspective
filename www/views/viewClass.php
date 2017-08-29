<?php

abstract class View {
    
    protected $pageInfo;    // holds the data read from the pages table
    protected $model;       //object for the database class
    
    
    public function __construct($info, $model) {
        
        /*
        Because we're calling these functions on the view class, and because all the
        other pages extend from this one, we can access any attribute or function contained
        in these two functions from any page.
        */
        $this -> pageInfo = $info;
        $this -> model = $model;
        
    }
    
    public function displayPage() {
        
        /*
        Calling these two functions so that we can regulate what information
        to display to the user at the time.
        */
        $this -> model -> checkUserSession();
        $this -> model -> checkDevice();

        /*
        Calling these three functions as they are what makes up each page. The displayHeader() and
        displayFooter() functions are included in the viewClass, but as for displayContent(), this is
        a protected function that is initialized in all other view classes that are used to display each pages
        content.
        */
        $html = $this -> displayHeader();
        $html .= $this -> displayContent();
        $html .= $this -> displayFooter();
        
        return $html;        
    }
    
    abstract protected function displayContent();
    
    private function displayHeader() {
        /*
        Constructing the header that is to be viewed on each page
        */

        $html  = '<!doctype html>'."\n";
        $html .= '<html lang="en">'."\n";
        $html .= '<head>'."\n";
        $html .= '<meta charset="utf-8">'."\n";
        $html .= '<title>'.$this -> pageInfo['pageTitle'].'</title>'."\n";
        $html .= '<meta name="viewport" content="width=device-width,initial-scale=1.0" />'."\n";
        $html .= '<link rel="stylesheet" type="text/css" href="css/styles.css" />'."\n";
        $html .= '<meta name="description" content="'.$this -> pageInfo['pageDescription'].'" />'."\n";
        $html .= '<meta name="keywords" content="'.$this -> pageInfo['pageKeywords'].'" />'."\n";
        $html .= '<!--[if lt IE 9]>'."\n";
        $html .= '<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>'."\n";
        $html .= '<![endif]-->'."\n";
        $html .= '</head>'."\n";
        $html .= '<header>'."\n";
        $html .= '<a href="index.php"><h1>Perspective</h1></a>'."\n";
        $html .= '<nav id="headerNav">'."\n";
        $html .= '<a href="index.php?page=home" accesskey="0" id="homeNav" class="mainNavItem">Home</a>'."\n";
        $html .= '<a href="index.php?page=projects" id="projectsNav" accesskey="1" class="mainNavItem">Project Photos</a>'."\n";
        $html .= '<a href="index.php?page=about" id="aboutNav" accesskey="2" class="mainNavItem">About Us</a>'."\n";
        $html .= '<a href="index.php?page=contact" id="contactNav" accesskey="3" class="mainNavItem">Contact Us</a>'."\n";

        if(!$this -> model -> mobileDetect && !$this -> model -> tabletDetect) {

            $categories = $result = $this -> model -> getCategoryDetails();

            $html .= '<div id="categorySubmenu">'."\n";
            foreach($categories as $category) {
                
                $html .= '<a href="index.php?page=projects&amp;category='.$category['categoryID'].'#categoryHeading">'.$category['categoryNav'].'</a>'."\n";
                
            }
            $html .= '</div>'."\n";

        }

        $html .= '</nav>'."\n";

        /*
        As long as the user isn't using Mobile Phone or a Tablet, these details are generated
        for the user to see.
        */
        if(!$this -> model -> mobileDetect && !$this -> model -> tabletDetect) {
            $html .= '<aside>'."\n";
            $html .= '<a href="index.php?page=contact#contactBrad">'."\n";
            $html .= '<section>'."\n";
            $html .= '<p>Brad Harley</p>'."\n";
            $html .= '<p>Wellington</p>'."\n";
            $html .= '<p>0272486204</p>'."\n";
            $html .= '</section>'."\n";
            $html .= '</a>'."\n";
            $html .= '<a href="index.php?page=contact#contactRyan">'."\n";
            $html .= '<section>'."\n";
            $html .= '<p>Ryan Harley</p>'."\n";
            $html .= '<p>Hawkes Bay</p>'."\n";
            $html .= '<p>0272486202</p>'."\n";
            $html .= '</section>'."\n";
            $html .= '</a>'."\n";
            $html .= '</aside>'."\n";
        }

        $html .= '</header>'."\n";

        $html .= '<div class="clearDiv"></div>'."\n";
        
        return $html;
        
    }
        
    private function displayFooter() {
        /*
        Constructing the footer that is to be viewed on each page
        */

        $html = '<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>'."\n";
        $html .= '<script type="text/javascript" src="js/nav.js"></script>'."\n";
          
        if($this -> model -> mobileDetect && !$this -> model -> adminLoggedIn || $this -> model -> tabletDetect && !$this -> model -> adminLoggedIn ) {
            $html .= '<div id="nonDesktopContactDetails">'."\n";
            $html .= '<a href="index.php?page=contact#contactBrad">'."\n";
            $html .= '<section>'."\n";
            $html .= '<p>Brad Harley</p>'."\n";
            $html .= '<p>Wellington</p>'."\n";
            $html .= '<p>0272486204</p>'."\n";
            $html .= '</section>'."\n";
            $html .= '</a>'."\n";
            $html .= '<a href="index.php?page=contact#contactRyan">'."\n";
            $html .= '<section>'."\n";
            $html .= '<p>Ryan Harley</p>'."\n";
            $html .= '<p>Hawkes Bay</p>'."\n";
            $html .= '<p>0272486202</p>'."\n";
            $html .= '</section>'."\n";
            $html .= '</a>'."\n";
            $html .= '</div>'."\n";
            $html .= '<div class="clearDiv"></div>'."\n";
        }

        $html .= '<footer>'."\n";

                    $html .= '<div id="footerLinks">'."\n";
        
        /*
        If the user is logged in, giving additional options for them such as the ability
        to Log Off, or to bring up the Admin Panel.
        */
        if($this -> model -> adminLoggedIn) {

            $html .= '<a href="index.php?page=admin">Admin Panel</a>'."\n";
            $html .= '<a href="index.php?page=logout">Logout</a>'."\n";

        } else {
            
            $html .= '<a href="index.php?page=access" accesskey="5">Accessibility</a>'."\n";
            $html .= '<a href="index.php?page=login" id="login">Login</a>'."\n";
                
        }

        $html .= '<a href="index.php?page=sitemap" accesskey="4">Sitemap</a>'."\n";
        $html .= '<div class="clearDiv"></div>'."\n";

        $html .= '</div>'."\n";

        /*
        These details are only displayed if the screen width that the user is displaying the
        website on is a certain size, closer to the size of Tablets & Mobile Phone.
        */
        $html .= '<div id="extraContactDetails">'."\n";
        $html .= '<p>Brad Harley ~ Wellington ~ 0272486204</p>'."\n";
        $html .= '<p>Ryan Harley ~ Hawkes Bay ~ 0272486202</p>'."\n";
        $html .= '</div>'."\n";
        
        $html .= '<p class="copyright">Copyright 2013 Perspective Ltd</p>'."\n";
        $html .= '<p class="copyright">Design by Proven Web</p>'."\n";
        
        $html .= '</footer>'."\n";
        $html .= '</body>'."\n";
        $html .= '</html>'."\n";
        
        return $html;
    }
    
    
    
}





?>