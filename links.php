<?php
include "lib/config.php";
include "lib/mysql.php";
include "lib/header.php";
if(isset($_REQUEST['view_all_posts'])) {
}
else{
$selectlinks = mysql_query("select name,text,username from posts");
while($selectlink = mysql_fetch_array($selectlinks)) {
$links = str_replace(" ", "-", $selectlink['name']);
$content = str_replace("\n", "<br>", $selectlink['text']);
if(isset($_REQUEST[$links])) {
?><title><? echo $selectlink['name']." - ".$sitename ?></title><?
echo "Titel: ".$selectlink['name'];
echo "<br><br>";
echo $content;
echo "<br><br>";
echo "Von ".$selectlink['username']." geschrieben";
}
}
}
if(!isset($_REQUEST[$links])) {
?><title>Alle Beiträge - <? echo $sitename ?></title><?
$sqls = mysql_query("select name from posts");
while($sql = mysql_fetch_array($sqls)) {
$link = str_replace(" ", "-", $sql['name']);
echo "<a href=\"links.php?".$link."\">".$sql['name']."</a><br>";
}
}
echo "<hr>".$footer;
?>