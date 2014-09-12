<?php

namespace OT\BackendBundle\Controller;

class WeekPlan()
{
    string $weekday;
    int $weekdaynum;

    int $start_hour;
    int $start_minute;
    int $end_hour;
    int $end_minute;

    int $hour;
    int $minute;
}

class TimeClass()
{

    public function timezone_covert(String $original_time_string, string $orginal_tz, string $target_tz)
    {
        //convert a time of the original timezone to the target timezone
       $original_time=new DateTime($original_time_string.' '.$orginal_tz);

       $original_time->setTimezone(new DateTimeZone($target_tz));
       
       return $original_time;
    }
}


$weekday=$dateTime->format('l');
       $weekdaynum=$dateTime->format('w');
       $hour=$dateTime->format('H');
       $minute=$dateTime->format('i');