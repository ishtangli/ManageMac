<?php
	//RIGHTS 0 = GENERAL
	//RIGHTS 1 = ADMIN
	//RIGHTS 2 = PRODUCTION

	if ($_SESSION["RIGHTS"] == 2) {
		include "Menu_2.php";
	}
	else {
		include "Menu_0.php";
	}
?>