	<table border="1" cellspace="1" width="100%">

		<tr>
			<td valign="bottom">
				<font size="2">
					<i>Kit</i>
				</font>
			</td>
			<td valign="bottom">
				<font size="2">
					<i>MSN</i>
				</font>
			</td>
			<td valign="bottom">
				<font size="2">
					<i>DWG</i>
				</font>
			</td>
			<td valign="bottom">
				<font size="2">
					<i>SN</i>
				</font>
			</td>
			<td valign="bottom">
				<font size="2">
					<i>Vendor</i>
				</font>
			</td>
			<td valign="bottom">
				<font size="2">
					<i>Work Pack</i>
				</font>
			</td>
			<td valign="bottom">
				<font size="2">
					<i>Prod#</i>
				</font>
			</td>
			<td valign="bottom">
				<font size="2">
					<i>PN</i>
				</font>
			</td>
			<td valign="bottom">
				<font size="2">
					<i>Desc</i>
				</font>
			</td>
			<td valign="bottom">
				<font size="2">
					<i>Kit MPN</i>
				</font>
			</td>
			<td valign="bottom" align="right">
				<font size="2">
					<i>Qty</i>
				</font>
			</td>
			<td valign="bottom">
				<font size="2">
					<i>From</i>
				</font>
			</td>
			<td valign="bottom">
				<font size="2">
					<i>To</i>
				</font>
			</td>
		</tr>

		<?php

			GetHistoryWithReturnsAndNotesByINVT_ID($INVT_ID, $result);

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
			<td valign="bottom" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<a href="javascript:void(window.open('Note_Insert.php?INVHID=<?php echo $ResultData["INVH_ID"]; ?>','NoteWindow','height=500,width=800,left=10,bottom=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no'));"><img src="note.png" width="12" height="12" alt="New Note" title="New Note"></a>
					<sup><a href="javascript:void(window.open('Note_Browse.php?INVHID=<?php echo $ResultData["INVH_ID"]; ?>','NoteWindow','height=500,width=800,left=10,bottom=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=no'));"><?php echo $ResultData["NOTECOUNT"]; ?></a></sup>
					<?php echo $ResultData["PN_KIT"]; ?>
				</font>
			</td>
			<td valign="bottom" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<?php echo $ResultData["PN_MSN"]; ?>
				</font>
			</td>
			<td valign="bottom" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<?php echo $ResultData["PN_DWG"]; ?>
				</font>
			</td>
			<td valign="bottom" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<?php echo $ResultData["PN_KIT_SN"]; ?>
				</font>
			</td>
			<td valign="bottom" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<?php echo $ResultData["PN_VENDOR"]; ?>
				</font>
			</td>
			<td valign="bottom" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<?php echo $ResultData["PN_WORKPACK"]; ?>
				</font>
			</td>
			<td valign="bottom" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<?php echo $ResultData["PN_PRODNUM"]; ?>
				</font>
			</td>
			<td valign="bottom" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<?php echo $ResultData["PN_PN"]; ?>
				</font>
			</td>
			<td valign="bottom" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<?php echo $ResultData["PN_DESC"]; ?>
				</font>
			</td>
			<td valign="bottom" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<?php echo $ResultData["PN_KIT_MPN"]; ?>
				</font>
			</td>
			<td valign="bottom" bgcolor="<?php echo $BGColor; ?>" align="right">
				<font size="2">
					<?php echo $ResultData["INVH_QTY"]; ?>
				</font>
			</td>
			<td valign="bottom" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<?php echo $ResultData["INVH_FROM_LOC"]; ?>
				</font>
			</td>
			<td valign="bottom" bgcolor="<?php echo $BGColor; ?>">
				<font size="2">
					<?php echo $ResultData["INVH_TO_LOC"]; ?>
				</font>
			</td>
		</tr>
			<?php
			}
			mysqli_free_result($result);
		?>

	</table>