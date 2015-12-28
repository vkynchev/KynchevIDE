<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>My ID | Kynchev</title>
	<link rel="shortcut icon" href="../../views/img/logo.ico" type="image/x-icon" />
	
	<link rel="stylesheet" href="../views/css/basic.css">
	<link rel="stylesheet" href="../views/css/myid.css">
	<link rel="stylesheet" href="../views/css/toastr.min.css">
</head>

<body>
	<section class="buttons">
		<?php 
		  if($_GET['from'] != '') { echo '<div class="back btn shadow-1"><i class="fa fa-arrow-left"></i> Go back</div>';} else { echo '<div></div>';}
		?>
		<div class="logout btn shadow-1">Log Out</div>
	</section>
	
	<section class="page">
		<div class="icon" style="text-transform: uppercase;">
			<?php
			  if($_SESSION[info_name] !== ''){
			    $name = $_SESSION['info_name'];
			  } else {
			    $name = $_SESSION['user_name'];
			  }
			  
			  echo $name[0];
			?>
		</div>
		<div class="name">
			<form class="name-form">
				<input class="name under" type="text" value="<?php echo $_SESSION['info_name']; ?>" name="info_name" placeholder="Name">
			</form>
		</div>
		
		<div class="desc">
			<form class="desc-form">
				<input class="desc under" type="text" value="<?php echo $_SESSION['info_desc']; ?>" name="info_desc" placeholder="Description">
			</form>
		</div>
		
		<!-- <div class="password-protected">
			<div class="inactive-overlay"></div>
			Whazzup
		</div> -->
	</section>
	
	
	<script src="../views/js/jquery-2.1.4.min.js"></script>
	<script src="../views/js/myid.js"></script>
	<script src="../views/js/toastr.min.js"></script>
</body>
</html>