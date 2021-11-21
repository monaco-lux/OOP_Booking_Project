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
  <!-- <link rel="stylesheet" href="code/stylesheet.css"> -->
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
  <script src="/code/scripts.js"></script>
  <div class="w3-container w3-purple">
    <h1>Hotel Booking Form</h1>
  </div>
  <hr>
  <form action="code/newBooking.php" method="post" class="w3-container">
    <label for="name" class="w3-text-purple"><b>What is your name?</b></label>
    <input
    type="text"
    name="name" id="name"
    placeholder="Joe"
    autofocus required
    class="w3-input w3-border w3-round"
    >
    <br>
    <label for="surname" class="w3-text-purple"><b>What is your surname?</b></label>
    <input
    type="text"
    name="surname" id="surname"
    placeholder="Blogs"
    required
    class="w3-input w3-border w3-round"
    >
    <br>
    <label for="email" class="w3-text-purple"><b>What is your email?</b></label>
    <input
    type="email"
    name="email" id="email"
    placeholder="joeblogs@emaildomain.com"
    required
    class="w3-input w3-border w3-round"
    >
    <br>
    <div class="w3-row-padding">
      <div class="w3-third">
        <label for="checkIn">Check-in:</label>
        <input
        type="date"
        name="checkIn" id="checkIn"
        required
        class="w3-input w3-border w3-round"
        >
      </div>
      <div class="w3-third">
        <label for="checkOut">Check-out:</label>
        <input
        type="date"
        name="checkOut" id="checkOut"
        required
        class="w3-input w3-border w3-round"
        >
      </div>
    </div>
    <br>
    <label for="hotel">Hotel:</label>
    <select
    name="hotel" id="hotel"
    required
    class="w3-select w3-border w3-round"
    >
    <option value="empty">Choose a hotel</option>
    <option value="Marriot">Marriot</option>
    <option value="Hilton">Hilton</option>
    <option value="ParkIn">Park-In</option>
    <option value="CityLodge">City Lodge</option>
  </select>
  <br>
  <br>
  <button type="submit" class="w3-button w3-black">Submit</button>
</form>
</body>
</html>
