<?php
	include 'Login_Script.php';

	$LOG_ID = $_GET["ID"];
	$LOG_UID = $_GET["UID"];
	$LOG_PWD1 = $_POST["LOG_PWD1"];
	$LOG_PWD2 = $_POST["LOG_PWD2"];

	if ($LOG_PWD1 == $LOG_PWD2) {

		$LOG_PWD = md5_encrypt($LOG_PWD1, "password");

		UpdateLoginByLOG_ID($LOG_ID, $LOG_PWD);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "PWD UPDATE";
		$AUD_INDEX = 0;
		$AUD_BY = $LOG_UID;

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);

		header ("Location: Login_Update_Confirm.php");

	}
	else {

		header ("Location: Login_Update_Error.php?ID=" . $LOG_ID);
	}
?>