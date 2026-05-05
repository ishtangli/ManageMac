<?php

	include 'Common.php';

	$TID = (isset($_GET["TID"])) ? trim($_GET["TID"]) : "";
	$TYPE = (isset($_GET["TYPE"])) ? trim($_GET["TYPE"]) : "ALL";
	$FDATE = (isset($_GET["FDATE"])) ? trim($_GET["FDATE"]) : "";
	$TDATE = (isset($_GET["TDATE"])) ? trim($_GET["TDATE"]) : "";
	$BY = (isset($_GET["BY"])) ? trim($_GET["BY"]) : "";

?>

<html>

<script language="JavaScript" src="calendar_db.js"></script>
<link rel="stylesheet" href="calendar.css">

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
					<b>History Browser - </b><?php echo BuilDHistoryDropdown($BY); ?>
				</font>

				<br>
				<br>

				<center>

				<form name="Action" method="get" action="Parts_History_TRANS_iFrames.php">

					<table border="0" cellspace="1">
						<tr>
							<td valign="top">
								<font size="2">
									<i>Transaction #</i>
								</font>
							</td>
							<td valign="top">
								<font size="2">
									<i>Type</i>
								</font>
							</td>
							<td valign="top">
								<font size="2">
									<i>From Date</i>
								</font>
							</td>
							<td valign="top">
								<font size="2">
									<i>To Date</i>
								</font>
							</td>
						</tr>
						<tr>
							<td valign="top">
								<input type="textbox" name="TID" value="<?php echo $TID; ?>">
							</td>
							<td valign="top">
								<?php echo BuilDTypeDropdown($TYPE); ?>
							</td>
							<td valign="top">
								<input type="textbox" name="FDATE" value="<?php echo $FDATE; ?>">
								<script language="JavaScript">
									new tcal ({
										// form name
										'formname': 'Action',
										// input name
										'controlname': 'FDATE'
									});
								</script>
							</td>
							<td valign="top">
								<input type="textbox" name="TDATE" value="<?php echo $TDATE; ?>">
								<script language="JavaScript">
									new tcal ({
										// form name
										'formname': 'Action',
										// input name
										'controlname': 'TDATE'
									});
								</script>
							</td>
						</tr>
					</table>

					<input type="hidden" name="BY" value="<?php echo $BY; ?>">

					<br>

					<input type="submit" value="Search">

					<br>
					<br>

					<input type="button" value="Refresh" onClick="document.getElementById('PartsFrame').contentWindow.location.reload(true);" style="width='200';">
					<input type="button" value="Reset Selection" onClick="window.location='Parts_History_TRANS_iFrames.php?BY=TRANS';" style="width='200';">

				</form>

				</center>

				<br>
				<hr>

				<iframe id="PartsFrame" src="Parts_History_TRANS.php?TID=<?php echo $TID; ?>&TYPE=<?php echo $TYPE; ?>&FDATE=<?php echo $FDATE; ?>&TDATE=<?php echo $TDATE; ?>" border='0' frameborder='0' scrolling='auto' width="100%" height="440"></iframe>

				<br>
				<br>

				<center><input type="button" value="Download as CSV File" onclick="window.location='Parts_History_TRANS_Download.php?TID=<?php echo $TID; ?>&TYPE=<?php echo $TYPE; ?>&FDATE=<?php echo $FDATE; ?>&TDATE=<?php echo $TDATE; ?>';"></center>
			</td>
		</tr>
	</table>

</body>
</html>
