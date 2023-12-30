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

?>