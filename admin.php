<?php
include "lib/config.php";
include "lib/adm_session.php";
include "lib/mysql.php";
include "lib/header.php";
?><center><a href="admin.php?createnews">News erstellen</a> | <a href="admin.php?create">Beitrag erstellen</a> | <a href="admin.php?deletenews">News löschen</a> | <a href="admin.php?delete">Beitrag löschen</a> | <a href="admin.php?userdelete">Benutzer löschen</a> | <a href="admin.php?users">Benutzerliste</a> | <a href="admin.php?usermanagement">Benutzerverwaltung</a></center><hr><?
if(isset($_REQUEST['create'])) { ?>
<title>Beitrag erstellen - <? echo $sitename ?></title>
<form action="" method="post">
Titel: <input type="text" name="name" size="80" maxlength="50"><br>
<textarea type="text" name="text" style="width:100%; height:72%"></textarea>
<input type="submit" name="submit" value="erstellen"
<form>
<?
echo "<hr>".$footer;
}
if(isset($_POST['submit'])) {
$name = $_POST['name'];
$text = $_POST['text'];
if(empty($name)) {
header ("Location: admin.php?titleerror");
}
else {
mysql_query("INSERT INTO posts (name, text, username) VALUES ('".$name."', '".$text."', '".$_SESSION['adm_user_username']."')");

header ("Location: admin.php?success");
}
}
if(isset($_REQUEST['delete'])) {
?> <title>Beitrag löschen - <? echo $sitename ?></title> <?
$sqls = mysql_query("select name,username from posts");
while($sql = mysql_fetch_array($sqls)) {
$sqlnametemp = str_replace(" ", "_", $sql['name']);
$sqlname = str_replace("!", "###", $sqlnametemp);
?>
<form action="" method="post">
<input type="submit" value="<? echo $sql['name']." von ".$sql['username']." löschen"; ?>" name="<? echo $sqlname; ?>">
</form>
<?
if(isset($_POST[$sqlname])) {
$sqlcorrectnametemp = str_replace("_", " ", $sqlname);
$sqlcorrectname = str_replace("###", "!", $sqlcorrectnametemp);
mysql_query("DELETE FROM posts WHERE name = '".$sqlcorrectname."'");

header ("Location: admin.php?success");
}
}
echo "<hr>".$footer;
}
if(isset($_REQUEST['success'])) {
echo "Aktion erfolgreich ausgeführt!<br><input type=\"button\" value=\"Zurück\" onclick=\"history.back(-1)\">";
}
if(isset($_REQUEST['titleerror'])) {
echo "Bitte wähle einen Titel!<br><input type=\"button\" value=\"Zurück\" onclick=\"history.back(-1)\">";
}
if(isset($_REQUEST['userdelete'])) {
?> <title>Benutzer löschen - <? echo $sitename ?></title> <?
$sqls = mysql_query("select username from accounts WHERE safe = '0'");
while($sql = mysql_fetch_array($sqls)) {
?>
<form action="" method="post">
<input type="submit" value="<? echo $sql['username']." löschen"; ?>" name="<? echo $sql['username']; ?>">
</form>
<?
if(isset($_POST[$sql['username']])) {
mysql_query("DELETE FROM accounts WHERE username = '".$sql['username']."' and safe = '0'");

header ("Location: admin.php?success");
}
}
echo "<hr>".$footer;
}
if(isset($_REQUEST['users'])) {
?> <title>Benutzerliste - <? echo $sitename ?></title> <?
echo "<b><u>Administratoren:</u></b><br>";
$sqlsadmin = mysql_query("select username from accounts where admin = '1'");
while($sqladmin = mysql_fetch_array($sqlsadmin)) {
echo $sqladmin['username']."<br>";
}
echo "<b><u>Benutzer:</u></b><br>";
$sqls = mysql_query("select username from accounts where admin = '0'");
while($sql = mysql_fetch_array($sqls)) {
echo $sql['username']."<br>";
}
echo "<hr>".$footer;
}
if(isset($_REQUEST['usermanagement'])) {
?> <title>Benutzerverwaltung - <? echo $sitename ?></title> <?
$sqls = mysql_query("select username from accounts WHERE admin = '0'");
while($sql = mysql_fetch_array($sqls)) {
?>
<form action="" method="post">
<input type="submit" value="<? echo $sql['username']." zum Admin befördern"; ?>" name="<? echo $sql['username']; ?>">
</form>
<?
if(isset($_POST[$sql['username']])) {
mysql_query("UPDATE accounts SET admin = '1' WHERE username = '".$sql['username']."'");

header ("Location: admin.php?success");
}
}
echo "<hr>".$footer;
}
if(isset($_REQUEST['createnews'])) { ?>
<title>News erstellen - <? echo $sitename ?></title>
<form action="" method="post">
Titel: <input type="text" name="name" size="80" maxlength="50"><br>
<textarea type="text" name="text" style="width:100%; height:72%"></textarea>
<input type="submit" name="newssubmit" value="erstellen"
<form>
<?
echo "<hr>".$footer;
}
if(isset($_POST['newssubmit'])) {
$name = $_POST['name'];
$text = $_POST['text'];
if(empty($name)) {
header ("Location: admin.php?titleerror");
}
else {
mysql_query("INSERT INTO news (name, text, username) VALUES ('".$name."', '".$text."', '".$_SESSION['adm_user_username']."')");

header ("Location: admin.php?success");
}
}
if(isset($_REQUEST['deletenews'])) {
?> <title>News löschen - <? echo $sitename ?></title> <?
$sqls33 = mysql_query("select name,username from news");
while($sql33 = mysql_fetch_array($sqls33)) {
$sql33name = str_replace(" ", "_", $sql33['name']);
?>
<form action="" method="post">
<input type="submit" value="<? echo $sql33['name']." von ".$sql33['username']." löschen"; ?>" name="<? echo $sql33name; ?>">
</form>
<?
if(isset($_POST[$sql33name])) {
$sql33correctname = str_replace("_", " ", $sql33name);
mysql_query("DELETE FROM news WHERE name = '".$sql33correctname."'");

header ("Location: admin.php?success");
}
}
echo "<hr>".$footer;
}
if(!isset($_REQUEST['create']) and !isset($_REQUEST['delete']) and !isset($_REQUEST['userdelete']) and !isset($_REQUEST['users']) and !isset($_REQUEST['usermanagement']) and !isset($_REQUEST['createnews']) and !isset($_REQUEST['deletenews']) and !isset($_REQUEST['success'])) {
?> <title>Adminpanel - <? echo $sitename ?></title><?
echo "Bitte wähle einer der oben genannten Optionen";
echo "<hr>".$footer;
}
?>