<?php
session_start ();  
if (!isset ($_SESSION["all_user_id"]))
{  
  header ("Location: login.php");  
}
?>