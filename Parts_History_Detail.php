<?php

	include 'Common.php';

	$INVT_ID = $_GET["INVTID"];

	GetTransactionsWithNotesByINVT_ID($INVT_ID, $result);

	$ResultData = mysqli_fetch_assoc($result);

	$INVT_USER = $ResultData["INVT_USER"];
	$INVT_TYPE = $ResultData["INVT_TYPE"];
	$INVT_AWB = $ResultData["INVT_AWB"];
	$INVT_TASKCARD = $ResultData["INVT_TASKCARD"];
	$INVT_DATE = $ResultData["INVT_DATE"];
	$INVT_FROM_ID = $ResultData["INVT_FROM_ID"];
	$INVT_BY = $ResultData["INVT_BY"];
	$LOG_NAME = $ResultData["LOG_NAME"];
	$NOTECOUNT = $ResultData["NOTECOUNT"];

	mysqli_free_result($result);

?>

<html>
<title>
	<?php echo GetTitle(); ?> - TRANSACTION RECEIPT
</title>


<?php 
	if (isset($_GET["R"])) { 
?>
<script type="text/javascript">
	window.opener.document.location.reload(true);
</script>
<?php 
	}
?>

<body>

	<table border="1" cellspace="1" width="100%">

		<tr>
			<td valign="bottom" bgcolor="#ADD2D3" colspan="2">
				<font size="6">
					<center><b><?php echo $INVT_TYPE; ?></b></center>
				</font>
			</td>
		</tr>
		<tr>
			<td valign="bottom" bgcolor="#ADD2D3" width="50%">
				<font size="4">
					<b>Transaction#</b>
				</font>
			</td>
			<td valign="bottom" bgcolor="#ADD2D3" width="50%">
				<font size="4">
					<b>Date:</b>
				</font>
			</td>
		</tr>
		<tr>
			<td valign="bottom">
				<font size="3">
					<i><?php echo $INVT_ID; ?></i>
				</font>

				<a href="javascript:void(window.open('Note_Insert.php?INVTID=<?php echo $INVT_ID; ?>','NoteWindow','height=500,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no'));"><img src="note.png" width="12" height="12" alt="New Note" title="New Note"></a>
				<sup><a href="javascript:void(window.open('Note_Browse.php?INVTID=<?php echo $INVT_ID; ?>','NoteWindow','height=500,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no'));"><?php echo $NOTECOUNT; ?></a></sup>
			</td>
			<td valign="bottom">
				<font size="3">
					<i><?php echo $INVT_DATE; ?></i>
				</font>
			</td>
		</tr>

		<?php
			if ($INVT_TYPE == "RESERVE") include 'Parts_History_Detail_Reserve.php';
			if ($INVT_TYPE == "ISSUE") include 'Parts_History_Detail_Issue.php';
			if ($INVT_TYPE == "RECEIVE") include 'Parts_History_Detail_Receive.php';
			if ($INVT_TYPE == "RETURN") include 'Parts_History_Detail_Return.php';
			if ($INVT_TYPE == "PNSUPERUPDATE") include 'Parts_History_Detail_Update.php';
			if ($INVT_TYPE == "RELEASE") include 'Parts_History_Detail_Release.php';
		?>

	</table>

	<br>

	<?php
		if ($INVT_TYPE == "PNSUPERUPDATE") {
				include 'Parts_History_Detail_Update_Body.php';
		}
		else {
				include 'Parts_History_Detail_PN_Body.php';
		}
	?>


	<br>
	<br>

	<center>
		<?php 
			if (isset($_GET["B"])) { 
		?>
			<a href="javascript:void(history.back());">Back</a>&nbsp&nbsp
		<?php 
			}
		?>

		<a href="javascript:void(window.close());">Close</a>&nbsp&nbsp
		<a href="javascript:void(window.print());">Print</a>
	</center>

</body>
</html>