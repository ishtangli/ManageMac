<?php
	include 'Common.php';

	$INVHValues = "";
	$INVDValues = "";
	$OLDINVHValues = "";
	$COUNTER = 0;

	$INVT_ID = $_GET["INVTID"];

	GetTransactionsWithNotesByINVT_ID($INVT_ID, $result);

	$ResultData = mysqli_fetch_assoc($result);

	$INVT_USER = $ResultData["INVT_USER"];
	$INVT_TASKCARD = $ResultData["INVT_TASKCARD"];

	mysqli_free_result($result);


	$NEW_INVT_ID = InventoryTransactionInsert($INVT_USER, "RELEASE", "", $INVT_TASKCARD, $INVT_ID, $_SESSION[GetSessionVar()]);

	GetForReleaseByINVT_ID($INVT_ID, $result);

	while ($ResultData = mysqli_fetch_assoc($result)) {

		$INVH_ID = "NULL";
		$INVH_INVT_ID = $NEW_INVT_ID;
		$INVH_PN_ID = $ResultData["INVH_PN_ID"];
		$INVH_QTY = $ResultData["INVH_QTY"] - $ResultData["ISSUEDQTY"];
		$INVH_RETURN_QTY = 0;
		$INVH_QTY_AVAILABLE = $ResultData["INVH_QTY_AVAILABLE"];
		$INVH_FROM = "";
		$INVH_TO = "";
		$INVH_FROM_LOC = "";
		$INVH_TO_LOC = "";
		$INVH_BIN = $ResultData["INVH_BIN"];
		$INVH_LOCATION = $ResultData["INVH_LOCATION"];
		$INVH_DATE = "NULL";
		$INVH_FROM_ID = $ResultData["INVH_ID"];
		$INVH_STATUS = "OPEN";
		$INVH_BY = $_SESSION[GetSessionVar()];

		$INVHValues = $INVHValues . "(" . $INVH_ID . ", " . $INVH_INVT_ID . ", " . $INVH_PN_ID . ", " . $INVH_QTY . ", " . $INVH_RETURN_QTY . ", " . $INVH_QTY_AVAILABLE . ", '" . $INVH_FROM . "', '" . $INVH_TO . "', '" . $INVH_FROM_LOC . "', '" . $INVH_TO_LOC . "', '" . $INVH_BIN . "', '" . $INVH_LOCATION . "', " . $INVH_DATE . ", " . $INVH_FROM_ID . ", '" . $INVH_STATUS . "', '" . $INVH_BY  . "'),";


		$INVD_ID = "NULL";
		$INVD_PN_ID = $ResultData["INVH_PN_ID"];
		$INVD_QTY = $ResultData["INVH_QTY"] - $ResultData["ISSUEDQTY"];
		$INVD_RESERVED = $ResultData["INVH_QTY"] - $ResultData["ISSUEDQTY"];
		$INVD_BIN = "";
		$INVD_LOCATION = "";
		$INVD_DATE = "NULL";

		$INVDValues = $INVDValues . "(" . $INVD_ID . ", " . $INVD_PN_ID . ", " . $INVD_QTY . ", " . $INVD_RESERVED . ", '" . $INVD_BIN . "', '" . $INVD_LOCATION . "', " . $INVD_DATE . "),";


		$OLD_INVH_ID = $ResultData["INVH_ID"];
		$OLD_INVH_INVT_ID = 0;
		$OLD_INVH_PN_ID = 0;
		$OLD_INVH_QTY = 0;
		$OLD_INVH_RETURN_QTY = 0;
		$OLD_INVH_QTY_AVAILABLE = 0;
		$OLD_INVH_FROM = "";
		$OLD_INVH_TO = "";
		$OLD_INVH_FROM_LOC = "";
		$OLD_INVH_TO_LOC = "";
		$OLD_INVH_BIN = "";
		$OLD_INVH_LOCATION = "";
		$OLD_INVH_DATE = "NULL";
		$OLD_INVH_FROM_ID = 0;
		$OLD_INVH_STATUS = "CLOSED";
		$OLD_INVH_BY = $_SESSION[GetSessionVar()];

		$OLDINVHValues = $OLDINVHValues . "(" . $OLD_INVH_ID . ", " . $OLD_INVH_INVT_ID . ", " . $OLD_INVH_PN_ID . ", " . $OLD_INVH_QTY . ", " . $OLD_INVH_RETURN_QTY . ", " . $OLD_INVH_QTY_AVAILABLE . ", '" . $OLD_INVH_FROM . "', '" . $OLD_INVH_TO . "', '" . $OLD_INVH_FROM_LOC . "', '" . $OLD_INVH_TO_LOC . "', '" . $OLD_INVH_BIN . "', '" . $OLD_INVH_LOCATION . "', " . $OLD_INVH_DATE . ", " . $OLD_INVH_FROM_ID . ", '" . $OLD_INVH_STATUS . "', '" . $OLD_INVH_BY  . "'),";


		$COUNTER++;

		if ($COUNTER == 50) {


			$INVHValues = trim($INVHValues, ",");
			InventoryHistoryInsertMulti($INVHValues);

			$INVDValues = trim($INVDValues, ",");
			InventoryDetailReleaseMulti($INVDValues);

			$OLDINVHValues = trim($OLDINVHValues, ",");
			InventoryHistoryUpdateMulti($OLDINVHValues);

			$INVHValues = "";
			$INVDValues = "";
			$OLDINVHValues = "";
			$COUNTER = 0;
		}
	}
	mysqli_free_result($result);


	if ($COUNTER != 0) {

		$INVHValues = trim($INVHValues, ",");
		InventoryHistoryInsertMulti($INVHValues);

		$INVDValues = trim($INVDValues, ",");
		InventoryDetailReleaseMulti($INVDValues);

		$OLDINVHValues = trim($OLDINVHValues, ",");
		InventoryHistoryUpdateMulti($OLDINVHValues);
	}

	header ("Location: Parts_History_Detail.php?INVTID=" . $NEW_INVT_ID . "&R=1");
?>