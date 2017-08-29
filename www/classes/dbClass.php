<?php
/*
    // the database class will contain all the information
    // about connecting to the database and to query tables
    // on the database
*/

include '../config.php';

class Dbase {
    
    private $db;
    
    public function __construct() {
        
        try {
            
            //host user password database
            $this -> db = new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);
            
            if(mysqli_connect_errno()) {
                throw new Exception('Unable to establish database connection');   
            }            
            
        } catch(Exception $e) {
            die($e -> getMessage());
        }
        
    }
    
    /*this function retrieves all the page information from the database and in effect alters the viewClass (index.php)
    with the specific content the user has requested*/

    public function getPageInfo($page) {
        
        $qry = "SELECT pageName, pageTitle, pageHeading, pageKeywords, pageDescription, pageContent FROM pages WHERE pageName = '$page'";
        
        $rs = $this -> db -> query($qry);
        
        if($rs) {
            
            if($rs -> num_rows > 0) {
                $pageInfo = $rs -> fetch_assoc();
                return $pageInfo;
            } else {
                echo 'This page does not exist';   
            }            
        } else {
            echo 'Error getPageInfo executing query';
        }
        
    }

    /*This function checks that the inputted username and password entered by a user are correct. If it is, then the function
    acquires all the user details for that user so as to user it for various operations which can only be performed by logged in
    users*/

    public function getUser() {
        extract($_POST);
        $password = sha1($userPassword);
        
        $qry = "SELECT userName, userPassword, userAccess FROM users WHERE userName = '$userName' AND userPassword = '$password'";
        
        $rs = $this -> db -> query($qry);
        
        if($rs) {
            
            if($rs -> num_rows > 0) {
                $user = $rs -> fetch_assoc();
                return $user;
            }
            
        } else {
            echo 'Error Executing Query';
        }     
        return false;        
    }

    /*This function retrieves all the Category details stored in the database*/
    public function getCategoryDetails() {

        $qry = "SELECT categoryID, categoryName, categoryNav FROM category";
        
        $rs = $this -> db -> query($qry);

        if($rs) {

            if($rs -> num_rows > 0) {

                $categories = array();

                while($row = $rs -> fetch_assoc()) {
                    $categories[] = $row;
                }

                return $categories;

            } else {
                return false;
            }
        } else {
            return false;
        }
        return false; 
    }

    /*This function retrieves the Category Name based on the categoryID thats run through the function*/
    public function getCategoryNameByID($categoryID) {

        $qry = "SELECT categoryName FROM category WHERE categoryID = '$categoryID'";
        
        $rs = $this -> db -> query($qry);

        if($rs) {

            if($rs -> num_rows > 0) {

                $category = $rs -> fetch_assoc();               

                return $category;

            } else {

            }
        } else {

        }
        return false; 
    }

    /*This function counts all the projects in a certain category, and is used for pagination in figuring
    out the total number of pages that need to be generated*/
    public function countProjects($category) {

        $qry = "SELECT count(projectID) FROM projects WHERE projectCategory = '$category'";

        $rs = $this -> db -> query($qry);

        if($rs) {

            if($rs -> num_rows > 0) {
                $count = array();

                while($row = $rs -> fetch_assoc()) {
                    $count[] = $row;
                }

                return $count;
            } else {
                echo 'No projects were able to be counted';
            }
        } else {
            echo 'Error Executing countProjects Query';
        }
        return false;
    }

    /*Now that we've got a select range of projects to display (based on the pagination function) we're now pulling from the database
    the range of projects in order to display their information. The $start & $limit values will change depending on the current page
    that is being displayed*/
    public function getProjects($start, $limit, $category) {

        $qry = "SELECT projectID, projectHeading, projectImage, projectDescription, projectCategory FROM projects WHERE projectCategory = '$category' LIMIT ".$start.", ".$limit;

        $rs = $this -> db -> query($qry);

        if($rs) {

            if($rs -> num_rows > 0) {

                $projects = array();

                while($row = $rs -> fetch_assoc()) {
                    $projects[] = $row;
                }

                return $projects;
            } else {

            }
        } else {

        }
        return false;
    }

    /*Retrieving the project details based on the projectID that has been inputted*/
    public function getProjectByID($id) {
        
        $qry = "SELECT projectHeading, projectImage, projectDescription, projectCategory FROM projects WHERE projectID = '$id'";
        
        $rs = $this -> db -> query($qry);
        
        if($rs) {
            
            if($rs -> num_rows > 0) {
                
                $project = $rs -> fetch_assoc();
                
                return $project;
                
            } 
                     
        } else {
            echo 'Error executing getProjectByID query';   
        }
        
        return false;        
    }

    /*Inserting the project details into the database*/
    public function insertProject($projectHeading, $projectImage, $projectDescription, $projectCategory) {

        /*The following code strips any slashes that have been inputted by the user, and then any apostrophes or
        quotation marks are escaped before it reaches the database*/
        if(!get_magic_quotes_gpc()) {
            $projectHeading = stripslashes($projectHeading);
            $projectHeading = $this -> db -> real_escape_string(strip_tags($projectHeading));
            $projectDescription = stripslashes($projectDescription);
            $projectDescription = $this -> db -> real_escape_string(strip_tags($projectDescription));
            
        }  

        $qry = "INSERT INTO projects VALUES(NULL, '$projectHeading', '$projectImage', '$projectDescription', '$projectCategory')";

        $rs = $this -> db -> query($qry);
        
        if($rs && $this -> db -> affected_rows > 0) {
            $msg = 'Project added.';
        } else {
            $msg = 'Project could not be added';
        }

        return $msg;
    }


    /*This function deletes the complete row of a project where its projectID matches
    the one that has been passed to the function*/
    public function deleteProject($projectID) {
               
        $qry = "DELETE FROM projects WHERE projectID = '$projectID'";
        $rs = $this -> db -> query($qry);
        
       if($rs) {
            if($this -> db -> affected_rows > 0) {
                $result = true;
            } else {
                $result = false;
            }
            return $result;
            
        } else {
            echo 'Error executing deleteProject query';   
        }
    }

    /*This function updates the complete row in the projects table where the projectID matches the projectID
    being passed through $_POST['projectID']*/
    public function updateProject() {
        
        /*Calling on the sanitize function that takes the $_POST values and performs validation and then updates
        the values back into the $_POST variable.*/
        if(!get_magic_quotes_gpc()) {
            $this -> sanitizeInput();
        }  

        /*Now we extract post to make the values to avoid having to put $_POST at the start of all the values that we put into the query we now perform*/
        extract($_POST);
        
        $qry = "UPDATE projects SET projectHeading = '$projectHeading', projectImage = '$projectImage', projectDescription = '$projectDescription', projectCategory = '$projectCategory' WHERE projectID = '$projectID'";
        
        $rs = $this -> db -> query($qry);
        
        if($rs) {
            if($this -> db -> affected_rows > 0) {
                   $msg = '<br />Project record updated.';
            } else {
                   $msg = '<br />No project updated.';
            }            
        } else {
            echo 'Error updating product';
        }
        return $msg;
    }

    public function updatePageContent($page, $content) {

        /*The following code strips any slashes that have been inputted by the user, and then any apostrophes or
        quotation marks are escaped before it reaches the database*/
        $content = stripslashes($content);
        $content = $this -> db -> real_escape_string($content);
        $content = strip_tags($content, '<h3><p>');
        
       
        $qry = "UPDATE pages SET pageContent = '$content' WHERE pageName = '$page'";
        
        $rs = $this -> db -> query($qry);
        
        if($rs) {
            if($this -> db -> affected_rows > 0) {
                   $result['ok'] = true;
            } else {
                   $result['errorMsg'] = 'The page wasn\'t updated. Please make sure you stick to the above rules and try again.';
            }

            return $result;            
        } else {
            $result['errorMsg'] = 'The page wasn\'t updated. Please make sure you stick to the above rules and try again.';
            return $result;
        }
    }


    /*This function take the values being stored in $_POST, runs them through functions to sanitize the values,
    taking any slahes out, then escaping any apostrophes or quotation marks.*/
    private function sanitizeInput() {
        
        foreach($_POST as &$post) {
            $post = stripslashes($post);
            $post = $this -> db -> real_escape_string($post);
            $post = strip_tags($post);
            
        }
        
    }
    
    
}




?>