<?php

class OneApiDateTime extends DateTime
{
    public static function createFromFormat($format, $time, $timezone = null)
    {
      if(!$timezone) $timezone = new DateTimeZone(date_default_timezone_get());
      //TODO uncomment this and find the solution for timestamp Y-m-d\TG:i:s.???O instead of Y-m-dTH:i:s....O
      //$version = explode('.', phpversion());
      //  if(((int)$version[0] >= 5 && (int)$version[1] >= 2 && (int)$version[2] > 17)){
      //      return parent::createFromFormat($format, $time, $timezone);
      //  }
        return new DateTime(date($format, strtotime($time)), $timezone);
    }
}

?>