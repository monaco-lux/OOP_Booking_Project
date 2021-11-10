<?php
session_start(); //Initialize Session

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hotel Booking Form</title>
    <link rel="stylesheet" href="code/stylesheet.css">
  </head>
  <body>
    <script src="/code/scripts.js"></script>
    <h1>Hotel Booking Form</h1>
    <hr>
    <form action="code/newBooking.php" method="post">
      <div class="group1">
        <label for="name">What is your name?</label>
  		   <input
          type="text"
          name="name" id="name"
          placeholder="Joe"
          autofocus required
        >
      </div>
      <br>
      <div class="group1">
        <label for="surname">What is your surname?</label>
        <input
          type="text"
          name="surname" id="surname"
          placeholder="Blogs"
          required
        >
      </div>
      <br>
      <div class="group1">
        <label for="email">What is your email?</label>
        <input
          type="email"
          name="email" id="email"
          placeholder="joeblogs@emaildomain.com"
          required
        >
      </div>
      <br>
      <div class="group1-inline">
        <label for="checkIn">Check-in:</label>
        <input
          type="date"
          name="checkIn" id="checkIn"
          required
        >
      </div>
      <div class="group1-inline">
        <label for="checkOut">Check-out:</label>
        <input
          type="date"
          name="checkOut" id="checkOut"
          required
        >
      </div>
      <br>
      <br>
      <br>
      <br>
      <div class="group1">
        <label for="hotel">Hotel:</label>
        <select
          name="hotel" id="hotel"
          required
        >
          <option value="empty">Choose a hotel</option>
          <option value="Marriot">Marriot</option>
          <option value="Hilton">Hilton</option>
          <option value="ParkIn">Park-In</option>
          <option value="CityLodge">City Lodge</option>
        </select>
      </div>
      <br>
      <hr>
      <br>
        <button type="submit">Submit</button>
    </form>
  </body>
</html>
