<?php

	include 'Common.php';

	$MSN = (isset($_GET["MSN"])) ? trim($_GET["MSN"]) : "";
	$KIT = (isset($_GET["KIT"])) ? trim($_GET["KIT"]) : "";
	$DWG = (isset($_GET["DWG"])) ? trim($_GET["DWG"]) : "";
	$VEN = (isset($_GET["VEN"])) ? trim($_GET["VEN"]) : "";
	$SN = (isset($_GET["SN"])) ? trim($_GET["SN"]) : "";
	$PN = (isset($_GET["PN"])) ? trim($_GET["PN"]) : "";
	$STA = (isset($_GET["STA"])) ? trim($_GET["STA"]) : "";
	$WP = (isset($_GET["WP"])) ? trim($_GET["WP"]) : "";
	$CurrentPage = (isset($_GET["P"])) ? $_GET["P"] : 1;

	$ResultCount = GetPartsForReceiptCount($MSN, $KIT, $DWG, $VEN, $WP, $PN, $SN, $STA);

	$PageCounter = GeneratePageCounter($CurrentPage, $ResultCount, 100, "Parts_Receive.php?MSN=" . $MSN . "&KIT=" . $KIT . "&DWG=" . $DWG . "&VEN=" . $VEN . "&PN=" . $PN . "&SN=" . $SN . "&STA=" . $STA . "&WP=" . $WP);
?>

<html>
<body onLoad="init()">

	<SCRIPT LANGUAGE="JavaScript">

		function checkAll() {
			for (i = 0; i < document.Receiving.elements.length; i++) {
				if(document.Receiving.elements[i].type=="checkbox") {
					document.Receiving.elements[i].checked=true;
				}
			}
		}

		function uncheckAll() {
			for (i = 0; i < document.Receiving.elements.length; i++) {
				if(document.Receiving.elements[i].type=="checkbox") {
					document.Receiving.elements[i].checked=false;
				}
			}
		}

		function CheckValues() {

			PNCOUNT = 0;

			for (i = 0; i < document.Receiving.elements.length; i++) {
				if(document.Receiving.elements[i].type=="checkbox") {
					if(document.Receiving.elements[i].checked==true) {
						PNCOUNT++;
					}
				}
			}

			if(PNCOUNT == 0) {
				alert("No PN selected.");
			}
			else {
				SendValues();
			}

		}

		function SendValues() {

			PNID = "";

			for (i = 0; i < document.Receiving.elements.length; i++) {
				if(document.Receiving.elements[i].type=="checkbox") {
					if(document.Receiving.elements[i].checked==true) {
						PNID = PNID + document.Receiving.elements[i].value + "/";
					}
				}
			}

			URL = "Parts_Receive_AWB.php?PNID=" + PNID;

			window.open(URL,'ReceiveWindow','height=500,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no');
		}

	</script>


	<div id="loading" style="position:absolute; width:100%; text-align:center; ">
		<img src="loading.gif" border=0>
	</div>

	<script>
		var ld=(document.all);

		var ns4=document.layers;
		var ns6=document.getElementById&&!document.all;
		var ie4=document.all;

		if (ns4) {
			ld=document.loading;
		}
		else if (ns6) {
			ld=document.getElementById("loading").style;
		}
		else if (ie4) {
			ld=document.all.loading.style;
		}

		function init() {

			if(ns4) {
				ld.visibility="hidden";
			}
			else if (ns6||ie4) {
				ld.display="none";
			}
		}
	</script>

	<form name="Receiving" method="post" action="Parts_Receive_Multi_Action.php">


		<center>

		<?php echo $PageCounter; ?>

		<br>
		<br>

		<a href="javascript:void(checkAll(document.Receiving.DATA));">Check All</a>
		<a href="javascript:void(uncheckAll(document.Receiving.DATA));">Uncheck All</a>
		<a href="javascript:void(CheckValues());" >Receive Selected</a>
		</center>

		<br>

		<table border="0" cellspace="1" width="100%">

			<tr>
				<td valign="top" width="1">
					<font size="2">
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>Kit</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>MSN</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>DWG</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>SN</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>Vendor</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>Work Pack</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>Prod#</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>PN</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>Desc</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>MFR</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>IDENT</i>
					</font>
				</td>
				<td valign="top" align="right">
					<font size="2">
						<i>Qty Req</i>
					</font>
				</td>
				<td valign="top" align="right">
					<font size="2">
						<i>Qty Rec</i>
					</font>
				</td>
				<td valign="top" align="right">
					<font size="2">
						<i>Qty Avl</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>UOM</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>Loc</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>Bin</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>Status</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>Kit MPN</i>
					</font>
				</td>
			</tr>

			<?php

				GetPartsForReceipt($MSN, $KIT, $DWG, $VEN, $WP, $PN, $SN, $STA, $CurrentPage, 100, $result);

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

					$DATA = $ResultData["PN_ID"] . "," . $ResultData["PN_QTY_REQ"] . "," . $ResultData["AVEQTY"] . "," . $ResultData["INVD_ID"] . "," . $ResultData["PN_QTY_REC"];

					$href = "javascript:void(window.open('Parts_Receive_AWB.php?PNID=" . $DATA . "','ReceiveWindow','height=500,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no'));";

					if ($ResultData["PN_STATUS"] == "OPEN") {
						$LINKOPEN = "<a href=\"" . $href . "\">";
						$LINKCLOSE = "</a>";
					}
					else {
						$LINKOPEN = "";
						$LINKCLOSE = "";
					}

			?>

			<tr>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php if ($ResultData["PN_STATUS"] == "OPEN") echo "<input type=\"checkbox\" name=\"DATA[]\" value=\"" . $DATA . "\">"; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $LINKOPEN . $ResultData["PN_KIT"] . $LINKCLOSE; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $LINKOPEN . $ResultData["PN_MSN"] . $LINKCLOSE; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $LINKOPEN . $LINKOPEN . $ResultData["PN_DWG"] . $LINKCLOSE; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $LINKOPEN . $ResultData["PN_KIT_SN"] . $LINKCLOSE; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $LINKOPEN . $ResultData["PN_VENDOR"] . $LINKCLOSE; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $LINKOPEN . $ResultData["PN_WORKPACK"] . $LINKCLOSE; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $LINKOPEN . $ResultData["PN_PRODNUM"] . $LINKCLOSE; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $LINKOPEN . $ResultData["PN_PN"] . $LINKCLOSE; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $LINKOPEN . $ResultData["PN_DESC"] . $LINKCLOSE; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $LINKOPEN . $LINKOPEN . $ResultData["PN_MFR"] . $LINKCLOSE; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $LINKOPEN . $ResultData["PN_IDENT"] . $LINKCLOSE; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>" align="right">
					<font size="2">
						<?php echo $LINKOPEN . $ResultData["PN_QTY_REQ"] . $LINKCLOSE; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>" align="right">
					<font size="2">
						<?php echo $LINKOPEN . $ResultData["PN_QTY_REC"] . $LINKCLOSE; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>" align="right">
					<font size="2">
						<?php echo $LINKOPEN . $ResultData["AVEQTY"] . $LINKCLOSE; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $LINKOPEN . $ResultData["PN_UOM"] . $LINKCLOSE; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $LINKOPEN . $ResultData["INVD_LOCATION"] . $LINKCLOSE; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $LINKOPEN . $ResultData["INVD_BIN"] . $LINKCLOSE; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $LINKOPEN . $ResultData["PN_STATUS"] . $LINKCLOSE; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $LINKOPEN . $ResultData["PN_KIT_MPN"] . $LINKCLOSE; ?>
					</font>
				</td>
			</tr>

			<?php
				}
				mysqli_free_result($result);
			?>

		</table>

		<br>

		<center>
		<a href="javascript:void(checkAll(document.Receiving.DATA));">Check All</a>
		<a href="javascript:void(uncheckAll(document.Receiving.DATA));">Uncheck All</a>
		<a href="javascript:void(CheckValues());" >Receive Selected</a>

		<br>
		<br>

		<?php echo $PageCounter; ?>

		</center>

	</form>

</body>
</html>