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
$dailyRate = $valueHotel[$bookingJson[session_id()]['hotel']]['dailyRate'];

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
    <h2>You are booking...</h2>
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
          <td>
            <?php
            if (isset($bookingOuput['dailyRate']))
            {
              echo "R".$bookingOutput['dailyRate'];
            } else
            {
              echo "R".$dailyRate;
            }
            ?>
          </td>
          <td>
            <?php
            if (isset($bookingOuput['total']))
            {
              echo $bookingOutput['total'];
            } else
            {
              echo $confirmationObj->ratePerDay;
            }
            ?>
          </td>
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
    <form action="comparison.php" method="post" id="confirmForm">
      <p>Alternatively, you can compare to other options available:</p>
      <button type="submit" name="confirm">Compare</button>
    </form>
  </body>
</html>
