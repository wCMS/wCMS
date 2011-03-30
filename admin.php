<?php
include "lib/config.php";
include "lib/adm_session.php";
include "lib/mysql.php";
include "lib/header.php";
include "lib/menu.php";
echo "<center>$menu_admin</center><hr>";
if(isset($_GET['create'])) { ?>
<title>Beitrag erstellen - <? echo $sitename ?></title>
<form action="" method="post">
Titel: <input type="text" name="name" size="80" maxlength="50"><br>
<textarea type="text" name="text" style="width:100%; height:72%"></textarea>
<input type="submit" name="submit" value="erstellen"
<form>
<?

}
if(isset($_POST['submit'])) {
$name = $_POST['name'];
$pretext = str_replace("\r\n", "\r\n<br>", $_POST['text']);
$text = str_replace("href=\"", "href=\"./redirect.php?url=", $pretext);
if(empty($name)) {
header ("Location: admin.php?error");
}
else {
mysql_query("INSERT INTO posts (name, text, username) VALUES ('".$name."', '".$text."', '".$_SESSION['adm_user_username']."')");

header ("Location: admin.php?success");
}
}
if(isset($_GET['delete'])) {
?> <title>Beitrag löschen - <? echo $sitename ?></title> <?
$sqls = mysql_query("select id,name,username from posts");
while($sql = mysql_fetch_array($sqls)) {
?>
<form action="" method="post">
<input type="submit" value="<? echo $sql['name']." von ".$sql['username']." löschen"; ?>" name="<? echo $sql['id']; ?>">
</form>
<?
if(isset($_POST[$sql['id']])) {
mysql_query("DELETE FROM posts WHERE id = '".$sql['id']."'");

header ("Location: admin.php?success");
}
}

}
if(isset($_GET['success'])) {
?> <title>Erfolgreich - <? echo $sitename ?></title> <?
echo "Aktion erfolgreich ausgeführt!<br><input type=\"button\" value=\"Zurück\" onclick=\"history.back(-1)\">";
}
if(isset($_GET['error'])) {
?> <title>Fehler - <? echo $sitename ?></title> <?
echo "Dir ist ein Fehler unterlaufen!<br><input type=\"button\" value=\"Zurück\" onclick=\"history.back(-1)\">";
}
if(isset($_GET['userdelete'])) {
?> <title>Benutzer löschen - <? echo $sitename ?></title> <?
$sqls = mysql_query("select id,username from accounts WHERE safe = '0'");
while($sql = mysql_fetch_array($sqls)) {
?>
<form action="" method="post">
<input type="submit" value="<? echo $sql['username']." löschen"; ?>" name="<? echo $sql['id']; ?>">
</form>
<?
if(isset($_POST[$sql['username']])) {
mysql_query("DELETE FROM accounts WHERE username = '".$sql['id']."' and safe = '0'");

header ("Location: admin.php?success");
}
}

}
if(isset($_GET['users'])) {
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

}
if(isset($_GET['usermanagement'])) {
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

}
if(isset($_GET['createnews'])) { ?>
<title>News erstellen - <? echo $sitename ?></title>
<form action="" method="post">
Titel: <input type="text" name="name" size="80" maxlength="50"><br>
<textarea type="text" name="text" style="width:100%; height:72%"></textarea>
<input type="submit" name="newssubmit" value="erstellen"
<form>
<?

}
if(isset($_POST['newssubmit'])) {
$name = $_POST['name'];
$pretext = str_replace("\r\n", "\r\n<br>", $_POST['text']);
$text = str_replace("href=\"", "href=\"./redirect.php?url=", $pretext);
if(empty($name)) {
header ("Location: admin.php?titleerror");
}
else {
mysql_query("INSERT INTO news (name, text, username) VALUES ('".$name."', '".$text."', '".$_SESSION['adm_user_username']."')");

header ("Location: admin.php?success");
}
}
if(isset($_GET['deletenews'])) {
?> <title>News löschen - <? echo $sitename ?></title> <?
$sqls33 = mysql_query("select id,name,username from news");
while($sql33 = mysql_fetch_array($sqls33)) {
?>
<form action="" method="post">
<input type="submit" value="<? echo $sql33['name']." von ".$sql33['username']." löschen"; ?>" name="<? echo $sql33['id']; ?>">
</form>
<?
if(isset($_POST[$sql33['id']])) {
mysql_query("DELETE FROM news WHERE id = '".$sql33['id']."'");

header ("Location: admin.php?success");
}
}

}
if(empty($_GET)) {
?> <title>Adminpanel - <? echo $sitename ?></title><?
echo "Bitte wähle einer der oben genannten Optionen";

}
if(isset($_GET['postsedit'])) {
?> <title>Beitrag editieren - <? echo $sitename ?></title> <?
$sqls = mysql_query("select id,name from posts");
while($sql = mysql_fetch_array($sqls)) {
?>
<form action="" method="post">
<input type="submit" value="<? echo $sql['name']." editieren"; ?>" name="<? echo $sql['id']; ?>">
</form>
<?
}
if(isset($_POST[$sql['id']])) {
$id = $_POST[$sql['id']];
$sql = mysql_query("select name,text from posts where id ='".$id."'");
$pretext = str_replace("<br>", "\r\n", $sql['text']);
?>
<form action="" method="post">
Titel: <input type="text" name="name" size="80" maxlength="50" value="<? echo $sql['name']; ?>"><br>
<textarea type="text" name="text" style="width:100%; height:72%"><? echo $pretext; ?></textarea>
<input type="submit" name="postedit" value="editieren"
<form>
<?
}
if(isset($_POST['postedit'])) {
$text = str_replace("\r\n", "\r\n<br>", $_POST['text']);
mysql_query("update posts set text='".$text."' where id = '".$id."'");
mysql_query("update posts set name='".$_POST['name']."' where id = '".$id."'");

header ("Location: admin.php?success");
}
}
echo "<hr>$footer";
?>