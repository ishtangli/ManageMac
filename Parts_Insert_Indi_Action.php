<?php

	include 'Common.php';

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
	$PN_UOM = $_POST["PN_UOM"];
	$PN_IDENT = $_POST["PN_IDENT"];
	$PN_KIT_MPN = $_POST["PN_KIT_MPN"];
	$PN_STATUS = "CLOSED";

	PartsInsert($PN_KIT, $PN_MSN, $PN_DWG, $PN_KIT_SN, $PN_VENDOR, $PN_WORKPACK, $PN_PRODNUM, $PN_PN, $PN_DESC, $PN_MFR, $PN_QTY_REQ, $PN_UOM, $PN_IDENT, $PN_KIT_MPN);

	header ("Location: Parts_Browse_iFrames.php");
?>