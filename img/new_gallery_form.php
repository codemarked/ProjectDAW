<?php
	session_start();
	if(!isset($_SESSION['uname']) or $_SESSION['uname']==''){
		header("Location:login_form.php");
	}
	require_once 'vendor/autoload.php';
	require 'db.php';
	$loader = new \Twig\Loader\FilesystemLoader('templates');
	$twig = new \Twig\Environment($loader);
	$pagetitle = 'Laborator 8 | TWIG & Bootstrap 4 & PHP 7.4 Website Example';
	$sql = "SELECT * FROM carousel";
	$result_c = $conn->query($sql);
	echo $twig->render('new_gallery_form_base.tpl.html', ['pagetitle' => $pagetitle, 'result_c' => $result_c ,'user_name'=>$_SESSION['uname'],'user_id' =>$_SESSION['uid'],'user_image'=>$_SESSION['uimage'],'user_description'=>$_SESSION['udescription']]);
?>