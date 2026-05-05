<?php 
	include 'Common.php';
?>

<html>
<script type="text/javascript">
	function CheckValues() {
		errormsg = "";
		if (document.InsertIndi.PN_KIT.value == "") errormsg = errormsg + "KIT is required.\r\n";
		if (document.InsertIndi.PN_MSN.value == "") errormsg = errormsg + "MSN is required.\r\n";
		if (document.InsertIndi.PN_DWG.value == "") errormsg = errormsg + "DWG is required.\r\n";
		if (document.InsertIndi.PN_KIT_SN.value == "") errormsg = errormsg + "SN is required.\r\n";
		if (document.InsertIndi.PN_VENDOR.value == "") errormsg = errormsg + "Vendor is required.\r\n";
		if (document.InsertIndi.PN_PN.value == "") errormsg = errormsg + "PN is required.\r\n";
		if (document.InsertIndi.PN_DESC.value == "") errormsg = errormsg + "Description is required.\r\n";
		if (document.InsertIndi.PN_MFR.value == "") errormsg = errormsg + "MFR is required.\r\n";
		if (document.InsertIndi.PN_QTY_REQ.value <= 0 || isNaN(document.InsertIndi.PN_QTY_REQ.value)) errormsg = errormsg + "Qty Required must be > 0.\r\n";
		if (document.InsertIndi.PN_UOM.value == "") errormsg = errormsg + "UOM is required.\r\n";
		if (errormsg != "") {
			alert(errormsg);
		}
		else {
			document.InsertIndi.submit();
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
					<b>Parts Uploader</b>
				</font>

				<br>
				<br>

				<form enctype="multipart/form-data" action="Parts_Upload_Action.php" method="post">

					<!-- MAX_FILE_SIZE must precede the file input field -->
					<input type="hidden" name="MAX_FILE_SIZE" value="81920000" />

					<!-- Name of input element determines name in $_FILES array -->
					Select file to upload:

					<br>

					<input name="file1" type="file" />

					<br>
					<br>

					<input type="submit" value="Upload File" />

				</form>

				<i>Please use <a href="Template.csv">this</a> template when uploading multiple parts.</i>
				<br>
				<i><b>Do not forget to remove the headers!</b></i>

			</td>
		</tr>
		<tr>
			<td valign="top">

				<font size="4">
					<b>Create New Part</b>
				</font>

				<br>
				<br>

				<form name="InsertIndi" method="post" action="Parts_Insert_Indi_Action.php">

					<table border="0" cellspace="1" width="50%">
						<tr>
							<td valign="top" width="35%">
								<font size="3">
									KIT
								</font>
							</td>
							<td>	
								<font size="3">
									<input type="textbox" name="PN_KIT">
								</font>
							</td>
						</tr>
						<tr>
							<td valign="top" width="35%">
								<font size="3">
									MSN
								</font>
							</td>
							<td>	
								<font size="3">
									<input type="textbox" name="PN_MSN">
								</font>
							</td>
						</tr>
						<tr>
							<td valign="top" width="35%">
								<font size="3">
									DWG
								</font>
							</td>
							<td>	
								<font size="3">
									<input type="textbox" name="PN_DWG">
								</font>
							</td>
						</tr>
						<tr>
							<td valign="top" width="35%">
								<font size="3">
									SN
								</font>
							</td>
							<td>	
								<font size="3">
									<input type="textbox" name="PN_KIT_SN">
								</font>
							</td>
						</tr>
						<tr>
							<td valign="top" width="35%">
								<font size="3">
									Vendor
								</font>
							</td>
							<td>	
								<font size="3">
									<input type="textbox" name="PN_VENDOR">
								</font>
							</td>
						</tr>
						<tr>
							<td valign="top" width="35%">
								<font size="3">
									PN
								</font>
							</td>
							<td>	
								<font size="3">
									<input type="textbox" name="PN_PN">
								</font>
							</td>
						</tr>
						<tr>
							<td valign="top" width="35%">
								<font size="3">
									Description
								</font>
							</td>
							<td>	
								<font size="3">
									<input type="textbox" name="PN_DESC">
								</font>
							</td>
						</tr>
						<tr>
							<td valign="top" width="35%">
								<font size="3">
									MFR
								</font>
							</td>
							<td>	
								<font size="3">
									<input type="textbox" name="PN_MFR">
								</font>
							</td>
						</tr>
						<tr>
							<td valign="top" width="35%">
								<font size="3">
									Qty Required
								</font>
							</td>
							<td>	
								<font size="3">
									<input type="textbox" name="PN_QTY_REQ">
								</font>
							</td>
						</tr>
						<tr>
							<td valign="top" width="35%">
								<font size="3">
									UOM
								</font>
							</td>
							<td>	
								<font size="3">
									<input type="textbox" name="PN_UOM">
								</font>
							</td>
						</tr>
						<tr>
							<td valign="top" width="35%">
								<font size="3">
									IDENT
								</font>
							</td>
							<td>	
								<font size="3">
									<input type="textbox" name="PN_IDENT">
								</font>
							</td>
						</tr>
						<tr>
							<td valign="top" width="35%">
								<font size="3">
									Kit MPN
								</font>
							</td>
							<td>	
								<font size="3">
									<input type="textbox" name="PN_KIT_MPN">
								</font>
							</td>
						</tr>
					</table>

					<br>

					<input type="button" value="Create Part" onClick="CheckValues();">

				</form>
			</td>
		</tr>
	</table>

</body>
</html>