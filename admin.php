<?php
include "lib/config.php";
include "lib/adm_session.php";
include "lib/mysql.php";
include "lib/header.php";
?><a href="admin.php?create">Beitrag erstellen</a> | <a href="admin.php?delete">Beitrag l�schen</a> | <a href="admin.php?userdelete">Benutzer l�schen</a> | <a href="admin.php?users">Benutzerliste</a> | <a href="admin.php?usermanagement">Benutzerverwaltung</a><hr><?
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
?> <title>Beitrag l�schen - <? echo $sitename ?></title> <?
$sqls = mysql_query("select name,username from posts");
while($sql = mysql_fetch_array($sqls)) {
?>
<form action="" method="post">
<input type="submit" value="<? echo $sql['name']." von ".$sql['username']." l�schen"; ?>" name="<? echo $sql['name']; ?>">
</form>
<?
if(isset($_POST[$sql['name']])) {
mysql_query("DELETE FROM posts WHERE name = '".$sql['name']."'");

header ("Location: admin.php?success");
}
}
echo "<hr>".$footer;
}
if(isset($_REQUEST['success'])) {
echo "Aktion erfolgreich ausgef�hrt!<br><input type=\"button\" value=\"Zur�ck\" onclick=\"history.back(-1)\">";
}
if(isset($_REQUEST['titleerror'])) {
echo "Bitte w�hle einen Titel!<br><input type=\"button\" value=\"Zur�ck\" onclick=\"history.back(-1)\">";
}
if(isset($_REQUEST['userdelete'])) {
?> <title>Benutzer l�schen - <? echo $sitename ?></title> <?
$sqls = mysql_query("select username from accounts WHERE safe = '0'");
while($sql = mysql_fetch_array($sqls)) {
?>
<form action="" method="post">
<input type="submit" value="<? echo $sql['username']." l�schen"; ?>" name="<? echo $sql['username']; ?>">
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
<input type="submit" value="<? echo $sql['username']." zum Admin bef�rdern"; ?>" name="<? echo $sql['username']; ?>">
</form>
<?
if(isset($_POST[$sql['username']])) {
mysql_query("UPDATE accounts SET admin = '1' WHERE username = '".$sql['username']."'");

header ("Location: admin.php?success");
}
}
echo "<hr>".$footer;
}
if(!isset($_REQUEST['create']) and !isset($_REQUEST['delete']) and !isset($_REQUEST['userdelete']) and !isset($_REQUEST['users']) and !isset($_REQUEST['usermanagement'])) {
?> <title>Adminpanel - <? echo $sitename ?></title><?
echo "<hr>".$footer;
}
?>