<?php

	include 'Common.php';

	$filename = "temp/" . $_GET["fn"];

	if (($handle = fopen($filename, "r")) !== FALSE) {

		$PNS = "";
		$COUNTER = 0;

		while (($PNDATA = fgetcsv($handle)) !== FALSE) {

			$PN_KIT = $PNDATA[0];
			$PN_MSN = $PNDATA[1];
			$PN_DWG = $PNDATA[2];
			$PN_KIT_SN = $PNDATA[3];
			$PN_VENDOR = $PNDATA[4];
			$PN_WORKPACK = $PNDATA[5];
			$PN_PRODNUM = $PNDATA[6];
			$PN_PN = $PNDATA[7];
			$PN_DESC = $PNDATA[8];
			$PN_MFR = $PNDATA[9];
			$PN_QTY_REQ = $PNDATA[10];
			$PN_UOM = $PNDATA[11];
			$PN_IDENT = $PNDATA[12];
			$PN_KIT_MPN = $PNDATA[13];
			$PN_ACTIVE = $PNDATA[14];

			$PNS = $PNS . "(NULL, '" . $PN_KIT . "', '" . $PN_MSN . "', '" . $PN_DWG . "', '" . $PN_KIT_SN . "', '" . $PN_VENDOR . "', '" . $PN_WORKPACK . "', '" . $PN_PRODNUM . "', '" . $PN_PN . "', '" . $PN_DESC . "', '" . $PN_MFR . "', " . $PN_QTY_REQ . ", 0, '" .  $PN_UOM . "', '" . $PN_IDENT . "', '" . $PN_KIT_MPN . "', 'OPEN', " . $PN_ACTIVE . "),";

			$COUNTER++;

			if ($COUNTER == 50) {

				$PNS = trim($PNS, ",");
				PartsInsertMulti($PNS);
				$PNS = "";
				$COUNTER = 0;
			}
				
		}

		fclose($handle);

		if ($COUNTER != 0) {

			$PNS = trim($PNS, ",");
			PartsInsertMulti($PNS);
		}

		header ("Location: Parts_Receive_iFrames.php");
	}

?>