<?php
    include('session.php');
    $selfProfile = false;
    $notFound = false;
    if (!isset($_GET['username'])) {
        if (!isset($_GET['id'])) {
            //self profile
            $selfProfile = true;
            $profileId = $userId;
            $profileAvatar = $avatarLink;
            $profileUsername  = $login_session;
            $postsResult = mysqli_query($connection,"SELECT * FROM `$TABLE_POSTS` WHERE `sender` = $profileId;");
            $postsCount = mysqli_num_rows($postsResult);
            $posts = mysqli_fetch_array($postsResult);
            $likesResult = mysqli_query($connection,"SELECT * FROM `$TABLE_LIKES_PROFILE` WHERE `profile_id` = $profileId;");
            $likesCount = mysqli_num_rows($likesResult);
        } else {
            $profileId = (int) mysqli_real_escape_string($connection, $_GET['id']);
            $profileAccount = mysqli_query($connection,"SELECT `id`,`username`,`avatar`,`role` FROM `$TABLE_ACCOUNTS` WHERE `id` = $profileId;");
            if ($profileAccountResult = mysqli_fetch_array($profileAccount)) {
                $profileAvatar = $profileAccountResult['avatar'];
                $profileUsername  = $profileAccountResult['username'];
                if ($userId == $profileId)
                    $selfProfile = true;
                $postsResult = mysqli_query($connection,"SELECT * FROM `$TABLE_POSTS` WHERE `sender` = $profileId;");
                $postsCount = mysqli_num_rows($postsResult);
                $posts = mysqli_fetch_array($postsResult);
                $likesResult = mysqli_query($connection,"SELECT * FROM `$TABLE_LIKES_PROFILE` WHERE `profile_id` = $profileId;");
                $likesCount = mysqli_num_rows($likesResult);
            }
        }
    } else {
        $profileUsername = mysqli_real_escape_string($connection, $_GET['username']);
        $profileAccount = mysqli_query($connection,"SELECT `id`,`username`,`avatar`,`role` FROM `$TABLE_ACCOUNTS` WHERE `username` = '".$profileUsername."';");
        if ($profileAccountResult = mysqli_fetch_array($profileAccount)) {
            $profileAvatar = $profileAccountResult['avatar'];
            $profileId = $profileAccountResult['id'];
            if ($userId == $profileId)
                $selfProfile = true;
            $postsResult = mysqli_query($connection,"SELECT * FROM `$TABLE_POSTS` WHERE `sender` = ".$profileId.";");
            $postsCount = mysqli_num_rows($postsResult);
            $posts = mysqli_fetch_array($postsResult);
            $likesResult = mysqli_query($connection,"SELECT * FROM `$TABLE_LIKES_PROFILE` WHERE `profile_id` = ".$profileId.";");
            $likesCount = mysqli_num_rows($likesResult);
        } else {
            //invalid
            $notFound = true;
        }
    }
    if (!$notFound && $selfProfile && isset($_POST['submit'])) {
        $tmpFilePath = $_FILES['avatar']['tmp_name'];
        $file_size = filesize($tmpFilePath);
        if ($tmpFilePath != "") {
            $file_name = $_FILES['avatar']['name'];
            $extension = pathinfo($file_name, PATHINFO_EXTENSION);
            $newFilePath = "uploaded/".time()."_".$file_name;
            if (!in_array($extension, ['png', 'jpg'])) {
                echo "You file extension must be .png or .jpg | now it's $extension";
            } else if ($file_size > 10000000) {
                echo "File too large: $file_size";
            } else {
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    mysqli_query($connection, "UPDATE `$TABLE_ACCOUNTS` SET `avatar` = '$newFilePath' WHERE `id` = $profileId;");
                } else {
                    echo "Failed to upload file.";
                }
            }
        }
    }
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
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
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
                    <?php if ($notFound) {?>
                    <h1>Couldn't find that profile!</h1>
                    <?php exit;}?>
                    <div class="profile" style="margin-top: 0px;">
                        <div style="display: flex;align-items: center;">
                            <div class="profile-pic" style="margin: 10px;min-width: 180px;min-height: 180px;width: 180px;height: 180px;">
                                <img src="<?php echo $profileAvatar;?>" alt="">
                            </div>
                            <div style="display: inline-block;padding-left: 20px;width: 100%;">
                                <h5 style="font-size: 25px;"><?php echo $profileUsername;?></h5>
                                <div style="display: flex;">
                                    <p style="font-weight: bold;"><?php echo $likesCount;?></p><p> likes</p>
                                    <p style="font-weight: bold;margin-left: 30px;"><?php echo $postsCount;?></p><p>  posts</p>
                                </div>
                            </div>
                            <?php 
                                if ($selfProfile) {
                            ?>
                            <div class="upload__box" style="border: 0px;">
                                <form id="upload-post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data" method="post">
                                    <div class="upload__btn-box">
                                        <label class="upload__btn">
                                            <span class="fas fa-upload"></span>Change avatar
                                            <input type="file" name="avatar" class="upload__inputfile" required>
                                        </label>
                                        <input class="submit" type="submit" name="submit" value="Apply avatar">
                                    </div>
                                </form>
                            </div>
                            <?php 
                                }
                            ?>
                        </div>
<!--                        <div style="display: inline-block;align-items: center;justify-content: space-evenly;">-->
                        <div class="gallery">
                            <div class="row">
                                <div class="column">
                        <?php 
                            $posts = mysqli_query($connection, "SELECT * FROM `$TABLE_POSTS` WHERE `sender` = $profileId ORDER BY `created_date` DESC;");
                            $postCount = mysqli_num_rows($posts);
                            $perCol = round($postCount / 5);
                            $count = 1;
                            while ($row = mysqli_fetch_array($posts)) {
                                $postid = $row['id'];
                                $sender = $row['sender'];
                                $images = mysqli_query($connection, "SELECT * FROM `$TABLE_FILES` WHERE post_id=$postid;");
                                if ($pictures = mysqli_fetch_array($images)) {
                                    if ($count > 1 && $perCol != 0 && $count % $perCol == 0) {
                        ?>
                                </div>
                                <div class="column">
                        <?php       
                                    }
                        ?>
                                <a href="http://localhost/post.php?id=<?php echo $postid;?>">
                                    <img src="<?php echo $pictures['file_path'];?>" alt="">
                                </a>
                        <?php
                                    $count++;
                                }
                            }
                        ?>
                                </div>
                            </div>
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