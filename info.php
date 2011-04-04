<title>Info</title>
<?php
include "lib/config.php";
include "lib/header.php";
include "lib/mysql.php";
$out = shell_exec("git describe --match $version --dirty=+ --abbrev=12");
echo $out;
?>