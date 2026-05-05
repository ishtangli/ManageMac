<?php
	session_start();

	include ".\Var\Variables.php";

	$uploaddir = 'temp/';
	$uploadfilename = str_replace(" ", "_", basename($_FILES['file1']['name']) . "-" . $_SESSION[GetSessionVar()]);
	$uploadfile = $uploaddir . $uploadfilename;

	if (move_uploaded_file($_FILES['file1']['tmp_name'], $uploadfile)) {

		header ("Location: Parts_Upload_Insert_Action.php?fn=" . $uploadfilename);

	}
	else {

		echo "Unable to upload file. Please try again later.";

	}
?> 
