	<table border="1" cellspace="1" width="100%">

		<tr>
			<td valign="bottom">
				<font size="3">
					<i>From</i>
				</font>
			</td>
			<td valign="bottom">
				<font size="3">
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
				<font size="3">
					<?php echo str_replace("\r\n", "<br>", $ResultData["INVH_FROM"]); ?>
				</font>
			</td>
			<td valign="bottom" bgcolor="<?php echo $BGColor; ?>">
				<font size="3">
					<?php echo str_replace("\r\n", "<br>", $ResultData["INVH_TO"]); ?>
				</font>
			</td>
		</tr>
			<?php
			}
			mysqli_free_result($result);
		?>

	</table>