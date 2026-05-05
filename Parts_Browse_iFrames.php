<?php

	include 'Common.php';

	$MSN = (isset($_GET["MSN"])) ? trim($_GET["MSN"]) : "";
	$KIT = (isset($_GET["KIT"])) ? trim($_GET["KIT"]) : "";
	$DWG = (isset($_GET["DWG"])) ? trim($_GET["DWG"]) : "";
	$VEN = (isset($_GET["VEN"])) ? trim($_GET["VEN"]) : "";
	$SN = (isset($_GET["SN"])) ? trim($_GET["SN"]) : "";
	$PN = (isset($_GET["PN"])) ? trim($_GET["PN"]) : "";

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
					<b>Parts Browser</b>
				</font>

				<br>
				<br>

				<center>

				<form method="get" action="Parts_Browse_iFrames.php">

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
						</tr>
						<tr>
							<td valign="top">
								<font size="2">
									<input type="textbox" name="KIT" value="<?php echo $KIT; ?>">
								</font>
							</td>
							<td valign="top">
								<font size="2">
									<input type="textbox" name="MSN" value="<?php echo $MSN; ?>">
								</font>
							</td>
							<td valign="top">
								<font size="2">
									<input type="textbox" name="DWG" value="<?php echo $DWG; ?>">
								</font>
							</td>
						</tr>
						<tr>
							<td valign="top" width="150">
								<font size="2">
									<i>SN</i>
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
						</tr>
						<tr>
							<td valign="top">
								<font size="2">
									<input type="textbox" name="SN" value="<?php echo $SN; ?>">
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
						</tr>
					</table>

					<br>

					<input type="submit" value="Search">

					<br>
					<br>

					<input type="button" value="Refresh" onClick="document.getElementById('PartsFrame').contentWindow.location.reload(true);" style="width='200';">
					<input type="button" value="Reset Selection" onClick="window.location='Parts_Browse_iFrames.php';" style="width='200';">

				</form>

				</center>

				<br>
				<hr>

				<iframe id="PartsFrame" src="Parts_Browse_Details.php?MSN=<?php echo $MSN; ?>&KIT=<?php echo $KIT; ?>&DWG=<?php echo $DWG; ?>&VEN=<?php echo $VEN; ?>&PN=<?php echo $PN; ?>&SN=<?php echo $SN; ?>" border='0' frameborder='0' scrolling='auto' width="100%" height="440"></iframe>

				<br>
				<br>

				<center><input type="button" value="Download as CSV File" onclick="window.location='Parts_Browse_Details_Download.php?MSN=<?php echo $MSN; ?>&KIT=<?php echo $KIT; ?>&DWG=<?php echo $DWG; ?>&VEN=<?php echo $VEN; ?>&PN=<?php echo $PN; ?>&SN=<?php echo $SN; ?>';"></center>
			</td>
		</tr>
	</table>

</body>
</html>
