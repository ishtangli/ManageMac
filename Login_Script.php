<?php

include ".\Var\Variables.php";

/*-----------------------------------------------------------------------------------------*/

	function ConnectDB(&$link) {
		$link = mysqli_connect("localhost", "mm", "rGnW4") or die("ConnectDB : " . mysqli_error());

		mysqli_select_db($link, GetDB()) or die("ConnectDB : Could not select database");
	}

	function CloseDB(&$link) {
		mysqli_close($link);
	}

	function OpenQuery($query, &$result) {
		$result = mysqli_query($link, $query) or die("OpenQuery : " . mysqli_error());
	}

	function OpenCommand($command) {
		mysqli_query($link, $command) or die("OpenCommand : " . mysqli_error());
	}

/*-----------------------------------------------------------------------------------------*/

	function Authenticate($username, $password, &$ResultData) {

		GetLoginByLOG_UID($username, $result);

		if (($ResultData = mysqli_fetch_assoc($result)) > 0) {


			if (strcmp(md5_decrypt($ResultData["LOG_PWD"], "password"), $password) == 0) {
				return 1;
			}
			else {
				return 0;
			}
		}
		else {
			return 0;
		}

		mysqli_free_result($result);
	}

	function get_rnd_iv($iv_len) {

		$iv = '';

		while ($iv_len-- > 0) {
			$iv .= chr(mt_rand() & 0xff);
		}

		return $iv;
	}

	function md5_encrypt($plain_text, $password) {

		$iv_len = 16;

		$plain_text .= "\x13";
		$n = strlen($plain_text);

		if ($n % 16) $plain_text .= str_repeat("\0", 16 - ($n % 16));

		$i = 0;
		$enc_text = get_rnd_iv($iv_len);
		$iv = substr($password ^ $enc_text, 0, 512);

		while ($i < $n) {

			$block = substr($plain_text, $i, 16) ^ pack('H*', md5($iv));
			$enc_text .= $block;
			$iv = substr($block . $iv, 0, 512) ^ $password;
			$i += 16;
		}

		return base64_encode($enc_text);
	}

	function md5_decrypt($enc_text, $password) {

		$iv_len = 16;

		$enc_text = base64_decode($enc_text);
		$n = strlen($enc_text);
		$i = $iv_len;
		$plain_text = '';
		$iv = substr($password ^ substr($enc_text, 0, $iv_len), 0, 512);

		while ($i < $n) {

			$block = substr($enc_text, $i, 16);
			$plain_text .= $block ^ pack('H*', md5($iv));
			$iv = substr($block . $iv, 0, 512) ^ $password;
			$i += 16;
		}

		return preg_replace('/\\x13\\x00*$/', '', $plain_text);
	}

/*-----------------------------------------------------------------------------------------*/

	function GetLoginByLOG_UID($vLOG_UID, &$result) {

		ConnectDB($link);

		$sSQL = "Select * from LOG_LOGINS where LOG_UID = '" . $vLOG_UID . "'";

		$result = mysqli_query($link, $sSQL) or die("GetLoginByLOG_UID failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetLoginByLOG_ID($vLOG_ID, &$result) {

		ConnectDB($link);

		$sSQL = "Select * from LOG_LOGINS where LOG_ID = '" . $vLOG_ID . "'";

		$result = mysqli_query($link, $sSQL) or die("GetLoginByLOG_ID failed : " . mysqli_error());

		CloseDB($link);
	}

	function UpdateLoginByLOG_ID($vLOG_ID, $vLOG_PWD) {

		ConnectDB($link);

		$sSQL = "Update LOG_LOGINS set LOG_PWD = '" . $vLOG_PWD ."', LOG_PWD_SET = 1 where LOG_ID = '" . $vLOG_ID . "'";

		$result = mysqli_query($link, $sSQL) or die("UpdateLoginByLOG_ID failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "UpdateLoginByLOG_ID - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $vLOG_ID;

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

/*-----------------------------------------------------------------------------------------*/

	function AuditInsert(&$rAUD_AUDIT_ID, $vAUD_ACTION, $vAUD_INDEX, $vAUD_BY) {

		ConnectDB($link);

		$sSQL = "Insert into AUD_AUDIT values (NULL, '" . $vAUD_ACTION . "', " . $vAUD_INDEX . ", NULL, '" . $vAUD_BY . "')";

		mysqli_query($link, $sSQL) or die("AuditInsert failed : " . mysqli_error());

		$rAUD_AUDIT_ID = mysqli_insert_id($link);

		CloseDB($link);
	}

/*-----------------------------------------------------------------------------------------*/

?>
