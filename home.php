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
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script type="text/javascript" src="js/upload_images.js"></script>
        <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Caption&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="header">
            <div style="width: 75%;margin: auto;">
                <div class="logo" style="background-image: url(img/logo.png)"></div>
<!--                <a href=""><div class="link"><span class="fas fa-home"></span>HOME</div></a>-->
                <div style="float: right;">
                    <div class="dropdown">
                        <div class="hoverable">
                            <div class="info">
                                <div class="user">
                                    <div class="profile-pic" style="border: 1px solid white;">
                                        <img src="<?php echo $avatarLink;?>" alt="">
                                    </div>
                                    <p class="username" style="color: white;"><?php echo $login_session;?></p>
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
                        <form id="upload-post" action="http://localhost/upload.php" enctype="multipart/form-data">
                        </form>
                        
                        <div class="comment-wrapper">
                            <input form="upload-post" class="comment-box" name="description" placeholder="Add a description" maxlength=255 required>
                            <input form="upload-post" class="submit" type="submit" name="submit" value="Post">
                        </div>
                        <div class="upload__btn-box">
                            <label class="upload__btn">
                                <span class="fas fa-upload"></span>Upload
                                <input form="upload-post" type="file" name="upload[]" multiple="multiple" data-max_length="5" class="upload__inputfile" required>
                            </label>
                        </div>
                        <div class="upload__img-wrap"></div>
                    </div>
                    
                    <div class="post">
                        <div class="info">
                            <div class="user">
                                <div class="profile-pic"><img src="<?php echo $avatarLink;?>" alt=""></div>
                                <p class="username"><?php echo $login_session;?></p>
                            </div>
                            <img src="img/icon/option.png" class="options" alt="">
                        </div>
                        <img src="https://picsum.photos/1900/1000?random=1" class="post-image" alt="">
                        <div class="post-content">
                            <div class="reaction-wrapper">
<!--
                                <span class="fas fa-heart active-button" onclick="toggleButton(this);"></span>
                                <span class="fas fa-comment active-button" onclick="toggleButton(this);"></span>
-->
                                <span class="fas fa-heart" onclick="toggleButton(this);"></span>
                                <span class="fas fa-comment" onclick="toggleButton(this);"></span>
                            </div>
                            <p class="likes">1,012 likes</p>
                            <p class="description"><span class="user"><?php echo $login_session;?> </span> Description...</p>
                            <p class="post-time">2 minutes ago</p>
                        </div>
                        <div class="comment-wrapper">
                            <input type="text" class="comment-box" placeholder="Add a comment" maxlength=255>
                            <button class="comment-btn">post</button>
                        </div>
                    </div>
                    <div class="post">
                        <div class="info">
                            <div class="user">
                                <div class="profile-pic"><img src="<?php echo $avatarLink;?>" alt=""></div>
                                <p class="username"><?php echo $login_session;?></p>
                            </div>
                            <img src="img/icon/option.png" class="options" alt="">
                        </div>
                        <img src="https://picsum.photos/1900/1000?random=2" class="post-image" alt="">
                        <img src="https://picsum.photos/1900/1000?random=3" class="post-image" alt="">
                        <div class="post-content">
                            <div class="reaction-wrapper">
                                <span class="fas fa-heart" onclick="toggleButton(this);"></span>
                                <span class="fas fa-comment" onclick="toggleButton(this);"></span>
                            </div>
                            <p class="likes">1,012 likes</p>
                            <p class="description"><span class="user"><?php echo $login_session;?> </span> Description...</p>
                            <p class="post-time">2 minutes ago</p>
                        </div>
                        <div class="comment-wrapper">
                            <input type="text" class="comment-box" placeholder="Add a comment" maxlength=255>
                            <button class="comment-btn">post</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function toggleButton(element) {  
                if (element.style.color == 'darkred')
                    element.style.color = 'white';
                else
                    element.style.color = 'darkred';
            }
        </script>
        <div class="footer">
            <small style="margin-left: 10px;color: #fff;">&copy; Copyright 2022, Bartha R.</small>
            <small style="color: #fff;font-size: 20px;">|</small>
            <a href="">Terms of Service</a>
            <small style="color: #fff;font-size: 20px;">|</small>
            <a href="">Privacy Policy</a>
        </div>
<!--        <script src="js/slide_show.js"></script>-->
    </body>
</html>