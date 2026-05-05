<?php

	include 'Common.php';

	$TID = (isset($_GET["TID"])) ? trim($_GET["TID"]) : "";
	$TYPE = (isset($_GET["TYPE"])) ? trim($_GET["TYPE"]) : "ALL";
	$FDATE = (isset($_GET["FDATE"])) ? trim($_GET["FDATE"]) : "";
	$TDATE = (isset($_GET["TDATE"])) ? trim($_GET["TDATE"]) : "";

	$XML = "Type,Trans#,Issued To,Task Card,AWB,Kit,MSN,DWG,SN,PN,Qty,UOM,Kit MPN,Date,By\n";
	$file ="Parts_History_by_Transaction_Report_" . date("Y-m-d"). ".csv";

	GetTransactionsByINVT_IDandDATEandTypeDownload($TID, $TYPE, $FDATE, $TDATE, $result);

	while ($ResultData = mysqli_fetch_assoc($result)) {

		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["INVT_TYPE"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["INVT_ID"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["INVT_USER"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["INVT_TASKCARD"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["INVT_AWB"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_KIT"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_MSN"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_DWG"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_KIT_SN"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_PN"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", number_format($ResultData["INVH_QTY"], 2)) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_UOM"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["PN_KIT_MPN"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["INVT_DATE"]) . "\",";
		$XML.= "\"" . str_replace("\"", "\"\"", $ResultData["INVT_BY"]) . "\"\n";
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