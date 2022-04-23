<?php
	session_start();
	require 'db.php';
	
	//move gallery thumbnail image and give a unique name to it
	$new_filename = time()."_".$_FILES["GalleryimgToUpload"]["name"];
	move_uploaded_file($_FILES["GalleryimgToUpload"]["tmp_name"],"templates/pictures/".$new_filename);
	//insert to db gallery info and get last inserted id for gallery
	$stmt = $conn->prepare("INSERT INTO galleries (title, title_description, img, long_description,id_user) VALUES (?,?,?,?,?)");
	$stmt->bind_param("ssssi", $_POST['gallerytitle'],$_POST['gallerytitledescription'],$new_filename,$_POST['gallerylongdescription'],$_SESSION['uid']);
	$stmt->execute();
	
	// move gallery images and give a unique name to each
	
	$id_gallery = $conn->insert_id;
	
	$new_filenames = array();
	for ($i = 0; $i<count($_FILES['Imagini']['name']);$i++){
		$new_filenames[] = time()."_".$_FILES['Imagini']['name'][$i];
		move_uploaded_file($_FILES['Imagini']['tmp_name'][$i],"templates/pictures/".$new_filenames[$i]);
		// insert to db gallery picture and short description one at a time
		$stmt = $conn->prepare("INSERT INTO pictures (id_gallery,picture,short_title_description) VALUES (?,?,?)");
		$stmt->bind_param("iss",$id_gallery,$new_filenames[$i],$_POST['Short_description'][$i]);
		$stmt->execute();
	}
		
	$stmt->close();
	$conn->close();
	// redirect to galleries page or show gallery page
	Header("Location:index.php");
	//Header("Locatoin:show_gallery.php?id=$id_gallery");
?>