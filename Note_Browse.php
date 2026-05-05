<?php
	include 'Common.php';

	$PN_ID = (isset($_GET["PNID"])) ? $_GET["PNID"] : 0;
	$INVT_ID = (isset($_GET["INVTID"])) ? $_GET["INVTID"] : 0;
	$INVH_ID = (isset($_GET["INVHID"])) ? $_GET["INVHID"] : 0;
?>

<html>

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
			<td valign="top" width="20%">
				<font size="2">
					<i>Date</i>
				</font>
			</td>
			<td valign="top">
				<font size="2">
					<i>Note</i>
				</font>
			</td>
			<td valign="top" width="30%">
				<font size="2">
					<i>By</i>
				</font>
			</td>
		</tr>

		<?php

			GetNoteByID($PN_ID, $INVT_ID, $INVH_ID, $result);

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

		?>

		<tr>
			<td valign="top" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<?php echo $ResultData["NOT_DATE"]; ?>
				</font>
			</td>
			<td valign="top" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<?php echo str_replace("\r\n", "<br>", $ResultData["NOT_NOTE"]); ?>
				</font>
			</td>
			<td valign="top" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<?php echo $ResultData["NOT_BY"]; ?> - <?php echo $ResultData["LOG_NAME"]; ?>
				</font>
			</td>
		</tr>

		<?php
			}
			mysqli_free_result($result);
		?>

	</table>

</body>
</html>