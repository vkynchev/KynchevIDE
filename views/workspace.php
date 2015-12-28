<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $workspace; ?> | Kynchev</title>
	<link rel="shortcut icon" href="../../views/img/logo.ico" type="image/x-icon" />
	
	<link rel="stylesheet" href="../../views/css/basic.css">
	<link rel="stylesheet" href="../../views/css/workspace.css">
</head>

<body>
	<div style="display: none;" class="user-position"><?php echo $_SESSION['user_position']; ?></div>
	<section class="menus">
		<div class="right-menu shadow-2">
			<a href="/my-id/?from=<?php echo $workspace; ?>" class="card-link">
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
				<a class="main-nav-item active" href="/workspaces/<?php echo $workspace; ?>/">Browse</a>
				<!--<a class="main-nav-item" href="/people/">People</a>-->
			</div>
			<div>
				<!-- <a class="main-nav-item" style="cursor: pointer;"><?php echo $workspace; ?> Settings</a> -->
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
		<div class="page-box" id="droparea">
			<div class="heading">
				<h1>
				<?php  
				if(isset($_GET['path']) && $_GET['path'] != '' && $_GET['path'] != $rootdir) {
					echo '<a href="?path=">'.$workspace.'</a>';
					$paths = explode("/", $_GET['path']);
					foreach($paths as $index => $path){
						for ($i = 0; $i <= $index; $i++) {
							$deep = $i;
						}
						
						for($i = 0; $i <= $deep; $i++){
							if($i == 0){
								$link = $paths[$i];
							} else {
								$link = $link . '/' . $paths[$i];
							}
							
						}
						
						echo ' <i style="color: #3498db;" class="fa fa-angle-right"></i> <a href="?path='.$link.'">'.$path.'</a>';
					}
				} else {
					$deep = -1;
					echo '<a href="?path=">'.$workspace.'</a>';
				}
				?>
				
				<div class="filename" style="display: none;"> <i style="color: #3498db;" class="fa fa-angle-right"></i> <span><form  class="filename-add" style="display: none; color: rgba(0, 0, 0, 0.8);"><input class="file-name" type="text" name="filename" placeholder="Filename"/><input class="file-name-btn" type="submit" value="Create" style="cursor: pointer; display: none;"></form></span></div>
				</h1>
				<div class="fullscreen"><i class="fa fa-expand"></i></div>
			</div>
			
			<div class="wrap">
				<?php
				
				$rootdir = "workspaces/".$workspace;

				if(isset($_GET['path']) && $_GET['path'] != '' && $_GET['path'] != $rootdir) {
					$dir = $rootdir . '/' . $_GET['path'];
				} else {
					$dir = $rootdir;
				}
				
				$response = scan($dir);
				
				echo '<div class="row head" style="border-bottom: 1px solid #BBC4CE;">
					<div class="icon-name">
					  <div class="icon" style="font-size: 14px; color: black;">Type</div>
					  <div class="name" style="cursor: auto; text-decoration: none;">Name</div>
				        </div>
				        <div class="size" style="text-align: center;">File Size</br>(in Bytes)</div>
				      </div>';
				
				if (empty($response)) {
					echo '<div class="row" style="border: none;">
						<span style="width: 100%; text-align: center;">There are no files...</span>
				              </div>';
				}
				foreach($response as $result) {
					if($result['type'] == 'folder'){
						$link = str_replace($rootdir.'/', '', $result['path']);
						echo '<div class="row">
							<div class="icon-name">
						          <div class="icon"><i class="fa fa-folder-o"></i></div>
					                  <div class="name"><a style="color: #3498DB;" href="?path=' . $link . '">' . $result['name'] . '</a></div>
				                        </div>
				                      </div>';
					} else {
						echo '<div class="row">
							<div class="icon-name">
						          <div class="icon"><i class="fa fa-file-o"></i></div>
					                  <div class="name" file-path="' . $result['path'] . '" file-extension="' . $result['ext'] . '">' . $result['name'] . '</div>
				                        </div>
				                        <div class="size">' . $result['size'] . ' B</div>
						      </div>';
					}
				}
				
				
				//debug($response);
				
				?>
				
			</div>
			
			<div id="editor" style="display: none;"><xmp></xmp></div>
			<div id="viewer" style="display: none;"></div>
			
		</div>
		
		<div class="right-options">
			<a target="_blank" href="preview/" style="text-decoration: none;"><p class="preview-link">Preview</p></a>
			<hr style="width: 50%; background-color: #DADFE9; height: 1px; border: 0; opacity: 0.5;">
			
			<?php
			if($deep == -1){
				if($_SESSION["user_position"] == 'developer') {
					echo '<p class="add add-project">New Project</p>';
				}
			}elseif($deep >= 0){
				if($_SESSION["user_position"] != 'read_only') {
				        echo '<p class="add add-file">New File</p>';
				        echo '<div class="remove-file-container"></div>';
				}
			        if($_SESSION["user_position"] == 'developer') {
				        echo '<hr style="width: 50%; background-color: #DADFE9; height: 1px; border: 0; opacity: 0.5;">';
				        echo '<p class="add download-project">Download Project</p>';
					echo '<p class="remove remove-project">Remove Project</p>';
				}
			} 
			?>
		</div>
		
		<div class="upload-file">
			<div class="area">
				<div class="icon" style="font-size: 64px;"><i class="fa fa-upload"></i></div>
				<div class="text" style="font-size: 32px;">Drag n' Drop to upload file...</div>
			</div>
			<div class="progresss"></div>
		</div>
	</section>
	<div id="editorBuffer" style="display: none;"></div>
	
	<div class="overlay">
		<div class="project">
			<div class="exit-btn"><i class="fa fa-times"></i></div>
			<div class="modal-icon"><i class="fa fa-code"></i></div>
			<div class="fill">
				<h2>Create new project</h2>
				<div class="new-project">
					<form class="project-form">
						<input class="project-name" type="text" name="project-name" placeholder="Name"/>
						<input class="project-name-btn" type="submit" value="Create" style="cursor: pointer;">
					</form>
				</div>
			</div>
		</div>
		
	</div>
	
	<div class="overlay2">
		<div class="confirm-delete">
			<div class="exit-btn"><i class="fa fa-times"></i></div>
			<div class="modal-icon2"><i class="fa fa-trash-o"></i></div>
			<div class="fill">
				<h2>Are you sure?</h2>
				<div class="password">
					<h3>Type your password to confirm:</h3>
					<form class="check-pass">
						<input class="password-check" type="password" name="password-check" placeholder="******" project="<?php echo $paths[0];?>"/>
						<input class="password-check-btn" type="submit" value="Delete" style="cursor: pointer;">
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<script src="../../views/js/ace/ace.js"></script>
	<script src="../../views/js/ace/ext-modelist.js"></script>
	<script src="../../views/js/ace/ext-language_tools.js"></script>
	<script src="../../views/js/jquery-2.1.4.min.js"></script>
	<script src="../../views/js/filedrop.js"></script>
	<script src="../../views/js/header.js"></script>
	<script src="../../views/js/workspace.js"></script>
	
</body>
</html>