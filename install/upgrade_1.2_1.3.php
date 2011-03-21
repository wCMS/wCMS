<title>wCMS Upgrade</title>
<center>
<?
include '../lib/config.php';
$cmsversion = "1.3";
if(!isset($_REQUEST['step1']) and !isset($_REQUEST['step2']) and !isset($_REQUEST['step3']) and !isset($_REQUEST['success'])) {
?>
<a href="upgrade_1.2_1.3.php?step1">Mit dem Upgrade von <? echo $version." auf ".$cmsversion ?> beginnen</a>
</form>
<?
}
if(isset($_REQUEST['step1'])) {
?>
<form action="upgrade_1.2_1.3.php?step2" method="post">
Seitenname: <input type="text" name="sitename" value="<? echo $sitename ?>" maxlength="25"><br>
Datenbank-Host: <input type="text" name="dbhost" value="<? echo $dbhost ?>" maxlength="50"><br>
Datenbank-Name: <input type="text" name="dbname" value="<? echo $dbname ?>" maxlength="25"><br>
Datenbank-Benutzer: <input type="text" name="dbuser" value="<? echo $dbuser ?>" maxlength="25"><br>
Datenbank-Passwort: <input type="password" name="dbpasswd" value="<? echo $dbpasswd ?>" maxlength="50"><br>
<input type="submit" name="configure" value="Weiter">
<?
}
if(isset($_REQUEST['step2'])) {
$configfile = "../lib/config.php";
$write = "<?php\n\$sitename = \"".$_POST['sitename']."\";\n\$dbhost = \"".$_POST['dbhost']."\";\n\$dbuser = \"".$_POST['dbuser']."\";\n\$dbpasswd = \"".$_POST['dbpasswd']."\";\n\$dbname = \"".$_POST['dbname']."\";\n//do not touch following\n\$version = \"".$cmsversion."\";\n\$footer = \"Copyright by \".\$sitename.\" - <a href=\"http://www.w-cms.tk/\" target=\"_blank\">wCMS \".\$version.\"</a>\";\n?>";
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
	echo "<br><a href='upgrade_1.2_1.3.php?step3'>Weiter</a>";

} else {
    print "Die Datei $configfile ist nicht schreibbar";
}
}
if(isset($_REQUEST['step3'])) {
include '../lib/mysql.php';
$sqlsnews = mysql_query("SELECT text FROM news");
while($sqlnews = mysql_fetch_array($sqlsnews)) {
$newstext = str_replace("\n", "<br>", $sqlnews['text']);
mysql_query("UPDATE `news` SET `text`='".$newstext."' WHERE `text`='".$sqlnews['text']."'");
}
$sqlsposts = mysql_query("SELECT text FROM posts");
while($sqlposts = mysql_fetch_array($sqlsposts)) {
$poststext = str_replace("\n", "<br>", $sqlposts['text']);
mysql_query("UPDATE `posts` SET `text`='".$poststext."' WHERE `text`='".$sqlposts['text']."'");
}
header("Location: upgrade_1.2_1.3.php?success");
echo "<a href=\"upgrade_1.2_1.3.php?success\">Weiter</a>";
}
if(isset($_REQUEST['success'])) {
echo "Upgrade erfolgreich";
?>
<form action="upgrade_1.2_1.3.php?success" method="post">
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