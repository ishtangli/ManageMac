<?php
	include 'Common.php';

	$INVHValues = "";
	$INVDValues = "";
	$COUNTER = 0;

	if (isset($_POST["DATA"])) {

		$TASKCARD = $_POST["TASKCARD"];
		$USER = $_POST["USER"];

		$DATA = $_POST["DATA"];
		$RESERVEDATA = $_POST["RESERVEQTY"];

		$INVT_ID = InventoryTransactionInsert($USER, "RESERVE", "", $TASKCARD, 0, $_SESSION[GetSessionVar()]);

		for ($i=0; $i<count($DATA); $i++) {

			//$Contents = explode(",", $DATA[$i]);
			$Contents = str_getcsv($DATA[$i], ',', "'");

			$PN_ID = $Contents[0];
			$REQUIRED = $Contents[1];
			$AVAILABLE = $Contents[2];
			$BIN = $Contents[3];
			$LOCATION = $Contents[4];
			$RESERVEQTY = $RESERVEDATA[$i];


			$INVH_ID = "NULL";
			$INVH_INVT_ID = $INVT_ID;
			$INVH_PN_ID = $PN_ID;
			$INVH_QTY = $RESERVEQTY;
			$INVH_RETURN_QTY = 0;
			$INVH_QTY_AVAILABLE = $AVAILABLE;
			$INVH_FROM = "";
			$INVH_TO = "";
			$INVH_FROM_LOC = "BIN: " . $BIN . " - LOC: " . $LOCATION;
			$INVH_TO_LOC = "";
			$INVH_BIN = "";
			$INVH_LOCATION = "";
			$INVH_DATE = "NULL";
			$INVH_FROM_ID = 0;
			$INVH_STATUS = "OPEN";
			$INVH_BY = $_SESSION[GetSessionVar()];

			$INVHValues = $INVHValues . "(" . $INVH_ID . ", " . $INVH_INVT_ID . ", " . $INVH_PN_ID . ", " . $INVH_QTY . ", " . $INVH_RETURN_QTY . ", " . $INVH_QTY_AVAILABLE . ", '" . $INVH_FROM . "', '" . $INVH_TO . "', '" . $INVH_FROM_LOC . "', '" . $INVH_TO_LOC . "', '" . $INVH_BIN . "', '" . $INVH_LOCATION . "', " . $INVH_DATE . ", " . $INVH_FROM_ID . ", '" . $INVH_STATUS . "', '" . $INVH_BY  . "'),";


			$INVD_ID = "NULL";
			$INVD_PN_ID = $PN_ID;
			$INVD_QTY = $RESERVEQTY;
			$INVD_RESERVED = $RESERVEQTY;
			$INVD_BIN = "";
			$INVD_LOCATION = "";
			$INVD_DATE = "NULL";

			$INVDValues = $INVDValues . "(" . $INVD_ID . ", " . $INVD_PN_ID . ", " . $INVD_QTY . ", " . $INVD_RESERVED . ", '" . $INVD_BIN . "', '" . $INVD_LOCATION . "', " . $INVD_DATE . "),";


			$COUNTER++;

			if ($COUNTER == 50) {

				$INVHValues = trim($INVHValues, ",");
				InventoryHistoryInsertMulti($INVHValues);

				$INVDValues = trim($INVDValues, ",");
				InventoryDetailReserveMulti($INVDValues);

				$INVHValues = "";
				$INVDValues = "";
				$COUNTER = 0;
			}
		}

		if ($COUNTER != 0) {

			$INVHValues = trim($INVHValues, ",");
			InventoryHistoryInsertMulti($INVHValues);

			$INVDValues = trim($INVDValues, ",");
			InventoryDetailReserveMulti($INVDValues);
		}
	}

	header ("Location: Parts_Reserve_Redirect.php?INVTID=" . $INVT_ID);
?>
