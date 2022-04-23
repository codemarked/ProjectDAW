<?php
    include('session.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Random Images</title>
        <meta name="description" content="Random Images Homepage">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="B. Roland">
        <link rel="icon" type="image/x-icon" href="img/logo.ico">
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Caption&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="header">
            <div class="logo" style="background-image: url(img/logo.png)"></div>
            <div class="links">
                <a style="visibility: hidden;">HIDDEN</a>
                <a style="visibility: hidden;">HIDDEN</a>
                <a class="active">HOME</a>
                <a id="regular">GALLERY</a>
                <a id="regular">CONTACT</a>
                <div class="auth">
                    <a href="http://localhost/profile.php" id="regular">PROFILE</a>
                </div>
                <div class="auth">
                    <a href="http://localhost/logout.php" id="regular">LOGOUT</a>
                </div>
            </div>
        </div>
        <div class="container">
			<h2>Profile Page</h2>
			<div>
				<p>Your account details are below:</p>
				<table>
					<tr>
						<td>Username:</td>
						<td><?php echo $login_session;?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?php echo $email;?></td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>