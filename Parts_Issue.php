<?php

	include 'Common.php';

	$MSN = (isset($_GET["MSN"])) ? trim($_GET["MSN"]) : "";
	$KIT = (isset($_GET["KIT"])) ? trim($_GET["KIT"]) : "";
	$DWG = (isset($_GET["DWG"])) ? trim($_GET["DWG"]) : "";
	$VEN = (isset($_GET["VEN"])) ? trim($_GET["VEN"]) : "";
	$SN = (isset($_GET["SN"])) ? trim($_GET["SN"]) : "";
	$PN = (isset($_GET["PN"])) ? trim($_GET["PN"]) : "";
	$TRN = (isset($_GET["TRN"])) ? trim($_GET["TRN"]) : "";
	$WP = (isset($_GET["WP"])) ? trim($_GET["WP"]) : "";
	$CurrentPage = (isset($_GET["P"])) ? $_GET["P"] : 1;

	$ResultCount = GetPartsForIssueCount($MSN, $KIT, $DWG, $VEN, $PN, $SN, $TRN, $WP);

	$PageCounter = GeneratePageCounter($CurrentPage, $ResultCount, 100, "Parts_Issue.php?MSN=" . $MSN . "&KIT=" . $KIT . "&DWG=" . $DWG . "&VEN=" . $VEN . "&PN=" . $PN . "&SN=" . $SN . "&TRN=" . $TRN . "&WP=" . $WP);

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

	<form name="Issue" method="post" action="Parts_Issue_Multi_Action.php">

		<center><?php echo $PageCounter; ?></center>

		<br>

		<table border="0" cellspace="1" width="100%">

			<tr>
				<td valign="top">
					<font size="2">
						<i>Trans#</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>Issued To</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>Task Card</i>
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
						<i>Qty Reserved</i>
					</font>
				</td>
				<td valign="top" align="right">
					<font size="2">
						<i>Qty Issued</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>UOM</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>Bin</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>Loc</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>Kit MPN</i>
					</font>
				</td>
			</tr>

			<?php

				GetPartsForIssue($MSN, $KIT, $DWG, $VEN, $PN, $SN, $TRN, $WP, $CurrentPage, 100, $result);

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

					$href = "javascript:void(window.open('Parts_Issue_Multi.php?INVTID=" . $ResultData["INVT_ID"] . "','IssueWindow','height=500,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no'));";
			?>

			<tr>
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
						<a href="<?php echo $href; ?>"><?php echo $ResultData["INVT_TASKCARD"]; ?></a>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<a href="<?php echo $href; ?>"><?php echo $ResultData["PN_KIT"]; ?></a>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<a href="<?php echo $href; ?>"><?php echo $ResultData["PN_MSN"]; ?></a>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<a href="<?php echo $href; ?>"><?php echo $ResultData["PN_DWG"]; ?></a>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<a href="<?php echo $href; ?>"><?php echo $ResultData["PN_KIT_SN"]; ?></a>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<a href="<?php echo $href; ?>"><?php echo $ResultData["PN_VENDOR"]; ?></a>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<a href="<?php echo $href; ?>"><?php echo $ResultData["PN_WORKPACK"]; ?></a>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<a href="<?php echo $href; ?>"><?php echo $ResultData["PN_PN"]; ?></a>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<a href="<?php echo $href; ?>"><?php echo $ResultData["PN_DESC"]; ?></a>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<a href="<?php echo $href; ?>"><?php echo $ResultData["PN_MFR"]; ?></a>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<a href="<?php echo $href; ?>"><?php echo $ResultData["PN_IDENT"]; ?></a>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>" align="right">
					<font size="2">
						<a href="<?php echo $href; ?>"><?php echo $ResultData["INVH_QTY"]; ?></a>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>" align="right">
					<font size="2">
						<a href="<?php echo $href; ?>"><?php echo $ResultData["ISSUEDQTY"]; ?></a>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<a href="<?php echo $href; ?>"><?php echo $ResultData["PN_UOM"]; ?></a>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<a href="<?php echo $href; ?>"><?php echo $ResultData["INVH_BIN"]; ?></a>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<a href="<?php echo $href; ?>"><?php echo $ResultData["INVH_LOCATION"]; ?></a>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<a href="<?php echo $href; ?>"><?php echo $ResultData["PN_KIT_MPN"]; ?></a>
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

	</form>

</body>
</html>