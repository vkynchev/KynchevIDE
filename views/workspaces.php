<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Workspaces | Kynchev</title>
	<link rel="shortcut icon" href="../../views/img/logo.ico" type="image/x-icon" />
	
	<link rel="stylesheet" href="../views/css/basic.css">
	<link rel="stylesheet" href="../views/css/workspaces.css">
</head>

<body>
	<section class="menus">
		<div class="right-menu shadow-2">
			<a href="/my-id/?from=workspaces" class="card-link">
				<div class="card">
					<div class="icon"><i class="fa fa-lightbulb-o shadow-1"></i></div>
					<div class="info">
						<div class="title">Manage your profile</div>
						<div class="description">Avatar, name, description, password</div>
					</div>
				</div>
			</a>
			
			<a class="logout shadow-1" href="?logout">Log out</a>
		</div>
	</section>
	<section class="header shadow-1">
		<div class="left-header part">
			<div class="home-btn"><i class="fa fa-home"></i></div>
		</div>
		<div class="center-header part">
			<div>
				<a class="main-nav-item active" href="/">Workspaces</a>
				<a class="main-nav-item" href="/people/">People</a>
			</div>
			<div>
				
			</div>
		</div>
		<div class="right-header part">
			<div class="right-menu-toggle">
				<?php 
				if($_SESSION['info_name'] !== ''){
				  $name = $_SESSION['info_name'];
				} else {
				  $name = $_SESSION['user_name'];
				}
				
				$name = $name[0]; 
				echo $name;
				?>
			</div>
			</nav>
		</div>
	</section>
	
	<section class="page">
		<div class="page-box">
			<h1>Workspaces</h1>
			<div class="wrap">
					<?php
					//path to directory to scan
			                $directory = "workspaces/";
			 
			                //get all files in specified directory
			                $files = glob($directory . "*");
			 
			                //print each file name
			                foreach($files as $file) {
			                  //check to see if the file is a folder/directory
			                  if(is_dir($file)) {
			                    $file = str_replace("$directory", "", "$file");
			                    if($_SESSION["user_position"] == 'developer'){
			                      echo '<form id="' . $file . '" class="delete-form" action="/workspaces/delete-old/" method="post">
			                            <div class="workspace">
						      <div class="icon"><i class="fa fa-server"></i></div>
						      <div class="info">' . $file . '</div>
						      <a href="/workspaces/' . $file . '/" class="open"><div class="name">Open</div></a><br>
						      <input type="text" name="workspace" value="' . $file . '" style="text-align: center; display: none;"/>
						      <a href="" class="delete"><input type="submit" id="delete-confirm" class="fa fa-trash" value="&#xf014;" style="cursor: pointer;"></a>
				                    </div>
				                    </form>
				                    <div class="divider"></div>';
				            } else {
				              echo '<div class="workspace">
						      <div class="icon"><i class="fa fa-server"></i></div>
						      <div class="info">' . $file . '</div>
						      <a href="/workspaces/' . $file . '/" class="open"><div class="name">Open</div></a><br>
				                    </div>
				                    <div class="divider"></div>';
				            }
			                  }
			                }
			                
			                if($_SESSION["user_position"] == 'developer') {
			                 echo '<form action="/workspaces/add-new/" method="post">
					         <div class="workspace">
				                   <div class="icon"><i class="fa fa-server"></i></div>
					           <div class="info"><input class="under" type="text" name="workspace" placeholder="Workspace Name" style="text-align: center;"/></div><br>
					           <a href="" class="open"><input type="submit" value="Add" style="cursor: pointer;"></a>
					         </div>
			                       </form>';
			                }
					?>
					
				        
			</div>
		</div>
	</section>
	
	<div class="overlay">
		<div class="confirm-delete">
			<div class="exit-btn"><i class="fa fa-times"></i></div>
			<div class="modal-icon"><i class="fa fa-trash-o"></i></div>
			<div class="fill">
				<h2>Are you sure?</h2>
				<div class="password">
					<h3>Type your password to confirm:</h3>
					<form class="check-pass">
						<input class="password-check"type="password" name="password-check" placeholder="******"/>
						<input class="password-check-btn" type="submit" value="Delete" style="cursor: pointer;">
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<script src="../views/js/jquery-2.1.4.min.js"></script>
	<script src="../views/js/header.js"></script>
	<script src="../views/js/workspaces.js"></script>
</body>
</html>