<?php
	include "Login_Script.php";

	session_start();

	$AUD_AUDIT_ID = NULL;
	$AUD_ACTION = "LOGOUT";
	$AUD_INDEX = 0;
	$AUD_BY = $_SESSION[GetSessionVar()];

	AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);

	session_unset();
	session_destroy();

	header ("Location: Logout_Confirm.php");
?>
