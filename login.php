<?php
include "includes/config.php";
?>
<title>Login - <? echo $sitename ?></title>
<?php session_start (); ?> 
<html>  
<body>  
<?php  
if (isset ($_REQUEST["error"]))  
{  
  echo "Die Zugangsdaten waren ung�ltig.";  
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
if(isset($_REQUEST['login'])) {   
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
    "(username like '".$_REQUEST["name"]."') AND ".  
    "(password = '".sha1($_REQUEST["pwd"])."')";  
$result = mysql_query ($sql);  

if (mysql_num_rows ($result) > 0)  
{   
 $data = mysql_fetch_array ($result);  
$sql2 = ("Select admin from Accounts WHERE username = '".$_POST['name']."'");
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
if(isset($_REQUEST["logout"])) {   
ob_start ();  

session_start ();  
session_unset ();  
session_destroy ();  

header ("Location: index.php");  
ob_end_flush ();  
} 
?>