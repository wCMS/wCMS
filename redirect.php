<?php
include "lib/config.php";
include "lib/header.php";
?>
<title>Redirecting - <? echo $sitename ?></title>
<center>You will be redirected in 3 seconds</center>
<head><meta http-equiv="refresh" content="3; <? echo $_SERVER['QUERY_STRING'] ?>"></head>
<?
echo "<hr>".$footer;
?>