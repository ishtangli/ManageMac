<?php

	include 'Common.php';

	if(isset($_GET["PNID"])) {

		$NOT_PN_ID = $_GET["PNID"];
	}
	else {
		$NOT_PN_ID = 0;
	}

	if(isset($_GET["INVTID"])) {

		$NOT_INVT_ID = $_GET["INVTID"];
	}
	else {
		$NOT_INVT_ID = 0;
	}

	if(isset($_GET["INVHID"])) {

		$NOT_INVH_ID = $_GET["INVHID"];
	}
	else {
		$NOT_INVH_ID = 0;
	}

	$NOT_NOTE = $_POST["NOTE"];
	$NOT_BY = $_SESSION[GetSessionVar()];


	if (trim($NOT_NOTE) != "") NoteInsert($NOT_PN_ID, $NOT_INVT_ID, $NOT_INVH_ID, $NOT_NOTE, $NOT_BY);

	header ("Location: Note_Browse.php?PNID=" . $NOT_PN_ID . "&INVTID=" . $NOT_INVT_ID . "&INVHID=" . $NOT_INVH_ID . "&R=1");
?>
