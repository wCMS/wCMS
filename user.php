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
if(isset($_GET['success'])) {
?> <title>Erfolgreich - <? echo $sitename ?></title> <?
echo "Aktion erfolgreich ausgeführt!<br><input type=\"button\" value=\"Zurück\" onclick=\"history.back(-1)\">";
}
if(isset($_GET['error'])) {
?> <title>Fehler - <? echo $sitename ?></title> <?
echo "Dir ist ein Fehler unterlaufen!<br><input type=\"button\" value=\"Zurück\" onclick=\"history.back(-1)\">";
}
if(isset($_GET['pm'])) {
$pm = $_GET['pm'];
echo "<a href=\"user.php?pm=inbox\">Posteingang</a> | <a href=\"user.php?pm=create\">Nachricht schicken</a><hr>";
if($pm == 'inbox') {
$sqls = mysql_query("SELECT id,title,from,to,text FROM pm WHERE to = '".$_SESSION['all_user_username']."'");
while($sql = mysql_fetch_array($sqls)) {
echo "<a href=\"user.php?pm=".$sql['id']."\">".$sql['title']." von ".$sql['from']."</a><br>";
$outid = $sql['id'];
}
if($pm == $outid) {
$sql = mysql_query("SELECT title,from,text from pm WHERE to = '".$_SESSION['all_user_username']."' AND WHERE id = '".$_GET['id']."'");
echo "Titel: ".$sql['title']."<br><br>".$sql['text']."<br><br>Von ".$sql['from']." geschrieben";
}
}
if($pm == 'create') {
?>
<title>Nachricht schicken - <? echo $sitename ?></title>
<form action="" method="post">
Titel: <input type="text" name="name" size="80" maxlength="50"> Empfänger: <input type="text" name="to" size="40" maxlength="25"><br>
<textarea type="text" name="text" style="width:100%; height:72%"></textarea>
<input type="submit" name="submit" value="erstellen"
<form>
<?

}
if(isset($_POST['submit'])) {
$name = $_POST['title'];
$to = $_POST['to'];
$pretext = str_replace("\r\n", "\r\n<br>", $_POST['text']);
$text = str_replace("href=\"", "href=\"./redirect.php?url=", $pretext);
if(empty($name)) {
header ("Location: user.php?error");
}
else {
mysql_query("INSERT INTO pm (title, text, from, to) VALUES ('".$name."', '".$text."', '".$_SESSION['all_user_username']."', '".$to."')");

header ("Location: user.php?success");
}
}
}
echo "<hr>$footer";
?>