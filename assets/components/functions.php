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

// calculate charge for one reservation
function calculate_room_charge($room_numbers, $room_prices, $stayDuration)
{
  $total = 0;
  for ($i = 0; $i < count($room_numbers); $i++) {
    $rprice = $room_prices[$i];
    $total += ($stayDuration * $rprice);
  }
  return $total;
}

//calculate additional costs
function calculate_additional_charges($parking, $breakfast, $pets, $person_amount, $stayDuration)
{
  $total = 0;
  if ($parking)
    $total += 20;
  if ($pets)
    $total += 50;
  if ($breakfast) {
    $total += ((10 * $person_amount) * $stayDuration);
  }
  return $total;
}
?>