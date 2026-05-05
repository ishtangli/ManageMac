<?php

session_start();

include ".\Var\Variables.php";

/*-----------------------------------------------------------------------------------------*/

	function ConnectDB(&$link) {
		$link = mysqli_connect("localhost", "mm", "rGnW4") or die("ConnectDB : " . mysqli_error());

		mysqli_select_db($link, GetDB()) or die("ConnectDB : Could not select database");
	}

	function CloseDB(&$link) {
		mysqli_close($link);
	}

	function OpenQuery($query, &$result) {
		$result = mysqli_query($link, $query) or die("OpenQuery : " . mysqli_error());
	}

	function OpenCommand($command) {
		mysqli_query($link, $command) or die("OpenCommand : " . mysqli_error());
	}

/*-----------------------------------------------------------------------------------------*/

	function Authenticate($username, $password, &$ResultData) {

		GetLoginByLOG_USERNAME($username, $result);

		if (($ResultData = mysqli_fetch_assoc($result)) > 0) {

			if (strcmp(md5_decrypt($ResultData["LOG_PASSWORD"], "password"), $password) == 0) {
				return 1;
			}
			else {
				return 0;
			}
		}
		else {
			return 0;
		}

		mysqli_free_result($result);
	}

	function get_rnd_iv($iv_len) {

		$iv = '';

		while ($iv_len-- > 0) {
			$iv .= chr(mt_rand() & 0xff);
		}

		return $iv;
	}

	function md5_encrypt($plain_text, $password) {

		$iv_len = 16;

		$plain_text .= "\x13";
		$n = strlen($plain_text);

		if ($n % 16) $plain_text .= str_repeat("\0", 16 - ($n % 16));

		$i = 0;
		$enc_text = get_rnd_iv($iv_len);
		$iv = substr($password ^ $enc_text, 0, 512);

		while ($i < $n) {

			$block = substr($plain_text, $i, 16) ^ pack('H*', md5($iv));
			$enc_text .= $block;
			$iv = substr($block . $iv, 0, 512) ^ $password;
			$i += 16;
		}

		return base64_encode($enc_text);
	}

	function md5_decrypt($enc_text, $password) {

		$iv_len = 16;

		$enc_text = base64_decode($enc_text, true);
		$n = strlen($enc_text);
		$i = $iv_len;
		$plain_text = '';
		$iv = substr($password ^ substr($enc_text, 0, $iv_len), 0, 512);

		while ($i < $n) {

			$block = substr($enc_text, $i, 16);
			$plain_text .= $block ^ pack('H*', md5($iv));
			$iv = substr($block . $iv, 0, 512) ^ $password;
			$i += 16;
		}

		return preg_replace('/\\x13\\x00*$/', '', $plain_text);
	}

/*-----------------------------------------------------------------------------------------*/

	function add_date($givendate,$day=0,$mth=0,$yr=0) {
		$cd = strtotime($givendate);
		$newdate = date('Y-m-d h:i:s', mktime(date('h',$cd),date('i',$cd), date('s',$cd), date('m',$cd)+$mth,date('d',$cd)+$day, date('Y',$cd)+$yr));
		return $newdate;
	}

/*-----------------------------------------------------------------------------------------*/

	function GetLoginByLOG_UID($vLOG_UID, &$result) {

		ConnectDB($link);

		$sSQL = "Select * from LOG_LOGINS where LOG_UID = '" . $vLOG_UID . "'";

		$result = mysqli_query($link, $sSQL) or die("GetLoginByLOG_UID failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetLoginByLOG_ID($vLOG_ID, &$result) {

		ConnectDB($link);

		$sSQL = "Select * from LOG_LOGINS where LOG_ID = '" . $vLOG_ID . "'";

		$result = mysqli_query($link, $sSQL) or die("GetLoginByLOG_ID failed : " . mysqli_error());

		CloseDB($link);
	}

	function UpdateLoginByLOG_ID($vLOG_ID, $vLOG_PWD) {

		ConnectDB($link);

		$sSQL = "Update LOG_LOGINS set LOG_PWD = '" . $vLOG_PWD ."', LOG_PWD_SET = 1 where LOG_ID = '" . $vLOG_ID . "'";

		$result = mysqli_query($link, $sSQL) or die("UpdateLoginByLOG_ID failed : " . mysqli_error());

		CloseDB($link);
	}

/*-----------------------------------------------------------------------------------------*/

	function BuilDDropdown($tablename, $selectobjectname, $valuefield, $groupfield, $selection = "0") {

		$query = "Select * from " . $tablename . " group by " . $groupfield . " order by " . $valuefield;

		ConnectDB($link);

		OpenQuery($query, $result);

		CloseDB($link);

		$Dropdown = "<select name=\"" . $selectobjectname . "\" style=\"width:150\"><option value=\"ALL\">ALL";

		while ($ResultData = mysqli_fetch_assoc($result)) {
			$Dropdown = $Dropdown . "<option value=\"" . $ResultData[$valuefield] . "\">" . $ResultData[$valuefield];
		}

		$Dropdown = $Dropdown . "</select>";

		mysqli_free_result($result);

		$Dropdown = str_replace("\"" . $selection . "\"", "\"" . $selection . "\" selected", $Dropdown);

		return $Dropdown;
	}

	function BuilDDropdownWithHREF($tablename, $selectobjectname, $valuefield, $groupfield, $HREF, $selection = "ALL") {

		$query = "Select * from " . $tablename . " group by " . $groupfield . " order by " . $valuefield;

		ConnectDB($link);

		OpenQuery($query, $result);

		CloseDB($link);

		$Dropdown = "<select name=\"" . $selectobjectname . "\" style=\"width:150\" onChange=\"window.location='" . $HREF . "' + this.options[this.selectedIndex].value; \" ><option value=\"ALL\">ALL";

		while ($ResultData = mysqli_fetch_assoc($result)) {
			$Dropdown = $Dropdown . "<option value=\"" . $ResultData[$valuefield] . "\">" . $ResultData[$valuefield];
		}

		$Dropdown = $Dropdown . "</select>";

		mysqli_free_result($result);

		$Dropdown = str_replace("\"" . $selection . "\"", "\"" . $selection . "\" selected", $Dropdown);

		return $Dropdown;
	}

	function BuilDHistoryDropdown($selection = "KIT") {

		$Header = "<select name=\"HistoryReportType\" style=\"width:200\" onChange=\"window.location=this.options[this.selectedIndex].value; \">";

		$Options = "<option value=\"Parts_History_KIT_iFrames.php?BY=KIT\" id=\"KIT\">by PN Details";
		$Options = $Options . "<option value=\"Parts_History_TRANS_iFrames.php?BY=TRANS\" id=\"TRANS\">by TRANS # and Date";

		$Close = "</select>";

		$Dropdown = $Header . $Options . $Close;

		$Dropdown = str_replace("\"" . $selection . "\"", "\"" . $selection . "\" selected", $Dropdown);

		return $Dropdown;
	}

	function BuilDTypeDropdown($selection = "ALL") {

		$Header = "<select name=\"TYPE\" style=\"width:150\" id=\"SEARCHTYPE\">";

		$Options = "<option value=\"ALL\">ALL";
		$Options = $Options . "<option value=\"ISSUE\">ISSUE";
		$Options = $Options . "<option value=\"RETURN\">RETURN";
		$Options = $Options . "<option value=\"RECEIVE\">RECEIVE";
		$Options = $Options . "<option value=\"RESERVE\">RESERVE";
		$Options = $Options . "<option value=\"RELEASE\">RELEASE";
		$Options = $Options . "<option value=\"PNSUPERUPDATE\">PNSUPERUPDATE";

		$Close = "</select>";

		$Dropdown = $Header . $Options . $Close;

		$Dropdown = str_replace("\"" . $selection . "\"", "\"" . $selection . "\" selected", $Dropdown);

		return $Dropdown;
	}

	function BuilDStatusDropdownWithHREF($HREF, $selection = "OPEN") {

		$Header = "<select name=\"TransactionType\" style=\"width:150\" onChange=\"window.location='" . $HREF . "' + this.options[this.selectedIndex].value; \" >";

		$Options = "<option value=\"ALL\">ALL";
		$Options = $Options . "<option value=\"OPEN\">OPEN";
		$Options = $Options . "<option value=\"CLOSED\">CLOSED";

		$Close = "</select>";

		$Dropdown = $Header . $Options . $Close;

		$Dropdown = str_replace("\"" . $selection . "\"", "\"" . $selection . "\" selected", $Dropdown);

		return $Dropdown;
	}

/*-----------------------------------------------------------------------------------------*/

	function PartsInsert($vPN_KIT, $vPN_MSN, $vPN_DWG, $vPN_KIT_SN, $vPN_VENDOR, $vPN_WORKPACK, $vPN_PRODNUM, $vPN_PN, $vPN_DESC, $vPN_MFR, $vPN_QTY_REQ, $vPN_UOM, $vPN_IDENT, $vPN_KIT_MPN) {

		ConnectDB($link);

		$sSQL = "Insert into PNS values (NULL, '" . $vPN_KIT . "', '" . $vPN_MSN . "', '" . $vPN_DWG . "', '" . $vPN_KIT_SN . "', '" . $vPN_VENDOR . "', '" . $vPN_WORKPACK . "', '" . $vPN_PRODNUM . "', '" . $vPN_PN . "', '" . $vPN_DESC . "', '" . $vPN_MFR . "', " . $vPN_QTY_REQ . ", 0, '" .  $vPN_UOM . "', '" . $vPN_IDENT . "', '" . $vPN_KIT_MPN . "', 'OPEN', 1)";

		mysqli_query($link, $sSQL) or die("PartsInsert failed : " . mysqli_error());

		$ID = mysqli_insert_id($link);

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "PartsInsert - " . addslashes($sSQL);
		$AUD_INDEX = $ID;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);

		return $ID;
	}

	function PartsUpdate($vPN_ID, $vPN_KIT, $vPN_MSN, $vPN_DWG, $vPN_KIT_SN, $vPN_VENDOR, $vPN_WORKPACK, $vPN_PRODNUM, $vPN_PN, $vPN_DESC, $vPN_MFR, $vPN_QTY_REQ, $vPN_UOM, $vPN_IDENT, $vPN_KIT_MPN, $vPN_STATUS, $vPN_ACTIVE) {

		ConnectDB($link);

		$sSQL = "Update PNS set PN_KIT = '" . $vPN_KIT . "', PN_MSN = '" . $vPN_MSN . "', PN_DWG = '" . $vPN_DWG . "', PN_KIT_SN = '" . $vPN_KIT_SN . "', PN_VENDOR = '" . $vPN_VENDOR . "', PN_WORKPACK = '" . $vPN_WORKPACK . "', PN_PRODNUM = '" . $vPN_PRODNUM . "', PN_PN = '" . $vPN_PN . "', PN_DESC = '" . $vPN_DESC . "', PN_MFR = '" . $vPN_MFR . "', PN_QTY_REQ = " . $vPN_QTY_REQ . ", PN_UOM = '" .  $vPN_UOM . "', PN_IDENT = '" . $vPN_IDENT . "', PN_KIT_MPN = '" . $vPN_KIT_MPN . "', PN_STATUS = '" . $vPN_STATUS . "', PN_ACTIVE = " . $vPN_ACTIVE . " where PN_ID = " . $vPN_ID;

		mysqli_query($link, $sSQL) or die("PartsUpdate failed : " . mysqli_error());

		$ID = mysqli_insert_id($link);

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "PartsUpdate - " . addslashes($sSQL);
		$AUD_INDEX = $ID;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);

		return $ID;
	}

	function PartsInsertMulti($PNS) {

		ConnectDB($link);

		$sSQL = "Insert into PNS values " . $PNS;

		mysqli_query($link, $sSQL) or die("PartsInsertMulti failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "PartsInsertMulti - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

	function PartsReceiveMulti($Values) {

		ConnectDB($link);

		$sSQL = "Insert into PNS values " . $Values . " on duplicate key update PN_QTY_REC = PN_QTY_REC + values(PN_QTY_REC), PN_STATUS = values(PN_STATUS)";

		mysqli_query($link, $sSQL) or die("PartsReceiveMulti failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "PartsReceiveMulti - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

	function GetParts($MSN, $KIT, $DWG, $VEN, $PN, $SN, $CurrentPage, $NumPerPage, &$result) {

		ConnectDB($link);

		$sSQL = "Select *, ifnull(INVD_QTY,0) AVLQTY, ifnull(INVD_RESERVED,0) RSVDQTY from PNS left join INV_DETAILS on PN_ID = INVD_PN_ID";
		$WHERE = "";

		if($MSN != "" || $KIT != "" || $DWG != "" || $VEN != "" || $PN != "" || $SN != "") {

			$sSQL = $sSQL . " where ";

			if ($MSN != "") $WHERE = $WHERE . " and PN_MSN like '" . $MSN . "%'";
			if ($KIT != "") $WHERE = $WHERE . " and (PN_KIT like '" . $KIT . "%' or PN_KIT_MPN like '" . $KIT . "%')";
			if ($DWG != "") $WHERE = $WHERE . " and PN_DWG like '" . $DWG . "%'";
			if ($VEN != "") $WHERE = $WHERE . " and PN_VENDOR like '" . $VEN . "%'";
			if ($PN != "") $WHERE = $WHERE . " and PN_PN like '" . $PN . "%'";
			if ($SN != "") $WHERE = $WHERE . " and PN_KIT_SN like '" . $SN . "%'";

			$sSQL = $sSQL . trim($WHERE, " and");
		}

		$sSQL = $sSQL . " limit " . (($CurrentPage * $NumPerPage) - $NumPerPage) . ", $NumPerPage";

		$result = mysqli_query($link, $sSQL) or die("GetParts failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetPartsDownload($MSN, $KIT, $DWG, $VEN, $PN, $SN, &$result) {

		ConnectDB($link);

		$sSQL = "Select * from PNS";
		$WHERE = "";

		if($MSN != "" || $KIT != "" || $DWG != "" || $VEN != "" || $PN != "" || $SN != "") {

			$sSQL = $sSQL . " where ";

			if ($MSN != "") $WHERE = $WHERE . " and PN_MSN like '" . $MSN . "%'";
			if ($KIT != "") $WHERE = $WHERE . " and (PN_KIT like '" . $KIT . "%' or PN_KIT_MPN like '" . $KIT . "%')";
			if ($DWG != "") $WHERE = $WHERE . " and PN_DWG like '" . $DWG . "%'";
			if ($VEN != "") $WHERE = $WHERE . " and PN_VENDOR like '" . $VEN . "%'";
			if ($PN != "") $WHERE = $WHERE . " and PN_PN like '" . $PN . "%'";
			if ($SN != "") $WHERE = $WHERE . " and PN_KIT_SN like '" . $SN . "%'";

			$sSQL = $sSQL . trim($WHERE, " and");
		}

		$result = mysqli_query($link, $sSQL) or die("GetPartsDownload failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetPartsCount($MSN, $KIT, $DWG, $VEN, $PN, $SN) {

		ConnectDB($link);

		$sSQL = "Select COUNT(PN_ID) as PNCOUNT from PNS";
		$WHERE = "";

		if($MSN != "" || $KIT != "" || $DWG != "" || $VEN != "" || $PN != "" || $SN != "") {

			$sSQL = $sSQL . " where ";

			if ($MSN != "") $WHERE = $WHERE . " and PN_MSN like '" . $MSN . "%'";
			if ($KIT != "") $WHERE = $WHERE . " and (PN_KIT like '" . $KIT . "%' or PN_KIT_MPN like '" . $KIT . "%')";
			if ($DWG != "") $WHERE = $WHERE . " and PN_DWG like '" . $DWG . "%'";
			if ($VEN != "") $WHERE = $WHERE . " and PN_VENDOR like '" . $VEN . "%'";
			if ($PN != "") $WHERE = $WHERE . " and PN_PN like '" . $PN . "%'";
			if ($SN != "") $WHERE = $WHERE . " and PN_KIT_SN like '" . $SN . "%'";

			$sSQL = $sSQL . trim($WHERE, " and");
		}

		$result = mysqli_query($link, $sSQL) or die("GetPartsCount failed : " . mysqli_error());

		CloseDB($link);

		$ResultData = mysqli_fetch_assoc($result);

		return $ResultData["PNCOUNT"];

		mysqli_free_result($result);
	}

	function GetPartsByValues($KIT, $MSN, $DWG, $PN, $DESC, $MFR, &$result) {

		ConnectDB($link);

		$sSQL = "Select *, ifnull(INVD_QTY,0) AVEQTY from PNS left join INV_DETAILS on PN_ID = INVD_PN_ID";
		$WHERE = "";

		if($MSN != "ALL" || $KIT != "ALL" || $DWG != "ALL" || $PN != "" || $DESC != "" || $MFR != "") {

			$sSQL = $sSQL . " where ";
			
			if ($MSN != "ALL") $WHERE = $WHERE . " and PN_MSN = '" . $MSN . "'";
			if ($KIT != "ALL") $WHERE = $WHERE . " and PN_KIT = '" . $KIT . "'";
			if ($DWG != "ALL") $WHERE = $WHERE . " and PN_DWG = '" . $DWG . "'";
			if ($PN != "") $WHERE = $WHERE . " and PN_PN like '" . $PN . "%'";
			if ($DESC != "") $WHERE = $WHERE . " and PN_DESC like '" . $DWG . "%'";
			if ($MFR != "") $WHERE = $WHERE . " and PN_MFR like '" . $MFR . "%'";

			$sSQL = $sSQL . trim($WHERE, " and");
		}

		$result = mysqli_query($link, $sSQL) or die("GetPartsByValues failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetPartsForReceipt($MSN, $KIT, $DWG, $VEN, $WP, $PN, $SN, $STA, $CurrentPage, $NumPerPage, &$result) {

		ConnectDB($link);

		$sSQL = "Select *, ifnull(INVD_QTY,0) AVEQTY from PNS left join INV_DETAILS on PN_ID = INVD_PN_ID where PN_ACTIVE = 1";
		$WHERE = "";

		if($MSN != "" || $KIT != "" || $DWG != "" || $VEN != "" || $PN != "" || $SN != "" || $STA != "" || $WP != "") {

			if ($MSN != "") $WHERE = $WHERE . " and PN_MSN like '" . $MSN . "%'";
			if ($KIT != "") $WHERE = $WHERE . " and (PN_KIT like '" . $KIT . "%' or PN_KIT_MPN like '" . $KIT . "%')";
			if ($DWG != "") $WHERE = $WHERE . " and PN_DWG like '" . $DWG . "%'";
			if ($VEN != "") $WHERE = $WHERE . " and PN_VENDOR like '" . $VEN . "%'";
			if ($PN != "") $WHERE = $WHERE . " and PN_PN like '" . $PN . "%'";
			if ($SN != "") $WHERE = $WHERE . " and PN_KIT_SN like '" . $SN . "%'";
			if ($STA != "") $WHERE = $WHERE . " and PN_STATUS like '" . $STA . "%'";
			if ($WP != "") $WHERE = $WHERE . " and PN_WORKPACK like '" . $WP . "%'";

			$sSQL = $sSQL . $WHERE;
		}

		$sSQL = $sSQL . " limit " . (($CurrentPage * $NumPerPage) - $NumPerPage) . ", $NumPerPage";

		$result = mysqli_query($link, $sSQL) or die("GetPartsForReceipt failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetPartsForReceiptDownload($MSN, $KIT, $DWG, $VEN, $WP, $PN, $SN, $STA, &$result) {

		ConnectDB($link);

		$sSQL = "Select *, ifnull(INVD_QTY,0) AVEQTY from PNS left join INV_DETAILS on PN_ID = INVD_PN_ID where PN_ACTIVE = 1 and PN_STATUS = 'OPEN'";
		$WHERE = "";

		if($MSN != "" || $KIT != "" || $DWG != "" || $VEN != "" || $PN != "" || $SN != "" || $STA != "" || $WP != "") {

			if ($MSN != "") $WHERE = $WHERE . " and PN_MSN like '" . $MSN . "%'";
			if ($KIT != "") $WHERE = $WHERE . " and (PN_KIT like '" . $KIT . "%' or PN_KIT_MPN like '" . $KIT . "%')";
			if ($DWG != "") $WHERE = $WHERE . " and PN_DWG like '" . $DWG . "%'";
			if ($VEN != "") $WHERE = $WHERE . " and PN_VENDOR like '" . $VEN . "%'";
			if ($PN != "") $WHERE = $WHERE . " and PN_PN like '" . $PN . "%'";
			if ($SN != "") $WHERE = $WHERE . " and PN_KIT_SN like '" . $SN . "%'";
			if ($STA != "") $WHERE = $WHERE . " and PN_STATUS like '" . $STA . "%'";
			if ($WP != "") $WHERE = $WHERE . " and PN_WORKPACK like '" . $WP . "%'";

			$sSQL = $sSQL . $WHERE;
		}

		$result = mysqli_query($link, $sSQL) or die("GetPartsForReceiptDownload failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetPartsForReceiptCount($MSN, $KIT, $DWG, $VEN, $WP, $PN, $SN, $STA) {

		ConnectDB($link);

		$sSQL = "Select COUNT(PN_ID) as RECEIPTCOUNT from PNS left join INV_DETAILS on PN_ID = INVD_PN_ID where PN_ACTIVE = 1 and PN_STATUS = 'OPEN'";
		$WHERE = "";

		if($MSN != "" || $KIT != "" || $DWG != "" || $VEN != "" || $PN != "" || $SN != "" || $STA != "" || $WP != "") {

			if ($MSN != "") $WHERE = $WHERE . " and PN_MSN like '" . $MSN . "%'";
			if ($KIT != "") $WHERE = $WHERE . " and (PN_KIT like '" . $KIT . "%' or PN_KIT_MPN like '" . $KIT . "%')";
			if ($DWG != "") $WHERE = $WHERE . " and PN_DWG like '" . $DWG . "%'";
			if ($VEN != "") $WHERE = $WHERE . " and PN_VENDOR like '" . $VEN . "%'";
			if ($PN != "") $WHERE = $WHERE . " and PN_PN like '" . $PN . "%'";
			if ($SN != "") $WHERE = $WHERE . " and PN_KIT_SN like '" . $SN . "%'";
			if ($STA != "") $WHERE = $WHERE . " and PN_STATUS like '" . $STA . "%'";
			if ($WP != "") $WHERE = $WHERE . " and PN_WORKPACK like '" . $WP . "%'";

			$sSQL = $sSQL . $WHERE;
		}

		$result = mysqli_query($link, $sSQL) or die("GetPartsForReceiptCount failed : " . mysqli_error());

		CloseDB($link);

		$ResultData = mysqli_fetch_assoc($result);

		return $ResultData["RECEIPTCOUNT"];

		mysqli_free_result($result);
	}

	function GetPartsForReceiptByPNID($PN, &$result) {

		ConnectDB($link);

		$sSQL = "Select *, ifnull(INVD_QTY,0) AVEQTY from PNS left join INV_DETAILS on PN_ID = INVD_PN_ID where PN_ID in (" . $PN . ")";

		$result = mysqli_query($link, $sSQL) or die("GetPartsForReceiptByPNID failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetPartsForIssue($MSN, $KIT, $DWG, $VEN, $PN, $SN, $TRN, $WP, $CurrentPage, $NumPerPage, &$result) {

		ConnectDB($link);

		$sSQL = "Select *, ifnull(ISSUEDQTY,0) as ISSUEDQTY from INV_TRANSACTIONS inner join INV_HISTORY on INVT_ID = INVH_INVT_ID inner join PNS on INVH_PN_ID = PN_ID left join INV_DETAILS on INVH_PN_ID = INVD_PN_ID left join (Select INVH_FROM_ID, SUM(INVH_QTY) as ISSUEDQTY from INV_HISTORY inner join INV_TRANSACTIONS on INVH_INVT_ID = INVT_ID where INVT_TYPE = 'ISSUE' group by INVH_FROM_ID) as ISSUED on INVH_ID = ISSUED.INVH_FROM_ID where INVT_TYPE = 'RESERVE' and PN_ACTIVE = 1 and INVH_STATUS = 'OPEN' and INVH_BIN <> '' and INVH_LOCATION <> ''";
		$WHERE = "";

		if($MSN != "" || $KIT != "" || $DWG != "" || $VEN != "" || $PN != "" || $SN != "" || $TRN != "" || $WP != "") {
			
			if ($MSN != "") $WHERE = $WHERE . " and PN_MSN like '" . $MSN . "%'";
			if ($KIT != "") $WHERE = $WHERE . " and (PN_KIT like '" . $KIT . "%' or PN_KIT_MPN like '" . $KIT . "%')";
			if ($DWG != "") $WHERE = $WHERE . " and PN_DWG like '" . $DWG . "%'";
			if ($VEN != "") $WHERE = $WHERE . " and PN_VENDOR like '" . $VEN . "%'";
			if ($PN != "") $WHERE = $WHERE . " and PN_PN like '" . $PN . "%'";
			if ($SN != "") $WHERE = $WHERE . " and PN_KIT_SN like '" . $SN . "%'";
			if ($TRN != "") $WHERE = $WHERE . " and INVT_ID = " . $TRN;
			if ($WP != "") $WHERE = $WHERE . " and PN_WORKPACK like '" . $WP . "%'";

			$sSQL = $sSQL . $WHERE;
		}

		$sSQL = $sSQL . " limit " . (($CurrentPage * $NumPerPage) - $NumPerPage) . ", $NumPerPage";

		$result = mysqli_query($link, $sSQL) or die("GetPartsForIssue failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetPartsForIssueDownload($MSN, $KIT, $DWG, $VEN, $PN, $SN, $TRN, $WP, &$result) {

		ConnectDB($link);

		$sSQL = "Select *, ifnull(ISSUEDQTY,0) as ISSUEDQTY from INV_TRANSACTIONS inner join INV_HISTORY on INVT_ID = INVH_INVT_ID inner join PNS on INVH_PN_ID = PN_ID left join INV_DETAILS on INVH_PN_ID = INVD_PN_ID left join (Select INVH_FROM_ID, SUM(INVH_QTY) as ISSUEDQTY from INV_HISTORY inner join INV_TRANSACTIONS on INVH_INVT_ID = INVT_ID where INVT_TYPE = 'ISSUE' group by INVH_FROM_ID) as ISSUED on INVH_ID = ISSUED.INVH_FROM_ID where INVT_TYPE = 'RESERVE' and PN_ACTIVE = 1 and INVH_STATUS = 'OPEN' and INVH_BIN <> '' and INVH_LOCATION <> ''";
		$WHERE = "";

		if($MSN != "" || $KIT != "" || $DWG != "" || $VEN != "" || $PN != "" || $SN != "" || $TRN != "" || $WP != "") {
			
			if ($MSN != "") $WHERE = $WHERE . " and PN_MSN like '" . $MSN . "%'";
			if ($KIT != "") $WHERE = $WHERE . " and (PN_KIT like '" . $KIT . "%' or PN_KIT_MPN like '" . $KIT . "%')";
			if ($DWG != "") $WHERE = $WHERE . " and PN_DWG like '" . $DWG . "%'";
			if ($VEN != "") $WHERE = $WHERE . " and PN_VENDOR like '" . $VEN . "%'";
			if ($PN != "") $WHERE = $WHERE . " and PN_PN like '" . $PN . "%'";
			if ($SN != "") $WHERE = $WHERE . " and PN_KIT_SN like '" . $SN . "%'";
			if ($TRN != "") $WHERE = $WHERE . " and INVT_ID = " . $TRN;
			if ($WP != "") $WHERE = $WHERE . " and PN_WORKPACK like '" . $WP . "%'";

			$sSQL = $sSQL . $WHERE;
		}

		$result = mysqli_query($link, $sSQL) or die("GetPartsForIssueDownload failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetPartsForIssueCount($MSN, $KIT, $DWG, $VEN, $PN, $SN, $TRN, $WP) {

		ConnectDB($link);

		$sSQL = "Select COUNT(INVT_ID) as RESERVECOUNT from INV_TRANSACTIONS inner join INV_HISTORY on INVT_ID = INVH_INVT_ID inner join PNS on INVH_PN_ID = PN_ID left join INV_DETAILS on INVH_PN_ID = INVD_PN_ID where INVT_TYPE = 'RESERVE' and PN_ACTIVE = 1 and INVH_STATUS = 'OPEN' and INVH_BIN <> '' and INVH_LOCATION <> ''";
		$WHERE = "";

		if($MSN != "" || $KIT != "" || $DWG != "" || $VEN != "" || $PN != "" || $SN != "" || $TRN != "" || $WP != "") {
			
			if ($MSN != "") $WHERE = $WHERE . " and PN_MSN like '" . $MSN . "%'";
			if ($KIT != "") $WHERE = $WHERE . " and (PN_KIT like '" . $KIT . "%' or PN_KIT_MPN like '" . $KIT . "%')";
			if ($DWG != "") $WHERE = $WHERE . " and PN_DWG like '" . $DWG . "%'";
			if ($VEN != "") $WHERE = $WHERE . " and PN_VENDOR like '" . $VEN . "%'";
			if ($PN != "") $WHERE = $WHERE . " and PN_PN like '" . $PN . "%'";
			if ($SN != "") $WHERE = $WHERE . " and PN_KIT_SN like '" . $SN . "%'";
			if ($TRN != "") $WHERE = $WHERE . " and INVT_ID = " . $TRN;
			if ($WP != "") $WHERE = $WHERE . " and PN_WORKPACK like '" . $WP . "%'";

			$sSQL = $sSQL . $WHERE;
		}

		$result = mysqli_query($link, $sSQL) or die("GetPartsForIssueCount failed : " . mysqli_error());

		CloseDB($link);

		$ResultData = mysqli_fetch_assoc($result);

		return $ResultData["RESERVECOUNT"];

		mysqli_free_result($result);
	}

	function GetPartsForTransfer($MSN, $KIT, $DWG, $VEN, $PN, $SN, $CurrentPage, $NumPerPage, &$result) {

		ConnectDB($link);

		$sSQL = "Select * from PNS inner join INV_DETAILS on PN_ID = INVD_PN_ID where INVD_QTY > 0";
		$WHERE = "";

		if($MSN != "" || $KIT != "" || $DWG != "" || $VEN != "" || $PN != "" || $SN != "") {

			if ($MSN != "") $WHERE = $WHERE . " and PN_MSN like '" . $MSN . "%'";
			if ($KIT != "") $WHERE = $WHERE . " and (PN_KIT like '" . $KIT . "%' or PN_KIT_MPN like '" . $KIT . "%')";
			if ($DWG != "") $WHERE = $WHERE . " and PN_DWG like '" . $DWG . "%'";
			if ($VEN != "") $WHERE = $WHERE . " and PN_VENDOR like '" . $VEN . "%'";
			if ($PN != "") $WHERE = $WHERE . " and PN_PN like '" . $PN . "%'";
			if ($SN != "") $WHERE = $WHERE . " and PN_KIT_SN like '" . $SN . "%'";

			$sSQL = $sSQL . $WHERE;
		}

		$sSQL = $sSQL . " limit " . (($CurrentPage * $NumPerPage) - $NumPerPage) . ", $NumPerPage";

		$result = mysqli_query($link, $sSQL) or die("GetPartsForTransfer failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetPartsForTransferCount($MSN, $KIT, $DWG, $VEN, $PN, $SN) {

		ConnectDB($link);

		$sSQL = "Select COUNT(PN_ID) as TRANSFERCOUNT from PNS inner join INV_DETAILS on PN_ID = INVD_PN_ID where INVD_QTY > 0";
		$WHERE = "";

		if($MSN != "" || $KIT != "" || $DWG != "" || $VEN != "" || $PN != "" || $SN != "") {

			if ($MSN != "") $WHERE = $WHERE . " and PN_MSN like '" . $MSN . "%'";
			if ($KIT != "") $WHERE = $WHERE . " and (PN_KIT like '" . $KIT . "%' or PN_KIT_MPN like '" . $KIT . "%')";
			if ($DWG != "") $WHERE = $WHERE . " and PN_DWG like '" . $DWG . "%'";
			if ($VEN != "") $WHERE = $WHERE . " and PN_VENDOR like '" . $VEN . "%'";
			if ($PN != "") $WHERE = $WHERE . " and PN_PN like '" . $PN . "%'";
			if ($SN != "") $WHERE = $WHERE . " and PN_KIT_SN like '" . $SN . "%'";

			$sSQL = $sSQL . $WHERE;
		}

		$result = mysqli_query($link, $sSQL) or die("GetPartsForTransferCount failed : " . mysqli_error());

		CloseDB($link);

		$ResultData = mysqli_fetch_assoc($result);

		return $ResultData["TRANSFERCOUNT"];

		mysqli_free_result($result);
	}

	function GetPartsForIssueByPNID($PN, &$result) {

		ConnectDB($link);

		$sSQL = "Select * from PNS inner join INV_DETAILS on PN_ID = INVD_PN_ID where PN_ID in (" . $PN . ")";

		$result = mysqli_query($link, $sSQL) or die("GetPartsForIssueByPNID failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetPartsForTransferByPNID($PN, &$result) {

		ConnectDB($link);

		$sSQL = "Select * from PNS inner join INV_DETAILS on PN_ID = INVD_PN_ID where PN_ID in (" . $PN . ")";

		$result = mysqli_query($link, $sSQL) or die("GetPartsForTransferByPNID failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetPartsForReturn($MSN, $KIT, $DWG, $VEN, $PN, $SN, $TRN, $WP, $CurrentPage, $NumPerPage, &$result) {

		ConnectDB($link);

		$sSQL = "Select * from INV_TRANSACTIONS inner join INV_HISTORY on INVT_ID = INVH_INVT_ID inner join PNS on INVH_PN_ID = PN_ID left join INV_DETAILS on INVH_PN_ID = INVD_PN_ID where INVT_TYPE = 'ISSUE' and INVH_QTY <> INVH_RETURN_QTY and PN_ACTIVE = 1";
		$WHERE = "";

		if($MSN != "" || $KIT != "" || $DWG != "" || $VEN != "" || $PN != "" || $SN != "" || $TRN != "" || $WP != "") {
			
			if ($MSN != "") $WHERE = $WHERE . " and PN_MSN like '" . $MSN . "%'";
			if ($KIT != "") $WHERE = $WHERE . " and (PN_KIT like '" . $KIT . "%' or PN_KIT_MPN like '" . $KIT . "%')";
			if ($DWG != "") $WHERE = $WHERE . " and PN_DWG like '" . $DWG . "%'";
			if ($VEN != "") $WHERE = $WHERE . " and PN_VENDOR like '" . $VEN . "%'";
			if ($PN != "") $WHERE = $WHERE . " and PN_PN like '" . $PN . "%'";
			if ($SN != "") $WHERE = $WHERE . " and PN_KIT_SN like '" . $SN . "%'";
			if ($TRN != "") $WHERE = $WHERE . " and INVT_ID = " . $TRN;
			if ($WP != "") $WHERE = $WHERE . " and PN_WORKPACK like '" . $WP . "%'";

			$sSQL = $sSQL . $WHERE;
		}

		$sSQL = $sSQL . " limit " . (($CurrentPage * $NumPerPage) - $NumPerPage) . ", $NumPerPage";

		$result = mysqli_query($link, $sSQL) or die("GetPartsForReturn failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetPartsForReturnDownload($MSN, $KIT, $DWG, $VEN, $PN, $SN, $TRN, $WP, &$result) {

		ConnectDB($link);

		$sSQL = "Select * from INV_TRANSACTIONS inner join INV_HISTORY on INVT_ID = INVH_INVT_ID inner join PNS on INVH_PN_ID = PN_ID left join INV_DETAILS on INVH_PN_ID = INVD_PN_ID where INVT_TYPE = 'ISSUE' and INVH_QTY <> INVH_RETURN_QTY and PN_ACTIVE = 1";
		$WHERE = "";

		if($MSN != "" || $KIT != "" || $DWG != "" || $VEN != "" || $PN != "" || $SN != "" || $TRN != "" || $WP != "") {
			
			if ($MSN != "") $WHERE = $WHERE . " and PN_MSN like '" . $MSN . "%'";
			if ($KIT != "") $WHERE = $WHERE . " and (PN_KIT like '" . $KIT . "%' or PN_KIT_MPN like '" . $KIT . "%')";
			if ($DWG != "") $WHERE = $WHERE . " and PN_DWG like '" . $DWG . "%'";
			if ($VEN != "") $WHERE = $WHERE . " and PN_VENDOR like '" . $VEN . "%'";
			if ($PN != "") $WHERE = $WHERE . " and PN_PN like '" . $PN . "%'";
			if ($SN != "") $WHERE = $WHERE . " and PN_KIT_SN like '" . $SN . "%'";
			if ($TRN != "") $WHERE = $WHERE . " and INVT_ID = " . $TRN;
			if ($WP != "") $WHERE = $WHERE . " and PN_WORKPACK like '" . $WP . "%'";

			$sSQL = $sSQL . $WHERE;
		}

		$result = mysqli_query($link, $sSQL) or die("GetPartsForReturnDownload failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetPartsForReturnCount($MSN, $KIT, $DWG, $VEN, $PN, $SN, $TRN, $WP) {

		ConnectDB($link);

		$sSQL = "Select COUNT(INVT_ID) as RETURNCOUNT from INV_TRANSACTIONS inner join INV_HISTORY on INVT_ID = INVH_INVT_ID inner join PNS on INVH_PN_ID = PN_ID left join INV_DETAILS on INVH_PN_ID = INVD_PN_ID where INVT_TYPE = 'ISSUE' and INVH_QTY <> INVH_RETURN_QTY and PN_ACTIVE = 1";
		$WHERE = "";

		if($MSN != "" || $KIT != "" || $DWG != "" || $VEN != "" || $PN != "" || $SN != "" || $TRN != "" || $WP != "") {
			
			if ($MSN != "") $WHERE = $WHERE . " and PN_MSN like '" . $MSN . "%'";
			if ($KIT != "") $WHERE = $WHERE . " and (PN_KIT like '" . $KIT . "%' or PN_KIT_MPN like '" . $KIT . "%')";
			if ($DWG != "") $WHERE = $WHERE . " and PN_DWG like '" . $DWG . "%'";
			if ($VEN != "") $WHERE = $WHERE . " and PN_VENDOR like '" . $VEN . "%'";
			if ($PN != "") $WHERE = $WHERE . " and PN_PN like '" . $PN . "%'";
			if ($SN != "") $WHERE = $WHERE . " and PN_KIT_SN like '" . $SN . "%'";
			if ($TRN != "") $WHERE = $WHERE . " and INVT_ID = " . $TRN;
			if ($WP != "") $WHERE = $WHERE . " and PN_WORKPACK like '" . $WP . "%'";

			$sSQL = $sSQL . $WHERE;
		}

		$result = mysqli_query($link, $sSQL) or die("GetPartsForReturnCount failed : " . mysqli_error());

		CloseDB($link);

		$ResultData = mysqli_fetch_assoc($result);

		return $ResultData["RETURNCOUNT"];

		mysqli_free_result($result);
	}

	function GetPartsByPN_ID($PN_ID, &$result) {

		ConnectDB($link);

		$sSQL = "Select *, ifnull(INVD_QTY,0) AVEQTY, ifnull(INVD_RESERVED,0) RSVDQTY from PNS left join INV_DETAILS on PN_ID = INVD_PN_ID where PN_ID = " . $PN_ID;

		$result = mysqli_query($link, $sSQL) or die("GetPartsByPN_ID failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetPartsHistoryByKit($MSN, $KIT, $DWG, $VEN, $PN, $SN, $CurrentPage, $NumPerPage, &$result) {

		ConnectDB($link);

		$sSQL = "Select *, ifnull(INVD_QTY,0) AVEQTY, ifnull(INVD_RESERVED,0) RSVDQTY from PNS left join INV_DETAILS on PN_ID = INVD_PN_ID left join (Select INVH_PN_ID HISTORYPN from INV_HISTORY group by INVH_PN_ID) INVHISTORY on PN_ID = HISTORYPN";
		$WHERE = "";

		if($MSN != "" || $KIT != "" || $DWG != "" || $VEN != "" || $PN != "" || $SN != "") {

			$sSQL = $sSQL . " where ";
			
			if ($MSN != "") $WHERE = $WHERE . " and PN_MSN like '" . $MSN . "%'";
			if ($KIT != "") $WHERE = $WHERE . " and (PN_KIT like '" . $KIT . "%' or PN_KIT_MPN like '" . $KIT . "%')";
			if ($DWG != "") $WHERE = $WHERE . " and PN_DWG like '" . $DWG . "%'";
			if ($VEN != "") $WHERE = $WHERE . " and PN_VENDOR like '" . $VEN . "%'";
			if ($PN != "") $WHERE = $WHERE . " and PN_PN like '" . $PN . "%'";
			if ($SN != "") $WHERE = $WHERE . " and PN_KIT_SN like '" . $SN . "%'";

			$sSQL = $sSQL . trim($WHERE, " and");
		}

		$sSQL = $sSQL . " limit " . (($CurrentPage * $NumPerPage) - $NumPerPage) . ", $NumPerPage";

		$result = mysqli_query($link, $sSQL) or die("GetPartsHistoryByKit failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetPartsHistoryByKitCount($MSN, $KIT, $DWG, $VEN, $PN, $SN) {

		ConnectDB($link);

		$sSQL = "Select COUNT(PN_ID) as HISTORYCOUNT from PNS left join INV_DETAILS on PN_ID = INVD_PN_ID left join (Select INVH_PN_ID HISTORYPN from INV_HISTORY group by INVH_PN_ID) INVHISTORY on PN_ID = HISTORYPN";
		$WHERE = "";

		if($MSN != "" || $KIT != "" || $DWG != "" || $VEN != "" || $PN != "" || $SN != "") {

			$sSQL = $sSQL . " where ";
			
			if ($MSN != "") $WHERE = $WHERE . " and PN_MSN like '" . $MSN . "%'";
			if ($KIT != "") $WHERE = $WHERE . " and (PN_KIT like '" . $KIT . "%' or PN_KIT_MPN like '" . $KIT . "%')";
			if ($DWG != "") $WHERE = $WHERE . " and PN_DWG like '" . $DWG . "%'";
			if ($VEN != "") $WHERE = $WHERE . " and PN_VENDOR like '" . $VEN . "%'";
			if ($PN != "") $WHERE = $WHERE . " and PN_PN like '" . $PN . "%'";
			if ($SN != "") $WHERE = $WHERE . " and PN_KIT_SN like '" . $SN . "%'";

			$sSQL = $sSQL . trim($WHERE, " and");
		}

		$result = mysqli_query($link, $sSQL) or die("GetPartsHistoryByKitCount failed : " . mysqli_error());

		CloseDB($link);

		$ResultData = mysqli_fetch_assoc($result);

		return $ResultData["HISTORYCOUNT"];

		mysqli_free_result($result);
	}

	function GetPartsHistoryByPN($PN, &$result) {

		ConnectDB($link);

		$sSQL = "Select *, ifnull(INVD_QTY,0) AVEQTY from PNS left join INV_DETAILS on PN_ID = INVD_PN_ID left join (Select INVH_PN_ID HISTORYPN from INV_HISTORY group by INVH_PN_ID) INVHISTORY on PN_ID = HISTORYPN";

		if($PN != "") {
			$sSQL = $sSQL . " where PN_PN like '" . $PN . "%'";
		}

		$result = mysqli_query($link, $sSQL) or die("GetPartsHistoryByPN failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetPartsForReserve($MSN, $KIT, $DWG, $VEN, $PN, $SN, $LOC, $BIN, $WP, $PROD, $CurrentPage, $NumPerPage, &$result) {

		ConnectDB($link);

		$sSQL = "Select * from PNS inner join INV_DETAILS on PN_ID = INVD_PN_ID where INVD_QTY > 0 and PN_ACTIVE = 1";
		$WHERE = "";

		if($MSN != "" || $KIT != "" || $DWG != "" || $VEN != "" || $PN != "" || $SN != "" || $LOC != "" || $BIN != "" || $WP != "" || $PROD != "") {

			if ($MSN != "") $WHERE = $WHERE . " and PN_MSN like '" . $MSN . "%'";
			if ($KIT != "") $WHERE = $WHERE . " and (PN_KIT like '" . $KIT . "%' or PN_KIT_MPN like '" . $KIT . "%')";
			if ($DWG != "") $WHERE = $WHERE . " and PN_DWG like '" . $DWG . "%'";
			if ($VEN != "") $WHERE = $WHERE . " and PN_VENDOR like '" . $VEN . "%'";
			if ($PN != "") $WHERE = $WHERE . " and PN_PN like '" . $PN . "%'";
			if ($SN != "") $WHERE = $WHERE . " and PN_KIT_SN like '" . $SN . "%'";
			if ($LOC != "") $WHERE = $WHERE . " and INVD_LOCATION like '" . $LOC . "%'";
			if ($BIN != "") $WHERE = $WHERE . " and INVD_BIN like '" . $BIN . "%'";
			if ($WP != "") $WHERE = $WHERE . " and PN_WORKPACK like '" . $WP . "%'";
			if ($PROD != "") $WHERE = $WHERE . " and PN_PRODNUM = '" . $PROD . "'";

			$sSQL = $sSQL . $WHERE;
		}

		$sSQL = $sSQL . " limit " . (($CurrentPage * $NumPerPage) - $NumPerPage) . ", $NumPerPage";

		$result = mysqli_query($link, $sSQL) or die("GetPartsForReserve failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetPartsForReserveDownload($MSN, $KIT, $DWG, $VEN, $PN, $SN, $LOC, $BIN, $WP, $PROD, &$result) {

		ConnectDB($link);

		$sSQL = "Select * from PNS inner join INV_DETAILS on PN_ID = INVD_PN_ID where INVD_QTY > 0 and PN_ACTIVE = 1";
		$WHERE = "";

		if($MSN != "" || $KIT != "" || $DWG != "" || $VEN != "" || $PN != "" || $SN != "" || $LOC != "" || $BIN != "" || $WP != "" || $PROD != "") {

			if ($MSN != "") $WHERE = $WHERE . " and PN_MSN like '" . $MSN . "%'";
			if ($KIT != "") $WHERE = $WHERE . " and (PN_KIT like '" . $KIT . "%' or PN_KIT_MPN like '" . $KIT . "%')";
			if ($DWG != "") $WHERE = $WHERE . " and PN_DWG like '" . $DWG . "%'";
			if ($VEN != "") $WHERE = $WHERE . " and PN_VENDOR like '" . $VEN . "%'";
			if ($PN != "") $WHERE = $WHERE . " and PN_PN like '" . $PN . "%'";
			if ($SN != "") $WHERE = $WHERE . " and PN_KIT_SN like '" . $SN . "%'";
			if ($LOC != "") $WHERE = $WHERE . " and INVD_LOCATION like '" . $LOC . "%'";
			if ($BIN != "") $WHERE = $WHERE . " and INVD_BIN like '" . $BIN . "%'";
			if ($WP != "") $WHERE = $WHERE . " and PN_WORKPACK like '" . $WP . "%'";
			if ($PROD != "") $WHERE = $WHERE . " and PN_PRODNUM = '" . $PROD . "'";

			$sSQL = $sSQL . $WHERE;
		}

		$result = mysqli_query($link, $sSQL) or die("GetPartsForReserveDownload failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetPartsForReserveCount($MSN, $KIT, $DWG, $VEN, $PN, $SN, $LOC, $BIN, $WP, $PROD) {

		ConnectDB($link);

		$sSQL = "Select COUNT(PN_ID) as RESERVECOUNT from PNS inner join INV_DETAILS on PN_ID = INVD_PN_ID where INVD_QTY > 0 and PN_ACTIVE = 1";
		$WHERE = "";

		if($MSN != "" || $KIT != "" || $DWG != "" || $VEN != "" || $PN != "" || $SN != "" || $LOC != "" || $BIN != "" || $WP != "" || $PROD != "") {

			if ($MSN != "") $WHERE = $WHERE . " and PN_MSN like '" . $MSN . "%'";
			if ($KIT != "") $WHERE = $WHERE . " and (PN_KIT like '" . $KIT . "%' or PN_KIT_MPN like '" . $KIT . "%')";
			if ($DWG != "") $WHERE = $WHERE . " and PN_DWG like '" . $DWG . "%'";
			if ($VEN != "") $WHERE = $WHERE . " and PN_VENDOR like '" . $VEN . "%'";
			if ($PN != "") $WHERE = $WHERE . " and PN_PN like '" . $PN . "%'";
			if ($SN != "") $WHERE = $WHERE . " and PN_KIT_SN like '" . $SN . "%'";
			if ($LOC != "") $WHERE = $WHERE . " and INVD_LOCATION like '" . $LOC . "%'";
			if ($BIN != "") $WHERE = $WHERE . " and INVD_BIN like '" . $BIN . "%'";
			if ($WP != "") $WHERE = $WHERE . " and PN_WORKPACK like '" . $WP . "%'";
			if ($PROD != "") $WHERE = $WHERE . " and PN_PRODNUM = '" . $PROD . "'";

			$sSQL = $sSQL . $WHERE;
		}

		$result = mysqli_query($link, $sSQL) or die("GetPartsForReserveCount failed : " . mysqli_error());

		CloseDB($link);

		$ResultData = mysqli_fetch_assoc($result);

		return $ResultData["RESERVECOUNT"];

		mysqli_free_result($result);
	}

	function GetPartsForReserveByPNID($PN, &$result) {

		ConnectDB($link);

		$sSQL = "Select * from PNS inner join INV_DETAILS on PN_ID = INVD_PN_ID where PN_ID in (" . $PN . ")";

		$result = mysqli_query($link, $sSQL) or die("GetPartsForReserveByPNID failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetPartsForPositionCount($MSN, $KIT, $DWG, $VEN, $PN, $SN, $TRN, $WP) {

		ConnectDB($link);

		$sSQL = "Select COUNT(INVT_ID) as RESERVECOUNT from INV_TRANSACTIONS inner join INV_HISTORY on INVT_ID = INVH_INVT_ID inner join PNS on INVH_PN_ID = PN_ID left join INV_DETAILS on INVH_PN_ID = INVD_PN_ID where INVT_TYPE = 'RESERVE' and PN_ACTIVE = 1 and INVH_STATUS = 'OPEN' and INVH_BIN = '' and INVH_LOCATION = ''";
		$WHERE = "";

		if($MSN != "" || $KIT != "" || $DWG != "" || $VEN != "" || $PN != "" || $SN != "" || $TRN != "" || $WP != "") {
			
			if ($MSN != "") $WHERE = $WHERE . " and PN_MSN like '" . $MSN . "%'";
			if ($KIT != "") $WHERE = $WHERE . " and (PN_KIT like '" . $KIT . "%' or PN_KIT_MPN like '" . $KIT . "%')";
			if ($DWG != "") $WHERE = $WHERE . " and PN_DWG like '" . $DWG . "%'";
			if ($VEN != "") $WHERE = $WHERE . " and PN_VENDOR like '" . $VEN . "%'";
			if ($PN != "") $WHERE = $WHERE . " and PN_PN like '" . $PN . "%'";
			if ($SN != "") $WHERE = $WHERE . " and PN_KIT_SN like '" . $SN . "%'";
			if ($TRN != "") $WHERE = $WHERE . " and INVT_ID = " . $TRN;
			if ($WP != "") $WHERE = $WHERE . " and PN_WORKPACK like '" . $WP . "%'";

			$sSQL = $sSQL . $WHERE;
		}

		$result = mysqli_query($link, $sSQL) or die("GetPartsForPositionCount failed : " . mysqli_error());

		CloseDB($link);

		$ResultData = mysqli_fetch_assoc($result);

		return $ResultData["RESERVECOUNT"];

		mysqli_free_result($result);
	}

	function GetPartsForPosition($MSN, $KIT, $DWG, $VEN, $PN, $SN, $TRN, $WP, $CurrentPage, $NumPerPage, &$result) {

		ConnectDB($link);

		$sSQL = "Select *, ifnull(ISSUEDQTY,0) as ISSUEDQTY from INV_TRANSACTIONS inner join INV_HISTORY on INVT_ID = INVH_INVT_ID inner join PNS on INVH_PN_ID = PN_ID left join INV_DETAILS on INVH_PN_ID = INVD_PN_ID left join (Select INVH_FROM_ID, SUM(INVH_QTY) as ISSUEDQTY from INV_HISTORY inner join INV_TRANSACTIONS on INVH_INVT_ID = INVT_ID where INVT_TYPE = 'ISSUE' group by INVH_FROM_ID) as ISSUED on INVH_ID = ISSUED.INVH_FROM_ID where INVT_TYPE = 'RESERVE' and PN_ACTIVE = 1 and INVH_STATUS = 'OPEN' and INVH_BIN = '' and INVH_LOCATION = ''";
		$WHERE = "";

		if($MSN != "" || $KIT != "" || $DWG != "" || $VEN != "" || $PN != "" || $SN != "" || $TRN != "" || $WP != "") {
			
			if ($MSN != "") $WHERE = $WHERE . " and PN_MSN like '" . $MSN . "%'";
			if ($KIT != "") $WHERE = $WHERE . " and (PN_KIT like '" . $KIT . "%' or PN_KIT_MPN like '" . $KIT . "%')";
			if ($DWG != "") $WHERE = $WHERE . " and PN_DWG like '" . $DWG . "%'";
			if ($VEN != "") $WHERE = $WHERE . " and PN_VENDOR like '" . $VEN . "%'";
			if ($PN != "") $WHERE = $WHERE . " and PN_PN like '" . $PN . "%'";
			if ($SN != "") $WHERE = $WHERE . " and PN_KIT_SN like '" . $SN . "%'";
			if ($TRN != "") $WHERE = $WHERE . " and INVT_ID = " . $TRN;
			if ($WP != "") $WHERE = $WHERE . " and PN_WORKPACK like '" . $WP . "%'";

			$sSQL = $sSQL . $WHERE;
		}

		$sSQL = $sSQL . " order by INVT_ID desc limit " . (($CurrentPage * $NumPerPage) - $NumPerPage) . ", $NumPerPage";

		$result = mysqli_query($link, $sSQL) or die("GetPartsForPosition failed : " . mysqli_error());

		CloseDB($link);
	}

	function UpdatePositionByINVH_INVT_ID($INVT_ID, $BIN, $LOCATION) {

		ConnectDB($link);

		$sSQL = "Update INV_HISTORY set INVH_BIN = '" . $BIN . "', INVH_LOCATION = '" . $LOCATION . "' where INVH_INVT_ID = " . $INVT_ID;

		mysqli_query($link, $sSQL) or die("UpdatePositionByINVH_INVT_ID failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "UpdatePositionByINVH_INVT_ID - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

	function PartSearch($PN, $BIN, $LOC, &$result) {

		ConnectDB($link);

		$sSQL1 = "SELECT PN_PN, PN_MSN, PN_KIT, \"AVAILABLE\" as TYPE, INVD_QTY AS QTY, INVD_BIN AS BIN, INVD_LOCATION AS LOC FROM INV_DETAILS LEFT JOIN PNS ON PN_ID = INVD_PN_ID WHERE INVD_QTY > 0";
		$sSQL2 = "SELECT PN_PN, PN_MSN, PN_KIT, \"RESERVED\" as TYPE, INVH_QTY - ifnull(ISSUEDQTY,0) as QTY, INVH_BIN as BIN, INVH_LOCATION as LOC from INV_TRANSACTIONS inner join INV_HISTORY on INVT_ID = INVH_INVT_ID inner join PNS on INVH_PN_ID = PN_ID left join INV_DETAILS on INVH_PN_ID = INVD_PN_ID left join (Select INVH_FROM_ID, SUM(INVH_QTY) as ISSUEDQTY from INV_HISTORY inner join INV_TRANSACTIONS on INVH_INVT_ID = INVT_ID where INVT_TYPE = 'ISSUE' group by INVH_FROM_ID) as ISSUED on INVH_ID = ISSUED.INVH_FROM_ID where INVT_TYPE = 'RESERVE' and PN_ACTIVE = 1 and INVH_STATUS = 'OPEN'";

		$WHERE1 = "";
		$WHERE2 = "";

		if($PN != "" || $BIN != "" || $LOC != "") {

			if ($PN != "") $WHERE1 = $WHERE1 . " and PN_PN like '" . $PN . "%'";
			if ($PN != "") $WHERE2 = $WHERE2 . " and PN_PN like '" . $PN . "%'";
			if ($BIN != "") $WHERE1 = $WHERE1 . " and INVD_BIN like '" . $BIN . "%'";
			if ($BIN != "") $WHERE2 = $WHERE2 . " and INVH_BIN like '" . $BIN . "%'";
			if ($LOC != "") $WHERE1 = $WHERE1 . " and INVD_LOCATION like '" . $LOC . "%'";
			if ($LOC != "") $WHERE2 = $WHERE2 . " and INVH_LOCATION like '" . $LOC . "%'";

			$sSQL1 = $sSQL1 . $WHERE1;
			$sSQL2 = $sSQL2 . $WHERE2;
		}

		$sSQL = $sSQL1 . " UNION ALL " . $sSQL2;

		$result = mysqli_query($link, $sSQL) or die("GetPartsForReserveDownload failed : " . mysqli_error());

		CloseDB($link);
	}

/*-----------------------------------------------------------------------------------------*/

	function ClosePartsMulti($Values) {

		ConnectDB($link);

		$sSQL = "Update PNS set PN_STATUS = 'CLOSED' where PN_ID in (" . $Values . ")";

		mysqli_query($link, $sSQL) or die("ClosePartsMulti failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "ClosePartsMulti - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

	function OpenPartsMulti($Values) {

		ConnectDB($link);

		$sSQL = "Update PNS set PN_STATUS = 'OPEN' where PN_ID in (" . $Values . ")";

		mysqli_query($link, $sSQL) or die("OpenPartsMulti failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "OpenPartsMulti - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

	function UpdatePartsQtyByPN_ID($PN_ID, $PN_QTY_REC, $PN_STATUS) {

		ConnectDB($link);

		$sSQL = "Update PNS set PN_QTY_REC = PN_QTY_REC + " . $PN_QTY_REC . ", PN_STATUS = '" . $PN_STATUS . "' where PN_ID = " . $PN_ID;

		mysqli_query($link, $sSQL) or die("UpdatePartsQtyByPN_ID failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "UpdatePartsQtyByPN_ID - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

/*-----------------------------------------------------------------------------------------*/

	function InventoryTransactionInsert($vINVT_USER, $vINVT_TYPE, $vINVT_AWB, $vINVT_TASKCARD, $vINVT_FROM_ID, $vINVT_BY) {

		ConnectDB($link);

		$sSQL = "Insert into INV_TRANSACTIONS values (NULL, '" . $vINVT_USER . "', '" . $vINVT_TYPE . "', '" . $vINVT_AWB . "', '" . $vINVT_TASKCARD . "', NULL, " .  $vINVT_FROM_ID . ", '" . $vINVT_BY . "')";

		mysqli_query($link, $sSQL) or die("InventoryTransactionInsert failed : " . mysqli_error());

		$ID = mysqli_insert_id($link);

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "InventoryTransactionInsert - " . addslashes($sSQL);
		$AUD_INDEX = $ID;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);

		return $ID;
	}

	function InventoryTransactionDelete($vINVT_ID) {

		ConnectDB($link);

		$sSQL = "Delete from INV_TRANSACTIONS where INVT_ID = " . $vINVT_ID;

		mysqli_query($link, $sSQL) or die("InventoryTransactionDelete failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "InventoryTransactionDelete - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

	function GetTransactionsByINVT_ID($INVT_ID, &$result) {

		ConnectDB($link);

		$sSQL = "Select * from INV_TRANSACTIONS where INVT_ID = " . $INVT_ID;

		$result = mysqli_query($link, $sSQL) or die("GetTransactionsByINVT_ID failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetTransactionsWithNotesByINVT_ID($INVT_ID, &$result) {

		ConnectDB($link);

		$sSQL = "Select INVT_USER, INVT_TYPE, INVT_AWB, INVT_TASKCARD, INVT_DATE, INVT_FROM_ID, INVT_BY, LOG_NAME, COUNT(NOT_ID) NOTECOUNT from INV_TRANSACTIONS left join NOT_NOTES on INVT_ID = NOT_INVT_ID left join LOG_LOGINS on INVT_BY = LOG_UID where INVT_ID = " . $INVT_ID . " group by INVT_USER, INVT_TYPE, INVT_AWB, INVT_TASKCARD, INVT_DATE, INVT_FROM_ID, INVT_BY, LOG_NAME";

		$result = mysqli_query($link, $sSQL) or die("GetTransactionsWithNotesByINVT_ID failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetTransactionsByPN_ID($PN_ID, &$result) {

		ConnectDB($link);

		$sSQL = "Select * from PNS left join INV_HISTORY on PN_ID = INVH_PN_ID left join INV_TRANSACTIONS on INVH_INVT_ID = INVT_ID left join LOG_LOGINS on INVT_BY = LOG_UID where PN_ID = " . $PN_ID . " order by INVT_ID asc";

		$result = mysqli_query($link, $sSQL) or die("GetTransactionsByPN_ID failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetTransactionsByINVT_IDandDATEandType($INVT_ID, $INVT_TYPE, $FDATE, $TDATE, $CurrentPage, $NumPerPage, &$result) {

		ConnectDB($link);

		$sSQL = "Select * from INV_TRANSACTIONS left join INV_HISTORY on INVT_ID = INVH_INVT_ID left join PNS on INVH_PN_ID = PN_ID";
		$WHERE = "";

		if($INVT_ID != "" || $INVT_TYPE != "ALL" || $FDATE != "" || $TDATE != "") {

			$sSQL = $sSQL . " where ";
			
			if ($INVT_ID != "") $WHERE = $WHERE . " and INVT_ID = " . $INVT_ID;
			if ($INVT_TYPE != "ALL") $WHERE = $WHERE . " and INVT_TYPE = '" . $INVT_TYPE . "'";
			if ($FDATE != "") $WHERE = $WHERE . " and INVT_DATE >= '" . $FDATE . "'";
			if ($TDATE != "") $WHERE = $WHERE . " and INVT_DATE < '" . add_date($TDATE,1) . "'";

			$sSQL = $sSQL . trim($WHERE, " and");
		}

		$sSQL = $sSQL . " order by INVT_ID asc";

		$sSQL = $sSQL . " limit " . (($CurrentPage * $NumPerPage) - $NumPerPage) . ", $NumPerPage";

		$result = mysqli_query($link, $sSQL) or die("GetTransactionsByINVT_IDandDATEandType failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetTransactionsByINVT_IDandDATEandTypeDownload($INVT_ID, $INVT_TYPE, $FDATE, $TDATE, &$result) {

		ConnectDB($link);

		$sSQL = "Select * from INV_TRANSACTIONS left join INV_HISTORY on INVT_ID = INVH_INVT_ID left join PNS on INVH_PN_ID = PN_ID";
		$WHERE = "";

		if($INVT_ID != "" || $INVT_TYPE != "ALL" || $FDATE != "" || $TDATE != "") {

			$sSQL = $sSQL . " where ";
			
			if ($INVT_ID != "") $WHERE = $WHERE . " and INVT_ID = " . $INVT_ID;
			if ($INVT_TYPE != "ALL") $WHERE = $WHERE . " and INVT_TYPE = '" . $INVT_TYPE . "'";
			if ($FDATE != "") $WHERE = $WHERE . " and INVT_DATE >= '" . $FDATE . "'";
			if ($TDATE != "") $WHERE = $WHERE . " and INVT_DATE < '" . add_date($TDATE,1) . "'";

			$sSQL = $sSQL . trim($WHERE, " and");
		}

		$sSQL = $sSQL . " order by INVT_ID asc";

		$result = mysqli_query($link, $sSQL) or die("GetTransactionsByINVT_IDandDATEandTypeDownload failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetTransactionsByINVT_IDandDATEandTypeCount($INVT_ID, $INVT_TYPE, $FDATE, $TDATE) {

		ConnectDB($link);

		$sSQL = "Select COUNT(INVT_ID) as TRANSACTIONCOUNT from INV_TRANSACTIONS left join INV_HISTORY on INVT_ID = INVH_INVT_ID left join PNS on INVH_PN_ID = PN_ID";
		$WHERE = "";

		if($INVT_ID != "" || $INVT_TYPE != "ALL" || $FDATE != "" || $TDATE != "") {

			$sSQL = $sSQL . " where ";
			
			if ($INVT_ID != "") $WHERE = $WHERE . " and INVT_ID = " . $INVT_ID;
			if ($INVT_TYPE != "ALL") $WHERE = $WHERE . " and INVT_TYPE = '" . $INVT_TYPE . "'";
			if ($FDATE != "") $WHERE = $WHERE . " and INVT_DATE >= '" . $FDATE . "'";
			if ($TDATE != "") $WHERE = $WHERE . " and INVT_DATE < '" . add_date($TDATE,1) . "'";

			$sSQL = $sSQL . trim($WHERE, " and");
		}

		$sSQL = $sSQL . " order by INVT_ID asc";

		$result = mysqli_query($link, $sSQL) or die("GetTransactionsByINVT_IDandDATEandTypeCount failed : " . mysqli_error());

		CloseDB($link);

		$ResultData = mysqli_fetch_assoc($result);

		return $ResultData["TRANSACTIONCOUNT"];

		mysqli_free_result($result);
	}

/*-----------------------------------------------------------------------------------------*/

	function InventoryHistoryInsert($vINVH_INVT_ID, $vINVH_PN_ID, $vINVH_QTY, $vINVH_RETURN_QTY, $vINVH_QTY_AVAILABLE, $vINVH_FROM, $vINVH_TO, $vINVH_FROM_LOC, $vINVH_TO_LOC, $vINVH_FROM_ID, $vINVH_STATUS, $vINVH_BY) {

		ConnectDB($link);

		$sSQL = "Insert into INV_HISTORY values (NULL, " . $vINVH_INVT_ID . ", " . $vINVH_PN_ID . ", " . $vINVH_QTY . ", " . $vINVH_RETURN_QTY . ", " . $vINVH_QTY_AVAILABLE . ", '" . $vINVH_FROM . "', '" . $vINVH_TO . "', '" . $vINVH_FROM_LOC . "', '" . $vINVH_TO_LOC . "', NULL, " . $vINVH_FROM_ID . ", '" . $vINVH_STATUS . "', '" . $vINVH_BY . "')";

		if (mysqli_query($link, $sSQL)) {

			$ID = mysqli_insert_id($link);
		}
		else {
			$ID = false;
		}

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "InventoryHistoryInsert - " . addslashes($sSQL);
		$AUD_INDEX = $ID;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);

		return $ID;
	}

	function InventoryHistoryInsertMulti($Values) {

		ConnectDB($link);

		$sSQL = "Insert into INV_HISTORY values " . $Values;

		echo $sSQL;

		mysqli_query($link, $sSQL) or die("InventoryHistoryInsertMulti failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "InventoryHistoryInsertMulti - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

	function InventoryHistoryUpdateMulti($Values) {

		ConnectDB($link);

		$sSQL = "Insert into INV_HISTORY values " . $Values . " on duplicate key update INVH_STATUS = values(INVH_STATUS)";

		mysqli_query($link, $sSQL) or die("InventoryHistoryUpdateMulti failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "InventoryHistoryUpdateMulti - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

	function InventoryHistoryUpdateReturnMulti($Values) {

		ConnectDB($link);

		$sSQL = "Insert into INV_HISTORY values " . $Values . " on duplicate key update INVH_RETURN_QTY = INVH_RETURN_QTY + values(INVH_RETURN_QTY)";

		mysqli_query($link, $sSQL) or die("InventoryHistoryUpdateReturnMulti failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "InventoryHistoryUpdateReturnMulti - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

	function InventoryHistoryUpdate($vINVH_ID, $vINVH_RETURN_QTY) {

		ConnectDB($link);

		$sSQL = "Update INV_HISTORY set INVH_RETURN_QTY = INVH_RETURN_QTY + " . $vINVH_RETURN_QTY . " where INVH_ID = " . $vINVH_ID;

		mysqli_query($link, $sSQL) or die("InventoryHistoryUpdate failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "InventoryHistoryUpdate - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

	function InventoryHistoryClose($vINVH_ID) {

		ConnectDB($link);

		$sSQL = "Update INV_HISTORY set INVH_STATUS = 'CLOSED' where INVH_ID = " . $vINVH_ID;

		mysqli_query($link, $sSQL) or die("InventoryHistoryClose failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "InventoryHistoryClose - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

	function GetHistoryByINVT_ID($INVT_ID, &$result) {

		ConnectDB($link);

		$sSQL = "Select * from INV_HISTORY inner join PNS on INVH_PN_ID = PN_ID left join INV_DETAILS on INVH_PN_ID = INVD_PN_ID where INVH_INVT_ID = " . $INVT_ID;

		$result = mysqli_query($link, $sSQL) or die("GetHistoryByINVT_ID failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetReservedByINVT_ID($INVT_ID, &$result) {

		ConnectDB($link);

		$sSQL = "Select *, ifnull(ISSUEDQTY,0) as ISSUEDQTY from INV_HISTORY inner join PNS on INVH_PN_ID = PN_ID left join INV_DETAILS on INVH_PN_ID = INVD_PN_ID left join (Select INVH_FROM_ID, SUM(INVH_QTY) as ISSUEDQTY from INV_HISTORY inner join INV_TRANSACTIONS on INVH_INVT_ID = INVT_ID where INVT_TYPE = 'ISSUE' group by INVH_FROM_ID) as ISSUED on INVH_ID = ISSUED.INVH_FROM_ID where INVH_INVT_ID = " . $INVT_ID;

		$result = mysqli_query($link, $sSQL) or die("GetReservedByINVT_ID failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetForReleaseByINVT_ID($INVT_ID, &$result) {

		ConnectDB($link);

		$sSQL = "Select *, ifnull(ISSUEDQTY,0) as ISSUEDQTY from INV_HISTORY inner join PNS on INVH_PN_ID = PN_ID left join INV_DETAILS on INVH_PN_ID = INVD_PN_ID left join (Select INVH_FROM_ID, SUM(INVH_QTY) as ISSUEDQTY from INV_HISTORY inner join INV_TRANSACTIONS on INVH_INVT_ID = INVT_ID where INVT_TYPE = 'ISSUE' group by INVH_FROM_ID) as ISSUED on INVH_ID = ISSUED.INVH_FROM_ID where INVH_STATUS = 'OPEN' and INVH_INVT_ID = " . $INVT_ID;

		$result = mysqli_query($link, $sSQL) or die("GetForReleaseByINVT_ID failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetHistoryWithReturnsByINVT_ID($INVT_ID, &$result) {

		ConnectDB($link);

		$sSQL = "Select * from INV_HISTORY inner join PNS on INVH_PN_ID = PN_ID left join INV_DETAILS on INVH_PN_ID = INVD_PN_ID where INVH_INVT_ID = " . $INVT_ID;

		$result = mysqli_query($link, $sSQL) or die("GetHistoryWithReturnsByINVT_ID failed : " . mysqli_error());

		CloseDB($link);
	}

	function GetHistoryWithReturnsAndNotesByINVT_ID($INVT_ID, &$result) {

		ConnectDB($link);

		$sSQL = "Select INVH_ID, PN_KIT, PN_MSN, PN_DWG, PN_VENDOR, PN_WORKPACK, PN_PRODNUM, PN_PN, PN_DESC, INVH_QTY, PN_KIT_SN, PN_KIT_MPN, COUNT(NOT_ID) NOTECOUNT, INVH_FROM_LOC, INVH_TO_LOC, INVH_FROM, INVH_TO from INV_HISTORY inner join PNS on INVH_PN_ID = PN_ID left join INV_DETAILS on INVH_PN_ID = INVD_PN_ID left join NOT_NOTES on INVH_ID = NOT_INVH_ID where INVH_INVT_ID = " . $INVT_ID . " group by INVH_ID, PN_KIT, PN_MSN, PN_DWG, PN_VENDOR, PN_PN, PN_DESC, INVH_QTY, PN_KIT_SN, PN_KIT_MPN, INVH_FROM_LOC, INVH_TO_LOC, INVH_FROM, INVH_TO";

		$result = mysqli_query($link, $sSQL) or die("GetHistoryWithReturnsAndNotesByINVT_ID failed : " . mysqli_error());

		CloseDB($link);
	}

/*-----------------------------------------------------------------------------------------*/

	function InventoryDetailInsert($vINVD_PN_ID, $vINVD_QTY) {

		ConnectDB($link);

		$sSQL = "Insert into INV_DETAILS values (NULL, " . $vINVD_PN_ID . ", " . $vINVD_QTY . ", NULL)";

		mysqli_query($link, $sSQL) or die("InventoryDetailInsert failed : " . mysqli_error());

		$ID = mysqli_insert_id($link);

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "InventoryDetailInsert - " . addslashes($sSQL);
		$AUD_INDEX = $ID;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

	function InventoryDetailInsertMulti($Values) {

		ConnectDB($link);

		$sSQL = "Insert into INV_DETAILS values " . $Values . " on duplicate key update INVD_QTY = INVD_QTY + values(INVD_QTY)";

		mysqli_query($link, $sSQL) or die("InventoryDetailInsertMulti failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "InventoryDetailInsertMulti - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

	function InventoryDetailUpdate($vINVD_PN_ID, $vINVD_QTY) {

		ConnectDB($link);

		$sSQL = "Update INV_DETAILS set INVD_QTY = " . $vINVD_QTY . " where INVD_PN_ID = " . $vINVD_PN_ID;

		mysqli_query($link, $sSQL) or die("InventoryDetailUpdate failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "InventoryDetailUpdate - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

	function InventoryReturnUpdate($vINVD_PN_ID, $vINVD_QTY) {

		ConnectDB($link);

		$sSQL = "Update INV_DETAILS set INVD_QTY = INVD_QTY + " . $vINVD_QTY . " where INVD_PN_ID = " . $vINVD_PN_ID;

		mysqli_query($link, $sSQL) or die("InventoryReturnUpdate failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "InventoryReturnUpdate - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

	function InventoryDetailReturn($vINVD_PN_ID, $vINVD_QTY) {

		ConnectDB($link);

		$sSQL = "Update INV_DETAILS set INVD_QTY = INVD_QTY + " . $vINVD_QTY . " where INVD_PN_ID = " . $vINVD_PN_ID;

		mysqli_query($link, $sSQL) or die("InventoryDetailReturn failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "InventoryDetailReturn - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

	function InventoryDetailReceive($vINVD_PN_ID, $vINVD_QTY) {

		ConnectDB($link);

		$sSQL = "Update INV_DETAILS set INVD_QTY = INVD_QTY + " . $vINVD_QTY . " where INVD_PN_ID = " . $vINVD_PN_ID;

		mysqli_query($link, $sSQL) or die("InventoryDetailReceive failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "InventoryDetailReceive - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

	function InventoryDetailReserve($vINVD_PN_ID, $vINVD_QTY) {

		ConnectDB($link);

		$sSQL = "Update INV_DETAILS set INVD_QTY = INVD_QTY - " . $vINVD_QTY . ", INVD_RESERVED = INVD_RESERVED + " . $vINVD_QTY . " where INVD_PN_ID = " . $vINVD_PN_ID;

		mysqli_query($link, $sSQL) or die("InventoryDetailReserve failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "InventoryDetailReserve - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

	function InventoryDetailReserveMulti($Values) {

		ConnectDB($link);

		$sSQL = "Insert into INV_DETAILS values " . $Values . " on duplicate key update INVD_QTY = INVD_QTY - values(INVD_QTY), INVD_RESERVED = INVD_RESERVED + values(INVD_RESERVED)";

		mysqli_query($link, $sSQL) or die("InventoryDetailReserveMulti failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "InventoryDetailReserveMulti - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

	function InventoryDetailIssueMulti($Values) {

		ConnectDB($link);

		$sSQL = "Insert into INV_DETAILS values " . $Values . " on duplicate key update INVD_RESERVED = INVD_RESERVED - values(INVD_RESERVED)";

		mysqli_query($link, $sSQL) or die("InventoryDetailIssueMulti failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "InventoryDetailIssueMulti - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

	function InventoryDetailReturnMulti($Values) {

		ConnectDB($link);

		$sSQL = "Insert into INV_DETAILS values " . $Values . " on duplicate key update INVD_QTY = INVD_QTY + values(INVD_QTY)";

		mysqli_query($link, $sSQL) or die("InventoryDetailReturnMulti failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "InventoryDetailReturnMulti - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

	function InventoryDetailTransferMulti($Values) {

		ConnectDB($link);

		$sSQL = "Insert into INV_DETAILS values " . $Values . " on duplicate key update INVD_BIN = values(INVD_BIN), INVD_LOCATION = values(INVD_LOCATION)";

		mysqli_query($link, $sSQL) or die("InventoryDetailTransferMulti failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "InventoryDetailTransferMulti - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

	function InventoryDetailReleaseMulti($Values) {

		ConnectDB($link);

		$sSQL = "Insert into INV_DETAILS values " . $Values . " on duplicate key update INVD_QTY = INVD_QTY + values(INVD_QTY), INVD_RESERVED = INVD_RESERVED - values(INVD_RESERVED)";

		mysqli_query($link, $sSQL) or die("InventoryDetailReleaseMulti failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "InventoryDetailReleaseMulti - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

	function InventoryDetailRelease($vINVD_PN_ID, $vINVD_QTY) {

		ConnectDB($link);

		$sSQL = "Update INV_DETAILS set INVD_QTY = INVD_QTY + " . $vINVD_QTY . ", INVD_RESERVED = INVD_RESERVED - " . $vINVD_QTY . " where INVD_PN_ID = " . $vINVD_PN_ID;

		mysqli_query($link, $sSQL) or die("InventoryDetailRelease failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "InventoryDetailRelease - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

	function InventoryDetailIssue($vINVD_PN_ID, $vINVD_QTY) {

		ConnectDB($link);

		$sSQL = "Update INV_DETAILS set INVD_RESERVED = INVD_RESERVED - " . $vINVD_QTY . " where INVD_PN_ID = " . $vINVD_PN_ID;

		mysqli_query($link, $sSQL) or die("InventoryDetailIssue failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "InventoryDetailIssue - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

	function InventoryDetailUpdateLocation($vINVD_PN_ID, $vLocation, $vBin) {

		ConnectDB($link);

		$sSQL = "Update INV_DETAILS set INVD_LOCATION = '" . $vLocation . "', INVD_BIN = '" . $vBin . "' where INVD_PN_ID = " . $vINVD_PN_ID;

		mysqli_query($link, $sSQL) or die("InventoryDetailUpdateLocation failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "InventoryDetailUpdateLocation - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

/*-----------------------------------------------------------------------------------------*/

	function AuditInsert(&$rAUD_AUDIT_ID, $vAUD_ACTION, $vAUD_INDEX, $vAUD_BY) {

		ConnectDB($link);

		$sSQL = "Insert into AUD_AUDIT values (NULL, '" . $vAUD_ACTION . "', " . $vAUD_INDEX . ", NULL, '" . $vAUD_BY . "')";

		mysqli_query($link, $sSQL) or die("AuditInsert failed : " . mysqli_error());

		$rAUD_AUDIT_ID = mysqli_insert_id($link);

		CloseDB($link);
	}

	function AuditUpdate(&$rAUD_AUDIT_ID, $vAUD_USER_ID, $vAUD_FUNCTION, $vAUD_ERROR, $vAUD_INDEX, $vAUD_SQL, $vAUD_TIME) {

		$sSQL = "Update AUD_AUDIT set AUD_USER_ID = " . $vAUD_USER_ID . ", AUD_FUNCTION = '" . $vAUD_FUNCTION . "', AUD_ERROR = '" . $vAUD_ERROR . "', AUD_INDEX = " . $vAUD_INDEX . ", AUD_SQL = '" . $vAUD_SQL . "', $vAUD_TIME = '" . $vAUD_TIME . "' where AUD_AUDIT_ID = " . $vAUD_AUDIT_ID;

		mysqli_query($link, $sSQL) or die("AuditUpdate failed : " . mysqli_error());
	}

	function AuditDelete($vAUD_AUDIT_ID) {

		$sSQL = "Delete from AUD_AUDIT where AUD_AUDIT_ID = " . $vAUD_AUDIT_ID;

		mysqli_query($link, $sSQL) or die("AuditDelete failed : " . mysqli_error());
	}

	function GetAuditByAUD_AUDIT_ID($vAUD_AUDIT_ID, &$result) {

		$sSQL = "Select * from AUD_AUDIT where AUD_AUDIT_ID = " . $vAUD_AUDIT_ID;

		$result = mysqli_query($link, $sSQL) or die("GetAuditByAUD_AUDIT_ID failed : " . mysqli_error());
	}

	function GetAudit(&$result) {

		$sSQL = "Select * from AUD_AUDIT";

		$result = mysqli_query($link, $sSQL) or die("GetAudit failed : " . mysqli_error());
	}

/*-----------------------------------------------------------------------------------------*/

	function GetNoteCountByINVT_ID($INVT_ID) {

		ConnectDB($link);

		$sSQL = "Select ifnull(count(NOT_INVT_ID),0) NOTECOUNT from NOT_NOTES where NOT_INVT_ID = " . $INVT_ID;

		$result = mysqli_query($link, $sSQL) or die("GetNoteCountByINVT_ID failed : " . mysqli_error());

		CloseDB($link);

		$ResultData = mysqli_fetch_assoc($result);

		$NOTECOUNT = $ResultData["NOTECOUNT"];

		mysqli_free_result($result);

		return $NOTECOUNT;
	}

	function GetNoteCountByINVH_ID($INVH_ID) {

		ConnectDB($link);

		$sSQL = "Select ifnull(count(NOT_INVH_ID),0) NOTECOUNT from NOT_NOTES where NOT_INVH_ID = " . $INVH_ID;

		$result = mysqli_query($link, $sSQL) or die("GetNoteCountByINVH_ID failed : " . mysqli_error());

		CloseDB($link);

		$ResultData = mysqli_fetch_assoc($result);

		$NOTECOUNT = $ResultData["NOTECOUNT"];

		mysqli_free_result($result);

		return $NOTECOUNT;
	}

	function GetNoteByID($PN_ID, $INVT_ID, $INVH_ID, &$result) {

		ConnectDB($link);

		if ($PN_ID != 0) $sSQL = "Select * from NOT_NOTES left join LOG_LOGINS on NOT_BY = LOG_UID where NOT_PN_ID = " . $PN_ID;
		if ($INVT_ID != 0) $sSQL = "Select * from NOT_NOTES left join LOG_LOGINS on NOT_BY = LOG_UID where NOT_INVT_ID = " . $INVT_ID;
		if ($INVH_ID != 0) $sSQL = "Select * from NOT_NOTES left join LOG_LOGINS on NOT_BY = LOG_UID where NOT_INVH_ID = " . $INVH_ID;

		$result = mysqli_query($link, $sSQL) or die("GetNoteByPN_ID failed : " . mysqli_error());

		CloseDB($link);
	}

	function NoteInsert($vNOT_PN_ID, $vNOT_INVT_ID, $vNOT_INVH_ID, $vNOT_NOTE, $vNOT_BY) {

		ConnectDB($link);

		$sSQL = "Insert into NOT_NOTES values (NULL, " . $vNOT_PN_ID . ", " . $vNOT_INVT_ID . ", " . $vNOT_INVH_ID . ", '" . $vNOT_NOTE . "', NULL, '" .  $vNOT_BY . "')";

		mysqli_query($link, $sSQL) or die("NoteInsert failed : " . mysqli_error());

		$ID = mysqli_insert_id($link);

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "NoteInsert - " . addslashes($sSQL);
		$AUD_INDEX = $ID;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);

		return $ID;
	}

/*-----------------------------------------------------------------------------------------*/

	function GeneratePageCounter($CurrentPage, $ResultCount, $NumPerPage, $link) {

		$PrevPage = $CurrentPage - 1;
		$NextPage = $CurrentPage + 1;

		if ($ResultCount % $NumPerPage > 0) {
			$TotalPage = intval($ResultCount / $NumPerPage) + 1;
		}
		else {
			$TotalPage = $ResultCount / $NumPerPage;
		}

		$PageCounter = "";

		if ($TotalPage == 0) {

			$PageCounter = "Page 0 of 0";
		}
		else {

			if($PrevPage != 0) {
				$PageCounter = "<a href=\"" . $link . "&P=1\">First<<</a> " . "<a href=\"" . $link . "&P=" . $PrevPage . "\">Prev<</a>";
			}

			$PageCounter = $PageCounter . " Page " . $CurrentPage . " of " . $TotalPage;

			if($NextPage != $TotalPage + 1) {
				$PageCounter = $PageCounter . " <a href=\"" . $link . "&P=" . $NextPage . "\">>Next</a>" . " <a href=\"" . $link . "&P=" . $TotalPage . "\">>>Last</a>";
			}
		}

		return $PageCounter;
	}

	function GetMSN() {

		ConnectDB($link);

		$sSQL = "Select MSN from MSN";

		$result = mysqli_query($link, $sSQL) or die("GetMSN failed : " . mysqli_error());

		CloseDB($link);

		$ResultData = mysqli_fetch_assoc($result);

		return $ResultData["MSN"];

		mysqli_free_result($result);
	}

	function UpdateMSN($MSN) {

		ConnectDB($link);

		$sSQL = "Update MSN set MSN = '" . $MSN . "'";

		$result = mysqli_query($link, $sSQL) or die("UpdateMSN failed : " . mysqli_error());

		CloseDB($link);

		$AUD_AUDIT_ID = NULL;
		$AUD_ACTION = "UpdateMSN - " . addslashes($sSQL);
		$AUD_INDEX = 0;
		$AUD_BY = $_SESSION[GetSessionVar()];

		AuditInsert($AUD_AUDIT_ID, $AUD_ACTION, $AUD_INDEX, $AUD_BY);
	}

/*-----------------------------------------------------------------------------------------*/

if (!isset($_SESSION[GetSessionVar()])) {
	header ("Location: Session_Expire.php");
}

?>