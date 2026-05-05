<?php
	include 'Common.php';

	$PN = (isset($_GET["PN"])) ? trim($_GET["PN"]) : "";
	$BIN = (isset($_GET["BIN"])) ? trim($_GET["BIN"]) : "";
	$LOC = (isset($_GET["LOC"])) ? trim($_GET["LOC"]) : "";
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

	<form name="Position" method="post" action="Parts_Position_Multi_Action.php">

		<table border="0" cellspace="1" width="100%">

			<tr>
				<td valign="top">
					<font size="2">
						<i>PN</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>MSN</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>KIT</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>Type</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>Qty</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>Bin</i>
					</font>
				</td>
				<td valign="top">
					<font size="2">
						<i>Location</i>
					</font>
				</td>
			</tr>

			<?php

				PartSearch($PN, $BIN, $LOC, $result);

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

					$href = "";
			?>

			<tr>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $ResultData["PN_PN"]; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $ResultData["PN_MSN"]; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $ResultData["PN_KIT"]; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $ResultData["TYPE"]; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $ResultData["QTY"]; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $ResultData["BIN"]; ?>
					</font>
				</td>
				<td valign="top" bgcolor="<?php echo $BGColor; ?>">
					<font size="2">
						<?php echo $ResultData["LOC"]; ?>
					</font>
				</td>
			</tr>

			<?php
				}
				mysqli_free_result($result);
			?>

		</table>

	</form>

</body>
</html>