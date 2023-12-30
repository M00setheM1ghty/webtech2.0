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

error_reporting(E_ALL);
ini_set('display_errors', 1);

?>