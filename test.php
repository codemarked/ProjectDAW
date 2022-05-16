<?php
    session_start();

    if (isset($_POST['reaction']))
        echo $_POST['reaction']." ";

    if (isset($_POST['postid']))
        echo $_POST['postid']." ";

    if (isset($_REQUEST['reaction']))
        echo $_REQUEST['reaction']." ";

    if (isset($_REQUEST['postid']))
        echo $_REQUEST['postid']." ";

?>