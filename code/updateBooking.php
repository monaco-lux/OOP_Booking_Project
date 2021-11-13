<?php
session_start(); //Initialize Session
include "classes.php";

$updateBook = new BookingForm();
$updateBook->file = "../assets/bookings.json";
$updateBook->home = "Location: ../results.php";
$restart = "Location: ../index.php";

if(file_exists($updateBook->file))
{
  $getBookingJson = file_get_contents($updateBook->file);
  $bookingJson = json_decode($getBookingJson, true);
} else {
  {
    $bookingJson = [];
  }
}

// if it comes from the original data (not comparison) it will execute an email send
$original = $_POST['original'];
if($original == "yes")
{
  $to = $bookingJson[session_id()]['email'];
  $from = "brendonn@outlook.com";
  $date = date("F j, Y");
  $subject = "New Booking Received ".$date;
  $subject2 = "Copy of book received ".$date;
  $body =
    "The following information has been submitted via webform"."<br>".
    "<ul>".
    "<li>"."<b>Full Name:</b> ".$bookingJson[session_id()]['name']." ".$bookingJson[session_id()]['surname']."</li>".
    "<li>"."<b>Email:</b> ".$bookingJson[session_id()]['email']."</li>".
    "<li>"."<b>Stay Period:</b> ".$bookingJson[session_id()]['checkIn']." -> ".$bookingJson[session_id()]['checkOut']."</li>".
    "<li>"."<b>Days staying:</b> ".$bookingJson[session_id()]['daysStaying']."</li>".
    "<li>"."<b>Hotel:</b> ".$bookingJson[session_id()]['hotel']."</li>".
    "</ul>"."<br>"."Please make contact and ensure payment is made to secure the booking!";
    $body2 =
      "COPY: The following information has been submitted via webform"."<br>".
      "<ul>".
      "<li>"."<b>Full Name:</b> ".$bookingJson[session_id()]['name']." ".$bookingJson[session_id()]['surname']."</li>".
      "<li>"."<b>Email:</b> ".$bookingJson[session_id()]['email']."</li>".
      "<li>"."<b>Stay Period:</b> ".$bookingJson[session_id()]['checkIn']." -> ".$bookingJson[session_id()]['checkOut']."</li>".
      "<li>"."<b>Days staying:</b> ".$bookingJson[session_id()]['daysStaying']."</li>".
      "<li>"."<b>Hotel:</b> ".$bookingJson[session_id()]['hotel']."</li>".
      "</ul>"."<br>"."Please make contact and ensure payment is made to secure the booking!";

  mail($to,$subject,$body,'From: ');
  mail($from,$subject2,$body2,"From: ");
  // reset id and go back to the form input
  session_regenerate_id();
  header($restart);
  die();
} else
{
  // else it will write back to the json and go back to results.php
  $updateBook->hotel = $_POST['hotel'];
  $updateBook->daysStaying = $_POST['daysStaying'];
  $updateBook->ratePerDay = $_POST['dailyRate'];
  $total = $_POST['total'];

  $bookingJson[session_id()] =
  [
  "name"=>$bookingJson[session_id()]['name'],
  "surname"=>$bookingJson[session_id()]['surname'],
  "email"=>$bookingJson[session_id()]['email'],
  "checkIn"=>$bookingJson[session_id()]['checkIn'],
  "checkOut"=>$bookingJson[session_id()]['checkOut'],
  "hotel"=>$updateBook->hotel,
  "daysStaying"=>$updateBook->daysStaying,
  "ratePerDay"=>$updateBook->ratePerDay,
  "total"=>$total,
  "session"=>$bookingJson[session_id()]['session']
  ];
  file_put_contents($updateBook->file,json_encode($bookingJson, JSON_PRETTY_PRINT));
  header($updateBook->home);
}

?>
