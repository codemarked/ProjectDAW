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
        <script type="text/javascript" src="js/reloadFix.js"></script>
        <link rel="icon" type="image/x-icon" href="img/logo.ico">
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Caption&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="header">
            <div style="width: 75%;margin: auto;heigth: 80%;">
                <a href="http://localhost/home.php"><div class="logo" style="background-image: url(img/logo.png)"></div></a>
            </div>
        </div>
        <div class="container">
            <div class="wrapper">
                <div class="left-col">
                    <div class="profile" style="margin-top: 0px;">
                        <div style="display: flex;align-items: center;">
                            <div class="profile-pic" style="margin: 10px;width: 180px;height: 180px;">
                                <img src="<?php echo $avatarLink;?>" alt="">
                            </div>
                            <div style="display: inline-block;padding-left: 20px;">
                                <h5 style="font-size: 25px;"><?php echo $login_session;?></h5>
                                <div style="display: flex;">
                                    <p style="font-weight: bold;"><?php echo $likesCount;?></p><p> likes</p>
                                    <p style="font-weight: bold;margin-left: 30px;"><?php echo $postsCount;?></p><p> posts</p>
                                </div>
                            </div>
                        </div>
                        <div style="display: inline-block;align-items: center;justify-content: space-evenly;">
                        <?php 
                            $posts = mysqli_query($connection, "SELECT * FROM `$TABLE_POSTS` WHERE `sender` = $session_id ORDER BY `created_date` DESC LIMIT 10;");
                            while ($row = mysqli_fetch_array($posts)) {
                                $postid = $row['id'];
                                $sender = $row['sender'];
                                $images = mysqli_query($connection, "SELECT * FROM `$TABLE_FILES` WHERE post_id=$postid;");
                                if ($pictures = mysqli_fetch_array($images)) {
                            
                        ?>
                                <img src="<?php echo $pictures['file_path'];?>" class="posted" alt="">
                        <?php
                                }
                            }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <small style="margin-left: 10px;color: #fff;">&copy; Copyright 2022, Bartha R.</small>
            <small style="color: #fff;font-size: 20px;">|</small>
            <a href="">Terms of Service</a>
            <small style="color: #fff;font-size: 20px;">|</small>
            <a href="">Privacy Policy</a>
        </div>
	</body>
</html>