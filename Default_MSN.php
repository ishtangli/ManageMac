<?php 
	include 'Common.php';
?>

<html>
<script type="text/javascript">
	function CheckValues() {
		errormsg = "";
		if (document.MSN.MSN.value == "") errormsg = errormsg + "MSN is required.\r\n";
		if (errormsg != "") {
			alert(errormsg);
		}
		else {
			document.MSN.submit();
		}
	}
</script>
<title>
	<?php echo GetTitle(); ?>
</title>
<body>

	<table border="1" width="800" background="backgrnd.gif">
		<tr>
			<td valign="top" width="20%">
				<?php include 'Menu.php'; ?>
			</td>
		</tr>
		<tr>
			<td valign="top">

				<font size="4">
					<b>Current MSN: <?php echo GetMSN(); ?></b>
				</font>

				<br>
				<br>

				<form name="MSN" method="post" action="Default_MSN_Update_Action.php">

					<table border="0" cellspace="1" width="50%">
						<tr>
							<td valign="top" width="35%">
								<font size="3">
									New MSN
								</font>
							</td>
							<td>	
								<font size="3">
									<input type="textbox" name="MSN">
								</font>
							</td>
						</tr>
					</table>

					<br>

					<input type="button" value="Update Default MSN" onClick="CheckValues();">

				</form>
			</td>
		</tr>
	</table>

</body>
</html>