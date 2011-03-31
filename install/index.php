<title>wCMS Installation</title>
<center>
<?
$cmsversion = "1.4";
if(empty($_GET)) {
if(file_exists("../lib/config.php")) {
echo "<a href=\"upgrade.php\">Upgrade hier</a>";
header("Location: upgrade.php");
die;
}
else {
rename("../lib/config.php.new", "../lib/config.php");
}
?>
<a href="index.php?step=1">Mit der Installation beginnen</a>
</form>
<?
header("Location: index.php?step=1");
}
if(isset($_GET['step'])) {
if($_GET['step'] == 1) {
?>
<form action="index.php?step=2" method="post">
Seitenname: <input type="text" name="sitename" maxlength="25"><br>
Datenbank-Host: <input type="text" name="dbhost" maxlength="50"><br>
Datenbank-Name: <input type="text" name="dbname" maxlength="25"><br>
Datenbank-Benutzer: <input type="text" name="dbuser" maxlength="25"><br>
Datenbank-Passwort: <input type="password" name="dbpasswd" maxlength="50"><br>
<input type="submit" name="configure" value="Weiter">
<?
}
if($_GET['step'] == 2) {
$configfile = "../lib/config.php";
$write = "<?php\n\$sitename = \"".$_POST['sitename']."\";\n\$dbhost = \"".$_POST['dbhost']."\";\n\$dbuser = \"".$_POST['dbuser']."\";\n\$dbpasswd = \"".$_POST['dbpasswd']."\";\n\$dbname = \"".$_POST['dbname']."\";\n//do not touch following\n\$version = \"".$cmsversion."\";\n\$footer = \"Copyright by \".\$sitename.\" - <a href='http://www.w-cms.tk/' target='_blank\'>wCMS \".\$version.\"</a>\";\n?>";
if (is_writable($configfile)) {

    if (!$handle = fopen($configfile, "w+")) {
         print "Kann die Datei $configfile nicht öffnen";
         exit;
    }
    if (!fwrite($handle, $write)) {
        print "Kann in die Datei $configfile nicht schreiben";
        exit;
    }

    print "Konfiguration erfolgreich!";

    fclose($handle);
	echo "<br><a href='index.php?step=3'>Weiter</a>";
	header("Location: index.php?step=3");

} else {
    print "Die Datei $configfile ist nicht schreibbar";
}
}
if($_GET['step'] == 3) {
include '../lib/config.php';
include '../lib/mysql.php';
mysql_query("CREATE TABLE `accounts` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `username` text COLLATE latin1_german1_ci NOT NULL,
  `password` text COLLATE latin1_german1_ci NOT NULL,
  `admin` int(1) unsigned zerofill NOT NULL,
  `safe` int(1) unsigned zerofill NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci") or die (mysql_error());
mysql_query("CREATE TABLE `posts` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `username` text COLLATE latin1_german1_ci NOT NULL,
  `name` text COLLATE latin1_german1_ci NOT NULL,
  `text` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci") or die (mysql_error());
mysql_query("CREATE TABLE `news` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `username` text COLLATE latin1_german1_ci NOT NULL,
  `name` text COLLATE latin1_german1_ci NOT NULL,
  `text` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci") or die (mysql_error());
header("Location: index.php?step=4");
}
if($_GET['step'] == 4) {
?> <form action="index.php?step=4" method="post">
Benutzername: <input type="text" name="username" maxlength="25"><br>
Passwort: <input type="password" name="password" maxlength="25"><br>
<input type="submit" name="create" value="erstellen">
</form> <?
if(isset($_POST['create'])) {
include '../lib/config.php';
include '../lib/mysql.php';
$user = $_POST['username'];
$pw = sha1($_POST['password']);
$sql = ("Select username from accounts WHERE username = '".$user."'");
$result = mysql_query($sql);
$rows = mysql_num_rows($result);
mysql_query("INSERT INTO accounts (username, password, admin, safe) VALUES ('".$user."', '".$pw."', '1', '1')") or die ("Fehler beim erstellen des Administrators!");
mysql_query("INSERT INTO news (username, name, text) VALUES ('".$user."', 'Glückwunsch!', 'Glückwunsch!\nDu hast erfolgreich wCMS ".$version." installiert!\nDu kannst diesen Newseintrag im Adminpanel löschen!\n\nMit freundlichen Grüßen, dein wCMS Team')") or die("Fehler beim erstellen der Erstnews!");
header("Location: index.php?success");
}
}
}
if(isset($_GET['success'])) {
echo "Installation erfolgreich";
?>
<form action="index.php?success" method="post">
<input type="submit" name="complete" value="Installation abschließen">
</form>
<?
if(isset($_POST['complete'])) {
unlink("../lib/install");
header ("Location: ../index.php");
echo "Wenn die automatische Weiterleitung nicht funktioniert, klicke bitte <a href=\"../index.php\">HIER</a>";
}
}
?>
</center>