<?php
	include 'Common.php';

	$INVT_ID = $_GET["INVTID"];
	$BIN = $_POST["BIN"];
	$LOCATION = $_POST["LOCATION"];
	
	UpdatePositionByINVH_INVT_ID($INVT_ID, $BIN, $LOCATION);
?>

<script type="text/javascript">
	window.opener.parent.document.location.reload(true);
	window.close();
</script>