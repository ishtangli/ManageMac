<?php

	include 'Common.php';

	$PN_ID = $_GET["PN"];
	$PN_KIT = $_POST["PN_KIT"];
	$PN_MSN = $_POST["PN_MSN"];
	$PN_DWG = $_POST["PN_DWG"];
	$PN_KIT_SN = $_POST["PN_KIT_SN"];
	$PN_VENDOR = $_POST["PN_VENDOR"];
	$PN_WORKPACK = $_POST["PN_WORKPACK"];
	$PN_PRODNUM = $_POST["PN_PRODNUM"];
	$PN_PN = $_POST["PN_PN"];
	$PN_DESC = $_POST["PN_DESC"];
	$PN_MFR = $_POST["PN_MFR"];
	$PN_QTY_REQ = $_POST["PN_QTY_REQ"];
	$PN_QTY_REC = $_GET["REC"];
	$PN_UOM = $_POST["PN_UOM"];
	$PN_IDENT = $_POST["PN_IDENT"];
	$PN_KIT_MPN = $_POST["PN_KIT_MPN"];
	$PN_STATUS = ($PN_QTY_REC < $PN_QTY_REQ) ? "OPEN" : "CLOSED";
	$PN_ACTIVE = (isset($_POST["PN_ACTIVE"])) ? 1 : 0;

	PartsUpdate($PN_ID, $PN_KIT, $PN_MSN, $PN_DWG, $PN_KIT_SN, $PN_VENDOR, $PN_WORKPACK, $PN_PRODNUM, $PN_PN, $PN_DESC, $PN_MFR, $PN_QTY_REQ, $PN_UOM, $PN_IDENT, $PN_KIT_MPN, $PN_STATUS, $PN_ACTIVE);

	$FROM_PN_KIT = $_POST["FROM_PN_KIT"];
	$FROM_PN_MSN = $_POST["FROM_PN_MSN"];
	$FROM_PN_DWG = $_POST["FROM_PN_DWG"];
	$FROM_PN_KIT_SN = $_POST["FROM_PN_KIT_SN"];
	$FROM_PN_VENDOR = $_POST["FROM_PN_VENDOR"];
	$FROM_PN_WORKPACK = $_POST["FROM_PN_WORKPACK"];
	$FROM_PN_PRODNUM = $_POST["FROM_PN_PRODNUM"];
	$FROM_PN_PN = $_POST["FROM_PN_PN"];
	$FROM_PN_DESC = $_POST["FROM_PN_DESC"];
	$FROM_PN_MFR = $_POST["FROM_PN_MFR"];
	$FROM_PN_QTY_REQ = $_POST["FROM_PN_QTY_REQ"];
	$FROM_PN_UOM = $_POST["FROM_PN_UOM"];
	$FROM_PN_IDENT = $_POST["FROM_PN_IDENT"];
	$FROM_PN_KIT_MPN = $_POST["FROM_PN_KIT_MPN"];
	$FROM_PN_STATUS = $_POST["FROM_PN_STATUS"];
	$FROM_PN_ACTIVE = ($_POST["FROM_PN_ACTIVE"] == 1) ? "YES" : "NO";

	$INVT_USER = "";
	$INVT_TYPE = "PNSUPERUPDATE";
	$INVT_FROM_ID = 0;
	$INVT_BY = $_SESSION[GetSessionVar()];

	$INVT_ID = InventoryTransactionInsert($INVT_USER, $INVT_TYPE, "", "", $INVT_FROM_ID, $INVT_BY);


	$PN_ACTIVE = ($PN_ACTIVE == 1) ? "YES" : "NO";


	$INVH_ID = "NULL";
	$INVH_INVT_ID = $INVT_ID;
	$INVH_PN_ID = $PN_ID;
	$INVH_QTY = 0;
	$INVH_RETURN_QTY = 0;
	$INVH_QTY_AVAILABLE = 0;
	$INVH_FROM = "KIT = " . $FROM_PN_KIT . "\r\n" . "MSN = " . $FROM_PN_MSN . "\r\n" . "DWG = " . $FROM_PN_DWG . "\r\n" . "SN = " . $FROM_PN_KIT_SN . "\r\n" . "VENDOR = " . $FROM_PN_VENDOR . "\r\n" . "WORK PACKAGE = " . $FROM_PN_WORKPACK . "\r\n" . "PROD NUM = " . $FROM_PN_PRODNUM . "\r\n" . "PN = " . $FROM_PN_PN . "\r\n" . "DESC = " . $FROM_PN_DESC . "\r\n" . "MFR = " . $FROM_PN_MFR . "\r\n" . "QTY REQ = " . $FROM_PN_QTY_REQ . "\r\n" . "UOM = " . $FROM_PN_UOM . "\r\n" . "IDENT = " . $FROM_PN_IDENT . "\r\n" . "KIT MPN = " . $FROM_PN_KIT_MPN . "\r\n" . "STATUS = " . $FROM_PN_STATUS . "\r\n" . "ACTIVE = " . $FROM_PN_ACTIVE . "\r\n";
	$INVH_TO = "KIT = " . $PN_KIT . "\r\n" . "MSN = " . $PN_MSN . "\r\n" . "DWG = " . $PN_DWG . "\r\n" . "SN = " . $PN_KIT_SN . "\r\n" . "VENDOR = " . $PN_VENDOR . "\r\n" . "WORK PACKAGE = " . $PN_WORKPACK . "\r\n" . "PROD NUM = " . $PN_PRODNUM . "\r\n" . "PN = " . $PN_PN . "\r\n" . "DESC = " . $PN_DESC . "\r\n" . "MFR = " . $PN_MFR . "\r\n" . "QTY REQ = " . $PN_QTY_REQ . "\r\n" . "UOM = " . $PN_UOM . "\r\n" . "IDENT = " . $PN_IDENT . "\r\n" . "KIT MPN = " . $PN_KIT_MPN . "\r\n" . "STATUS = " . $PN_STATUS . "\r\n" . "ACTIVE = " . $PN_ACTIVE . "\r\n";	$INVH_FROM_LOC = "BIN: " . $BIN . " - LOC: " . $LOCATION;
	$INVH_TO_LOC = "";
	$INVH_BIN = "";
	$INVH_LOCATION = "";
	$INVH_DATE = "NULL";
	$INVH_FROM_ID = 0;
	$INVH_STATUS = "OPEN";
	$INVH_BY = $_SESSION[GetSessionVar()];

	$INVHValues = "(" . $INVH_ID . ", " . $INVH_INVT_ID . ", " . $INVH_PN_ID . ", " . $INVH_QTY . ", " . $INVH_RETURN_QTY . ", " . $INVH_QTY_AVAILABLE . ", '" . $INVH_FROM . "', '" . $INVH_TO . "', '" . $INVH_FROM_LOC . "', '" . $INVH_TO_LOC . "', '" . $INVH_BIN . "', '" . $INVH_LOCATION . "', " . $INVH_DATE . ", " . $INVH_FROM_ID . ", '" . $INVH_STATUS . "', '" . $INVH_BY  . "')";


	InventoryHistoryInsertMulti($INVHValues);

	header ("Location: Parts_History_Detail.php?INVTID=" . $INVT_ID . "&R=1");
?>
