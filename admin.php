<?
include "includes/config.php";
include "includes/adm_session.php";
mysql_connect($dbhost, $dbuser, $dbpasswd) or die ("Keine Verbindung zum MySQL Server!");
mysql_select_db($dbname) or die ("Die Datenbank ".$dbname." konnte nicht geöffnet werden!");
?><a href="admin.php?create">Beitrag erstellen</a> | <a href="admin.php?delete">Beitrag löschen</a><hr><?
if(isset($_REQUEST['create'])) { ?>
<title>Beitrag erstellen - <? echo $sitename ?></title>
<form action="" method="post">
Titel: <input type="text" name="name" size="80" maxlength="50"><br>
<textarea type="text" name="text" style="width:100%; height:72%"></textarea>
<input type="submit" name="submit" value="erstellen"
<form>
<?
if(isset($_POST['submit'])) {
$name = $_POST['name'];
$text = $_POST['text'];
mysql_query("INSERT INTO posts (name, text, username) VALUES ('".$name."', '".$text."', '".$_SESSION['adm_user_username']."')");

header ("Location: admin.php?success");
}
}
if(isset($_REQUEST['delete'])) {
?> <title>Beitrag löschen - <? echo $sitename ?></title> <?
$sqls = mysql_query("select name,username from posts");
while($sql = mysql_fetch_array($sqls)) {
?>
<form action="" method="post">
<input type="submit" value="<? echo $sql['name']." von ".$sql['username']." löschen"; ?>" name="<? echo $sql['name']; ?>">
</form>
<?
if(isset($_POST[$sql['name']])) {
mysql_query("DELETE FROM posts WHERE name = '".$sql['name']."'");

header ("Location: admin.php?success");
}
}
}
if(!isset($_REQUEST['create']) and !isset($_REQUEST['delete'])) {
?> <title>Adminpanel - <? echo $sitename ?></title><?
}
if(isset($_REQUEST['success'])) {
echo "Aktion erfolgreich ausgeführt! <br> <a href='admin.php'>Zurück zum Adminpanel</a>";
}
?>