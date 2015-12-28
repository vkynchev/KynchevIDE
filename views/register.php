<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sign Up | Kynchev</title>
	<link rel="shortcut icon" href="../../views/img/logo.ico" type="image/x-icon" />
	
	<link rel="stylesheet" href="../views/css/basic.css">
	<link rel="stylesheet" href="../views/css/form.css">
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
				if (isset($registration)) {
					if ($registration->errors) {
						foreach ($registration->errors as $error) {
							echo '<div class="info text--center">' . $error . '</div>';
						}
					}
					if ($registration->messages) {
						foreach ($registration->messages as $message) {
							echo '<div class="info text--center">' . $message. '</div>';
						}
					}
				}
				?>
				
				<form action="/register/" method="POST" class="form form--login">
					<div class="form__field shadow-1">
						<label class="icon fa fa-user" for="login__username"><span class="hidden">Username</span></label>
						<input id="login__username" type="text" class="form__input" placeholder="Username" name="user_name">
					</div>
					<div class="form__field shadow-1">
						<label class="icon fa fa-envelope" for="login__username"><span class="hidden">Email</span></label>
						<input id="login__username" type="text" class="form__input" placeholder="Email" name="user_email">
					</div>
					<div class="form__field shadow-1">
						<label class="icon fa fa-lock" for="login__password"><span class="hidden">Password</span></label>
						<input id="login__password" type="password" class="form__input" placeholder="Password" name="user_password_new" autocomplete="off">
					</div>
					<div class="form__field shadow-1">
						<label class="icon fa fa-lock" for="login__password"><span class="hidden">Repeat Password</span></label>
						<input id="login__password" type="password" class="form__input" placeholder="Repeat Password" name="user_password_repeat" autocomplete="off">
					</div>
					<div class="form__field shadow-1">
						<input type="submit" name="register" value="Sign Up">
					</div>
				</form>
			</div>
		</div>
	</section>
</body>
</html>