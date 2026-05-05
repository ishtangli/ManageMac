<?php
	include "Login_Script.php";

	$LOG_UID = $_POST["LOG_UID"];
	$LOG_PWD = $_POST["LOG_PWD"];

	if (Authenticate($LOG_UID, $LOG_PWD, $ResultData) == 1) {

		if ($ResultData["LOG_PWD_SET"] == 0) {

			$AUD_AUDIT_ID = NULL;
			$AUD_ACTION = "1ST LOGIN";
			$AUD_INDEX = 0;
			$AUD_BY = $LOG_UID;

			AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);

			header ("Location: Login_Update.php?ID=" . $ResultData["LOG_ID"] . "&UID=" . $ResultData["LOG_UID"]);
		}
		else {

			session_cache_expire(180);

			session_start();

			$_SESSION[GetSessionVar()] = $ResultData["LOG_UID"];
			$_SESSION["RIGHTS"] = $ResultData["LOG_ADMIN"];

			$AUD_AUDIT_ID = NULL;
			$AUD_ACTION = "LOGIN";
			$AUD_INDEX = 0;
			$AUD_BY = $_SESSION[GetSessionVar()];

			AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);

			if ($_SESSION["RIGHTS"] == 2) {
				header ("Location: Parts_Reserve_iFrames.php");
			}
			else {
				header ("Location: Parts_Issue_iFrames.php");
			}
		}
	}
	else {
		header ("Location: Login_Error.php");
	}
?>
