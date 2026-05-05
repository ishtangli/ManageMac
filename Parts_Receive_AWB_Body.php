		<table border="0" cellspace="1" width="50%">
			<tr>
				<td valign="center" bgcolor="#ADD2D3" width="35%">
					<font size="2">
						AWB
					</font>
				</td>
				<td bgcolor="#FFFFB4">	
					<font size="2">
						<input type="textbox" name="AWB" id="AWB">
					</font>
				</td>
			</tr>
			<tr>
				<td valign="center" bgcolor="#ADD2D3" width="35%">
					<font size="2">
						Bin
					</font>
				</td>
				<td bgcolor="#FFFFB4">	
					<font size="2">
						<input type="textbox" name="BIN" id="BIN" value="<?php echo $BIN; ?>" <?php if ($LOCATION . $BIN != "") echo "readonly"; ?>>
					</font>
				</td>
			</tr>
			<tr>
				<td valign="center" bgcolor="#ADD2D3" width="35%">
					<font size="2">
						Location
					</font>
				</td>
				<td bgcolor="#FFFFB4">	
					<font size="2">
						<input type="textbox" name="LOC" id="LOC" value="<?php echo $LOCATION; ?>" <?php if ($LOCATION . $BIN != "") echo "readonly"; ?>>
					</font>
				</td>
			</tr>
		</table>

		<br>

		<input type="button" id="ReceiveButton" value="Receive Parts" onClick="CheckValues();">