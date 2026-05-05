<?php
	include 'Common.php';

	$INVHValues = "";
	$INVDValues = "";
	$COUNTER = 0;

	if (isset($_POST["DATA"])) {

		$LOCATION = $_POST["LOCATION"];
		$BIN = $_POST["BIN"];

		$DATA = $_POST["DATA"];

		$INVT_ID = InventoryTransactionInsert("", "TRANSFER", "", "", 0, $_SESSION[GetSessionVar()]);

		for ($i=0; $i<count($DATA); $i++) {

			//$Contents = explode(",", $DATA[$i]);
			$Contents = str_getcsv($DATA[$i], ',', "'");

			$PN_ID = $Contents[0];
			$FROMLOC =  "BIN: " . $Contents[2] . " - LOC: " . $Contents[1];
			$TOLOC = "BIN: " . $BIN . " - LOC: " . $LOCATION;
			$AVAILABLE = $Contents[3];


			$INVH_ID = "NULL";
			$INVH_INVT_ID = $INVT_ID;
			$INVH_PN_ID = $PN_ID;
			$INVH_QTY = $AVAILABLE;
			$INVH_RETURN_QTY = 0;
			$INVH_QTY_AVAILABLE = $AVAILABLE;
			$INVH_FROM = "";
			$INVH_TO = "";
			$INVH_FROM_LOC = $FROMLOC;
			$INVH_TO_LOC = $TOLOC;
			$INVH_BIN = "";
			$INVH_LOCATION = "";
			$INVH_DATE = "NULL";
			$INVH_FROM_ID = 0;
			$INVH_STATUS = "OPEN";
			$INVH_BY = $_SESSION[GetSessionVar()];

			$INVHValues = $INVHValues . "(" . $INVH_ID . ", " . $INVH_INVT_ID . ", " . $INVH_PN_ID . ", " . $INVH_QTY . ", " . $INVH_RETURN_QTY . ", " . $INVH_QTY_AVAILABLE . ", '" . $INVH_FROM . "', '" . $INVH_TO . "', '" . $INVH_FROM_LOC . "', '" . $INVH_TO_LOC . "', '" . $INVH_BIN . "', '" . $INVH_LOCATION . "', " . $INVH_DATE . ", " . $INVH_FROM_ID . ", '" . $INVH_STATUS . "', '" . $INVH_BY  . "'),";


			$INVD_ID = "NULL";
			$INVD_PN_ID = $PN_ID;
			$INVD_QTY = $AVAILABLE;
			$INVD_RESERVED = $AVAILABLE;
			$INVD_BIN = $BIN;
			$INVD_LOCATION = $LOCATION;
			$INVD_DATE = "NULL";

			$INVDValues = $INVDValues . "(" . $INVD_ID . ", " . $INVD_PN_ID . ", " . $INVD_QTY . ", " . $INVD_RESERVED . ", '" . $INVD_BIN . "', '" . $INVD_LOCATION . "', " . $INVD_DATE . "),";


			$COUNTER++;

			if ($COUNTER == 50) {

				$INVHValues = trim($INVHValues, ",");
				InventoryHistoryInsertMulti($INVHValues);

				$INVDValues = trim($INVDValues, ",");
				InventoryDetailTransferMulti($INVDValues);

				$INVHValues = "";
				$INVDValues = "";
				$COUNTER = 0;
			}
		}

		if ($COUNTER != 0) {

			$INVHValues = trim($INVHValues, ",");
			InventoryHistoryInsertMulti($INVHValues);

			$INVDValues = trim($INVDValues, ",");
			InventoryDetailTransferMulti($INVDValues);
		}
	}

	header ("Location: Parts_History_Detail.php?INVTID=" . $INVT_ID . "&R=1");
?>
