<b>Transaction Menu:</b>

<br>
&nbsp&nbsp<a href='Parts_Reserve_iFrames.php'>Reserve Parts</a>
<br>
&nbsp&nbsp<a href='Parts_Position_iFrames.php'>Position Parts</a>
<br>
&nbsp&nbsp<a href='Parts_Issue_iFrames.php'>Issue Parts</a>
<br>
&nbsp&nbsp<a href='Parts_Return_iFrames.php'>Return Parts</a>
<br>
&nbsp&nbsp<a href='Parts_Receive_iFrames.php'>Receive Parts</a>
<br>
&nbsp&nbsp<a href='Parts_Transfer_iFrames.php'>Transfer Parts</a>
<br>
<br>

<b>Parts History:</b>

<br>
&nbsp&nbsp<a href='Parts_History_TRANS_iFrames.php?BY=TRANS'>History Browser</a>
<br>
&nbsp&nbsp<a href='Parts_Browse_iFrames.php'>Parts Browser</a>
<br>
&nbsp&nbsp<a href='Parts_Search_iFrames.php'>Part Search</a>
<br>
<br>

<?php if ($_SESSION["RIGHTS"] == 1) include "Menu_1.php"; ?>

<hr>
<a href='Logout_Action.php'>Logout</a>