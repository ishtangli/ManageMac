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
	$PN_PN = $ResultData["PN_PN"];
	$PN_DESC = $ResultData["PN_DESC"];
	$PN_MFR = $ResultData["PN_MFR"];
	$PN_QTY_REQ = $ResultData["PN_QTY_REQ"];
	$PN_QTY_REC = $ResultData["PN_QTY_REC"];
	$AVAILABLE = $ResultData["AVEQTY"];
	$RESERVED = $ResultData["RSVDQTY"];
	$PN_UOM = $ResultData["PN_UOM"];
	$PN_IDENT = $ResultData["PN_IDENT"];
	$PN_KIT_MPN = $ResultData["PN_KIT_MPN"];
	$PN_STATUS = $ResultData["PN_STATUS"];

	mysqli_free_result($result);

?>
<html>
<body>

	<center>

	<table border="0" cellspace="1" width="50%">
		<tr>
			<td valign="top" bgcolor="#ADD2D3" width="35%">
				<font size="2">
					KIT
				</font>
			</td>
			<td bgcolor="#FFFFB4">	
				<font size="2">
					<?php echo $PN_KIT; ?>
				</font>
			</td>
		</tr>
		<tr>
			<td valign="top" bgcolor="#ADD2D3" width="35%">
				<font size="2">
					MSN
				</font>
			</td>
			<td bgcolor="#FFFFB4">	
				<font size="2">
					<?php echo $PN_MSN; ?>
				</font>
			</td>
		</tr>
		<tr>
			<td valign="top" bgcolor="#ADD2D3" width="35%">
				<font size="2">
					DWG
				</font>
			</td>
			<td bgcolor="#FFFFB4">	
				<font size="2">
					<?php echo $PN_DWG; ?>
				</font>
			</td>
		</tr>
		<tr>
			<td valign="top" bgcolor="#ADD2D3" width="35%">
				<font size="2">
					Vendor
				</font>
			</td>
			<td bgcolor="#FFFFB4">	
				<font size="2">
					<?php echo $PN_VENDOR; ?>
				</font>
			</td>
		</tr>
		<tr>
			<td valign="top" bgcolor="#ADD2D3" width="35%">
				<font size="2">
					PN
				</font>
			</td>
			<td bgcolor="#FFFFB4">	
				<font size="2">
					<?php echo $PN_PN; ?>
				</font>
			</td>
		</tr>
		<tr>
			<td valign="top" bgcolor="#ADD2D3" width="35%">
				<font size="2">
					Description
				</font>
			</td>
			<td bgcolor="#FFFFB4">	
				<font size="2">
					<?php echo $PN_DESC; ?>
				</font>
			</td>
		</tr>
		<tr>
			<td valign="top" bgcolor="#ADD2D3" width="35%">
				<font size="2">
					MFR
				</font>
			</td>
			<td bgcolor="#FFFFB4">	
				<font size="2">
					<?php echo $PN_MFR; ?>
				</font>
			</td>
		</tr>
		<tr>
			<td valign="top" bgcolor="#ADD2D3" width="35%">
				<font size="2">
					Qty Required
				</font>
			</td>
			<td bgcolor="#FFFFB4">	
				<font size="2">
					<?php echo $PN_QTY_REQ; ?>
				</font>
			</td>
		</tr>
		<tr>
			<td valign="top" bgcolor="#ADD2D3" width="35%">
				<font size="2">
					Qty Received
				</font>
			</td>
			<td bgcolor="#FFFFB4">	
				<font size="2">
					<?php echo $PN_QTY_REC; ?>
				</font>
			</td>
		</tr>
		<tr>
			<td valign="top" bgcolor="#ADD2D3" width="35%">
				<font size="2">
					Qty Available
				</font>
			</td>
			<td bgcolor="#FFFFB4">	
				<font size="2">
					<?php echo $AVAILABLE; ?>
				</font>
			</td>
		</tr>
		<tr>
			<td valign="top" bgcolor="#ADD2D3" width="35%">
				<font size="2">
					Qty Reserved
				</font>
			</td>
			<td bgcolor="#FFFFB4">	
				<font size="2">
					<?php echo $RESERVED; ?>
				</font>
			</td>
		</tr>
		<tr>
			<td valign="top" bgcolor="#ADD2D3" width="35%">
				<font size="2">
					UOM
				</font>
			</td>
			<td bgcolor="#FFFFB4">	
				<font size="2">
					<?php echo $PN_UOM; ?>
				</font>
			</td>
		</tr>
		<tr>
			<td valign="top" bgcolor="#ADD2D3" width="35%">
				<font size="2">
					IDENT
				</font>
			</td>
			<td bgcolor="#FFFFB4">	
				<font size="2">
					<?php echo $PN_IDENT; ?>
				</font>
			</td>
		</tr>
		<tr>
			<td valign="top" bgcolor="#ADD2D3" width="35%">
				<font size="2">
					STATUS
				</font>
			</td>
			<td bgcolor="#FFFFB4">	
				<font size="2">
					<?php echo $PN_STATUS; ?>
				</font>
			</td>
		</tr>
	</table>

	</center>

	<br>
	<br>

	<table border="0" cellspace="1" width="100%">

		<tr>
			<td valign="top">
				<font size="2">
					<i>Type</i>
				</font>
			</td>
			<td valign="top">
				<font size="2">
					<i>Trans#</i>
				</font>
			</td>
			<td valign="top">
				<font size="2">
					<i>To</i>
				</font>
			</td>
			<td valign="top">
				<font size="2">
					<i>Task Card</i>
				</font>
			</td>
			<td valign="top">
				<font size="2">
					<i>AWB</i>
				</font>
			</td>
			<td valign="top">
				<font size="2">
					<i>Qty</i>
				</font>
			</td>
			<td valign="top">
				<font size="2">
					<i>Date</i>
				</font>
			</td>
			<td valign="top">
				<font size="2">
					<i>By</i>
				</font>
			</td>
		</tr>

		<?php

			GetTransactionsByPN_ID($PN_ID, $result);

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

				$href="Parts_History_Detail.php?INVTID=" . $ResultData["INVT_ID"] . "&B=1";
		?>

		<tr>
			<td valign="top" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<a href="<?php echo $href; ?>"><?php echo $ResultData["INVT_TYPE"]; ?></a>
				</font>
			</td>
			<td valign="top" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<a href="<?php echo $href; ?>"><?php echo $ResultData["INVT_ID"]; ?></a>
				</font>
			</td>
			<td valign="top" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<a href="<?php echo $href; ?>"><?php echo $ResultData["INVT_USER"]; ?></a>
				</font>
			</td>
			<td valign="top" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<a href="<?php echo $href; ?>"><?php echo str_replace("\r\n", "<br>", $ResultData["INVT_TASKCARD"]); ?></a>
				</font>
			</td>
			<td valign="top" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<a href="<?php echo $href; ?>"><?php echo str_replace("\r\n", "<br>", $ResultData["INVT_AWB"]); ?></a>
				</font>
			</td>
			<td valign="top" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<a href="<?php echo $href; ?>"><?php echo $ResultData["INVH_QTY"]; ?>
				</font>
			</td>
			<td valign="top" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<a href="<?php echo $href; ?>"><?php echo $ResultData["INVT_DATE"]; ?>
				</font>
			</td>
			<td valign="top" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<a href="<?php echo $href; ?>"><?php echo $ResultData["INVT_BY"]; ?> - <?php echo $ResultData["LOG_NAME"]; ?>
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