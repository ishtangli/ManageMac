<?php
	include 'Common.php';

	$INVHValues = "";
	$INVDValues = "";
	$OLDINVHValues = "";
	$COUNTER = 0;

	if (isset($_POST["ISSUEQTY"])) {

		$INVT_ID = $_GET["INVTID"];

		$ISSUEQTY = $_POST["ISSUEQTY"];
		$DATA = $_POST["DATA"];

		$NEW_INVT_ID = InventoryTransactionInsert($_POST["USER"], "ISSUE", "", $_POST["TASKCARD"], $INVT_ID, $_SESSION[GetSessionVar()]);

		for ($i=0; $i<count($ISSUEQTY); $i++) {

			if ($ISSUEQTY[$i] > 0) {

				//$Contents = explode(",", $DATA[$i]);
				$Contents = str_getcsv($DATA[$i], ',', "'");

				$OLD_INVH_ID = $Contents[0];
				$PN_ID = $Contents[1];
				$AVAILABLE = $Contents[2];
				$RESERVED = $Contents[3];
				$ISSUED = $Contents[4];
				$BIN = $Contents[5];
				$LOCATION = $Contents[6];
				$STATUS = ($RESERVED == $ISSUEQTY[$i] + $ISSUED) ? "CLOSED" : "OPEN";


				$INVH_ID = "NULL";
				$INVH_INVT_ID = $NEW_INVT_ID;
				$INVH_PN_ID = $PN_ID;
				$INVH_QTY = $ISSUEQTY[$i];
				$INVH_RETURN_QTY = 0;
				$INVH_QTY_AVAILABLE = $AVAILABLE;
				$INVH_FROM = "";
				$INVH_TO = "";
				$INVH_FROM_LOC = "BIN: " . $BIN . " - LOC: " . $LOCATION;
				$INVH_TO_LOC = "";
				$INVH_BIN = "";
				$INVH_LOCATION = "";
				$INVH_DATE = "NULL";
				$INVH_FROM_ID = $OLD_INVH_ID;
				$INVH_STATUS = "OPEN";
				$INVH_BY = $_SESSION[GetSessionVar()];

				$INVHValues = $INVHValues . "(" . $INVH_ID . ", " . $INVH_INVT_ID . ", " . $INVH_PN_ID . ", " . $INVH_QTY . ", " . $INVH_RETURN_QTY . ", " . $INVH_QTY_AVAILABLE . ", '" . $INVH_FROM . "', '" . $INVH_TO . "', '" . $INVH_FROM_LOC . "', '" . $INVH_TO_LOC . "', '" . $INVH_BIN . "', '" . $INVH_LOCATION . "', " . $INVH_DATE . ", " . $INVH_FROM_ID . ", '" . $INVH_STATUS . "', '" . $INVH_BY  . "'),";


				$INVD_ID = "NULL";
				$INVD_PN_ID = $PN_ID;
				$INVD_QTY = $ISSUEQTY[$i];
				$INVD_RESERVED = $ISSUEQTY[$i];
				$INVD_BIN = "";
				$INVD_LOCATION = "";
				$INVD_DATE = "NULL";

				$INVDValues = $INVDValues . "(" . $INVD_ID . ", " . $INVD_PN_ID . ", " . $INVD_QTY . ", " . $INVD_RESERVED . ", '" . $INVD_BIN . "', '" . $INVD_LOCATION . "', " . $INVD_DATE . "),";


				$OLD_INVH_ID = $OLD_INVH_ID;
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
				$OLD_INVH_STATUS = $STATUS;
				$OLD_INVH_BY = $_SESSION[GetSessionVar()];

				$OLDINVHValues = $OLDINVHValues . "(" . $OLD_INVH_ID . ", " . $OLD_INVH_INVT_ID . ", " . $OLD_INVH_PN_ID . ", " . $OLD_INVH_QTY . ", " . $OLD_INVH_RETURN_QTY . ", " . $OLD_INVH_QTY_AVAILABLE . ", '" . $OLD_INVH_FROM . "', '" . $OLD_INVH_TO . "', '" . $OLD_INVH_FROM_LOC . "', '" . $OLD_INVH_TO_LOC . "', '" . $OLD_INVH_BIN . "', '" . $OLD_INVH_LOCATION . "', " . $OLD_INVH_DATE . ", " . $OLD_INVH_FROM_ID . ", '" . $OLD_INVH_STATUS . "', '" . $OLD_INVH_BY  . "'),";


				$COUNTER++;

				if ($COUNTER == 50) {

					$INVHValues = trim($INVHValues, ",");
					InventoryHistoryInsertMulti($INVHValues);

					$INVDValues = trim($INVDValues, ",");
					InventoryDetailIssueMulti($INVDValues);

					$OLDINVHValues = trim($OLDINVHValues, ",");
					InventoryHistoryUpdateMulti($OLDINVHValues);

					$INVHValues = "";
					$INVDValues = "";
					$OLDINVHValues = "";
					$COUNTER = 0;
				}
			}
		}

		if ($COUNTER != 0) {

			$INVHValues = trim($INVHValues, ",");
			InventoryHistoryInsertMulti($INVHValues);

			$INVDValues = trim($INVDValues, ",");
			InventoryDetailIssueMulti($INVDValues);

			$OLDINVHValues = trim($OLDINVHValues, ",");
			InventoryHistoryUpdateMulti($OLDINVHValues);
		}
	}

	header ("Location: Parts_Issue_Redirect.php?INVTID=" . $NEW_INVT_ID);
?>
