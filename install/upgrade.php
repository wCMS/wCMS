<title>Upgrade</title>
<?php
$cmsversion = "1.3";
if(!file_exists("../lib/config.php")) {
echo "Ist noch nicht installiert! <a href=\"index.php\">Klicke hier um es zu installieren</a>";
die;
}
include '../lib/config.php';
elseif($version == $cmsversion) {
echo "Kein Upgrade möglich.<br>Es wird bereits die aktuelle Version genutzt oder es wurden keine Veränderungen an der Datenbank vorgenommen";
die;
}
elseif($version == "1.1") {
header("Location: upgrade_1.1_1.2.php");
}
elseif($version == "1.2") {
header("Location: upgrade_1.2_1.3.php");
}
?>