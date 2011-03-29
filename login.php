<center>
<?php
include "lib/config.php";
include "lib/header.php";
?>
<title>Login - <? echo $sitename ?></title>
<?php session_start (); ?> 
<html>  
<body>  
<?php  
if (isset ($_GET["error"]))  
{  
  echo "Die Zugangsdaten waren ungültig.";  
}  
?>  
<form action="login.php?login" method="post">  
Benutzername: <input type="text" name="name" size="20"><br>  
Passwort: <input type="password" name="pwd" size="20"><br>  
<input type="submit" value="Login">  
</form>  
</body>  
</html

<?php
if(isset($_GET['login'])) {   
session_start ();   
$connectionid = mysql_connect ($dbhost, $dbuser, $dbpasswd);  
if (!mysql_select_db ($dbname, $connectionid))  
{  
  die ("Verbindung zur Datenbank konnte nicht hergestellt werden!");  
}  

$sql = "SELECT ".  
    "id, username, password ".  
  "FROM ".  
    "accounts ".  
  "WHERE ".  
    "(username like '".$_GET["name"]."') AND ".  
    "(password = '".sha1($_GET["pwd"])."')";  
$result = mysql_query ($sql);  

if (mysql_num_rows ($result) > 0)  
{   
 $data = mysql_fetch_array ($result);  
$sql2 = ("Select admin from accounts WHERE username = '".$_POST['name']."' and admin = '1'");
$result2 = mysql_query($sql2);
$rows = mysql_num_rows($result2);
if($rows == 1) { 
  $_SESSION["adm_user_id"] = $data["id"];  
  $_SESSION["adm_user_username"] = $data["username"];

  header ("Location: admin.php");  
}
elseif($rows == 0) {
  $_SESSION["user_id"] = $data["id"];  
  $_SESSION["user_username"] = $data["username"];
  
  header ("Location: index.php");
}
} 
else  
{  
  header ("Location: login.php?error");  
}
} 
if(isset($_GET["logout"])) {   
ob_start ();  

session_start ();  
session_unset ();  
session_destroy ();  

header ("Location: index.php");  
ob_end_flush ();  
} 
?>
</center>