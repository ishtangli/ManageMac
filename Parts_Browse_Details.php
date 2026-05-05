<?php

	include 'Common.php';

	$MSN = (isset($_GET["MSN"])) ? trim($_GET["MSN"]) : "";
	$KIT = (isset($_GET["KIT"])) ? trim($_GET["KIT"]) : "";
	$DWG = (isset($_GET["DWG"])) ? trim($_GET["DWG"]) : "";
	$VEN = (isset($_GET["VEN"])) ? trim($_GET["VEN"]) : "";
	$SN = (isset($_GET["SN"])) ? trim($_GET["SN"]) : "";
	$PN = (isset($_GET["PN"])) ? trim($_GET["PN"]) : "";
	$CurrentPage = (isset($_GET["P"])) ? $_GET["P"] : 1;

	$ResultCount = GetPartsCount($MSN, $KIT, $DWG, $VEN, $PN, $SN);

	$PageCounter = GeneratePageCounter($CurrentPage, $ResultCount, 100, "Parts_Browse_Details.php?MSN=" . $MSN . "&KIT=" . $KIT . "&DWG=" . $DWG . "&VEN=" . $VEN . "&PN=" . $PN . "&SN=" . $SN);

?>

<html>
<body onLoad="init()">

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

	<center><?php echo $PageCounter; ?></center>

	<br>

	<table border="0" cellspace="1" width="100%">

		<tr>
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
			<td valign="top" align="right">
				<font size="2">
					<i>Qty Rsvd</i>
				</font>
			</td>
			<td valign="top">
				<font size="2">
					<i>UOM</i>
				</font>
			</td>
			<td valign="top">
				<font size="2">
					<i>IDENT</i>
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
			<td valign="top">
				<font size="2">
					<i>Active</i>
				</font>
			</td>
		</tr>

		<?php

			GetParts($MSN, $KIT, $DWG, $VEN, $PN, $SN, $CurrentPage, 100, $result);

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

				$href = "javascript:void(window.open('Parts_Update.php?PN=" . $ResultData["PN_ID"] . "','UpdateWindow','height=500,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no'));";

				if ($_SESSION["RIGHTS"] == 1) {
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
						<?php echo $LINKOPEN . $ResultData["PN_DWG"] . $LINKCLOSE; ?>
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
						<?php echo $LINKOPEN . $ResultData["PN_MFR"] . $LINKCLOSE; ?>
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
						<?php echo $LINKOPEN . $ResultData["AVLQTY"] . $LINKCLOSE; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>" align="right">
					<font size="2">
						<?php echo $LINKOPEN . $ResultData["RSVDQTY"] . $LINKCLOSE; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $LINKOPEN . $ResultData["PN_UOM"] . $LINKCLOSE; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $LINKOPEN . $ResultData["PN_IDENT"] . $LINKCLOSE; ?>
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
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $LINKOPEN . $ResultData["PN_ACTIVE"] . $LINKCLOSE; ?>
					</font>
				</td>
		</tr>

		<?php
			}
			mysqli_free_result($result);
		?>

	</table>

	<br>

	<center><?php echo $PageCounter; ?></center>

</body>
</html>