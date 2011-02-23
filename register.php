<?php
include "lib/config.php";
include "lib/header.php";
?>
<title>Registrierung - <? echo $sitename ?></title>
<form action="?register" method="post">
Benutzername: <input type="text" name="username" width="20"><br>
Passwort: <input type="password" name="password" width="20"><br>
<input type="submit" name="register" value="Registrieren">
</form>
<?php
include "lib/mysql.php";
if(isset($_POST['register'])) {
$user = $_POST['username'];
$pw = sha1($_POST['password']);
$sql = "Select username from accounts WHERE username = '".$user."'";
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
<? echo $footer ?>