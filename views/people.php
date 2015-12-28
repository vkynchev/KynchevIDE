<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>People | Kynchev</title>
	<link rel="shortcut icon" href="../../views/img/logo.ico" type="image/x-icon" />
	
	<link rel="stylesheet" href="../views/css/basic.css">
	<link rel="stylesheet" href="../views/css/people.css">
	<link rel="stylesheet" href="../views/css/toastr.min.css">
</head>

<body>
	<section class="menus">
		<div class="right-menu shadow-2">
			<a href="/my-id/?from=people" class="card-link">
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
				<a class="main-nav-item" href="/">Workspaces</a>
				<a class="main-nav-item active" href="/people/">People</a>
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
			<div class="heading">
				<h1>People</h1>
				<div class="map"><i class="fa fa-star"></i> - Developer<br><i class="fa fa-star-half-o"></i> - Jr. Developer<br><i class="fa fa-star-o"></i> - Read-only</div>
			</div>
			<div class="wrap">
					<?php
					$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
					
					$sql = "SELECT *
			                        FROM users
			                        ORDER BY info_name, user_name;";
                                        $result_users = $db_connection->query($sql);
                                        $result_users_count = $result_users->num_rows;

					while($result_row = $result_users->fetch_object()){
					  //output a row here
					  if($result_row->info_name !== ''){
				            $name = $result_row->info_name;
				          } else {
				            $name = $result_row->user_name;
				          }
				          
				          if($_SESSION['user_position'] == 'developer'){
				            if($result_row->user_name == $_SESSION['user_name']) {$starcursor = 'normal'; $currentclass = 'current';} else {$starcursor = 'pointer'; $currentclass = 'notcurrent';}
				          } else {
				            if($result_row->user_name == $_SESSION['user_name']) {$starcursor = 'normal'; $currentclass = 'current';} else {$starcursor = 'normal'; $currentclass = 'notcurrent';}
				          }
				          
				          $symbol = $name[0];
				          if($result_row->user_position == 'developer'){ $star = '<i class="fa fa-star"></i>'; }
				          if($result_row->user_position == 'jr_developer'){ $star = '<i class="fa fa-star-half-o"></i>'; }
				          if($result_row->user_position == 'read_only'){ $star = '<i class="fa fa-star-o"></i>'; }
				          
				          $position = $result_row->info_desc;
				          if(strtotime($result_row->user_online_timestamp) > strtotime("-15 minutes")){ $color_online = '#2ecc71'; }else{ $color_online = '#e74c3c'; };
					  
					  echo '<div class="user">
					          <div class="star-position ' . $currentclass . '" id="' . $result_row->user_name . '" style="cursor: ' . $starcursor . ';">' . $star .'</div>
						  <div class="icon">
						    ' . $symbol . '
						  </div>
						  <div class="online-status" style="background-color: ' . $color_online . ';"></div>
						  <div class="info">' . $name . '</div>
						  <div class="position">' . $position . '</div>
				                </div>
				                <div class="divider"></div>';
					}
					?>
			</div>
		</div>
		
		<div class="right-options">
			<p class="invite-link">Invite people</p>
		</div>
	</section>
	
	<div class="overlay">
		<div class="generate-invite">
			<div class="exit-btn"><i class="fa fa-times"></i></div>
			<div class="modal-icon"><i class="fa fa-link"></i></div>
			<div class="fill">
				<h2 class="normal">Generate Register Link</h2>
				<div class="generate">	
					<h3 class="normal">This link can be used only by one person and will be active for 24 hours.</h3>				
				        <form class="generate-form">
						<input class="generate-field" onClick="this.select();" type="text" name="generated-link" placeholder="Link will appear here..."/>
						<input class="generate-field-btn" type="submit" value="Generate" style="cursor: pointer;">
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<script src="../views/js/jquery-2.1.4.min.js"></script>
	<script src="../views/js/header.js"></script>
	<script src="../views/js/people.js"></script>
	<script src="../views/js/toastr.min.js"></script>
</body>
</html>
