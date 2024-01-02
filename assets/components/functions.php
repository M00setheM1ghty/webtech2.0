<?php
function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function increment_error_var($error_var)
{
  $error_var += 1;
}

if ($debug) {
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
}

function setToken()
{
  return md5(uniqid(rand(), true));
}
?>