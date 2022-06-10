<?php
    session_start();
    include('mysql/config.php');
    $msg = '';
    $VALID_LOGIN = $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['operation']) && isset($_POST['username']) && isset($_POST['password']) && $_POST['operation'] == "Login";
    if ($VALID_LOGIN) {
        $username = mysqli_real_escape_string($connection, $_POST['username']);
        $password = mysqli_real_escape_string($connection, $_POST['password']); 

        if (!mysqli_connect_errno()) {
            $result = mysqli_query($connection, "SELECT id, username, email FROM accounts WHERE username = '".$username."' AND password = '".$password."';");
            if (!$result) {
                $msg = 'Failed to connect to the database!';
            } else if (mysqli_num_rows($result) > 0 && $row = mysqli_fetch_array($result)) {
                $_SESSION['valid'] = TRUE;
                $_SESSION['user'] = $row['username'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                header('Location: http://localhost/home.php');
                exit();
            } else {
                $msg = 'Incorrect username and/or password';
            }
        } else {
            $msg = 'Failed to connect to the database!';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Upper</title>
        <meta name="description" content="Upper Login">
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
            <div style="width: 75%;margin: auto;">
                <div class="logo" style="background-image: url(img/logo.png)"></div>
            </div>
        </div>
        <div class="container">
            <div class="login">
                <h1>Login</h1>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
				    <label for="username">
					   <i class="fas fa-user"></i>
				    </label>
				    <input type="text" name="username" placeholder="Username" id="username" required autofocus>
				    <label for="password">
					   <i class="fas fa-lock"></i>
				    </label>
				    <input type="password" name="password" placeholder="Password" id="password" required>
                    <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
                    <a href="http://localhost/signup.php" style="text-decoration: none;color: #292929;"><h4 class = "form-signin-heading">Or click here to register</h4></a>
				    <input type="submit" name="operation" id="operation" value="Login">
                </form>
            </div>
        </div>
        <div id="cookieNotice" class="cookie">
            <div id="closeIcon"></div>
            <div class="title-wrap"><h4>Cookie Consent</h4></div>
            <div class="content-wrap">
                <div class="msg-wrap">
                    <p>This website uses cookies or similar technologies, to enhance your browsing experience and provide personalized recommendations. By continuing to use our website, you agree to our  <a style="color:#115cfa;" href="/privacy-policy">Privacy Policy</a></p>
                    <div class="btn-wrap">
                        <button class="btn-primary" onclick="acceptCookieConsent();">Accept</button>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="js/cookies.js"></script>
        <div class="footer">
            <small style="margin-left: 10px;color: #fff;">&copy; Copyright 2022, Bartha R.</small>
            <small style="color: #fff;font-size: 20px;">|</small>
            <a href="">Terms of Service</a>
            <small style="color: #fff;font-size: 20px;">|</small>
            <a href="">Privacy Policy</a>
        </div>
    </body>
</html>