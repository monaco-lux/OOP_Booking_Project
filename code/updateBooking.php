<?php
session_start(); //Initialize Session
include "classes.php";

$updateBook = new BookingForm();
$updateBook->file = "../assets/bookings.json";
$updateBook->home = "Location: ../results.php";

if(file_exists($updateBook->file))
{
  $getBookingJson = file_get_contents($updateBook->file);
  $bookingJson = json_decode($getBookingJson, true);
} else {
  {
    $bookingJson = [];
  }
}

$original = $_POST['original'];
if($original = "yes")
{
  header($updateBook->home);
  die();
} else
{
  $updateBook->hotel = $_POST['hotel'];
  $updateBook->daysStaying = $_POST['daysStaying'];
  $updateBook->ratePerDay; = $_POST['dailyRate'];
  $total = $_POST['total'];

  $bookingJson[session_id()] =
  "hotel"=>$updateBook->hotel,
  "daysStaying"=>$updateBook->daysStaying,
  "ratePerDay"=>$updateBook->ratePerDay,
  "total"=>$total
  ];
  file_put_contents($updateBook->file,json_encode($bookingJson, JSON_PRETTY_PRINT));
  header($updateBook->home);
}

?>
