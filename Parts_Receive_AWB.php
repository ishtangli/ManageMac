<?php

	include 'Common.php';

	$PNJAVASCRIPT = "";

	$PNLIST = trim($_GET["PNID"], "/");

	$PNINDI = explode("/", $PNLIST);

	$ID = "";

	for ($i=0; $i<count($PNINDI); $i++) {
		$PNID = explode(",", $PNINDI[$i]);
		$ID = $ID . $PNID[0] . ",";

		$PNJAVASCRIPT = $PNJAVASCRIPT . "if (document.getElementById('" . $PNID[0] ."').value <= 0 || isNaN(document.getElementById('" . $PNID[0] ."').value)) qtyerror = 1;\r\n";
	}

	$ID = trim($ID, ",");

?>

<html>
<title>
	<?php echo GetTitle(); ?> - PARTS RECEIVING
</title>

<script type="text/javascript">

	function CheckValues() {
		errormsg = "";
		qtyerror = 0;
		<?php echo $PNJAVASCRIPT; ?>
		if (qtyerror == 1) errormsg = errormsg + "Qty Received must be greater than 0.\r\n";
		if (document.getElementById('AWB').value == "") errormsg = errormsg + "AWB is required.\r\n";
		if (document.getElementById('BIN').value == "") errormsg = errormsg + "Bin is required.\r\n";
		if (document.getElementById('LOC').value == "") errormsg = errormsg + "Location is required.\r\n";
		if (errormsg != "") {
			alert(errormsg);
		}
		else {
			document.getElementById('ReceiveButton').value="Processing Request...";
			document.getElementById('ReceiveButton').disabled="true";
			document.PartsReceive.submit();
		}
	}
</script>
<body>

	<form name="PartsReceive" method="post" action="Parts_Receive_Multi_Action.php">

		<center>

		<table border="0" cellspace="1" width="100%">

			<tr>
				<td valign="center">
					<font size="2">
						<i>Kit</i>
					</font>
				</td>
				<td valign="center">
					<font size="2">
						<i>MSN</i>
					</font>
				</td>
				<td valign="center">
					<font size="2">
						<i>DWG</i>
					</font>
				</td>
				<td valign="center">
					<font size="2">
						<i>SN</i>
					</font>
				</td>
				<td valign="center">
					<font size="2">
						<i>Vendor</i>
					</font>
				</td>
				<td valign="center">
					<font size="2">
						<i>PN</i>
					</font>
				</td>
				<td valign="center">
					<font size="2">
						<i>Desc</i>
					</font>
				</td>
				<td valign="center">
					<font size="2">
						<i>Kit MPN</i>
					</font>
				</td>
				<td valign="center">
					<font size="2">
						<i>Loc</i>
					</font>
				</td>
				<td valign="center">
					<font size="2">
						<i>Bin</i>
					</font>
				</td>
				<td valign="center" align="right">
					<font size="2">
						<i>Qty Req</i>
					</font>
				</td>
				<td valign="center" align="right">
					<font size="2">
						<i>Qty Rec</i>
					</font>
				</td>
				<td valign="center" align="right">
					<font size="2">
						<i>Qty Avl</i>
					</font>
				</td>
				<td valign="center">
					<font size="2">
						<i>Receive Qty</i>
					</font>
				</td>
			</tr>

			<?php

				GetPartsForReceiptByPNID($ID, $result);

				$BGCount=0;

				$PREVLOC = "";
				$NEWLOC = "";

				$LOOPCOUNT = 0;
				$ERROR = 0;

				while ($ResultData = mysqli_fetch_assoc($result)) {

					if ($BGCount % 2 == 0) {
						$BGColor="#FFFFB4";
						$BGCount++;
					}
					else {
						$BGColor="#ADD2D3";
						$BGCount++;
					}

					$DATA = $ResultData["PN_ID"] . "," . $ResultData["PN_QTY_REQ"] . "," . $ResultData["AVEQTY"] . "," . $ResultData["INVD_ID"] . "," . $ResultData["PN_QTY_REC"];

					$LOCATION = $ResultData["INVD_LOCATION"];
					$BIN = $ResultData["INVD_BIN"];

					$NEWLOC = $LOCATION . "-" . $BIN;

					if ($LOOPCOUNT == 0) $PREVLOC = $NEWLOC;

					if ($PREVLOC != $NEWLOC) $ERROR = 1;

					$PREVLOC = $NEWLOC;

					$LOOPCOUNT++;

			?>

			<tr>
				<td valign="center" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $ResultData["PN_KIT"]; ?>
					</font>
				</td>
				<td valign="center" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $ResultData["PN_MSN"]; ?>
					</font>
				</td>
				<td valign="center" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $ResultData["PN_DWG"]; ?>
					</font>
				</td>
				<td valign="center" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $ResultData["PN_KIT_SN"]; ?>
					</font>
				</td>
				<td valign="center" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $ResultData["PN_VENDOR"]; ?>
					</font>
				</td>
				<td valign="center" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $ResultData["PN_PN"]; ?>
					</font>
				</td>
				<td valign="center" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $ResultData["PN_DESC"]; ?>
					</font>
				</td>
				<td valign="center" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $ResultData["PN_KIT_MPN"]; ?>
					</font>
				</td>
				<td valign="center" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $ResultData["INVD_LOCATION"]; ?>
					</font>
				</td>
				<td valign="center" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $ResultData["INVD_BIN"]; ?>
					</font>
				</td>
				<td valign="center" bgcolor="<?php echo $BGColor; ?>" align="right">
					<font size="2">
						<?php echo $ResultData["PN_QTY_REQ"]; ?>
					</font>
				</td>
				<td valign="center" bgcolor="<?php echo $BGColor; ?>" align="right">
					<font size="2">
						<?php echo $ResultData["PN_QTY_REC"]; ?>
					</font>
				</td>
				<td valign="center" bgcolor="<?php echo $BGColor; ?>" align="right">
					<font size="2">
						<?php echo $ResultData["AVEQTY"]; ?>
					</font>
				</td>
				<td valign="center" bgcolor="<?php echo $BGColor; ?>">
					<input type="textbox" name="RECEIVEQTY[]" id="<?php echo $ResultData["PN_ID"]; ?>" value="<?php echo $ResultData["PN_QTY_REQ"] - $ResultData["PN_QTY_REC"]; ?>">
					<input type="hidden" name="DATA[]" value="<?php echo $DATA; ?>">
				</td>
			</tr>

			<?php
				}
				mysqli_free_result($result);
			?>

		</table>

		<br>

		<?php 
			if ($ERROR == 1) {
				echo "<b>ERROR: CANNOT RECEIVE PARTS INTO DIFFERENT LOCATIONS</b>";
			}
			else {
				include 'Parts_Receive_AWB_Body.php';
			}
		?>

		</center>

	</form>

</body>
</html>