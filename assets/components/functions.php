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

// resize an image and save it as a thumbnail
function createThumbnail($sourcePath, $thumbnailWidth, $thumbnailHeight, $targetDirectory) {
  list($originalWidth, $originalHeight) = getimagesize($sourcePath);

  $aspectRatio = $originalWidth / $originalHeight;

  // Calculate new dimensions
  if (($thumbnailWidth / $thumbnailHeight) > $aspectRatio) {
      $thumbnailWidth = $thumbnailHeight * $aspectRatio;
  } else {
      $thumbnailHeight = $thumbnailWidth / $aspectRatio;
  }

  // Create a new image
  $thumbnail = imagecreatetruecolor($thumbnailWidth, $thumbnailHeight);

  // Load the original image
  $originalImage = imagecreatefromjpeg($sourcePath); // Change the function based on the image type

  // Resize the original image and create the thumbnail
  imagecopyresampled($thumbnail, $originalImage, 0, 0, 0, 0, $thumbnailWidth, $thumbnailHeight, $originalWidth, $originalHeight);

  // Clean up
  imagedestroy($originalImage);

  // Specify the path for the thumbnail
  $thumbnailFileName = 'thumbnail_' . basename($sourcePath);
  $thumbnailPath = $targetDirectory . $thumbnailFileName;

  // Save the thumbnail to the target directory
  imagejpeg($thumbnail, $thumbnailPath); // Change the function based on the desired thumbnail format

  // Clean up
  imagedestroy($thumbnail);

  return $thumbnailPath;
}
?>

