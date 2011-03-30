<?php
include "lib/config.php";
include "lib/mysql.php";
include "lib/header.php";
if(isset($_GET['id'])) {
$id = $_GET['id'];
$datas = mysql_query("select name,text,username from posts where id='".$id."'");
while($data = mysql_fetch_array($datas)) {
?><title><? echo $data['name']." - ".$sitename ?></title><?
echo "Titel: ".$data['name'];
echo "<br><br>";
echo $data['text'];
echo "<br><br>";
echo "Von ".$data['username']." geschrieben";
}
}
if(empty($_GET)) {
?><title>Alle Beiträge - <? echo $sitename ?></title><?
$sqls = mysql_query("select id, name from posts");
while($sql = mysql_fetch_array($sqls)) {
echo "<a href=\"links.php?id=".$sql['id']."\">".$sql['name']."</a><br>";
}
}
echo "<hr>".$footer;
?>