<?php
include "lib/config.php";
include "lib/mysql.php";
include "lib/header.php";
include "lib/menu.php";
include "lib/all_sessions.php";
echo $menu_user;
if(empty($_GET)) {
echo "Bitte wähle eine der oben genannten Optionen!";
}
if(isset($_GET['pm'])) {
echo "<a href=\"user.php?pm=inbox\">Posteingang</a><br><a href=\"user.php?pm=create\">Nachricht schicken</a>";
}
if(isset($_GET['pm']) == 'inbox') {
echo "Noch ein Test *gg*";
}
if(isset($_GET['pm']) == 'create') {
echo "Test";
}
echo "<hr>$footer";
?>