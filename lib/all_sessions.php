<?php
session_start ();  
if (!isset ($_SESSION["adm_user_id"]) or !isset($_SESSION["user_id"]))
{  
  header ("Location: login.php");  
}
?>