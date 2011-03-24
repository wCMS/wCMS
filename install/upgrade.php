<title>Upgrade</title>
<?php
$cmsversion = "1.4";
if(!file_exists("../lib/config.php")) {
echo "Ist noch nicht installiert! <a href=\"index.php\">Klicke hier um es zu installieren</a>";
die;
}
include '../lib/config.php';
if($version == $cmsversion) {
echo "Kein Upgrade möglich.<br>Es wird bereits die aktuelle Version genutzt oder es wurden keine Veränderungen an der Datenbank vorgenommen";
die;
}
if($version == "1.1") {
header("Location: upgrade_1.1_1.2.php");
}
if($version == "1.2") {
header("Location: upgrade_1.2_1.3.php");
}
if($version == "1.3") {
header("Location: upgrade_1.3_1.4.php");
?>