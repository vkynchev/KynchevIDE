<?php
if (!$_GET['path'] == ''){
	$path = $_GET['path'];
	if (file_exists(getcwd() . "/workspaces/" . $workspace . "/" . $path . "/index.html")){
		header ("Location: http://".$_SERVER['SERVER_NAME']."/workspaces/" . $workspace . "/" . $path . "/index.html");
		die;
	} elseif (file_exists(getcwd() . "/workspaces/" . $workspace . "/" . $path . "/index.php")) {
		header ("Location: http://".$_SERVER['SERVER_NAME']."/workspaces/" . $workspace . "/" . $path . "/index.php");
		die;
	}
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Preview | Kynchev</title>
        <?php if ($_GET['path'] == ''): ?>
	        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	        <link rel="stylesheet" href="../../../views/css/basic.css">
	        <style>
	        body {
	          background-color: #F4F6FC;
	        }
	        
	        h1.name {
	          color: #3498db;
		  font-size: 32px;
		  margin: 0rem;
		  margin-top: 2rem;
	        }
	        
	        .heading {
	          color: rgba(0,0,0, 0.8);
	        }
	        
	        .row {
	          padding: 20px 0px 20px 0px;
	          border-bottom: 1px solid rgba(0,0,0, 0.1);
	        }
	        
	        </style>
        <?php endif; ?>
    </head>
    <?php if ($_GET['path'] == ''): ?>
	    <body style="display: flex; justify-content: center;  position: fixed; top: 0px; left: 0px; right: 0px; bottom: 0px;">
	    	<div class="wrap" style="text-align: center;">
	    		<img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/views/img/logo.svg" style="height: 100px; width: 100%; margin-bottom: -50px; margin-top: 20px;">
			<h1 class="name text--center">KYNCHEV</h1>
	    		<h1 class="heading">Select Project</h1>
	    		<p class="heading">You will need <b>index.html</b> or <b>index.php</b> file in the project to use 'Preview'.</p>
	        			<?php
					
					$rootdir = "workspaces/".$workspace;
					
					$response = scan($rootdir);
					
					if (empty($response)) {
						echo '<div class="row" style="border: none;">
							<span style="width: 100%; text-align: center;">There are no projects...</span>
					              </div>';
					}
					foreach($response as $result) {
						if($result['type'] == 'folder'){
							$link = str_replace($rootdir.'/', '', $result['path']);
							echo '<div class="row">
								<div class="proj-name">
						                  <div class="name"><a style="color: rgba(0,0,0, 0.8);" href="?path=' . $link . '">' . $result['name'] . '</a></div>
					                        </div>
					                      </div>';
						}
					}
					
					
					//debug($response);
					
					?>
		</div>
	    </body>
    <?php endif; ?>
</html>