<?php

require_once("classes/Zip.php");

/**
 * Class login
 * handles the web page when the user is logged in
 */
class Login
{
    /**
     * @var object The database connection
     */
    private $db_connection = null;
    /**
     * @var array Collection of error messages
     */
    public $errors = array();
    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {
        // create/read session, absolutely necessary
        session_start();

        // check the possible login actions:
        // if user tried to log out (happen when user clicks logout button)
        if (isset($_GET["logout"])) {
            $this->doLogout();
        } elseif (isset($_POST["login"])) {
            $this->doLogin();
        } elseif (isset($_GET["passwordCheck"])) {
            $this->passwordCheck();
        } elseif (isset($_GET["updateProfile"])) {
            $this->updateProfile();
        } elseif (isset($_GET["changePosition"]) && $_SESSION['user_position'] == 'developer') {
            $this->changePosition();
        } elseif (isset($_GET["loadFile"])) {
            $this->loadFile();
        } elseif (isset($_GET["fileDownload"])) {
            $this->downloadProject();
        }
        
        // && ($_SESSION['user_position'] == 'developer' || $_SESSION['user_position'] == 'jr_developer')
    }

    /**
     * log in with post data
     */
    private function doLogin()
    {
        // check login form contents
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Username field was empty.";
        } elseif (empty($_POST['user_password'])) {
            $this->errors[] = "Password field was empty.";
        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {

            // create a database connection, using the constants from config/db.php (which we loaded in index.php)
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escape the POST stuff
                $user_name = $this->db_connection->real_escape_string($_POST['user_name']);

                // database query, getting all the info of the selected user (allows login via email address in the
                // username field)
                $sql = "SELECT user_name, user_email, user_password_hash, user_position, info_name, info_desc, info_avatar
                        FROM users
                        WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_name . "';";
                $result_of_login_check = $this->db_connection->query($sql);

                // if this user exists
                if ($result_of_login_check->num_rows == 1) {

                    // get result row (as an object)
                    $result_row = $result_of_login_check->fetch_object();

                    // using PHP 5.5's password_verify() function to check if the provided password fits
                    // the hash of that user's password
                    if (password_verify($_POST['user_password'], $result_row->user_password_hash)) {

                        // write user data into PHP SESSION (a file on your server)
                        $_SESSION['user_name'] = $result_row->user_name;
                        $_SESSION['user_email'] = $result_row->user_email;
                        $_SESSION['user_position'] = $result_row->user_position;
                        $_SESSION['info_name'] = $result_row->info_name;
                        $_SESSION['info_desc'] = $result_row->info_desc;
                        $_SESSION['info_avatar'] = $result_row->info_avatar;
                        $_SESSION['user_login_status'] = 1;

                    } else {
                        $this->errors[] = "Wrong password. Try again.";
                    }
                } else {
                    $this->errors[] = "This user does not exist.";
                }
            } else {
                $this->errors[] = "Database connection problem.";
            }
        }
    }
    
    public function passwordCheck()
    {
    	$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    	$sql = "SELECT user_password_hash
                FROM users
                WHERE user_name = '" . $_SESSION['user_name'] . "';";
        $query_check_pass = $this->db_connection->query($sql);
        
        $result_row = $query_check_pass->fetch_object();
        
        if (password_verify($_GET["passwordCheck"], $result_row->user_password_hash)) {
	  echo 'true';
        } else {
	  echo 'false';
        }
        
        die;

    }

    /**
     * perform the logout
     */
    public function doLogout()
    {
        // delete the session of the user
        $_SESSION = array();
        session_destroy();
        // return a little feeedback message
        $this->messages[] = "You have been logged out successfully.";

    }

    /**
     * simply return the current state of the user's login
     * @return boolean user's login status
     */
    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        // default return
        return false;
    }
    
    
    
    public function isFirstUser()
    {
    	$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    	
    	$sql = "SELECT * FROM users";
        $first_user_check_query = $this->db_connection->query($sql);
                
        if ($first_user_check_query->num_rows == 0) {
            return true;
        }
        // default return
        return false;
    }
    
    
    
    public function setTimestamp()
    {
        //Update user online timestamp option
    	$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    	$sql = "UPDATE users SET user_online_timestamp=NOW() WHERE user_name='" . $_SESSION['user_name'] ."'";
        $query_view_user_online = $this->db_connection->query($sql);
    }
    
    public function updateProfile()
    {
        //Update user profile
    	if($_GET['updateProfile'] == 'true') {
    	  $update = $_GET['updateThing'];
    	  $value = $_GET['value'];
    	  
    	  $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    	  
    	  if (!$this->db_connection->connect_errno) {
    	    $sql = "UPDATE users SET " . $update . "='" . $value . "' WHERE user_name='" . $_SESSION['user_name'] ."'";
            $query_update_profile = $db_connection->query($sql);
            
            
            $_SESSION[$update] = $value;
            
            echo 'true';
    	  } else {
    	    echo 'false';
    	  }
    	  
          
    	}
    	
    	die;
    }
    
    public function changePosition()
    {
        //Change user position	
    	$user = $_GET['changePosition'];
    	
    	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    	
    	
    	if (!$this->db_connection->connect_errno) {
    	  $sql = "SELECT user_position FROM users WHERE user_name = '" . $user . "'";
          $view_position_query = $db_connection->query($sql);
    	  
    	  $result_row = $view_position_query->fetch_object();
    	  
    	  if($result_row->user_position == 'developer') {
    	    $changeto = 'read_only';
    	  } elseif ($result_row->user_position == 'jr_developer') {
    	    $changeto = 'developer';
    	  } elseif ($result_row->user_position == 'read_only') {
    	    $changeto = 'jr_developer';
    	  }
    	  
    	  $sql = "UPDATE users SET user_position='" . $changeto . "' WHERE user_name='" . $user ."'";
          $query_update_position = $db_connection->query($sql);
          
          
          echo $changeto;
    	} else {
    	  echo '';
    	}
    	
    	
    	
    	
    	die;
    }
    
    public function loadFile()
    {
        $file = $_GET['loadFile'];
    	
    	$content = file_get_contents($file);
    	
    	echo htmlentities($content);
    	
    	
    	die;
    }
    
    public function downloadProject()
    {
    	$path = $_GET['fileDownload'];
    	$project = $_GET['project'];
    	
    	$the_folder = $_SERVER['DOCUMENT_ROOT'].'/workspaces/'.$project.'/'.$path;
	$zip_file_name = $path . '_' . time() . '.zip';
	$za = new FlxZipArchive;
	$res = $za->open($zip_file_name, ZipArchive::CREATE);
	if($res === TRUE) {
    	    $za->addDir($the_folder, basename($the_folder));
    	    $za->close();
	}
	else {
    	    echo 'Could not create a zip archive';
    	}

	header( "Pragma: public" );
	header( "Expires: 0" );
	header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
	header( "Cache-Control: public" );
	header( "Content-Description: File Transfer" );
	header( "Content-type: application/zip" );
	header( "Content-Disposition: attachment; filename=\"" . $zip_file_name . "\"" );
	header( "Content-Transfer-Encoding: binary" );
	header( "Content-Length: " . filesize( $zip_file_name ) );

	readfile( $zip_file_name );
	
	unlink($zip_file_name);
	
        die;
    }
}