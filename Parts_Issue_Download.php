<?php

	include 'Common.php';

	$MSN = (isset($_GET["MSN"])) ? trim($_GET["MSN"]) : "";
	$KIT = (isset($_GET["KIT"])) ? trim($_GET["KIT"]) : "";
	$DWG = (isset($_GET["DWG"])) ? trim($_GET["DWG"]) : "";
	$VEN = (isset($_GET["VEN"])) ? trim($_GET["VEN"]) : "";
	$SN = (isset($_GET["SN"])) ? trim($_GET["SN"]) : "";
	$PN = (isset($_GET["PN"])) ? trim($_GET["PN"]) : "";
	$TRN = (isset($_GET["TRN"])) ? trim($_GET["TRN"]) : "";
	$WP = (isset($_GET["WP"])) ? trim($_GET["WP"]) : "";

	$XML = "Trans#,Issued To,Task Card,Kit,MSN,DWG,SN,Vendor,Work Pack,PN,Desc,MFR,IDENT,Qty Reserved,Qty Issued,UOM,From Loc,Kit MPN\n";
	$file ="Reserved_Parts_Report_" . date("Y-m-d"). ".csv";

	GetPartsForIssueDownload($MSN, $KIT, $DWG, $VEN, $PN, $SN, $TRN, $WP, $result);

	while ($ResultData = mysqli_fetch_assoc($result)) {

		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["INVT_ID"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["INVT_USER"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["INVT_TASKCARD"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_KIT"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_MSN"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_DWG"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_KIT_SN"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_VENDOR"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_WORKPACK"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_PN"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_DESC"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_MFR"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_IDENT"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", number_format($ResultData["INVH_QTY"], 2)) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", number_format($ResultData["ISSUEDQTY"], 2)) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_UOM"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["INVH_FROM_LOC"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_KIT_MPN"]) . "\"\n";
	}

	mysqli_free_result($result);

	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=\"$file\"");
	header("Content-Transfer-Encoding: binary");

	if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
		    header('Cache-Control: public');
	}

	echo $XML;
	exit;
?>