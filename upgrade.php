<title>wCMS Upgrade</title>
<center>
<?
if(file_exists("lib/install")) {
echo "Ist noch nicht installiert! <a href=\"install.php\">Klicke hier um es zu installieren</a>";
die;
}
else {
include 'lib/config.php';
$cmsversion = "1.2";

if(!isset($_REQUEST['step1']) and !isset($_REQUEST['step2']) and !isset($_REQUEST['step3']) and !isset($_REQUEST['success'])) {
if($version == $cmsversion) {
echo "Kein Upgrade möglich.<br>Es wird bereits die aktuelle Version genutzt oder es wurden keine Veränderungen an der Datenbank vorgenommen";
die;
}
?>
<a href="upgrade.php?step1">Mit dem Upgrade von <? echo $version." auf ".$cmsversion ?> beginnen</a>
</form>
<?
}
if(isset($_REQUEST['step1'])) {
?>
<form action="upgrade.php?step2" method="post">
Seitenname: <input type="text" name="sitename" maxlength="25"><br>
Datenbank-Host: <input type="text" name="dbhost" maxlength="50"><br>
Datenbank-Name: <input type="text" name="dbname" maxlength="25"><br>
Datenbank-Benutzer: <input type="text" name="dbuser" maxlength="25"><br>
Datenbank-Passwort: <input type="password" name="dbpasswd" maxlength="50"><br>
<input type="submit" name="configure" value="Weiter">
<?
}
if(isset($_REQUEST['step2'])) {
$configfile = "lib/config.php";
$write = "<?php\n\$sitename = \"".$_POST['sitename']."\";\n\$dbhost = \"".$_POST['dbhost']."\";\n\$dbuser = \"".$_POST['dbuser']."\";\n\$dbpasswd = \"".$_POST['dbpasswd']."\";\n\$dbname = \"".$_POST['dbname']."\";\n//do not touch following\n\$version = \"".$cmsversion."\";\n\$footer = \"Copyright by \".\$sitename.\" - wCMS \".\$version;\n?>";
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
	echo "<br><a href='upgrade.php?step3'>Weiter</a>";

} else {
    print "Die Datei $configfile ist nicht schreibbar";
}
}
if(isset($_REQUEST['step3'])) {
include 'lib/mysql.php';
mysql_query("CREATE TABLE `news` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `username` text COLLATE latin1_german1_ci NOT NULL,
  `name` text COLLATE latin1_german1_ci NOT NULL,
  `text` text COLLATE latin1_german1_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci") or die (mysql_error());
header("Location: upgrade.php?success");
}
if(isset($_REQUEST['success'])) {
echo "Upgrade erfolgreich";
?>
<form action="upgrade.php?success" method="post">
<input type="submit" name="complete" value="Upgrade abschließen">
</form>
<?
if(isset($_POST['complete'])) {
header ("Location: index.php");
echo "Wenn die automatische Weiterleitung nicht funktioniert, klicke bitte <a href=\"index.php\">HIER</a>";
}
}
}
?>
</center>