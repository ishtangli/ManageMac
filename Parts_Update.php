<?php

	include 'Common.php';

	$PN_ID = $_GET["PN"];

	GetPartsByPN_ID($PN_ID, $result);

	$ResultData = mysqli_fetch_assoc($result);

	$PN_KIT = $ResultData["PN_KIT"];
	$PN_MSN = $ResultData["PN_MSN"];
	$PN_DWG = $ResultData["PN_DWG"];
	$PN_KIT_SN = $ResultData["PN_KIT_SN"];
	$PN_VENDOR = $ResultData["PN_VENDOR"];
	$PN_WORKPACK = $ResultData["PN_WORKPACK"];
	$PN_PRODNUM = $ResultData["PN_PRODNUM"];
	$PN_PN = $ResultData["PN_PN"];
	$PN_DESC = $ResultData["PN_DESC"];
	$PN_MFR = $ResultData["PN_MFR"];
	$PN_QTY_REQ = $ResultData["PN_QTY_REQ"];
	$PN_QTY_REC = $ResultData["PN_QTY_REC"];
	$AVAILABLE = $ResultData["AVEQTY"];
	$PN_UOM = $ResultData["PN_UOM"];
	$PN_IDENT = $ResultData["PN_IDENT"];
	$PN_KIT_MPN = $ResultData["PN_KIT_MPN"];
	$PN_STATUS = $ResultData["PN_STATUS"];
	$PN_ACTIVE = $ResultData["PN_ACTIVE"];

	mysqli_free_result($result);

?>

<html>
<script type="text/javascript">
	function CheckValues() {
		//errormsg = "";
		//if (document.UpdateIndi.PN_KIT.value == "") errormsg = errormsg + "KIT is required.\r\n";
		//if (document.UpdateIndi.PN_MSN.value == "") errormsg = errormsg + "MSN is required.\r\n";
		//if (document.UpdateIndi.PN_DWG.value == "") errormsg = errormsg + "DWG is required.\r\n";
		//if (document.UpdateIndi.PN_KIT_SN.value == "") errormsg = errormsg + "SN is required.\r\n";
		//if (document.UpdateIndi.PN_VENDOR.value == "") errormsg = errormsg + "Vendor is required.\r\n";
		//if (document.UpdateIndi.PN_PN.value == "") errormsg = errormsg + "PN is required.\r\n";
		//if (document.UpdateIndi.PN_DESC.value == "") errormsg = errormsg + "Description is required.\r\n";
		//if (document.UpdateIndi.PN_MFR.value == "") errormsg = errormsg + "MFR is required.\r\n";
		//if (document.UpdateIndi.PN_QTY_REQ.value <= 0) errormsg = errormsg + "Qty Required must be > 0.\r\n";
		//if (document.UpdateIndi.PN_UOM.value == "") errormsg = errormsg + "UOM is required.\r\n";
		//if (errormsg != "") {
		//	alert(errormsg);
		//}
		//else {
			document.UpdateIndi.submit();
		//}
	}
</script>
<body>

	<form name="UpdateIndi" method="post" action="Parts_Update_Action.php?PN=<?php echo $PN_ID; ?>&REC=<?php echo $PN_QTY_REC; ?>">

		<center>

		<table border="0" cellspace="1" width="50%">
			<tr>
				<td valign="top" bgcolor="#ADD2D3" width="35%">
					<font size="3">
						KIT
					</font>
				</td>
				<td bgcolor="#FFFFB4">	
					<font size="3">
						<input type="textbox" name="PN_KIT" value="<?php echo $PN_KIT; ?>">
						<input type="hidden" name="FROM_PN_KIT" value="<?php echo $PN_KIT; ?>">
					</font>
				</td>
			</tr>
			<tr>
				<td valign="top" bgcolor="#ADD2D3" width="35%">
					<font size="3">
						MSN
					</font>
				</td>
				<td bgcolor="#FFFFB4">	
					<font size="3">
						<input type="textbox" name="PN_MSN" value="<?php echo $PN_MSN; ?>">
						<input type="hidden" name="FROM_PN_MSN" value="<?php echo $PN_MSN; ?>">
					</font>
				</td>
			</tr>
			<tr>
				<td valign="top" bgcolor="#ADD2D3" width="35%">
					<font size="3">
						DWG
					</font>
				</td>
				<td bgcolor="#FFFFB4">	
					<font size="3">
						<input type="textbox" name="PN_DWG" value="<?php echo $PN_DWG; ?>">
						<input type="hidden" name="FROM_PN_DWG" value="<?php echo $PN_DWG; ?>">
					</font>
				</td>
			</tr>
			<tr>
				<td valign="top" bgcolor="#ADD2D3" width="35%">
					<font size="3">
						SN
					</font>
				</td>
				<td bgcolor="#FFFFB4">	
					<font size="3">
						<input type="textbox" name="PN_KIT_SN" value="<?php echo $PN_KIT_SN; ?>">
						<input type="hidden" name="FROM_PN_KIT_SN" value="<?php echo $PN_KIT_SN; ?>">
					</font>
				</td>
			</tr>
			<tr>
				<td valign="top" bgcolor="#ADD2D3" width="35%">
					<font size="3">
						Vendor
					</font>
				</td>
				<td bgcolor="#FFFFB4">	
					<font size="3">
						<input type="textbox" name="PN_VENDOR" value="<?php echo $PN_VENDOR; ?>">
						<input type="hidden" name="FROM_PN_VENDOR" value="<?php echo $PN_VENDOR; ?>">
					</font>
				</td>
			</tr>
			<tr>
				<td valign="top" bgcolor="#ADD2D3" width="35%">
					<font size="3">
						Work Pack
					</font>
				</td>
				<td bgcolor="#FFFFB4">	
					<font size="3">
						<input type="textbox" name="PN_WORKPACK" value="<?php echo $PN_WORKPACK; ?>">
						<input type="hidden" name="FROM_PN_WORKPACK" value="<?php echo $PN_WORKPACK; ?>">
					</font>
				</td>
			</tr>
			<tr>
				<td valign="top" bgcolor="#ADD2D3" width="35%">
					<font size="3">
						Prod#
					</font>
				</td>
				<td bgcolor="#FFFFB4">	
					<font size="3">
						<input type="textbox" name="PN_PRODNUM" value="<?php echo $PN_PRODNUM; ?>">
						<input type="hidden" name="FROM_PN_PRODNUM" value="<?php echo $PN_PRODNUM; ?>">
					</font>
				</td>
			</tr>
			<tr>
				<td valign="top" bgcolor="#ADD2D3" width="35%">
					<font size="3">
						PN
					</font>
				</td>
				<td bgcolor="#FFFFB4">	
					<font size="3">
						<input type="textbox" name="PN_PN" value="<?php echo $PN_PN; ?>">
						<input type="hidden" name="FROM_PN_PN" value="<?php echo $PN_PN; ?>">
					</font>
				</td>
			</tr>
			<tr>
				<td valign="top" bgcolor="#ADD2D3" width="35%">
					<font size="3">
						Description
					</font>
				</td>
				<td bgcolor="#FFFFB4">	
					<font size="3">
						<input type="textbox" name="PN_DESC" value="<?php echo $PN_DESC; ?>">
						<input type="hidden" name="FROM_PN_DESC" value="<?php echo $PN_DESC; ?>">
					</font>
				</td>
			</tr>
			<tr>
				<td valign="top" bgcolor="#ADD2D3" width="35%">
					<font size="3">
						MFR
					</font>
				</td>
				<td bgcolor="#FFFFB4">	
					<font size="3">
						<input type="textbox" name="PN_MFR" value="<?php echo $PN_MFR; ?>">
						<input type="hidden" name="FROM_PN_MFR" value="<?php echo $PN_MFR; ?>">
					</font>
				</td>
			</tr>
			<tr>
				<td valign="top" bgcolor="#ADD2D3" width="35%">
					<font size="3">
						Qty Required
					</font>
				</td>
				<td bgcolor="#FFFFB4">	
					<font size="3">
						<input type="textbox" name="PN_QTY_REQ" value="<?php echo $PN_QTY_REQ; ?>">
						<input type="hidden" name="FROM_PN_QTY_REQ" value="<?php echo $PN_QTY_REQ; ?>">
					</font>
				</td>
			</tr>
			<tr>
				<td valign="top" bgcolor="#ADD2D3" width="35%">
					<font size="3">
						Qty Received
					</font>
				</td>
				<td bgcolor="#FFFFB4">	
					<font size="3">
						<?php echo $PN_QTY_REC; ?>
					</font>
				</td>
			</tr>
			<tr>
				<td valign="top" bgcolor="#ADD2D3" width="35%">
					<font size="3">
						Qty Available
					</font>
				</td>
				<td bgcolor="#FFFFB4">	
					<font size="3">
						<?php echo $AVAILABLE; ?>
					</font>
				</td>
			</tr>
			<tr>
				<td valign="top" bgcolor="#ADD2D3" width="35%">
					<font size="3">
						UOM
					</font>
				</td>
				<td bgcolor="#FFFFB4">	
					<font size="3">
						<input type="textbox" name="PN_UOM" value="<?php echo $PN_UOM; ?>">
						<input type="hidden" name="FROM_PN_UOM" value="<?php echo $PN_UOM; ?>">
					</font>
				</td>
			</tr>
			<tr>
				<td valign="top" bgcolor="#ADD2D3" width="35%">
					<font size="3">
						IDENT
					</font>
				</td>
				<td bgcolor="#FFFFB4">	
					<font size="3">
						<input type="textbox" name="PN_IDENT" value="<?php echo $PN_IDENT; ?>">
						<input type="hidden" name="FROM_PN_IDENT" value="<?php echo $PN_IDENT; ?>">
					</font>
				</td>
			</tr>
			<tr>
				<td valign="top" bgcolor="#ADD2D3" width="35%">
					<font size="3">
						Kit MPN
					</font>
				</td>
				<td bgcolor="#FFFFB4">	
					<font size="3">
						<input type="textbox" name="PN_KIT_MPN" value="<?php echo $PN_KIT_MPN; ?>">
						<input type="hidden" name="FROM_PN_KIT_MPN" value="<?php echo $PN_KIT_MPN; ?>">
					</font>
				</td>
			</tr>
			<tr>
				<td valign="top" bgcolor="#ADD2D3" width="35%">
					<font size="3">
						STATUS
					</font>
				</td>
				<td bgcolor="#FFFFB4">	
					<font size="3">
						<?php echo $PN_STATUS; ?>
						<input type="hidden" name="FROM_PN_STATUS" value="<?php echo $PN_STATUS; ?>">
					</font>
				</td>
			</tr>
			<tr>
				<td valign="top" bgcolor="#ADD2D3" width="35%">
					<font size="3">
						Active
					</font>
				</td>
				<td bgcolor="#FFFFB4">	
					<font size="3">
						<input type="checkbox" name="PN_ACTIVE" <?php if ($PN_ACTIVE == 1) echo "Checked"; ?>>
						<input type="hidden" name="FROM_PN_ACTIVE" value="<?php echo $PN_ACTIVE; ?>">
					</font>
				</td>
			</tr>
		</table>

		<br>

		<input type="button" value="Update Part" onClick="CheckValues();">

		</center>
	</form>

</body>
</html>