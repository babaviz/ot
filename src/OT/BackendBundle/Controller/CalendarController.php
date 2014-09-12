<?php

namespace OT\BackendBundle\Controller;

use OT\BackendBundle\Entity\Weekplan;


class CalendarController
{

  public function parse_weekplan(Weekplan $plan, $tz = 'GMT')
  {
    $workingPlan=$plan->getPlan();
    $offset_tz=$this->get_timezone_offset($tz);
    $strPlan='';

    $workingArray=explode(',',$workingPlan);

    foreach ($workingArray as $workingElement)
    {
      $workingString=explode('*',$workingElement);
      $strPlan.=str_repeat($workingString[0],$workingString[1]);
    }

    $offset=-$offset_tz/60/10;

    if ($offset!=0)
      $strPlan=substr($strPlan,$offset).substr($strPlan,0,$offset);

    return $strPlan;

  }

  public function render_parsed_weekplan($strPlan)
  {

    $result='<table class="table"><tbody>';

    for ($d=0;$d<1008;$d+=144){
      $result.='<tr><td colspan=12>';
      $result.=array('mon','tue','wed','thu','fri','sat','sun')[$d/144];
      $result.='</td></tr><tr>';
      for ($h=0;$h<24;$h++){
        $result.=('<td>'.$h.'</td><td>');
        $result.=substr($strPlan,$d+$h*6,6);
        $result.=('</td>');
        if ($h==11)
          $result.='</tr><tr>';
        }
      $result.='</tr>';
    }

    $result=str_replace('F','<strong>F</strong>',$result);
    $result=str_replace('B','_',$result);

    return $result.'</tbody></table>';

  }

  private function day_to_agenda($strDay)
  {
    return $strDay;
  }


  public function render_parsed_weekplan_agenda($strPlan)
  {
    $result='';
    for ($d=0;$d<1008;$d+=144){
      $result.='<br/>';
      $result.=array('mon:','tue:','wed:','thu:','fri:','sat:','sun:')[$d/144];
      $result.=$this->day_to_agenda(substr($strPlan,$d,144),'F');
    }
    return $result;
  }

  public function get_timezone_offset($remote_tz, $origin_tz = 'GMT') {
    //get the difference of timezones by seconds
      //if($origin_tz === null) {
      //    if(!is_string($origin_tz = date_default_timezone_get())) {
      //        return false; // A UTC timestamp was returned -- bail out!
      //    }
      //}
      $origin_dtz = new \DateTimeZone($origin_tz);
      $remote_dtz = new \DateTimeZone($remote_tz);
      $origin_dt = new \DateTime("now", $origin_dtz);
      $remote_dt = new \DateTime("now", $remote_dtz);
      $offset = $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);
      return $offset;
  }

/*
    public function timezone_convert($original_time_string, $orginal_tz, $target_tz)
    {
       //convert a time of the original timezone to the target timezone
       //param original_time_string: time in the string format 'Y-m-d H:i:s'

       $original_time=new \DateTime($original_time_string.' '.$orginal_tz);

       $original_time->setTimezone(new \DateTimeZone($target_tz));
       
        return $original_time;
    }

    public function time_to_string($time)
    {
      //convert a DateTime object to 'Y-m-d H:i:s' string.
      return $time->format('Y-m-d H:i');
    }

    public function parse_time($time,$length_in_minute)
    {
      //parse a localized time to array.
      $result['weekday']=$time->format('l');
      $result['weekdaynum']=$time->format('W');

      $result['start_hour']=$time->format('H');
      $result['start_minute']=$time->format('i');

      $result['end_hour']=strval($result['start_hour']+round($length_in_minute/60));
      $result['end_minute']=strval($result['start_minute']+$length_in_minute%60);

      return $result;
    }

    public function parse_weekplan($weekday, $start_hour, $start_minute, $end_hour, $end_minute)
    {
      //parse a weekplan to array.
      $result['weekday']=$weekday;

      $result['start_hour']=$start_hour;
      $result['start_minute']=$start_minute;

      $result['end_hour']=$end_hour;
      $result['end_minute']=$end_minute;

      return $result;
    }

    public function time_available($booking,$planned)
    {
      //test whether a booking time meeting the planned schedule
      $start_booking=$booking['start_hour']*60+$booking['start_minute'];
      $end_booking=$booking['end_hour']*60+$booking['end_minute'];
      $start_planned=$planned['start_hour']*60+$planned['start_minute'];
      $end_planned=$planned['end_hour']*60+$planned['end_minute'];
      if ($start_planned<=$start_booking && $end_planned>=$end_booking)
        return true;
      else
        return false;
    }

    

    function push_calendar_timezone(Weekplan $origin)
    {
        $result=new Weekplan();
        
        return $result;
    }
*/

}
