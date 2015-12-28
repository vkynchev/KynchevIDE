<?php
require 'AltoRouter.php';

$router = new AltoRouter();

// Routers -----------------------------------------------------------------------------------------


$router->map( 'GET|POST', '/', function( ) {
  // checking for minimum PHP version
  if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, The login script does not run on a PHP version smaller than 5.3.7 !");
  } else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("libraries/password_compatibility_library.php");
  }
  
  // include the configs / constants for the database connection
  require_once("config/db.php");
  
  // load the login class
  require_once("classes/Login.php");
  
  // create a login object. when this object is created, it will do all login/logout stuff automatically
  // so this single line handles the entire login process. in consequence, you can simply ...
  $login = new Login();
  
  if ($login->isUserLoggedIn() == true) {
    // the user is logged in
    require __DIR__ . '/views/workspaces.php';
    $login->setTimestamp();
  } elseif ($login->isFirstUser() == true) {
    //first user -> register the user
    //require __DIR__ . '/views/register.php';
    header("Location: /register/");
  } else {
    // the user is not logged in
    require __DIR__ . '/views/login.php';
  }
  
});


$router->map( 'GET|POST', '/register/', function( ) {
  // checking for minimum PHP version
  if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, The login script does not run on a PHP version smaller than 5.3.7 !");
  } else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("libraries/password_compatibility_library.php");
  }

  // include the configs / constants for the database connection
  require_once("config/db.php");

  // load the registration class
  require_once("classes/Registration.php");

  // create the registration object. when this object is created, it will do all registration stuff automatically
  // so this single line handles the entire registration process.
  $registration = new Registration();

  if($registration->success == true) {
    // the user is successfully registered
    require __DIR__ . '/views/login.php';
    die;
  }
  // show the register view (with the registration form, and messages/errors)
  require __DIR__ . '/views/register.php';
});


$router->map( 'GET|POST', '/workspaces/[a:workspace]/', function( $workspace ) {
  // checking for minimum PHP version
  if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, The login script does not run on a PHP version smaller than 5.3.7 !");
  } else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("libraries/password_compatibility_library.php");
  }
  
  // include the configs / constants for the database connection
  require_once("config/db.php");
  
  // load the login class
  require_once("classes/Login.php");
  
  // create a login object. when this object is created, it will do all login/logout stuff automatically
  // so this single line handles the entire login process. in consequence, you can simply ...
  $login = new Login();
  
  if ($login->isUserLoggedIn() == true) {
    // the user is logged in
    require __DIR__ . '/libraries/scan.php';
    require __DIR__ . '/views/workspace.php';
    $login->setTimestamp();

  } else {
    // the user is not logged in
    require __DIR__ . '/views/login.php';
  }
});

$router->map( 'GET|POST', '/workspaces/[a:workspace]/preview/', function( $workspace ) {
  require __DIR__ . '/libraries/scan.php';
  require __DIR__ . '/viewProject.php';
});

$router->map( 'GET|POST', '/workspaces/[a:workspace]/add-project/', function( $workspace ) {
  // checking for minimum PHP version
  if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, The login script does not run on a PHP version smaller than 5.3.7 !");
  } else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("libraries/password_compatibility_library.php");
  }
  
  // include the configs / constants for the database connection
  require_once("config/db.php");
  
  // load the login class
  require_once("classes/Login.php");
  
  // create a login object. when this object is created, it will do all login/logout stuff automatically
  // so this single line handles the entire login process. in consequence, you can simply ...
  $login = new Login();
  
  if ($login->isUserLoggedIn() == true) {
    $project = $_GET["createProject"];
    $path = "workspaces/" . $workspace . "/" . $project;
    $path= str_replace(" ", "_", "$path");
    if (!is_dir($path)) {
      mkdir($path, 0777, true); // true for recursive create
    }
    $login->setTimestamp();

  } else {
    // the user is not logged in
    require __DIR__ . '/views/login.php';
  }
});

$router->map( 'GET|POST', '/workspaces/[a:workspace]/remove-project/', function( $workspace ) {
  // checking for minimum PHP version
  if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, The login script does not run on a PHP version smaller than 5.3.7 !");
  } else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("libraries/password_compatibility_library.php");
  }
  
  // include the configs / constants for the database connection
  require_once("config/db.php");
  
  // load the login class
  require_once("classes/Login.php");
  
  // create a login object. when this object is created, it will do all login/logout stuff automatically
  // so this single line handles the entire login process. in consequence, you can simply ...
  $login = new Login();
  
  if ($login->isUserLoggedIn() == true) {
    // the user is logged in
    $project = $_GET["removeProject"];
    $path = "workspaces/" . $workspace . "/" . $project;
    $path= str_replace(" ", "_", "$path");
    function rrmdir($dir) { 
     if (is_dir($dir)) { 
       $objects = scandir($dir); 
       foreach ($objects as $object) { 
         if ($object != "." && $object != "..") { 
           if (is_dir($dir."/".$object)) {
             rrmdir($dir."/".$object);
           } else {
             unlink($dir."/".$object); 
           }
         } 
       }
       rmdir($dir); 
     } 
    }
  
    rrmdir($path);
    $login->setTimestamp();

  } else {
    // the user is not logged in
    require __DIR__ . '/views/login.php';
  }
});

$router->map( 'GET|POST', '/workspaces/[a:workspace]/add-file/', function( $workspace ) {
  // checking for minimum PHP version
  if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, The login script does not run on a PHP version smaller than 5.3.7 !");
  } else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("libraries/password_compatibility_library.php");
  }
  
  // include the configs / constants for the database connection
  require_once("config/db.php");
  
  // load the login class
  require_once("classes/Login.php");
  
  // create a login object. when this object is created, it will do all login/logout stuff automatically
  // so this single line handles the entire login process. in consequence, you can simply ...
  $login = new Login();
  
  if ($login->isUserLoggedIn() == true) {
    $file = $_GET["createFile"];
    $project = $_GET["inPath"];
    $path = "workspaces/" . $workspace . "/" . $project . "/" . $file;
    $path= str_replace(" ", "_", "$path");
  
    $dirname = dirname($path);
  
    if (!is_dir($dirname))
    {
      mkdir($dirname, 0777, true);
    }
  
    fopen($path, 'w');
    $login->setTimestamp();

  } else {
    // the user is not logged in
    require __DIR__ . '/views/login.php';
  }
});

$router->map( 'GET|POST', '/workspaces/[a:workspace]/upload-file/', function( $workspace ) {
  // checking for minimum PHP version
  if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, The login script does not run on a PHP version smaller than 5.3.7 !");
  } else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("libraries/password_compatibility_library.php");
  }
  
  // include the configs / constants for the database connection
  require_once("config/db.php");
  
  // load the login class
  require_once("classes/Login.php");
  
  // create a login object. when this object is created, it will do all login/logout stuff automatically
  // so this single line handles the entire login process. in consequence, you can simply ...
  $login = new Login();
  
  if ($login->isUserLoggedIn() == true) {
    $project = $_POST["inPath"];
    $path = "workspaces/" . $workspace . "/" . $project . "/";
    $path= str_replace(" ", "_", "$path");
  
    if ( 0 < $_FILES['file']['error'] ) {
      echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    } else {
      move_uploaded_file($_FILES['file']['tmp_name'], $path . $_FILES['file']['name']);
    }
    $login->setTimestamp();

  } else {
    // the user is not logged in
    require __DIR__ . '/views/login.php';
  }
});


$router->map( 'GET|POST', '/workspaces/[a:workspace]/save-file/', function( $workspace ) {
  // checking for minimum PHP version
  if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, The login script does not run on a PHP version smaller than 5.3.7 !");
  } else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("libraries/password_compatibility_library.php");
  }
  
  // include the configs / constants for the database connection
  require_once("config/db.php");
  
  // load the login class
  require_once("classes/Login.php");
  
  // create a login object. when this object is created, it will do all login/logout stuff automatically
  // so this single line handles the entire login process. in consequence, you can simply ...
  $login = new Login();
  
  if ($login->isUserLoggedIn() == true) {
    $file = $_GET["saveFile"];
    $project = $_GET["inPath"];
    $data = $_GET["filedata"];
    $path = "workspaces/" . $workspace . "/" . $project . "/" . $file;
    $path= str_replace(" ", "_", "$path");
  
    $handle = fopen($path, 'w');
    fwrite($handle, $data);
    
    $login->setTimestamp();

  } else {
    // the user is not logged in
    require __DIR__ . '/views/login.php';
  }
});


$router->map( 'GET|POST', '/workspaces/[a:workspace]/remove-file/', function( $workspace ) {
  // checking for minimum PHP version
  if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, The login script does not run on a PHP version smaller than 5.3.7 !");
  } else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("libraries/password_compatibility_library.php");
  }
  
  // include the configs / constants for the database connection
  require_once("config/db.php");
  
  // load the login class
  require_once("classes/Login.php");
  
  // create a login object. when this object is created, it will do all login/logout stuff automatically
  // so this single line handles the entire login process. in consequence, you can simply ...
  $login = new Login();
  
  if ($login->isUserLoggedIn() == true) {
    $file = $_GET["removeFile"];
    $project = $_GET["inPath"];
    $path = "workspaces/" . $workspace . "/" . $project . "/" . $file;
    $path= str_replace(" ", "_", "$path");
  
    unlink($path);
  
    $dirname = dirname("workspaces/" . $workspace . "/" . $project);
  
    removeEmptyFolders($dirname);
    $login->setTimestamp();

  } else {
    // the user is not logged in
    require __DIR__ . '/views/login.php';
  }
});

$router->map( 'GET|POST', '/workspaces/add-new/', function( ) {
  // checking for minimum PHP version
  if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, The login script does not run on a PHP version smaller than 5.3.7 !");
  } else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("libraries/password_compatibility_library.php");
  }
  
  // include the configs / constants for the database connection
  require_once("config/db.php");
  
  // load the login class
  require_once("classes/Login.php");
  
  // create a login object. when this object is created, it will do all login/logout stuff automatically
  // so this single line handles the entire login process. in consequence, you can simply ...
  $login = new Login();
  
  if ($login->isUserLoggedIn() == true) {
    $workspace_name = $_POST["workspace"];
    $path = "workspaces/" . $workspace_name;
    $path= str_replace(" ", "_", "$path");
    if (!is_dir($path)) {
      mkdir($path, 0777, true); // true for recursive create
    }
    header("Location: /");
    $login->setTimestamp();

  } else {
    // the user is not logged in
    require __DIR__ . '/views/login.php';
  } 
});

$router->map( 'GET|POST', '/workspaces/delete-old/', function( ) {
  // checking for minimum PHP version
  if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, The login script does not run on a PHP version smaller than 5.3.7 !");
  } else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("libraries/password_compatibility_library.php");
  }
  
  // include the configs / constants for the database connection
  require_once("config/db.php");
  
  // load the login class
  require_once("classes/Login.php");
  
  // create a login object. when this object is created, it will do all login/logout stuff automatically
  // so this single line handles the entire login process. in consequence, you can simply ...
  $login = new Login();
  
  if ($login->isUserLoggedIn() == true) {
    $workspace_name = $_POST["workspace"];
    $path = "workspaces/" . $workspace_name;
    $path= str_replace(" ", "_", "$path");
    function rrmdir($dir) { 
      if (is_dir($dir)) { 
        $objects = scandir($dir); 
        foreach ($objects as $object) { 
          if ($object != "." && $object != "..") { 
            if (is_dir($dir."/".$object)) {
              rrmdir($dir."/".$object);
            } else {
              unlink($dir."/".$object); 
            }
          } 
        }
        rmdir($dir); 
      } 
    }
  
    rrmdir($path);
  
    header("Location: /");
    $login->setTimestamp();

  } else {
    // the user is not logged in
    require __DIR__ . '/views/login.php';
  } 
});

$router->map( 'GET|POST', '/people/', function( ) {
  // checking for minimum PHP version
  if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, The login script does not run on a PHP version smaller than 5.3.7 !");
  } else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("libraries/password_compatibility_library.php");
  }
  
  // include the configs / constants for the database connection
  require_once("config/db.php");
  
  // load the login class
  require_once("classes/Login.php");
  
  // create a login object. when this object is created, it will do all login/logout stuff automatically
  // so this single line handles the entire login process. in consequence, you can simply ...
  $login = new Login();
  
  if ($login->isUserLoggedIn() == true) {
    // the user is logged in
    require __DIR__ . '/views/people.php';
    $login->setTimestamp();

  } else {
    // the user is not logged in
    require __DIR__ . '/views/login.php';
  }
});


$router->map( 'GET|POST', '/my-id/', function( ) {
  // checking for minimum PHP version
  if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, The login script does not run on a PHP version smaller than 5.3.7 !");
  } else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    require_once("libraries/password_compatibility_library.php");
  }
  
  // include the configs / constants for the database connection
  require_once("config/db.php");
  
  // load the login class
  require_once("classes/Login.php");
  
  // create a login object. when this object is created, it will do all login/logout stuff automatically
  // so this single line handles the entire login process. in consequence, you can simply ...
  $login = new Login();
  
  if ($login->isUserLoggedIn() == true) {
    // the user is logged in
    require __DIR__ . '/views/myid.php';
    $login->setTimestamp();

  } else {
    // the user is not logged in
    require __DIR__ . '/views/login.php';
  }
});




// match current request url
$match = $router->match();

// call closure or throw 404 status
if( $match && is_callable( $match['target'] ) ) {
  call_user_func_array( $match['target'], $match['params'] ); 
} else {
  // no route was matched
  header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}


function includeFolder($dir){
    $ffs = scandir($dir);
    foreach($ffs as $ff){
        if($ff != '.' && $ff != '..'){
            if(is_dir($dir.'/'.$ff)) {includeFolder($dir.'/'.$ff);} else {require_once($dir.'/'.$ff);}
        }
    }
}

function removeEmptyFolders($path){
  $empty=true;
  foreach (glob($path.DIRECTORY_SEPARATOR."*") as $file)
  {
     if (is_dir($file))
     {
        if (!removeEmptyFolders($file)) $empty=false;
     }
     else
     {
        $empty=false;
     }
  }
  if ($empty) rmdir($path);
  return $empty;
}
?>