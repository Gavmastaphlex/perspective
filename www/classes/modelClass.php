<?php

/*
     will contain any processing of page information either
    before it goes into the database or after..
    e.g. validation, uploading/resizing of images, e.t.c
*/

include 'classes/dbClass.php';
include 'classes/uploadClass.php';
include 'classes/resizeClass.php';


class Model extends Dbase {
    
    /*
    the variables that made public are accessible in any
    other class that extends the dbClass. The private
    variables are 
    */
    public $adminLoggedIn;
    public $loginMsg;
    public $mobileDetect;
    public $tabletDetect;
    private $validate;
    
    /*
    the function __construct is run right away.
    */
    public function __construct() {
        parent::__construct();
        
        /*storing the names of the pages that we require validating
        on in an array*/
        $validationPages = array('addProject', 'editProject');
        
        /*checking to see if the current page that is being viewed
        matches any of the stored pages in the $validationPages array*/
        if(in_array($_GET['page'], $validationPages)) {

        /*
        If the page is in validationPages 
        */
            include 'classes/validateClass.php';
            $this -> validate = new Validate;
        } 
        
    }

    /*
    Using the mobileDetectClass to find out if the user is using a mobile or tablet
    to view the website, and therefore regulating the content that is displayed to
    the user.
    */
    public function checkDevice() {

        include 'classes/mobileDetectClass.php';

        $detector = new Mobile_Detect();

        $this -> mobileDetect = $detector -> isMobile();
        $this -> tabletDetect = $detector -> isTablet();

    }

    public function checkUserSession() {
        
        /*
        If the user has logged out we reset every single variable and array
        that was linked to them so theres no risk of unauthorized access,
        setting the property of $this -> adminLoggedIn to false so that any functions
        that check this value will be updated,
        */
        if($_GET['page'] == 'logout') {
            unset($_SESSION['userName']);
            unset($_SESSION['userAccess']);
            $this -> adminLoggedIn = false;
            $this -> loginMsg = 'You have successfully logged out!';
        }
        
        /*
        Running a query that checks the users login name and password with
        whats stored in the database to check they've entered the right username
        and password, and if they have, setting the appropriate sessions to signify
        that they are now logged in.

        Conversely generating validation messages if the login process fails.
        */
        if($_POST['login']) {
            if($_POST['userName'] && $_POST['userPassword']) {
                $this -> adminLoggedIn = $this -> validateUser();
                if($this -> adminLoggedIn == false) {
                    $this -> loginMsg = 'Login Failed!';   
                }               
                
            } else {
                $this -> loginMsg = 'Please enter the username and password!';   
            }
            
        //check to see if the login form was submitted
        } else {
            
            if($_SESSION['userAccess'] == 'admin') {
                $this -> adminLoggedIn = true;  
            }
        }
        
        
    }   //closing check user session {
    

    /*
        This function is used in the checkUserSession function
        and for that fact that is why it is a private function
        as it only needs to be used inside the dbClass.
    */
    private function validateUser() {
        
        /*
        Runs this function from the dbClass.
        */
        $user = $this -> getUser();
        
        /*
        if the $user variable is an array then the database query
        worked and we'll have the user details available.
        */
        if(is_array($user) && $user['userAccess'] == 'admin') {
            $_SESSION['userName'] = $user['userName'];
            $_SESSION['userAccess'] = $user['userAccess'];

            return true;
        } else {
            return false;   
        }        
        
    }

    public function processAddProject() {
        
        /*
        First we use the private function in the model class
        to validate the Add Project Form, making sure the forms
        are all filled out and with valid values.
        */
        $vresult = $this -> validateProject('Add');
        
        if($vresult['ok'] == false) {
        /*
        No point in continuing so we stop the code and return
        the error messages.
        */
            return $vresult;
        }
        
        /*
        Then we have run the uploadAndResizeImage to process the uploaded
        image and return a value to check if the process was successful or
        not. We do this after the validating process so theres no chance of
        double-uploading an image in the case of other fields not validating.
        */
        $iresult = $this -> uploadAndResizeImage();
        
        // check to see if the image was uploaded and resized
        if($iresult['ok'] == false) {
            $iresult['msg'] .= 'Unable to upload/resize image';
        } else {
            /*
            if the image upload and resize was successful then go ahead and insert the information
            into the database.
            */
            $iresult['msg'] .= 'Image uploaded/resized successfully<br />';
            $iresult['msg'] .= $this -> insertProject($_POST['projectHeading'], $_FILES['projectImage']['name'], $_POST['projectDescription'], $_POST['projectCategory']);
        }
        return $iresult;
    }


    public function processUpdateProject() {
        
        /*
        First we use the private function in the model class
        to validate the Edit Project Form, making sure the forms
        are all filled out and with valid values.
        */
        $vresult = $this -> validateProject('Edit');
        
        if($vresult['ok'] == false) {
            /*
            No point in continuing so we stop the code and return
            the error messages.
            */
            return $vresult;
        }
        

        $uresult['msg'] = '';
        $id = $_POST['projectID'];
        
        /*
        Checking to see if theres a new image that the user has uploaded,
        otherwise we know that they are still using the existing image
        */
        if($_FILES['projectImage']['name']) {
            $uresult = $this -> uploadAndResizeImage();
            
            if($uresult['ok']) {
                $_POST['projectImage'] = $uresult['projectImage'];
                $uresult['msg'] .= 'Image uploaded/resized successfully';
            } else {
                $uresult['msg'] .= 'Unable to upload/resize image';   
            }            
            
        }
        
        $uresult['msg'] .= $this -> updateProject();
        $uresult['ok'] = true;
        
        return $uresult;  
    }

        
    public function processUpdatePage($page, $content) {
        /*
        First of all checking to see if there is some content that has
        been entered, if not then we return a false value and an error message,
        but if there is text then we run the database function to insert the content
        into the database.
        */
        if(!$content) {
            $presult['errorMsg'] = 'Please enter some text!';
            $presult['ok'] = false;
        } else {
            $presult = $this -> updatePageContent($page, $content);
        }
        
        return $presult;  

    }


    public function processDeleteProject($projectID) {
            
            /*
            First of all enquiring of the database before we delete
            the project records so as to obtain the image filename
            that is associated with that project, so that then we can
            delete the image that is associated with that project.
            */

        $project = $this -> getProjectByID($projectID);
        $result = $this -> deleteProject($projectID);
        
        if($result == true) {
            @ unlink('uploads/'.$project['projectImage']);
            @ unlink('uploads/thumbnails/'.$project['projectImage']);
        } 
        return $result;
    }


    private function validateProject($mode) {
        /*
        Validating by taking the necessary information from $_POST and passing it through
        to the validate class while specifying the function that is going to be carried out
        in the validate class. If the $mode is 'Add' then performing the extra check that there is an Image.
        */    
        $result['pHeadingMsg'] = $this -> validate -> checkRequired($_POST['projectHeading']);
        $result['pDescMsg'] = $this -> validate -> checkRequired($_POST['projectDescription']);
        $result['pCategoryMsg'] = $this -> validate -> checkRequired($_POST['projectCategory']);
        
        if($mode == 'Add') {
            $result['pImageMsg'] = $this -> validate -> checkRequired($_FILES['projectImage']['name']);
        }
        
        /*
        Checking to see if there was any generated error messages by going back into the validate class
        and running the function "checkErrorMessages".
        */

        $result['ok'] = $this -> validate -> checkErrorMessages($result);
        
        return $result;
        
    }

    private function uploadAndResizeImage() {
        
        /*
        Setting the filepaths for where the images are going to be stored.
        */
        $imgPath = 'uploads';
        $thumbImgsPath = 'uploads/thumbnails';
        
        /*
        Checking to see if there was an image that has been uploaded first
        */
        if(!$_FILES['projectImage']['name']) {
            return false;
        }
        
        //setting the file types that user is allowed to upload.
        $fileTypes = array('image/jpeg','image/jpg','image/png','image/gif');
        /*
        Passing through the necessary information to the Upload class.
        */
        $upload = new Upload('projectImage', $fileTypes, $imgPath);
        
        /*
        This variable is only returned if the upload process
        worked correctly
        */
        $returnFile = $upload -> isUploaded();
        
        /*
        If the variable isn't active then something went wrong and
        the error message is returned to the user.
        */
        if(!$returnFile) {
            $result['uploadMsg'] = $upload -> msg;
            $result['ok'] = false;
            return $result;
        }
        
        //if we are this point, the image should have uploaded
        //should be on our server. 'images/products'
        //resize it
        
        /*
        Obtaining the actual filename from the $returnFile
        */
        $fileName = basename($returnFile);

        /*
        Working out the actual filepath names for the image and
        thumbnail.
        */
        $bigPath = $imgPath.'/'.$fileName;
        $thumbPath = $thumbImgsPath . '/'.$fileName;
        
        /*
        The copy() function will copy the $returnFile to the $thumbPath.
        */
        copy($returnFile, $thumbPath);
        
        /*
        If no file exists at $thumbPath then something went wrong, return false
        */
        if(!file_exists($thumbPath)) {
            return false;
        }
        
        /*
        Obtaining the dimensions of the image.
        */
        $imgInfo = getimagesize($returnFile);
        
        /*
        If the width or the height is greater than 200pixels, then we need to resize
        the image for the thumbnail.
        */
        if($imgInfo[0] > 200 || $imgInfo[1] > 200) {
            $resizeObj = new ResizeImage($thumbPath, 200, $thumbImgsPath, '');
            if(!$resizeObj->resize()) {
                echo 'Unable to resize image to 200 pixels';
            }
        }
        
        //resize big image now
        rename($returnFile, $bigPath);
        
        /*
        If the width or the height is greater than 200pixels, then we need to resize
        the image for the main image.
        */
        if($imgInfo[0] > 400 || $imgInfo[1] > 400) {
            $resizeObj1 = new ResizeImage($bigPath, 400, $imgPath, '');
            if(!$resizeObj1 -> resize()) {
                echo 'Unable to resize image to 400 pixels';
            }
        }
        
        /*
        Checking to see if the newly uploaded image exists in the main upload
        folder, as well as in the thumbnail folder. If it does, then we know that
        the whole process was successfull and we can return true.
        */
        if(file_exists($thumbPath) && file_exists($bigPath)) {
            $result['projectImage'] = basename($thumbPath);
            $result['ok'] = true;
            return $result;
        } else {
            return false;
        }
                
    }

    
} 

?>