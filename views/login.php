<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sign In | Kynchev</title>
	<link rel="shortcut icon" href="../../views/img/logo.ico" type="image/x-icon" />
	
	<link rel="stylesheet" href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/views/css/basic.css">
	<link rel="stylesheet" href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/views/css/form.css">
</head>

<body>
	<section class="align">
		<div class="site__container">
			<div class="grid__container">
				<img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/views/img/logo.svg" style="height: 100px; width: 100%; margin-bottom: -50px;"></img>
				<h1 class="name text--center">KYNCHEV</h1>
				<p class="name-info text--center">Web Developer IDE</p>
				<?php
				// show potential errors / feedback (from login object)(ex: You have been logged out.)
				if (isset($login)) {
					if ($login->errors) {
						foreach ($login->errors as $error) {
							echo '<div class="info text--center">' . $error . '</div>';
						}
					}
					if ($login->messages) {
						foreach ($login->messages as $message) {
							echo '<div class="info text--center">' . $message. '</div>';
						}
					}
					
				} elseif (isset($registration)) {
					if ($registration->messages) {
						foreach ($registration->messages as $message) {
							echo '<div class="info text--center">' . $message. '</div>';
						}
					}
				}
				?>
				
				<form action="/" method="POST" class="form form--login">
					<div class="form__field shadow-1">
						<label class="icon fa fa-user" for="login__username"><span class="hidden">Username / Email</span></label>
						<input id="login__username" type="text" class="form__input" placeholder="v.kynchev@gmail.com" name="user_name">
					</div>
					<div class="form__field shadow-1">
						<label class="icon fa fa-lock" for="login__password"><span class="hidden">Password</span></label>
						<input id="login__password" type="password" class="form__input" placeholder="******" name="user_password">
					</div>
					<div class="form__field shadow-1">
						<input type="submit" name="login" value="Sign In">
					</div>
				</form>
			</div>
		</div>
	</section>
</body>
</html>