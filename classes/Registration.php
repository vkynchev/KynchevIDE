<?php

/**
 * Class registration
 * handles the user registration
 */
class Registration
{

    private $db_connection = null;

    public $errors = array();

    public $messages = array();
    
    public $success;

    public function __construct()
    {
        if (isset($_POST["register"])) {
            $this->registerNewUser();
        } elseif (isset($_GET["generateLink"])) {
            $this->generateLink();
        } elseif ($this->isFirstUser() == false) {
            $this->verifyInvite();
        }
    }

    /**
     * handles the entire registration process. checks all error possibilities
     * and creates a new user in the database if everything is fine
     */
    private function registerNewUser()
    {
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Username field cannot be empty.";
        } elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {
            $this->errors[] = "Password field cannot be empty.";
        } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {
            $this->errors[] = "Passwords doesn't match.";
        } elseif (strlen($_POST['user_password_new']) < 6) {
            $this->errors[] = "Password has a minimum length of 6 characters.";
        } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
            $this->errors[] = "Username cannot be shorter than 2 or longer than 64 characters.";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {
            $this->errors[] = "Username doesn't fit the name scheme: only a-Z and numbers, 2 to 64 characters";
        } elseif (empty($_POST['user_email'])) {
            $this->errors[] = "Email field cannot be empty.";
        } elseif (strlen($_POST['user_email']) > 64) {
            $this->errors[] = "Email cannot be longer than 64 characters";
        } elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Your email address is not in a valid email format";
        } elseif (!empty($_POST['user_name'])
            && strlen($_POST['user_name']) <= 64
            && strlen($_POST['user_name']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
            && !empty($_POST['user_email'])
            && strlen($_POST['user_email']) <= 64
            && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['user_password_new'])
            && !empty($_POST['user_password_repeat'])
            && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
        ) {
            // create a database connection
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escaping, additionally removing everything that could be (html/javascript-) code
                $user_name = $this->db_connection->real_escape_string(strip_tags($_POST['user_name'], ENT_QUOTES));
                $user_email = $this->db_connection->real_escape_string(strip_tags($_POST['user_email'], ENT_QUOTES));

                $user_password = $_POST['user_password_new'];

                // crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
                // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
                // PHP 5.3/5.4, by the password hashing compatibility library
                $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

                // check if user or email address already exists
                $sql = "SELECT * FROM users WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_email . "';";
                $query_check_user_name = $this->db_connection->query($sql);
                
                // make the first user developer(admin)
                $sql = "SELECT * FROM users";
                $first_user_check_query = $this->db_connection->query($sql);
                
                if ($first_user_check_query->num_rows == 0) {
                    $user_position = "developer";
                } else {
                    $user_position = "read_only";
                }
                

                if ($query_check_user_name->num_rows == 1) {
                    $this->errors[] = "Sorry, that username / email address is already taken.";
                } else {
                    // write new user's data into database
                    
                    $sql = "INSERT INTO users (user_name, user_password_hash, user_email, user_position)
                            VALUES('" . $user_name . "', '" . $user_password_hash . "', '" . $user_email . "', '" . $user_position . "');";
                    $query_new_user_insert = $this->db_connection->query($sql);

                    // if user has been added successfully
                    if ($query_new_user_insert) {
                        $this->messages[] = "Your account has been created successfully. You can now log in.";
                        $this->success = true;
                    } else {
                        $this->errors[] = "Sorry, your registration failed. Please go back and try again.";
                        $this->success = false;
                    }
                }
            } else {
                $this->errors[] = "Sorry, no database connection.";
            }
        } else {
            $this->errors[] = "An unknown error occurred.";
        }
    }
    
    public function generateLink()
    {
        $invite = substr( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ,mt_rand( 0 ,50 ) ,1 ).substr( md5( time() ), 1);
        $link = 'http://' . $_SERVER[HTTP_HOST] . '/register/?invite='.$invite;
        
        $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "INSERT INTO invites (invite_value)
                VALUES('" . $invite . "');";
        $query_new_invite = $db_connection->query($sql);
        $sql = "DELETE FROM invites WHERE invite_create < (NOW() - INTERVAL 24 HOUR);";
        $query_delete_invite = $db_connection->query($sql);
                    
                    
        echo $link;
        die;
    }
    
    public function verifyInvite()
    {
        $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "DELETE FROM invites WHERE invite_create < (NOW() - INTERVAL 24 HOUR);";
        $db_connection->query($sql);
        
        $invite_url = $_GET['invite'];
                    
        $sql = "SELECT *
                FROM invites
                WHERE invite_value = '" . $invite_url . "';";
        $result_of_invite_check = $db_connection->query($sql);
        
        $sql = "DELETE FROM invites WHERE invite_value = '" . $invite_url . "';";
        $db_connection->query($sql);

        // if this invite exist
        if ($result_of_invite_check->num_rows == 1) {
          require __DIR__ . '/../views/register.php';
        } else {
          header("Location: /");
        }
        
        die;
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
}