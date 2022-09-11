<?php
if (!isset($_SESSION)) {
  session_start();
}

function flash($message)
{
  echo '<script language="javascript">alert("' . $message . '");</script>';
}

function redirect($location)
{
  header("location: http://cvmanager.test/" . $location);
  exit();
}
