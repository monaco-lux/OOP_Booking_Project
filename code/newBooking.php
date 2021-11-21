<?php
session_start(); //Initialize Session
include "classes.php";

// Used to write back to a JSON file to store booking information

$newBook = new BookingForm(); // creating new instance of class
$newBook->name = trim($_POST['name']);
$newBook->surname = trim($_POST['surname']);
$newBook->email = trim($_POST['email']);
$newBook->checkIn = trim($_POST['checkIn']);
$newBook->checkOut = trim($_POST['checkOut']);
$newBook->checkInStr = strtotime(trim($_POST['checkIn']));
$newBook->checkOutStr = strtotime(trim($_POST['checkOut']));
$daysCalc= $newBook->checkOutStr - $newBook->checkInStr; //minusing dates to get value
$newBook->daysStaying=ceil(abs($daysCalc / 86400)); //Calculate # days
$newBook->hotel = trim($_POST['hotel']);
$newBook->file= "../assets/bookings.json";
$newBook->home = "Location: ../results.php";

// this is used to pull data through from json


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


// write back to array and associate with session_id()
  $bookingJson[session_id()] =
  [
    "name"=>$newBook->name,
    "surname"=>$newBook->surname,
    "email"=>$newBook->email,
    "checkIn"=>$newBook->checkIn,
    "checkOut"=>$newBook->checkOut,
    "daysStaying"=>$newBook->daysStaying,
    "hotel"=>$newBook->hotel,
    "session"=>session_id()
  ];
  file_put_contents($newBook->file,json_encode($bookingJson, JSON_PRETTY_PRINT));

}
// navigate to results.php to output
header($newBook->home);


?>
