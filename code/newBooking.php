<?php

$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$checkIn = $_POST['checkIn'];
$checkOut = $_POST['checkOut'];
$hotel = $_POST['hotel'];

$name = trim($name);
$surname = trim($surname);
$email = trim($email);
$checkIn = trim($checkIn);
$checkOut = trim($checkOut);
$hotel = trim($hotel);

if($name)
{
  if(file_exists('Location: assets/booking.json'))
  {
    $bookingJson = file_get_contents('Location: code/booking.json');
    $bookingJson = json_decode($bookingJson, true);
  } else {
    {
      $bookingJson = [];
    }
  }
  file_put_contents('Location: code/booking.json', json_encode($bookingJson, JSON_PRETTY_PRINT));
}

header

?>
