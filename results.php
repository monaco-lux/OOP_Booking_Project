<?php
session_start(); //Initialize Session
include "code/classes.php";

$confirmationObj = new BookingForm();
$confirmationObj->file = "assets/bookings.json";

$hotelThings = new HotelValues();
$hotelThings->file = "assets/hotels.json";

if(file_exists($confirmationObj->file))
{
  $getBookingJson = file_get_contents($confirmationObj->file);
  $bookingJson = json_decode($getBookingJson, true);
} else {
  $bookingJson = "Did not pull data";
}

if(file_exists($hotelThings->file))
{
  $getHotel = file_get_contents($hotelThings->file);
  $valueHotel = json_decode($getHotel, true);
} else {
  $valueHotel = "Did not pull data";
}

$confirmationObj->ratePerDay = "R".($bookingJson[session_id()]['daysStaying'] * $valueHotel[$bookingJson[session_id()]['hotel']]['dailyRate']);

// figure out how to unset session on this page!
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Results and Comparison Page</title>
    <link rel="stylesheet" href="code/resultsstylesheet.css">
  </head>
  <body>
   <h1>Results of Booking</h1>
    <hr>
    <table>
      <thead>
        <th>Full Name</th>
        <th>Email</th>
        <th>Check-in and Check-out</th>
        <th>Days Staying</th>
        <th>Hotel</th>
        <th>Rate</th>
      </thead>
      <tbody>
    <?php
      foreach($bookingJson as $bookingOutput) :
        if($bookingOutput['session'] == session_id())
        {
    ?>
        <tr>
          <td><?php echo $bookingOutput['name']." ".$bookingOutput['surname'];?></td>
          <td><?php echo $bookingOutput['email']; ?></td>
          <td><?php echo $bookingOutput['checkIn']." -> ".$bookingOutput['checkOut'];?></td>
          <td><?php echo $bookingOutput['daysStaying']; ?></td>
          <td><?php echo $bookingOutput['hotel'];?></td>
          <td><?php echo $confirmationObj->ratePerDay; ?></td>
        </tr>
    <?php
        }
      endforeach;
    ?>
      <tbody>
      </thead>
    </table>
  </body>
</html>
