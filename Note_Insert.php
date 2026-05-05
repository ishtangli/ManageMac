<?php
	$PN_ID = (isset($_GET["PNID"])) ? $_GET["PNID"] : 0;
	$INVT_ID = (isset($_GET["INVTID"])) ? $_GET["INVTID"] : 0;
	$INVH_ID = (isset($_GET["INVHID"])) ? $_GET["INVHID"] : 0;
?>

<html>
<body>

	<form name="Notes" method="post" action="Note_Insert_Action.php?PNID=<?php echo $PN_ID; ?>&INVTID=<?php echo $INVT_ID; ?>&INVHID=<?php echo $INVH_ID; ?>">

		<font size="4">
			<center><b>New Note</b></center>
		</font>

		<table width="100%">
			<tr>
				<td>
					<center>

					<textarea name="NOTE" cols=50 rows=10></textarea>

					<br>
					<br>

					<input type="submit" value="Create Note">

					</center>
				</td>
			</tr>
		</table>	

	</form>

</body>
</html>