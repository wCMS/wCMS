<?php
include "lib/config.php";
include "lib/mysql.php";
include "lib/header.php";
$selectlinks = mysql_query("select id,name,text,username from posts");
while($selectlink = mysql_fetch_array($selectlinks)) {
$content = str_replace("\n", "<br>", $selectlink['text']);
if(isset($_REQUEST[$selectlink['id']])) {
?><title><? echo $selectlink['name']." - ".$sitename ?></title><?
echo "Titel: ".$selectlink['name'];
echo "<br><br>";
echo $content;
echo "<br><br>";
echo "Von ".$selectlink['username']." geschrieben";
}
}
if(isset($_REQUEST['all'])) {
?><title>Alle Beiträge - <? echo $sitename ?></title><?
$sqls = mysql_query("select id, name from posts");
while($sql = mysql_fetch_array($sqls)) {
echo "<a href=\"links.php?".$sql['id']."\">".$sql['name']."</a><br>";
}
}
echo "<hr>".$footer;
?>