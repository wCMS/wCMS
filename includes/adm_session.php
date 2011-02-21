<?php 
session_start ();  
if (!isset ($_SESSION["adm_user_id"]))
{  
  header ("Location: login.php");  
}
?>