<?php  
if(file_exists("lib/config.php.new")) {
echo "<center>Das Script ist nicht installiert! Jetzt installieren? <a href=\"install/install.php\">Ja</a> oder <a href=\"index.php\">Nein</a></center>";
die;
}
else {
include "lib/config.php"; 
include "lib/mysql.php";
include "lib/header.php";
?>  
<html>  
<head>  
  <title><? echo $sitename ?></title>  
</head>  
<body>
<? $sqls = mysql_query("select name,text,username from news");
while($sql = mysql_fetch_array($sqls)) {
$text = $sql['text'];
echo 'Titel: '.$sql['name'].'<br><br>'.$text.'<br><br>Von '.$sql['username'].' geschrieben<hr>';
}
}
?>  
<? echo $footer ?>  
</body>  
</html>