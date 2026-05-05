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
	<?php echo GetTitle(); ?> - PARTS RETURN
</title>
<body>

	<table border="1" cellspace="1" width="100%">

		<tr>
			<td valign="center" bgcolor="#ADD2D3" width="50%">
				<font size="3">
					<b>Transaction#</b>
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
					<b>Issued To:</b>
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

	<form name="ReturnMulti" method="post" action="Parts_Return_Multi_Action.php?INVTID=<?php echo $_GET["INVTID"]; ?>">

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
						<i>From Loc</i>
					</font>
				</td>
				<td valign="center" align="right">
					<font size="2">
						<i>Qty Issued</i>
					</font>
				</td>
				<td valign="center" align="right">
					<font size="2">
						<i>Qty Returned</i>
					</font>
				</td>
				<td valign="center">
					<font size="2">
						<i>Return Qty</i>
					</font>
				</td>
			</tr>

			<?php

				GetHistoryByINVT_ID($INVT_ID, $result);

				$BGCount=0;
				$PNJAVASCRIPT = "";
				$RETURNTOTAL = "";

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
				<td valign="center" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $ResultData["INVH_FROM_LOC"]; ?>
					</font>
				</td>
				<td valign="center" bgcolor="<?php echo $BGColor; ?>" align="right">
					<font size="2">
						<?php echo $ResultData["INVH_QTY"]; ?>
					</font>
				</td>
				<td valign="center" bgcolor="<?php echo $BGColor; ?>" align="right">
					<font size="2">
						<?php echo $ResultData["INVH_RETURN_QTY"]; ?>
					</font>
				</td>
				<td valign="center" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php
							if ($ResultData["INVH_QTY"] > $ResultData["INVH_RETURN_QTY"]) {
								$PNJAVASCRIPT = $PNJAVASCRIPT . "if (document.getElementById('" . $ResultData["INVH_ID"] ."').value < 0 || document.getElementById('" . $ResultData["INVH_ID"] ."').value > " . ($ResultData["INVH_QTY"] - $ResultData["INVH_RETURN_QTY"]) . " || isNaN(document.getElementById('" . $ResultData["INVH_ID"] ."').value)) qtyerror = 1;\r\n";
								$RETURNTOTAL = $RETURNTOTAL . "document.getElementById('" . $ResultData["INVH_ID"] ."').value + ";
						?>

						<input type="textbox" name="RETURNQTY[]" id="<?php echo $ResultData["INVH_ID"];?>" value=0>
						<input type="hidden" name="DATA[]" value="<?php echo $ResultData["INVH_ID"] . "," . $ResultData["PN_ID"] . "," . $ResultData["INVD_QTY"] . "," . $ResultData["INVH_RETURN_QTY"] . "," . $ResultData["INVH_FROM_LOC"]; ?>">

						<?php
							}
							else {
								echo "RETURNED";
							}
						?>
					</font>
				</td>
			</tr>
			<?php
				}
				mysqli_free_result($result);
				$RETURNTOTAL = trim($RETURNTOTAL, "+ ");
			?>

		</table>

		<br>

		<center>
			<input type="button" id="ReturnButton" value="Return Parts" onClick="CheckValues();">
		</center>

	</form>

	<br>
	<br>

	<script type="text/javascript">

		function CheckValues() {
			errormsg = "";
			qtyerror = 0;
			<?php echo $PNJAVASCRIPT; ?>
			if (qtyerror == 1) errormsg = errormsg + "Return Qty must be between 0 and Qty Issued.\r\n";
			if (<?php echo $RETURNTOTAL; ?> == 0) errormsg = errormsg + "No Qty to return.\r\n";
			if (errormsg != "") {
				alert(errormsg);
			}
			else {
				document.getElementById('ReturnButton').value="Processing Request...";
				document.getElementById('ReturnButton').disabled="true";
				document.ReturnMulti.submit();
			}
		}

	</script>

</body>
</html>