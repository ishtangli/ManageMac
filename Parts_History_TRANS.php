<?php

	include 'Common.php';

	$TID = (isset($_GET["TID"])) ? trim($_GET["TID"]) : "";
	$TYPE = (isset($_GET["TYPE"])) ? trim($_GET["TYPE"]) : "ALL";
	$FDATE = (isset($_GET["FDATE"])) ? trim($_GET["FDATE"]) : "";
	$TDATE = (isset($_GET["TDATE"])) ? trim($_GET["TDATE"]) : "";
	$CurrentPage = (isset($_GET["P"])) ? $_GET["P"] : 1;

	$ResultCount = GetTransactionsByINVT_IDandDATEandTypeCount($TID, $TYPE, $FDATE, $TDATE);

	$PageCounter = GeneratePageCounter($CurrentPage, $ResultCount, 100, "Parts_History_TRANS.php?TID=" . $TID . "&TYPE=" . $TYPE . "&FDATE=" . $FDATE . "&TDATE=" . $TDATE);

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
					<i>AWB</i>
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
					<i>PN</i>
				</font>
			</td>
			<td valign="top" align="right">
				<font size="2">
					<i>Qty</i>
				</font>
			</td>
			<td valign="top">
				<font size="2">
					<i>UOM</i>
				</font>
			</td>
			<td valign="top">
				<font size="2">
					<i>Kit MPN</i>
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

			GetTransactionsByINVT_IDandDATEandType($TID, $TYPE, $FDATE, $TDATE, $CurrentPage, 100, $result);

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

				$href = "javascript:void(window.open('Parts_History_Detail.php?INVTID=" . $ResultData["INVT_ID"] . "&TYPE=" . $ResultData["INVT_TYPE"] . "','HistoryPartsDetail','height=500,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no'));";
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
					<a href="<?php echo $href; ?>"><?php echo $ResultData["INVT_TASKCARD"]; ?></a>
				</font>
			</td>
			<td valign="top" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<a href="<?php echo $href; ?>"><?php echo $ResultData["INVT_AWB"]; ?></a>
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
					<a href="<?php echo $href; ?>"><?php echo $ResultData["PN_PN"]; ?></a>
				</font>
			</td>
			<td valign="top" bgcolor="<?php echo $BGColor; ?>" align="right">
				<font size="2">
					<a href="<?php echo $href; ?>"><?php echo $ResultData["INVH_QTY"]; ?></a>
				</font>
			</td>
			<td valign="top" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<a href="<?php echo $href; ?>"><?php echo $ResultData["PN_UOM"]; ?></a>
				</font>
			</td>
			<td valign="top" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<a href="<?php echo $href; ?>"><?php echo $ResultData["PN_KIT_MPN"]; ?></a>
				</font>
			</td>
			<td valign="top" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<a href="<?php echo $href; ?>"><?php echo $ResultData["INVT_DATE"]; ?></a>
				</font>
			</td>
			<td valign="top" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<a href="<?php echo $href; ?>"><?php echo $ResultData["INVT_BY"]; ?></a>
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