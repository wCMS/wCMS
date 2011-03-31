<title>wCMS Upgrade</title>
<center>
<?
include '../lib/config.php';
$cmsversion = "1.4";
if(empty($_GET)) {
?>
<a href="upgrade_1.3_1.4.php?step=1">Mit dem Upgrade von <? echo $version." auf ".$cmsversion ?> beginnen</a>
</form>
<?
}
if(isset($_GET['step'])) {
if($_GET['step'] == 1) {
?>
<form action="upgrade_1.3_1.4.php?step=2" method="post">
Seitenname: <input type="text" name="sitename" value="<? echo $sitename ?>" maxlength="25"><br>
Datenbank-Host: <input type="text" name="dbhost" value="<? echo $dbhost ?>" maxlength="50"><br>
Datenbank-Name: <input type="text" name="dbname" value="<? echo $dbname ?>" maxlength="25"><br>
Datenbank-Benutzer: <input type="text" name="dbuser" value="<? echo $dbuser ?>" maxlength="25"><br>
Datenbank-Passwort: <input type="password" name="dbpasswd" value="<? echo $dbpasswd ?>" maxlength="50"><br>
<input type="submit" name="configure" value="Weiter">
<?
}
if($_GET['step'] == 2) {
$configfile = "../lib/config.php";
$write = "<?php\n\$sitename = \"".$_POST['sitename']."\";\n\$dbhost = \"".$_POST['dbhost']."\";\n\$dbuser = \"".$_POST['dbuser']."\";\n\$dbpasswd = \"".$_POST['dbpasswd']."\";\n\$dbname = \"".$_POST['dbname']."\";\n//do not touch following\n\$version = \"".$cmsversion."\";\n\$footer = \"Copyright by \".\$sitename.\" - <a href='http://www.w-cms.tk/' target='_blank'>wCMS \".\$version.\"</a>\";\n?>";
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
	echo "<br><a href='upgrade_1.3_1.4.php?step=3'>Weiter</a>";
	header("Location: upgrade_1.3_1.4.php?step=3");

} else {
    print "Die Datei $configfile ist nicht schreibbar";
}
}
if($_GET['step'] == 3) {
include '../lib/mysql.php';
mysql_query("CREATE TABLE `pm` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE latin1_german1_ci NOT NULL,
  `from` text COLLATE latin1_german1_ci NOT NULL,
  `to` text COLLATE latin1_german1_ci NOT NULL,
  `text` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci") or die(mysql_error());
$sqlsnews = mysql_query("SELECT text FROM news");
while($sqlnews = mysql_fetch_array($sqlsnews)) {
$newstext = str_replace("href=\"", "href=\"./redirect.php?url=", $sqlnews['text']);
mysql_query("UPDATE `news` SET `text`='".$newstext."' WHERE `text`='".$sqlnews['text']."'");
}
$sqlsposts = mysql_query("SELECT text FROM posts");
while($sqlposts = mysql_fetch_array($sqlsposts)) {
$poststext = str_replace("href=\"", "href=\"./redirect.php?url=", $sqlposts['text']);
mysql_query("UPDATE `posts` SET `text`='".$poststext."' WHERE `text`='".$sqlposts['text']."'");
}
header("Location: upgrade_1.3_1.4.php?success");
echo "<a href=\"upgrade_1.3_1.4.php?success\">Weiter</a>";
}
}
if(isset($_GET['success'])) {
echo "Upgrade erfolgreich";
?>
<form action="upgrade_1.3_1.4.php?success" method="post">
<input type="submit" name="complete" value="Upgrade abschließen">
</form>
<?
if(isset($_POST['complete'])) {
header ("Location: ../index.php");
echo "Wenn die automatische Weiterleitung nicht funktioniert, klicke bitte <a href=\"../index.php\">HIER</a>";
}
}
?>
</center>