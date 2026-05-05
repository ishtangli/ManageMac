<?php
	include 'Common.php';

	$INVHValues = "";
	$INVDValues = "";
	$PNValues = "";
	$COUNTER = 0;

	if (isset($_POST["DATA"])) {

		$AWB = $_POST["AWB"];
		$BIN = $_POST["BIN"];
		$LOCATION = $_POST["LOC"];

		$DATA = $_POST["DATA"];
		$RECEIVEDATA = $_POST["RECEIVEQTY"];

		$INVT_ID = InventoryTransactionInsert("", "RECEIVE", $AWB, "", 0, $_SESSION[GetSessionVar()]);


		for ($i=0; $i<count($DATA); $i++) {

			//$Contents = explode(",", $DATA[$i]);
			$Contents = str_getcsv($DATA[$i], ',', "'");

			$PN_ID = $Contents[0];
			$REQUIRED = $Contents[1];
			$AVAILABLE = $Contents[2];
			$INVD_ID = $Contents[3];
			$RECEIVEQTY = $RECEIVEDATA[$i];
			$RECEIVEDQTY = $Contents[4];
			$STATUS = ($RECEIVEDQTY + $RECEIVEQTY >= $REQUIRED) ? "CLOSED" : "OPEN";


			$INVH_ID = "NULL";
			$INVH_INVT_ID = $INVT_ID;
			$INVH_PN_ID = $PN_ID;
			$INVH_QTY = $RECEIVEQTY;
			$INVH_RETURN_QTY = 0;
			$INVH_QTY_AVAILABLE = $AVAILABLE;
			$INVH_FROM = "";
			$INVH_TO = "";
			$INVH_FROM_LOC = "";
			$INVH_TO_LOC = "LOC: " . $LOCATION . " - BIN: " . $BIN;
			$INVH_BIN = "";
			$INVH_LOCATION = "";
			$INVH_DATE = "NULL";
			$INVH_FROM_ID = 0;
			$INVH_STATUS = "OPEN";
			$INVH_BY = $_SESSION[GetSessionVar()];
		
			$INVHValues = $INVHValues . "(" . $INVH_ID . ", " . $INVH_INVT_ID . ", " . $INVH_PN_ID . ", " . $INVH_QTY . ", " . $INVH_RETURN_QTY . ", " . $INVH_QTY_AVAILABLE . ", '" . $INVH_FROM . "', '" . $INVH_TO . "', '" . $INVH_FROM_LOC . "', '" . $INVH_TO_LOC . "', '" . $INVH_BIN . "', '" . $INVH_LOCATION . "', " . $INVH_DATE . ", " . $INVH_FROM_ID . ", '" . $INVH_STATUS . "', '" . $INVH_BY  . "'),";


			$INVD_ID = "NULL";
			$INVD_PN_ID = $PN_ID;
			$INVD_QTY = $RECEIVEQTY;
			$INVD_RESERVED = 0;
			$INVD_BIN = $BIN;
			$INVD_LOCATION = $LOCATION;
			$INVD_DATE = "NULL";

			$INVDValues = $INVDValues . "(" . $INVD_ID . ", " . $INVD_PN_ID . ", " . $INVD_QTY . ", " . $INVD_RESERVED . ", '" . $INVD_BIN . "', '" . $INVD_LOCATION . "', " . $INVD_DATE . "),";


			$PN_ID = $PN_ID;
			$PN_KIT = "";
			$PN_MSN = "";
			$PN_DWG = "";
			$PN_KIT_SN = "";
			$PN_VENDOR = "";
			$PN_WORKPACK = "";
			$PN_PRODNUM = "";
			$PN_PN = "";
			$PN_DESC = "";
			$PN_MFR = "";
			$PN_QTY_REQ = 0;
			$PN_QTY_REC = $RECEIVEQTY;
			$PN_UOM = "";
			$PN_IDENT = "";
			$PN_KIT_MPN = "";
			$PN_STATUS = $STATUS;
			$PN_ACTIVE = 0;

			$PNValues = $PNValues . "(" . $PN_ID . ", '" . $PN_KIT . "', '" . $PN_MSN . "', '" . $PN_DWG . "', '" . $PN_KIT_SN . "', '" . $PN_VENDOR . "', '" . $PN_WORKPACK . "', '" . $PN_PRODNUM . "', '" . $PN_PN . "', '" . $PN_DESC . "', '" . $PN_MFR . "', " . $PN_QTY_REQ . ", " . $PN_QTY_REC . ", '" . $PN_UOM . "', '" . $PN_IDENT . "', '" . $PN_KIT_MPN . "', '" . $PN_STATUS . "', " . $PN_ACTIVE . "),";


			$COUNTER++;

			if ($COUNTER == 50) {

				$INVHValues = trim($INVHValues, ",");
				InventoryHistoryInsertMulti($INVHValues);

				$INVDValues = trim($INVDValues, ",");
				InventoryDetailInsertMulti($INVDValues);

				$PNValues = trim($PNValues, ",");
				PartsReceiveMulti($PNValues);

				$INVHValues = "";
				$INVDValues = "";
				$PNValues = "";
				$COUNTER = 0;
			}
		}

		if ($COUNTER != 0) {

			$INVHValues = trim($INVHValues, ",");
			InventoryHistoryInsertMulti($INVHValues);

			$INVDValues = trim($INVDValues, ",");
			InventoryDetailInsertMulti($INVDValues);

			$PNValues = trim($PNValues, ",");
			PartsReceiveMulti($PNValues);
		}
	}

	header ("Location: Parts_History_Detail.php?INVTID=" . $INVT_ID . "&R=1");
?>
