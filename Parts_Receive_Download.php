<?php

	include 'Common.php';

	$MSN = (isset($_GET["MSN"])) ? trim($_GET["MSN"]) : "";
	$KIT = (isset($_GET["KIT"])) ? trim($_GET["KIT"]) : "";
	$DWG = (isset($_GET["DWG"])) ? trim($_GET["DWG"]) : "";
	$VEN = (isset($_GET["VEN"])) ? trim($_GET["VEN"]) : "";
	$SN = (isset($_GET["SN"])) ? trim($_GET["SN"]) : "";
	$PN = (isset($_GET["PN"])) ? trim($_GET["PN"]) : "";
	$STA = (isset($_GET["STA"])) ? trim($_GET["STA"]) : "";
	$WP = (isset($_GET["WP"])) ? trim($_GET["WP"]) : "";

	$XML = "#,Kit,MSN,DWG,SN,Vendor,Work Pack,Prod#,PN,Desc,MFR,IDENT,Qty Req,Qty Rec,Qty Avl,UOM,Loc,Bin,Status,Kit MPN\n";
	$file ="Parts_for_Receipt_Report_" . date("Y-m-d"). ".csv";

	$ROWNUM = 1;

	GetPartsForReceiptDownload($MSN, $KIT, $DWG, $VEN, $WP, $PN, $SN, $STA, $result);

	while ($ResultData = mysqli_fetch_assoc($result)) {

		$XML.= "\"" . str_replace("\"", "\"\"", $ROWNUM) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_KIT"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_MSN"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_DWG"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_KIT_SN"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_VENDOR"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_WORKPACK"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_PRODNUM"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_PN"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_DESC"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_MFR"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_IDENT"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", number_format($ResultData["PN_QTY_REQ"], 2)) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", number_format($ResultData["PN_QTY_REC"], 2)) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", number_format($ResultData["INVD_QTY"], 2)) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_UOM"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["INVD_LOCATION"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["INVD_BIN"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_STATUS"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_KIT_MPN"]) . "\"\n";

		$ROWNUM++;
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