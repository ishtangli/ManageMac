<?php

	include 'Common.php';

	$MSN = (isset($_GET["MSN"])) ? trim($_GET["MSN"]) : "";
	$KIT = (isset($_GET["KIT"])) ? trim($_GET["KIT"]) : "";
	$DWG = (isset($_GET["DWG"])) ? trim($_GET["DWG"]) : "";
	$VEN = (isset($_GET["VEN"])) ? trim($_GET["VEN"]) : "";
	$SN = (isset($_GET["SN"])) ? trim($_GET["SN"]) : "";
	$PN = (isset($_GET["PN"])) ? trim($_GET["PN"]) : "";
	$LOC = (isset($_GET["LOC"])) ? trim($_GET["LOC"]) : "";
	$BIN = (isset($_GET["BIN"])) ? trim($_GET["BIN"]) : "";
	$WP = (isset($_GET["WP"])) ? trim($_GET["WP"]) : "";
	$PROD = (isset($_GET["PROD"])) ? trim($_GET["PROD"]) : "";
	$RIGHTS = "";

	if ($_SESSION["RIGHTS"] == 2) {
		$RIGHTS = "READONLY";
		$MSN = GetMSN();
	}

	$LINKVARS = "MSN=" . $MSN . "&KIT=" . $KIT . "&DWG=" . $DWG . "&VEN=" . $VEN . "&PN=" . $PN . "&SN=" . $SN . "&LOC=" . $LOC . "&BIN=" . $BIN . "&WP=" . $WP . "&PROD=" . $PROD;

?>

<html>
<title>
	<?php echo GetTitle(); ?>
</title>
<body>

	<table border="1" width="1024">
		<tr>
			<td valign="top">
				<?php include 'Menu.php'; ?>
			</td>
		</tr>
		<tr>
			<td valign="top">

				<font size="4">
					<b>Reserve Parts</b>
				</font>

				<br>
				<br>

				<center>

				<form method="get" action="Parts_Reserve_iFrames.php">

					<table border="0" cellspace="1">
						<tr>
							<td valign="top" width="150">
								<font size="2">
									<i>KIT</i>
								</font>
							</td>
							<td valign="top" width="150">
								<font size="2">
									<i>MSN</i>
								</font>
							</td>
							<td valign="top" width="150">
								<font size="2">
									<i>DWG</i>
								</font>
							</td>
							<td valign="top" width="150">
								<font size="2">
									<i>SN</i>
								</font>
							</td>
							<td valign="top" width="150">
								<font size="2">
									<i>Work Package</i>
								</font>
							</td>
						</tr>
						<tr>
							<td valign="top">
								<font size="2">
									<input type="textbox" name="KIT" value="<?php echo $KIT; ?>">
								</font>
							</td>
							<td valign="top">
								<font size="2">
									<input type="textbox" name="MSN" value="<?php echo $MSN; ?>" <?php echo $RIGHTS; ?>>
								</font>
							</td>
							<td valign="top">
								<font size="2">
									<input type="textbox" name="DWG" value="<?php echo $DWG; ?>">
								</font>
							</td>
							<td valign="top">
								<font size="2">
									<input type="textbox" name="SN" value="<?php echo $SN; ?>">
								</font>
							</td>
							<td valign="top">
								<font size="2">
									<input type="textbox" name="WP" value="<?php echo $WP; ?>">
								</font>
							</td>
						</tr>
						<tr>
							<td valign="top" width="150">
								<font size="2">
									<i>PROD#</i>
								</font>
							</td>
							<td valign="top" width="150">
								<font size="2">
									<i>PN</i>
								</font>
							</td>
							<td valign="top" width="150">
								<font size="2">
									<i>Vendor</i>
								</font>
							</td>
							<td valign="top" width="150">
								<font size="2">
									<i>Location</i>
								</font>
							</td>
							<td valign="top" width="150">
								<font size="2">
									<i>Bin</i>
								</font>
							</td>
						</tr>
						<tr>
							<td valign="top">
								<font size="2">
									<input type="textbox" name="PROD" value="<?php echo $PROD; ?>">
								</font>
							</td>
							<td valign="top">
								<font size="2">
									<input type="textbox" name="PN" value="<?php echo $PN; ?>">
								</font>
							</td>
							<td valign="top">
								<font size="2">
									<input type="textbox" name="VEN" value="<?php echo $VEN; ?>">
								</font>
							</td>
							<td valign="top">
								<font size="2">
									<input type="textbox" name="LOC" value="<?php echo $LOC; ?>">
								</font>
							</td>
							<td valign="top">
								<font size="2">
									<input type="textbox" name="BIN" value="<?php echo $BIN; ?>">
								</font>
							</td>
						</tr>
					</table>

					<br>

					<input type="submit" value="Search">

					<br>
					<br>

					<input type="button" value="Refresh" onClick="document.getElementById('PartsFrame').contentWindow.location.reload(true);" style="width='200';">
					<input type="button" value="Reset Selection" onClick="window.location='Parts_Reserve_iFrames.php';" style="width='200';">

				</form>

				</center>

				<br>
				<hr>

				<iframe id="PartsFrame" src="Parts_Reserve.php?<?php echo $LINKVARS; ?>" border='0' frameborder='0' scrolling='auto' width="100%" height="440"></iframe>

				<br>
				<br>

				<center><input type="button" value="Download as CSV File" onclick="window.location='Parts_Reserve_Download.php?<?php echo $LINKVARS; ?>';"></center>
			</td>
		</tr>
	</table>

</body>
</html>
