<?php
	include 'Login_Script.php';

	GetLoginByLOG_ID($_GET["ID"], $result);

	$ResultData = mysqli_fetch_assoc($result);

	$LOG_UID = $ResultData["LOG_UID"];
	$LOG_PWD = md5_decrypt($ResultData["LOG_PWD"], "password");
	$LOG_NAME = $ResultData["LOG_NAME"];
	$LOG_PWD_SET = $ResultData["LOG_PWD_SET"];

	mysqli_free_result($result);

	if ($LOG_PWD_SET == 1) {
		header ("Location: Login_Update_Set.php");
	}

?>
<html>
<body>

	<table border="1" cellspace="1" width="800">

		<tr>
			<td>
				<form name="Logins" method="post" action="Login_Update_Action.php?ID=<?php echo $_GET["ID"]; ?>&UID=<?php echo $_GET["UID"]; ?>">

					<font size="4">
						<b>UPDATE ADMIN DETAILS</b>
					</font>

					<br>
					<br>

					<table border="0" cellspace="1">

						<tr>
							<td width="150">
								<font size="3">
									Name
								</font>
							</td>
							<td>
								<font size="3">
									<?php echo $LOG_NAME; ?>
								</font>
							</td>
						</tr>
						<tr>
							<td width="150">
								<font size="3">
									User ID
								</font>
							</td>
							<td>
								<font size="3">
									<?php echo $LOG_UID; ?>
								</font>
							</td>
						</tr>
						<tr>
							<td width="150">
								<font size="3">
									Old Password
								</font>
							</td>
							<td>
								<font size="3">
									<?php echo $LOG_PWD; ?>
								</font>
							</td>
						</tr>
						<tr>
							<td width="150">
								<font size="3">
									New Password
								</font>
							</td>
							<td>
								<font size="3">
									<input type="password" name="LOG_PWD1">
								</font>
							</td>
						</tr>
						<tr>
							<td width="150">
								<font size="3">
									Confirm Password
								</font>
							</td>
							<td>
								<font size="3">
									<input type="password" name="LOG_PWD2">
								</font>
							</td>
						</tr>

					</table>

					<br>

					<input type="button" value="Cancel" onclick="window.location='Login.php';">
					<input type="submit" value="Update Password">

				</form>
			</td>
		</tr>

	</table>

</body>
</html>