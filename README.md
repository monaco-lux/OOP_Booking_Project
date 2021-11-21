# OOP_Booking_Project
Created to comply with CodeSpace OOP Booking project

## index.php
index.php is where the booking form is hosted. The first thing that is done is that we initailize a PHP session in order to get a session_id() - which is used to identify the user throughout the booking process. 
Thereafter, we begin by including the W3.CSS stylesheet (which is an easy workaroudn for consistent styling) and jQUery for the date script.
### Date Script
The date script is simple. We start by defining the date of today so that the user cannot choose any date before today. This works on loading index.php. Therefater, we define the interaction between the two dates to ensure that checkOut cannot choose a date before the checkIn date.
```
  <script>
    var today = new Date(); // get the current date
    var dd = today.getDate(); //get the day from today.
    var mm = today.getMonth()+1; //get the month from today +1 because january is 0!
    var yyyy = today.getFullYear(); //get the year from today

    //if day is below 10, add a zero before (ex: 9 -> 09)
    if(dd<10) {
      dd='0'+dd
    }

  //like the day, do the same to month (3->03)
    if(mm<10) {
      mm='0'+mm
    }

  //finally join yyyy mm and dd with a "-" between then
    today = yyyy+'-'+mm+'-'+dd;
    function todayDate(){
      document.getElementById("checkIn").setAttribute("min", today);
    }

    // make sure that you cannot choose any days before today
    $(document).ready(function(){
      $('#checkIn').attr('min', todayDate());
    });

    // set the choice for checkOut to any day from the chosen date
    function setDate()
    {
      var minToDate = document.getElementById("checkIn").value;
      document.getElementById("checkOut").setAttribute("min", minToDate);
    }
  </script>
```
### Form
The HTML form is styled according to W3.CSS and is defined to be responsive. The elements from here will be passed to newBooking.PHP to be processed and output on results.php.
## newBooking.php
The purpose of this piece of code is to act as a script to process form data. It uses encapsulated properties from the BookingForm object class to store the post data. We trim the entry data to ensure the data comes in consistently. The data is then defined to each encapsulated property.
```
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
```

Thereafter, we make use of JSON to store the data to be transferred to results.php. Everytime the newBooking.PHP script is run, it will write back the data to the JSON file based on the user's current session_id(). This allows consistent transfer of data between screens. 
```
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
  ```
 ## results.php
 The purpose of results.PHP is to output the JSON data written back based on the users id. The user can then choose to book the options chosen, or to choose a different hotel or compare the pricing. We intialize two objects: BookingForm and HotelValues. These bring through encapsulated properties that will be used to store the translated json files from the booking form and the stored hotel data. 
```
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
 ```
 
 We next calculate some values that need to be used throughout the booking process, these include the total booking value and the rate per day.
  ```
  $confirmationObj->ratePerDay = "R".($bookingJson[session_id()]['daysStaying'] * $valueHotel[$bookingJson[session_id()]['hotel']]['dailyRate']);
$dailyRate = $valueHotel[$bookingJson[session_id()]['hotel']]['dailyRate'];
  ```
  
The values are then outputted into a table using a PHP foreach. If the user selects "book", a value of "original=yes" is assigned to the values sent through for purposes of the updateBooking.PHP script - which then populates an email to be sent. Otherwise, the comparison.PHP page is called when the user selects "Compare".

## compare.php
compate.php operates mostly the same as results.PHP - however, it allows you to update the bookings.json with other hotel values if you choose. If you select "Select" on any of the other hotel values, updateBooking.PHP will be called and the scripts inside there will be run.

##updateBooking.php
updateBooking.PHP works with an if which checks to see if the $_POST data reaching it has a value of "original=yes" or "original=no". If original=yes, a mail is populated and sent. The session_id() is regenerated for a new session and the script redirects to index.PHP.
```
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
```

If original=no, the bookings.json file is updated with the new values and the script redirects back to results.php for the user to either book or recompare.
```
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
```
## Conclusion
This concludes the OOP Booking Project. I have made use of Object Orientated language and classes and have succesfully transferred data between PHP pages. I have also built a smooth system that will consistetly update and retrieve the JSON as well as mail the outputs thereof. The design of the site is also smooth, responsive and consistent.
