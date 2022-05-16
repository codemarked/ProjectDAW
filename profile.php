<?php
    include('session.php');
    $postsResult = mysqli_query($connection,"SELECT * FROM `$TABLE_POSTS` WHERE `sender` = ".$_SESSION['id'].";");
    $postsCount = mysqli_num_rows($postsResult);
    $posts = mysqli_fetch_array($postsResult);
    $likesResult = mysqli_query($connection,"SELECT * FROM `$TABLE_LIKES_PROFILE` WHERE `profile_id` = ".$_SESSION['id'].";");
    $likesCount = mysqli_num_rows($likesResult);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Upper</title>
        <meta name="description" content="Upper Profile">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="B. Roland">
        <link rel="icon" type="image/x-icon" href="img/logo.ico">
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Caption&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="header">
            <div class="logo" style="background-image: url(img/logo.png)"></div>
        </div>
        <div class="container">
            <div class="post">
                <div style="display: flex;align-items: center;">
                    <div class="profile-pic" style="width: 180px;height: 180px;"><img src="<?php echo $avatarLink;?>" alt=""></div>
                    <div style="font-size: 25px;padding-left: 20px;">
                        <div><?php echo $login_session;?></div>
                        <div><?php echo $likesCount;?> profile likes</div>
                        <div><?php echo $postsCount;?> posts</div>
                    </div>
                </div>
            </div>
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