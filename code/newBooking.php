<?php
session_start(); //Initialize Session
include "classes.php";

// Used to write back to a JSON file to store booking information

$newBooking = new BookingForm();
$newBook->name = trim($_POST['name']);
$newBook->surname = trim($_POST['surname']);
$newBook->email = trim($_POST['email']);
$newBook->checkIn = trim($_POST['checkIn']);
$newBook->checkOut = trim($_POST['checkOut']);
$newBook->hotel = trim($_POST['hotel']);
$newBook->file= "../assets/bookings.json";
$newBook->home = "Location: ../results.php";


if($newBook->name)
{
  if(file_exists($newBook->file))
  {
    $getBookingJson = file_get_contents($newBook->file);
    $bookingJson = json_decode($getBookingJson, true);
  } else {
    {
      $bookingJson = [];
    }
  }


  $bookingJson[session_id()] =
  [
    "name"=>$newBook->name,
    "surname"=>$newBook->surname,
    "email"=>$newBook->email,
    "checkIn"=>$newBook->checkIn,
    "checkOut"=>$newBook->checkOut,
    "hotel"=>$newBook->hotel,
    "session"=>session_id()
  ];
  file_put_contents($newBook->file,json_encode($bookingJson, JSON_PRETTY_PRINT));

}

header($newBook->home);


?>
