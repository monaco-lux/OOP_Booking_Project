<?php

class BookingForm
{

  private $name;
  private $surname;
  private $email;
  private $checkIn;
  private $checkOut;
  private $hotel;

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

      return $this;
    }

}

 ?>
