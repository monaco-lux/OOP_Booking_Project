<?php
session_start();
include "classes.php";

$newBooking = new BookingForm();
$newBook->__set("name",trim($_POST['name']));
$newBook->__set("surname",trim($_POST['surname']));
$newBook->__set("email",trim($_POST['email']));
$newBook->__set("checkIn",trim($_POST['checkIn']));
$newBook->__set("checkOut",trim($_POST['checkOut']));
$newBook->__set("hotel",trim($_POST['hotel']));
$newBook->__set("file","../assets/bookings.json");
$newBook->__set("home","Location: ../index.php");


if($newBook->__get("name"))
{
  if(file_exists($newBook->__get("file"))
  {
    $getBookingJson = file_get_contents($newBook->__get("file"));
    $bookingJson = json_decode($getBookingJson, true);
  } else {
    {
      $bookingJson = [];
    }
  }

  $bookingJson[session_id()] = ["name"=>$newBook->__get("name"),"surname"=>$newBook->__get("surname"),"email"=>$newBook->__get("email"),
  "checkIn"=>$newBook->__get("checkIn"),"checkOut"=>$newBook->__get("checkOut"),"hotel"=>$newBook->__get("hotel")];
  file_put_contents($newBook->__get("file"), json_encode($bookingJson, JSON_PRETTY_PRINT));

}

header($newBook->__get("home"));

?>
