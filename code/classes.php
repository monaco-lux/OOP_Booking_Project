<?php

// Used to provide properties to write back to a JSON
class BookingForm
{

  private $name;
  private $surname;
  private $email;
  private $checkIn;
  private $checkOut;
  private $checkInStr;
  private $checkOutStr;
  private $hotel;
  private $daysStaying;
  private $ratePerDay;

  private $file;
  private $home;

  public function __get($property) {
    if (property_exists($this, $property)) {
      return $this->$property;
    }
  }

  public function __set($property, $value) {
      if (property_exists($this, $property)) {
        $this->$property = $value;
      }
    }

}

 ?>
