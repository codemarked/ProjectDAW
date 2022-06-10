<?php
    session_start();
    include('mysql/config.php');

    $result = mysqli_query($connection, "SELECT id, username, avatar, role FROM accounts WHERE username = '".$_SESSION['user']."';");
    
    if (mysqli_num_rows($result) > 0 && $row = mysqli_fetch_array($result)) {
        $_SESSION['user'] = $row['username'];
        $_SESSION['id'] = $row['id'];
        $_SESSION['avatar'] = $row['avatar'];
        $_SESSION['role'] = $row['role'];
    }
    $userId = $_SESSION['id'];
    $login_session = $_SESSION['user'];
    $avatarLink = $_SESSION['avatar'];
    $email = $_SESSION['email'];
    $role = $_SESSION['role'];
?>