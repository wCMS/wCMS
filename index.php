<?php  
include "includes/config.php"; 
mysql_connect($dbhost, $dbuser, $dbpasswd) or die ("Keine Verbindung zum MySQL Server!");
mysql_select_db($dbname) or die ("Die Datenbank ".$dbname." konnte nicht geöffnet werden!");
?>  
<html>  
<head>  
  <title><? echo $sitename ?></title>  
</head>  
<body>
<? $sqls = mysql_query("select name,text,username from posts");
while($sql = mysql_fetch_array($sqls)) {
$text = str_replace("\n", "<br>", $sql['text']);
echo 'Titel: '.$sql['name'].'<br><br>'.$text.'<br><br>Von '.$sql['username'].' geschrieben<hr>';
}
?>  
<? echo $show ?>  
</body>  
</html>