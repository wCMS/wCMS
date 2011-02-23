<?php  
if(file_exists("install.php")) {
unlink("install.php");
}
include "lib/config.php"; 
include "lib/mysql.php";
include "lib/header.php";
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
<? echo $footer ?>  
</body>  
</html>