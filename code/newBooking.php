<?php
session_start();

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

$file = '../assets/bookings.json';
$home = 'Location: ../index.php';

if($name)
{
  if(file_exists($file))
  {
    $getBookingJson = file_get_contents($file);
    $bookingJson = json_decode($getBookingJson, true);
  } else {
    {
      $bookingJson = [];
    }
  }

  $bookingJson[session_id()] = ["name"=>$name,"surname"=>$surname,"email"=>$email,
  "checkIn"=>$checkIn,"checkOut"=>$checkOut,"hotel"=>$hotel];
  file_put_contents($file, json_encode($bookingJson, JSON_PRETTY_PRINT));
}

header($home);

?>
