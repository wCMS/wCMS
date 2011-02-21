<?
include '../includes/config.php';
mysql_connect($dbhost, $dbuser, $dbpasswd) or die ("Verbindung zum MySQL Server konnte nicht hergestellt werden!");
mysql_select_db($dbname) or die ("Die Datenbank ".$dbname." konnte nicht geöffnet werden.");
if(!isset($_REQUEST['step1']) and !isset($_REQUEST['step2']) and !isset($_REQUEST['success'])) {
?>
<title>wCMS Installation</title>
<a href="index.php?step1">Mit der Installation beginnen</a>
</form>
<?
}
if(isset($_REQUEST['step1'])) {
mysql_query("CREATE TABLE `accounts` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `username` text COLLATE latin1_german1_ci NOT NULL,
  `password` text COLLATE latin1_german1_ci NOT NULL,
  `admin` int(1) unsigned zerofill NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci") or die ("Erstellung der Tabellen ist fehlgeschlagen!");
mysql_query("CREATE TABLE `posts` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `username` text COLLATE latin1_german1_ci NOT NULL,
  `name` text COLLATE latin1_german1_ci NOT NULL,
  `text` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci") or die ("Erstellung der Tabellen ist fehlgeschlagen!");
header("Location: index.php?step2");
}
if(isset($_REQUEST['step2'])) {
?> <form action="index.php?step2" method="post">
Benutzername: <input type="text" name="username" width="20"><br>
Passwort: <input type="password" name="password" width="20"><br>
<input type="submit" name="create" value="erstellen">
</form> <?
if(isset($_POST['create'])) {
$user = $_POST['username'];
$pw = sha1($_POST['password']);
$sql = ("Select username from Accounts WHERE username = '".$user."'");
$result = mysql_query($sql);
$rows = mysql_num_rows($result);
mysql_query("INSERT INTO accounts (username, password, admin) VALUES ('".$user."', '".$pw."', '1')") or die ("Fehler beim erstellen des Administrators!");
header("Location: index.php?success");
}
}
if(isset($_REQUEST['success'])) {
echo "Installation erfolgreich. Bitte löschen sie nun diesen Ordner!";
?> <br><a href="../index.php">Zum Index</a> <?
}
?>