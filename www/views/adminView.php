<?php

class AdminView extends View {
    
    protected function displayContent() {


        if($_GET['projectUpload'] == 'true') {
            $html .= '<div id="updateSuccess">'."\n";
            $html .= '<h3>Your project has been uploaded!</h3>'."\n";
            $html .= '</div>'."\n";
        }
        
            /*
            If adminLoggedIn is true, then we know to display the Admin Actions
            page.
            */
        if($this -> model -> adminLoggedIn) {
            $html .= '<div class="content" id="adminContent">'."\n";
            $html .= '<h2>Admin actions:</h2>'."\n";
            $html .= '<ul>'."\n";
            $html .= '<a href="index.php?page=addProject"><li>Add Project</li></a>'."\n";
            $html .= '<a href="index.php?page=projects"><li>Edit Project</li></a>'."\n";
            $html .= '<a href="index.php?page=projects"><li>Delete Project</li></a>'."\n";
            $html .= '</ul>'."\n";

        } else {
            /*
            If adminLoggedIn is false, then the user hasn't logged in yet.
            So we run the function to display the login form.
            */
            $html .= $this -> displayLoginForm()."\n";   
            
        }
        
        $html .= '</div>'."\n";

        return $html;
    }
    
    private function displayLoginForm() {
            /*
            The form that we call when the user hasn't logged in.
            */
        $html = '<div class="content" id="adminLoginForm">'."\n";
        $html .= '<form method="post" action="'.$_SERVER['REQUEST_URI'].'">'."\n";
        $html .= '<label for="userName">Username</label>'."\n";
        $html .= '<input type="text" name="userName" id="userName"  placeholder="Username" />'."\n";
        $html .= '<div class="clearDiv"></div>'."\n";
        $html .= '<label for="userPassword">Password</label>'."\n";
        $html .= '<input type="password" name="userPassword" id="userPassword" placeholder="Password" />'."\n";
        $html .= '<div class="clearDiv"></div>'."\n";
        $html .= '<p id="loginMsg">'.$this -> model -> loginMsg.'</p>'."\n";
        $html .= '<input id="loginBtn" type="submit" name="login" value="Login" />'."\n";
        $html .= '<div class="clearDiv"></div>'."\n";
        $html .= '</form>'."\n";

        return $html;        
    }
    
    
    
    
    
    
    
    
}






?>