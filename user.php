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
$pm = $_GET['pm'];
echo "<a href=\"user.php?pm=inbox\">Posteingang</a> | <a href=\"user.php?pm=create\">Nachricht schicken</a><hr>";
if($pm == 'inbox') {
$get = mysql_query("SELECT id,title,from,to,text FROM pm WHERE to = '".$_SESSION['all_user_username']."'");
while($out = mysql_fetch_array($get)) {
echo "<a href='user.php?pm=".$out['id']."'>".$out['title']." von ".$out['from']."</a><br>";
}
if($pm == $out['id']) {
$get = mysql_query("SELECT title,from,text from pm where to = '".$_SESSION['all_user_username']."' and id = '".$_GET['id']."'");
echo "Titel: ".$get['title']."<br><br>".$get['text']."<br><br>Von ".$get['from']." geschrieben";
}
}
if($pm == 'create') {
echo "Test";
}
}
echo "<hr>$footer";
?>