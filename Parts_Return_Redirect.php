<?php

	include 'Common.php';

	$INVT_ID = $_GET["INVTID"];

	if ($INVT_ID == "false") {

		header ("Location: Parts_Return_Error.php");
	}
	else {

		header ("Location: Parts_History_Detail.php?INVTID=" . $INVT_ID . "&R=1");
	}

?>