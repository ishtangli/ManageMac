<?php

	include 'Common.php';

	$PNJAVASCRIPT = "";

	$PNLIST = trim($_GET["PNID"], "/");

	$PNINDI = explode("/", $PNLIST);

	$ID = "";

	for ($i=0; $i<count($PNINDI); $i++) {
		$PNID = explode(",", $PNINDI[$i]);
		$ID = $ID . $PNID[0] . ",";

		$PNJAVASCRIPT = $PNJAVASCRIPT . "if (document.getElementById('" . $PNID[0] ."').value <= 0 || document.getElementById('" . $PNID[0] ."').value > " . $PNID[2] . " || isNaN(document.getElementById('" . $PNID[0] ."').value)) qtyerror = 1;\r\n";
	}

	$ID = trim($ID, ",");

?>
<html>
<script type="text/javascript">

	function CheckValues() {
		errormsg = "";
		qtyerror = 0;
		<?php echo $PNJAVASCRIPT; ?>
		if (qtyerror == 1) errormsg = errormsg + "Issue Qty must be between 0 and Qty Avl.\r\n";
		if (document.getElementById('TASKCARD').value == "") errormsg = errormsg + "Task Card is required.\r\n";
		if (document.getElementById('USER').value == "") errormsg = errormsg + "Issued To is required.\r\n";
		if (errormsg != "") {
			alert(errormsg);
		}
		else {
			document.getElementById('IssueButton').value="Processing Request...";
			document.getElementById('IssueButton').disabled="true";
			document.PartsIssue.submit();
		}
	}

</script>
<body>

	<form name="PartsIssue" method="post" action="Parts_Issue_Multi_Action.php">

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
						<i>Work Pack</i>
					</font>
				</td>
				<td valign="center">
					<font size="2">
						<i>Prod#</i>
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
						<i>Qty Avl</i>
					</font>
				</td>
				<td valign="center">
					<font size="2">
						<i>Issue Qty</i>
					</font>
				</td>
			</tr>

			<?php

				GetPartsForIssueByPNID($ID, $result);

				$BGCount=0;

				while ($ResultData = mysqli_fetch_assoc($result)) {

					if ($BGCount % 2 == 0) {
						$BGColor="#FFFFB4";
						$BGCount++;
					}
					else {
						$BGColor="#ADD2D3";
						$BGCount++;
					}

					$DATA = $ResultData["PN_ID"] . "," . $ResultData["PN_QTY_REQ"] . "," . $ResultData["INVD_QTY"] . "," . $ResultData["INVD_ID"] . "," . $ResultData["INVD_LOCATION"] . "," . $ResultData["INVD_BIN"];

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
						<?php echo $ResultData["PN_WORKPACK"]; ?>
					</font>
				</td>
				<td valign="center" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $ResultData["PN_PRODNUM"]; ?>
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
						<?php echo $ResultData["INVD_QTY"]; ?>
					</font>
				</td>
				<td valign="center" bgcolor="<?php echo $BGColor; ?>">
					<input type="textbox" name="ISSUEQTY[]" id="<?php echo $ResultData["PN_ID"]; ?>" value="<?php echo $ResultData["INVD_QTY"]; ?>">
					<input type="hidden" name="DATA[]" value="<?php echo $DATA; ?>">
				</td>
			</tr>

			<?php
				}
				mysqli_free_result($result);
			?>

		</table>

		<br>

		<table border="0" cellspace="1" width="50%">
			<tr>
				<td valign="center" bgcolor="#ADD2D3" width="35%">
					<font size="2">
						Task Card
					</font>
				</td>
				<td bgcolor="#FFFFB4">	
					<font size="2">
						<textarea name="TASKCARD" rows="5" id="TASKCARD"></textarea>
					</font>
				</td>
			</tr>
			<tr>
				<td valign="center" bgcolor="#ADD2D3" width="35%">
					<font size="2">
						Issue To
					</font>
				</td>
				<td bgcolor="#FFFFB4">	
					<font size="2">
						<input type="textbox" name="USER" id="USER">
					</font>
				</td>
			</tr>

		</table>

		<br>

		<?php

			if ($_SESSION["RIGHTS"] == 2) {
				echo "<input type=\"button\" value=\"Print Page\" onClick=\"print();\">";

			}
			else {
				echo "<input type=\"button\" id=\"IssueButton\" value=\"Issue Parts\" onClick=\"CheckValues();\">";
			}
		?>

		</center>

	</form>

</body>
</html>