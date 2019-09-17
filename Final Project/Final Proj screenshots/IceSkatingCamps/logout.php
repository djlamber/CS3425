<?php
  session_start();
  session_destroy();
  echo 'You\'ve been logged out';
  header("LOCATION:home.html");
  return;
?>