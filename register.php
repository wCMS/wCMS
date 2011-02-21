<?php
include "includes/config.php";
?>
<title>Registrierung - <? echo $sitename ?></title>
<form action="?register" method="post">
Benutzername: <input type="text" name="username" width="20"><br>
Passwort: <input type="password" name="password" width="20"><br>
<input type="submit" name="register" value="Registrieren">
</form>
<?php
mysql_connect($dbhost, $dbuser, $dbpasswd) or die ("Verbindung zur Datenbank konnten nicht hergestellt werden!");
mysql_select_db($dbname) or die ("Die Datenbank ".$dbname." konnte nicht geöffnet werden!");
if(isset($_POST['register'])) {
$user = $_POST['username'];
$pw = sha1($_POST['password']);
$sql = ("Select username from Accounts WHERE username = '".$user."'");
$result = mysql_query($sql);
$rows = mysql_num_rows($result);
if($rows == 1) {
echo "Der Benutzername wird bereits verwendet!";
}
if($rows == 0) {
mysql_query("INSERT INTO accounts (username, password, admin) VALUES ('".$user."', '".$pw."', '0')") or die ("Fehler beim erstellen des Benutzers!");
echo "User wurde erstellt!";
}
}
?>
<hr>
<? echo $show ?>