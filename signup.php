<?php
    session_start();
    $userMessage = '';
    $passwordMessage = '';
    $cpasswordMessage = '';
    $emailMessage = '';
    $resultMessage = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['operation']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['cpassword']) && isset($_POST['email']) && $_POST['operation'] == "Signup") {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $cPassword = $_POST['cpassword'];
        $email = $_POST['email'];
 
        if(!strlen($password) < 6 && preg_match('@[0-9]@', $password) && preg_match('@[a-z]@', $password)) {
            if (preg_match('/^[a-zA-Z0-9]{5,}$/', $username)) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)){
                    if ($password == $cPassword) {
                        include('mysql/config.php');
                        $result = mysqli_query($connection, "SELECT id FROM accounts WHERE username = '".$username."';");
                        if (mysqli_num_rows($result) == 0) {
                            $currentMillis = round(microtime(true) * 1000);
                            $username = mysqli_real_escape_string($connection, $_POST['username']);
                            $password = mysqli_real_escape_string($connection, $password);
                            $email = mysqli_real_escape_string($connection, $email);
                            
                            $insertQuery = "INSERT INTO `accounts` (`username`,`password`,`email`,`created_date`,`lastjoin_date`) VALUES ('".$username."','".$password."','".$email."','".$currentMillis."','".$currentMillis."');";
                            if (mysqli_query($connection, $insertQuery)) {
                                $last_id = mysqli_insert_id($connection);
                                $_SESSION['valid'] = TRUE;
                                $_SESSION['user'] = $username;
                                $_SESSION['id'] = $last_id;
                                $_SESSION['email'] = $email;
                                
                                header('Location: http://localhost/home.php');
                                exit();
                            } else {
                                $resultMessage = 'There was an error trying to register';
                            }
                        } else {
                            $userMessage = 'Username already taken';
                        }
                        mysqli_close($connection);
                    } else {
                        $cpasswordMessage = 'The passwords do not match';
                    }
                } else {
                    $emailMessage = 'Incorrect email format';
                }
            } else {
                $userMessage = 'Username is too short or not valid';
            }
        } else {
            $passwordMessage = "Password is too weak";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Upper</title>
        <meta name="description" content="Upper">
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
            <div class="logo" style="background-image: url(img/logo.png)"></div>
            <div class="links">
                <a style="visibility: hidden;">HIDDEN</a>
            </div>
        </div>
        <div class="container">
            <div class="login">
                <h1>Signup</h1>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                    <div style="display: inline-flex;position: relative;">
                        <h4 class="errormessage" style="position: absolute;"><?php echo $userMessage; ?></h4>
				        <label for="username">
					       <i class="fas fa-user"></i>
				        </label>
				        <input type="text" name="username" placeholder="Username" id="username" required autofocus>
                    </div>
                    <div style="display: inline-flex;position: relative;">
                        <h4 class="errormessage" style="position: absolute;"><?php echo $passwordMessage; ?></h4>
				        <label for="password">
                            <i class="fas fa-lock"></i>
				        </label>
				        <input type="password" name="password" placeholder="Password" id="password" required>
                    </div>
                    <div style="display: inline-flex;position: relative;">
				        <label for="cpassword">
					       <i class="fas fa-lock"></i>
				        </label>
				        <input type="password" name="cpassword" placeholder="Confirm Password" id="cpassword" required>
                        <h4 class="errormessage" style="position: absolute;"><?php echo $cpasswordMessage; ?></h4>
                    </div>
                    <div style="display: inline-flex;position: relative;">
                        <h4 class="errormessage" style="position: absolute;"><?php echo $emailMessage; ?></h4>
				        <label for="email">
                            <i class="fas fa-envelope"></i>
				        </label>
				        <input type="text" name="email" placeholder="here@email.com" id="email" required>
                    </div>
                    <div style="display: inline-flex;position: relative;width: 100%;">
                        <h4 class="errormessage" style="position: absolute;"><?php echo $resultMessage; ?></h4>
				        <input type="submit" name="operation" id="operation" value="Signup">
                    </div>
                </form>
            </div>
        </div>
        <div class="footer">
            <div class="links">
                <small style="margin-left: 10px; float: left;">&copy; Copyright 2022, Bartha R.</small>
                <a href="">Terms of Service</a>
                <a href="">Privacy Policy</a>
                <a href="">Cookies</a>
            </div>
        </div>
    </body>
</html>