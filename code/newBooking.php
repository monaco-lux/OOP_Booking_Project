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
  if(file_exists('Location: ../assets/bookings.json'))
  {
    $bookingJson[] = array("name"=>$name,"surname"=>$surname,"email"=>$email,
    "checkIn"=>$checkIn,"checkOut"=>$checkOut,"hotel"=>$hotel);
  } else {
    {
      $bookingJson = [];
    }
  }
  file_put_contents('Location: ../assets/bookings.json', json_encode($bookingJson, JSON_PRETTY_PRINT));
}

header('Location: ../index.php');

?>
