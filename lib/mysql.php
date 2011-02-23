<?php
include 'config.php';
mysql_connect($dbhost, $dbuser, $dbpasswd) or die(mysql_error());
mysql_select_db($dbname) or die(mysql_error());
?>