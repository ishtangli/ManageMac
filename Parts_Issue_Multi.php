<?php

	include 'Common.php';

	$INVT_ID = $_GET["INVTID"];

	GetTransactionsByINVT_ID($INVT_ID, $result);

	$ResultData = mysqli_fetch_assoc($result);

	$INVT_DATE = $ResultData["INVT_DATE"];
	$INVT_TASKCARD = $ResultData["INVT_TASKCARD"];
	$INVT_USER = $ResultData["INVT_USER"];

	mysqli_free_result($result);

?>

<html>
<title>
	<?php echo GetTitle(); ?> - PARTS ISSUE
</title>
<body>

	<table border="1" cellspace="1" width="100%">

		<tr>
			<td valign="center" bgcolor="#ADD2D3" width="50%">
				<font size="3">
					<b>Reservation#</b>
				</font>
			</td>
			<td valign="center" bgcolor="#ADD2D3" width="50%">
				<font size="3">
					<b>Date:</b>
				</font>
			</td>
		</tr>
		<tr>
			<td valign="center">
				<font size="3">
					<i><?php echo $INVT_ID; ?></i>
				</font>
			</td>
			<td valign="center">
				<font size="3">
					<i><?php echo $INVT_DATE; ?></i>
				</font>
			</td>
		</tr>
		<tr>		
			<td valign="center" bgcolor="#ADD2D3">
				<font size="3">
					<b>Task Card:</b>
				</font>
			</td>
			<td valign="center" bgcolor="#ADD2D3">
				<font size="3">
					<b>Reserved To:</b>
				</font>
			</td>
		</tr>
		<tr>
			<td valign="center">
				<font size="3">
					<i><?php echo $INVT_TASKCARD; ?></i>
				</font>
			</td>
			<td valign="center">
				<font size="3">
					<i><?php echo $INVT_USER; ?></i>
				</font>
			</td>
		</tr>

	</table>

	<br>

	<form name="IssueMulti" method="post" action="Parts_Issue_Multi_Action.php?INVTID=<?php echo $_GET["INVTID"]; ?>">

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
				<td valign="center" align="right">
					<font size="2">
						<i>Qty Reserved</i>
					</font>
				</td>
				<td valign="center" align="right">
					<font size="2">
						<i>Qty Issued</i>
					</font>
				</td>
				<td valign="center">
					<font size="2">
						<i>Issue Qty</i>
					</font>
				</td>
			</tr>

			<?php

				GetReservedByINVT_ID($INVT_ID, $result);

				$BGCount=0;
				$PNJAVASCRIPT = "";
				$ISSUETOTAL = "";

				while ($ResultData = mysqli_fetch_assoc($result)) {

					if ($BGCount % 2 == 0) {
						$BGColor="#FFFFB4";
						$BGCount++;
					}
					else {
						$BGColor="#ADD2D3";
						$BGCount++;
					}
					
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
				<td valign="center" bgcolor="<?php echo $BGColor; ?>" align="right">
					<font size="2">
						<?php echo $ResultData["INVH_QTY"]; ?>
					</font>
				</td>
				<td valign="center" bgcolor="<?php echo $BGColor; ?>" align="right">
					<font size="2">
						<?php echo $ResultData["ISSUEDQTY"]; ?>
					</font>
				</td>
				<td valign="center" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php
							if ($ResultData["INVH_STATUS"] == "OPEN") {
								$PNJAVASCRIPT = $PNJAVASCRIPT . "if (document.getElementById('" . $ResultData["INVH_ID"] ."').value < 0 || document.getElementById('" . $ResultData["INVH_ID"] ."').value > " . ($ResultData["INVH_QTY"] - $ResultData["ISSUEDQTY"]) . " || isNaN(document.getElementById('" . $ResultData["INVH_ID"] ."').value)) qtyerror = 1;\r\n";
								$ISSUETOTAL = $ISSUETOTAL . "document.getElementById('" . $ResultData["INVH_ID"] ."').value + ";
						?>

						<input type="textbox" name="ISSUEQTY[]" id="<?php echo $ResultData["INVH_ID"];?>" value="<?php echo $ResultData["INVH_QTY"] - $ResultData["ISSUEDQTY"]; ?>">
						<input type="hidden" name="DATA[]" value="<?php echo $ResultData["INVH_ID"] . "," . $ResultData["PN_ID"] . "," . $ResultData["INVD_QTY"] . "," . $ResultData["INVH_QTY"] . "," . $ResultData["ISSUEDQTY"] . "," . $ResultData["INVH_BIN"] . "," . $ResultData["INVH_LOCATION"]; ?>">

						<?php
							}
							else {
								echo "CLOSED";
							}
						?>
					</font>
				</td>
			</tr>
			<?php
				}
				mysqli_free_result($result);
				$ISSUETOTAL = trim($ISSUETOTAL, "+ ");
			?>

		</table>

		<br>

		<center>

			<table border="0" cellspace="1" width="50%">
				<tr>
					<td valign="center" bgcolor="#ADD2D3" width="35%">
						<font size="2">
							Issue To
						</font>
					</td>
					<td bgcolor="#FFFFB4">	
						<font size="2">
							<input name="USER" id="USER">
							<input type="hidden" name="TASKCARD" value="<?php echo $INVT_TASKCARD; ?>">
						</font>
					</td>
				</tr>
			</table>

			<br>

			<input type="button" id="IssueButton" value="Issue Parts" onClick="CheckValues();">
			<input type="button" id="ReleaseButton" value="Release Parts" onClick="ConfirmRelease();">
		</center>

	</form>

	<br>
	<br>

	<script type="text/javascript">

		function CheckValues() {
			errormsg = "";
			qtyerror = 0;
			<?php echo $PNJAVASCRIPT; ?>
			if (qtyerror == 1) errormsg = errormsg + "Issue Qty must be between 0 and Qty Reserved.\r\n";
			if (<?php echo $ISSUETOTAL; ?> == 0) errormsg = errormsg + "No Qty to issue.\r\n";
			if (document.getElementById('USER').value == "") errormsg = errormsg + "Issue To is required.\r\n";
			if (errormsg != "") {
				alert(errormsg);
			}
			else {
				document.getElementById('IssueButton').value="Processing Request...";
				document.getElementById('IssueButton').disabled="true";
				document.getElementById('ReleaseButton').disabled="true";
				document.IssueMulti.submit();
			}
		}

		function ConfirmRelease() {

			answer = confirm("Are you sure you would like to release reserved qty?");

			if (answer) {
				document.getElementById('IssueButton').disabled="true";
				document.getElementById('ReleaseButton').value="Processing Request...";
				document.getElementById('ReleaseButton').disabled="true";
				window.location = 'Parts_Release_Multi_Action.php?INVTID=<?php echo $INVT_ID; ?>';
			}
		}

	</script>

</body>
</html>