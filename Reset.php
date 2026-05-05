<?php
	include 'Login_Script.php';

	ConnectDB($link);

	$sSQL = "TRUNCATE `aud_audit`";

	OpenCommand($sSQL);

	$sSQL = "TRUNCATE `inv_details`";

	OpenCommand($sSQL);

	$sSQL = "TRUNCATE `inv_history`";

	OpenCommand($sSQL);

	$sSQL = "TRUNCATE `inv_transactions`";

	OpenCommand($sSQL);

	$sSQL = "UPDATE PNS SET PN_STATUS = 'OPEN', PN_QTY_REC = 0";

	OpenCommand($sSQL);

	CloseDB($link);
?>