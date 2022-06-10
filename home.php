<?php
    include('utils.php');
    include('session.php');
    $currentTime = round(microtime(true) * 1000);
    if (isset($_POST['reaction'])) {
        if ($_POST['reaction'] == 'Like_Post') {
            mysqli_query($connection, "INSERT INTO `$TABLE_LIKES_POST` (`post_id`,`sender`,`created_date`) VALUES (".$_POST['postid'].",".$userId.",".(round(microtime(true) * 1000)).");");
            
        } else if ($_POST['reaction'] == 'Unlike_Post') {
            mysqli_query($connection, "DELETE FROM `$TABLE_LIKES_POST` WHERE `sender`=".$userId." AND `post_id`=".$_POST['postid'].";");
            
        } else if ($_POST['reaction'] == 'Like_Profile') {
            mysqli_query($connection, "INSERT INTO `$TABLE_LIKES_PROFILE` (`post_id`,`sender`,`created_date`) VALUES (".$_POST['postid'].",".$userId.",".(round(microtime(true) * 1000)).");");
            
        } else if ($_POST['reaction'] == 'Unlike_Profile') {
            mysqli_query($connection, "DELETE FROM `$TABLE_LIKES_PROFILE` WHERE `sender`=".$userId." AND `post_id`=".$_POST['postid'].";");
            
        } else if ($_POST['reaction'] == 'Comment_Post') {
            mysqli_query($connection, "INSERT INTO `$TABLE_COMMENTS_POST` (`post_id`,`sender`,`text`,`created_date`) VALUES (".$_POST['postid'].",".$userId.",'".$_POST['text']."',".(round(microtime(true) * 1000)).");");
        } else if ($_POST['reaction'] == 'Uncomment_Post') {
            mysqli_query($connection, "DELETE FROM `$TABLE_COMMENTS_POST` WHERE `sender`=".$_POST['user']." AND `post_id`=".$_POST['postid']." AND `id`=".$_POST['id'].";");
        } else if ($_POST['reaction'] == 'Comment_Profile') {
            mysqli_query($connection, "INSERT INTO `$TABLE_COMMENTS_PROFILE` (`post_id`,`sender`,`text`,`created_date`) VALUES (".$_POST['postid'].",".$userId.",'".$_POST['text']."',".(round(microtime(true) * 1000)).");");
        } else if ($_POST['reaction'] == 'Hide_Comment_Post') {
            mysqli_query($connection, "UPDATE `$TABLE_COMMENTS_POST` SET `visible`=0 WHERE `sender`=".$_POST['user']." AND `post_id`=".$_POST['postid']." AND `id`=".$_POST['id'].";");
        } else if ($_POST['reaction'] == 'Uncomment_Profile') {
            mysqli_query($connection, "DELETE FROM `$TABLE_COMMENTS_PROFILE` WHERE `sender`=".$userId." AND `post_id`=".$_POST['postid'].";");
        }
    } else if (isset($_POST['unpost'])) {
        $query = "DELETE FROM `$TABLE_POSTS` WHERE `id`=".$_POST['postid'].";";
    } else if (isset($_POST['submit'])) {
        $files = array_filter($_FILES['upload']['name']);
        $totalCount = count($_FILES['upload']['name']);
    
        if (isset($_POST['description']) && !empty($_POST['description'])) {
            $description = $_POST['description'];
            $query = "INSERT INTO `$TABLE_POSTS` (sender, description,created_date) VALUES ('$userId', '$description',$currentTime);";
        } else {
            $query = "INSERT INTO `$TABLE_POSTS` (sender,created_date) VALUES ('$userId',$currentTime);";
        }
        
        if (mysqli_query($connection, $query)) {
            $post_id = mysqli_insert_id($connection);
    
            for($i=0;$i<$totalCount;$i++) {
                $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
                $file_size = filesize($tmpFilePath);
                if ($tmpFilePath != "") {
                    $file_name = $_FILES['upload']['name'][$i];
                    $extension = pathinfo($file_name, PATHINFO_EXTENSION);
                    $newFilePath = "uploaded/".round(microtime(true)).$extension;
                    if (!in_array($extension, ['png', 'jpg'])) {
                        echo "You file extension must be .png or .jpg | now it's $extension";
                    } else if ($file_size > 8388608) {
                        echo "File too large: $file_size";
                    } else {
                        if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                            mysqli_query($connection, "INSERT INTO `$TABLE_FILES` (post_id, file_name, file_path, file_size) VALUES ('$post_id', '$file_name','$newFilePath', $file_size);");
                        } else {
                            echo "Failed to upload file";
                        }
                    }
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
        <meta name="description" content="Upper Homepage">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="B. Roland">
        <link rel="icon" type="image/x-icon" href="img/logo.ico">
        <link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script type="text/javascript" src="js/upload_images.js"></script>
        <script type="text/javascript" src="js/postButtons.js"></script>
        <script type="text/javascript" src="js/reloadFix.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Caption&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="header">
            <div style="width: 75%;margin: auto;">
                <div class="logo" style="background-image: url(img/logo.png)"></div>
                <div style="float: right;">
                    <div class="dropdown">
                        <div class="hoverable">
                            <div class="info">
                                <div class="user">
                                    <div class="profile-pic" style="width: 45px;height: 45px;broder: 1px solid #fff;">
                                        <img src="<?php echo $avatarLink;?>" alt="">
                                    </div>
                                    <p class="username" style="color: white;"><?php echo $login_session;?></p>
                                    <?php if ($role == 'admin') {?>
                                        <img src="img/icon/admin.png" style="width: 20px;height: 20px;">
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-content">
                            <a href="http://localhost/profile.php" id="regular"><span class="fas fa-user"></span>Profile</a>
                            <a href="http://localhost/logout.php" id="regular"><span class="fas fa-sign-out-alt"></span>Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="wrapper">
                <div class="left-col">
                    <div class="upload__box">
                        <form id="upload-post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data" method="post">
                        </form>
                        <div class="comment-wrapper">
                            <input form="upload-post" class="comment-box" name="description" placeholder="Add a description" maxlength=255>
                            <input form="upload-post" class="submit" type="submit" name="submit" value="Post">
                        </div>
                        <div class="upload__btn-box">
                            <label class="upload__btn">
                                <span class="fas fa-upload"></span>Upload
                                <input form="upload-post" id="uploadField" type="file" name="upload[]" data-max_length="1" class="upload__inputfile" required>
                            </label>
                        </div>
                        <div class="upload__img-wrap"></div>
                    </div>
                    
                    <?php 
                        $posts = mysqli_query($connection, "SELECT * FROM `$TABLE_POSTS` ORDER BY `created_date` DESC LIMIT 10;");
                        while ($row = mysqli_fetch_array($posts)) {
                            $postid = $row['id'];
                            $postSender = $row['sender'];
                            $account = mysqli_query($connection, "SELECT `id`, `username`, `avatar`, `role` FROM `$TABLE_ACCOUNTS` WHERE `id`=$postSender;");
                            if ($profile = mysqli_fetch_array($account)) {
                    ?>
                    
                    <div class="post" id="post-<?php echo $postid;?>">
                        <div class="info">
                            <a href="http://localhost/profile.php?username=<?php echo $profile['username'];?>" id="regular">
                                <div class="user">
                                    <div class="profile-pic"><img src="<?php echo $profile['avatar'];?>" alt=""></div>
                                    <p class="username"><?php echo $profile['username'];?></p>
                                    <?php if ($profile['role'] == 'admin') {?>
                                        <img src="img/icon/admin.png" style="width: 20px;height: 20px;">
                                    <?php }?>
                                </div>
                            </a>
                            <div class="dropdown">
                                <img src="img/icon/option.png" style="width: 20px;" class="options" alt="">
                                <?php if ($postSender == $userId || $role == 'admin') {?>
                                <div class="dropdown-content">
                                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="postid" <?php echo 'value="'.$postid.'"'?>>
                                        <label class="post_delete_button">
                                            <span class="fas fa-eye-slash" style="font-size: 15px;" id="h-<?php? echo $postid;?>"></span>
                                            <input form="upload-post" class="submit" type="submit" name="hide_post" value="Hide Post">
                                        </label>
                                    </form>
                                    
                                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data" method="post">
                                        <input type="hidden" name="postid" <?php echo 'value="'.$postid.'"'?>>
                                        <label class="post_delete_button">
                                            <span class="fas fa-trash-alt" style="font-size: 15px;" id="d-<?php? echo $postid;?>"></span>
                                            <input form="upload-post" class="submit" type="submit" name="unpost" value="Delete Post">
                                        </label>
                                    </form>
                                </div>
                                <?php }?>
                            </div>
                        </div>
                        
                        <?php
                            $images = mysqli_query($connection, "SELECT * FROM `$TABLE_FILES` WHERE post_id=$postid;");
                            while ($pictures = mysqli_fetch_array($images)) {
                        ?>
                        
                        <a href="http://localhost/post.php?id=<?php echo $postid;?>">
                            <img src="<?php echo $pictures['file_path'];?>" class="post-image" alt="">
                        </a>
                        
                        <?php } ?>
                        
                        <div class="post-content">
                            
                            <?php 
                                $likeUser = mysqli_query($connection,"SELECT COUNT(*) AS `liked` FROM `$TABLE_LIKES_POST` WHERE `post_id`=".$postid." AND `sender`=".$userId.";");
                                $likedUses = mysqli_fetch_array($likeUser);
                            ?>
                            
                            <div class="reaction-wrapper">
                                <span <?php echo 'class="reaction-like '.($likedUses['liked'] > 0 ? 'liked' : 'unliked').' fas fa-heart" id="l-'.$postid.'"';?>></span>
                                <span class="reaction-comment fas fa-comment" <?php echo 'id="c-'.$postid.'"';?>></span>
                            </div>
                            
                            <?php 
                                $likes = mysqli_query($connection,"SELECT COUNT(*) AS `likes` FROM `$TABLE_LIKES_POST` WHERE `post_id`=$postid;");
                                $likeCount = mysqli_fetch_array($likes);
                            ?>
                            
                            <p class="likes" <?php echo 'id="p-'.$postid.'"';?>><?php echo $likeCount['likes'];?> likes</p>
                                
                            <p class="description"><span class="user"><?php echo $login_session;?> </span> <?php echo $row['description'] != NULL ? $row['description'] : "";?></p>
                            
                            <p class="post-time"><?php echo getTimePassed($row['created_date']);?></p>
                            
                            <div class="comment-section" style="display: none;" <?php echo 'id="s-'.$postid.'"';?>>
                                <?php
                                    $comments = mysqli_query($connection, "SELECT * FROM `$TABLE_COMMENTS_POST` WHERE `post_id` = $postid ORDER BY `created_date`;");
                                    while ($comm = mysqli_fetch_array($comments)) {
                                        $commenter = mysqli_query($connection, "SELECT `id`, `username`, `avatar`, `role` FROM `$TABLE_ACCOUNTS` WHERE `id`=".$comm['sender'].";");
                                        if ($commenterProfile = mysqli_fetch_array($commenter)) {
                                ?>
                                <div class="comment">
                                    <a href="http://localhost/profile.php?username=<?php echo $commenterProfile['username'];?>" id="regular">
                                    <div class="profile-pic" style="width: 50px;height: 50px;min-width: 50px;min-height: 50px;background: #fff;">
                                        <img src="<?php echo $commenterProfile['avatar'];?>" alt="">
                                    </div>
                                    </a>
                                    <div>
                                        <p class="username"><?php echo $commenterProfile['username'];?></p>
                                        <p class="post-time" style="font-size: 10px;margin-left: 5px;"><?php echo getTimePassed($comm['created_date']);?></p>
                                    </div>
                                    <p class="text" style="width: 100%;"><?php echo $comm['text'];?></p>
                                    <div class="dropdown">
                                        <img src="img/icon/option.png" style="width: 20px;" class="options" alt="">
                                        <?php if ($commenterProfile['id'] == $userId || $role == 'admin') {?>
                                        <div class="dropdown-content">
                                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data" method="post">
                                                <input type="hidden" name="reaction" value="Hide_Comment_Post">
                                                <input type="hidden" name="postid" <?php echo 'value="'.$postid.'"'?>>
                                                <input type="hidden" name="id" <?php echo 'value="'.$comm['id'].'"'?>>
                                                <input type="hidden" name="user" <?php echo 'value="'.$comm['sender'].'"'?>>
                                                <label class="post_delete_button">
                                                    <span class="fas fa-eye-slash" style="font-size: 15px;" id="h-<?php? echo $comm['id'];?>"></span>
                                                    <input form="upload-post" class="submit" type="submit" name="delete" value="Hide">
                                                </label>
                                            </form>
                                    
                                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data" method="post">
                                                <input type="hidden" name="reaction" value="Uncomment_Post">
                                                <input type="hidden" name="postid" <?php echo 'value="'.$postid.'"'?>>
                                                <input type="hidden" name="id" <?php echo 'value="'.$comm['id'].'"'?>>
                                                <input type="hidden" name="user" <?php echo 'value="'.$comm['sender'].'"'?>>
                                                <label class="post_delete_button">
                                                    <span class="fas fa-trash-alt" style="font-size: 15px;" id="d-<?php? echo $comm['id'];?>"></span>
                                                    <input form="upload-post" class="submit" type="submit" name="delete" value="Delete">
                                                </label>
                                            </form>
                                        </div>
                                        <?php }?>
                                    </div>
                                </div>
                                <?php }}?>
                            </div>
                        </div>
                        
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data" method="post">
                            <input type="hidden" name="postid" <?php echo 'value="'.$postid.'"'?>>
                            <input type="hidden" name="reaction" value="Comment_Post"?>
                            <div class="comment-wrapper">
                                <input class="comment-box" name="text" placeholder="Add a comment" maxlength=255 required>
                                <input class="comment-btn" type="submit" value="post">
                            </div>
                        </form>
                    </div>
                    
                    <?php }
                        }
                    ?>
                    
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