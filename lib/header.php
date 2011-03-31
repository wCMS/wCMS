<center><a href="index.php">News</a> | <a href="links.php">Alle Beiträge</a>
<?
session_start();
include 'config.php';
include 'mysql.php';
if(isset($_SESSION['all_user_id'])) {
echo " | <a href=\"user.php\">Userpanel</a>";
}
$sql = ("Select admin from accounts WHERE username = '".$_SESSION['adm_user_username']."' and admin = '1'");
$result = mysql_query($sql);
$rows = mysql_num_rows($result);
if($rows == 1) { 
echo " | <a href=\"admin.php\">Adminpanel</a>";
if(!isset($_SESSION['all_user_id'])) {
echo " | <a href=\"login.php\">Einloggen</a> oder <a href=\"login.php?mode=register\">Registrieren</a>";
}
else {
echo " | <a href=\"login.php?mode=logout\">Ausloggen</a>";
}
}
?>
<hr>