<?php
session_start(); //Initialize Session
include "code/classes.php";

// this section of code in the header is repeated from results.php

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
$dailyRate = $valueHotel[$bookingJson[session_id()]['hotel']]['dailyRate'];


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comparison Page</title>
    <link rel="stylesheet" href="code/resultsstylesheet.css">
  </head>
  <body>
   <h1>Comparison Page</h1>
    <hr>
    <h2>Original Choice</h2>
    <table>
      <thead>
        <th>Full Name</th>
        <th>Email</th>
        <th>Check-in and Check-out</th>
        <th>Days Staying</th>
        <th>Hotel</th>
        <th>Daily Rate</th>
        <th>Total to Pay</th>
        <th>Book this?</th>
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
          <td><?php echo "R".$dailyRate ?></td>
          <td><?php echo $confirmationObj->ratePerDay; ?></td>
          <td>
            <form action="code/updateBooking.php" method="post">
              <input type="hidden" id="original" name="original" value="yes">
              <button type-type="submit">Book</button>
            </form>
          </td>
        </tr>
    <?php
        }
      endforeach;
    ?>
      <tbody>
      </thead>
    </table>
    <h3>Comparison Options</h3>
    <table>
      <thead>
        <th>Hotel</th>
        <th>Days Staying</th>
        <th>Daily Rate</th>
        <th>Total to Pay</th>
        <th>Change values?</th>
      </thead>
      <tbody>
    <?php
      // below looks complicated but its just to show hotel outputs from json
      foreach($valueHotel as $hotelOutput) :
        if($bookingJson[session_id()]['hotel'] != $hotelOutput['hotel'])
        {
    ?>
    <form action="code/updateBooking.php" method="post">
      <tr>
        <td>
          <?php echo $hotelOutput['hotel'];?>
          <input type="hidden" id="hotel" name="hotel" value=<?php echo $hotelOutput['hotel'];?>>
        </td>
        <td>
          <?php echo $bookingJson[session_id()]['daysStaying'];?>
          <input type="hidden" id="daysStaying" name="daysStaying" value=<?php echo $bookingJson[session_id()]['daysStaying'];?>>
        </td>
        <td>
          <?php echo "R".$hotelOutput['dailyRate']; ?>
          <input type="hidden" id="dailyRate" name="dailyRate" value=<?php echo $hotelOutput['dailyRate'];?>>
        </td>
        <td>
          <?php echo "R".$bookingJson[session_id()]['daysStaying'] * $hotelOutput['dailyRate']; ?>
          <input type="hidden" id="total" name="total" value=<?php echo $bookingJson[session_id()]['daysStaying'] * $hotelOutput['dailyRate'];?>>
        </td>
        <td>
          <input type="hidden" id="original" name="original" value="no">
          <button type-type="submit">Select</button>
        </td>
      <tr>
    </form>
    <?php
        }
      endforeach;
    ?>
  </body>
</html>
