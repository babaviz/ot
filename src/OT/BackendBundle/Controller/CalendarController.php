<?php

namespace OT\BackendBundle\Controller;


use OT\BackendBundle\Entity\Weekplan;


class CalendarController
{
  public function encode_weekplan($str, $tz = 'GMT')
  {
    $result='';
    $last_char='';
    $count=0;

    $offset_tz=$this->get_timezone_offset($tz);
    $offset=-$offset_tz/60/10;

    if ($offset!=0)
      $str=substr($str,$offset).substr($str,0,$offset);

    for ($i=0;$i<1008;$i++){
      if ($str[$i]!=$last_char){
        if ($i!=0){
          $result.=strval($count);
          $result.=',';  
        }
        $result.=$str[$i];
        $result.='*';
        $count=1;
      }
      else
      $count++;
      $last_char=$str[$i];
      if ($i==1007){
        $result.=$count;
      }
    }

    return $result;
  }

  public function parse_weekplan(Weekplan $plan, $tz = 'GMT')
  {
    //uncompress weekplan to timezoned string
    $workingPlan=$plan->getPlan();
    $offset_tz=$this->get_timezone_offset($tz);
    $offset=$offset_tz/60/10;
    $strPlan='';

    $workingArray=explode(',',$workingPlan);

    foreach ($workingArray as $workingElement)
    {
      $workingString=explode('*',$workingElement);
      $strPlan.=str_repeat($workingString[0],$workingString[1]);
    }

    if ($offset!=0)
      $strPlan=substr($strPlan,$offset).substr($strPlan,0,$offset);

    return $strPlan;

  }

  public function render_parsed_weekplan($strPlan)
  {
    //render parsed weekplan to HTML table
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
    //convert 144 bytes daily string to array
    $strDay.='B';
    $pos_start;
    $pos_end;
    $result_array=[];
    $i=0;

    //$result.=$strDay;  debug

    while ($i<144)
    {
      $result='';
      $pos_start=strpos($strDay,'F',$i);
      if ($pos_start!==false){

        $pos_end=strpos($strDay,'B',$pos_start);

        $result.=str_pad(floor($pos_start/6),2,'0',STR_PAD_LEFT);
        $result.=':';
        $result.=$pos_start%6;
        $result.='0 - ';
        $result.=str_pad(floor($pos_end/6),2,'0',STR_PAD_LEFT);
        $result.=':';
        $result.=$pos_end%6;
        $result.='0';

        $i=$pos_end;

        array_push($result_array,$result);

      }
      
      $i++;
    }

    return $result_array;
  }


  public function render_parsed_weekplan_agenda($strPlan)
  {
    //render parsed weekplan string to weekplan array
    $result=[];

    for ($d=0;$d<1008;$d+=144){
      array_push($result,$this->day_to_agenda(substr($strPlan,$d,144)));
    }

    return $result;
  }

  public function render_parsed_weekplan_learner($strPlan, $start_date)
  { 
    $result=[];

    $dw = date( "w", strtotime($start_date));  //0 is Sunday through 6 is Sat
    $dw = ($dw==0)?7:$dw;

    for ($d=0;$d<1008;$d+=144){
      array_push($result,$this->day_to_agenda(substr($strPlan,($d+($dw-1)*144)%1008,144)));
    }

    return $result;
  }

  public function override_rotate($strPlan, $start_date)
  {
    $dw = date( "w", strtotime($start_date));  //0 is Sunday through 6 is Sat
    $dw = ($dw==0)?7:$dw; //1 is mon and 7 is sun
    $dw--;//0 is mon (no move) and 6 is sun
    //$dw = 7 - $dw; //7(0) is mon and 1 is sun

    return substr($strPlan, 1008-$dw*144) . substr($strPlan, 0, (7-$dw)*144);

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

  public function utc_timezoned_string($str, $tz='GMT', $fmt='Y-m-d H:i:s')
  {
    //convert a UTC time string to timezoned time string
      $UTC = new \DateTimeZone('UTC');
      $date = new \DateTime($str, $UTC);
      $date->setTimezone(new \DateTimeZone($tz));
      return $date->format($fmt);
  }

  public function timezoned_utc_string($str, $tz='GMT', $fmt='Y-m-d H:i:s')
  {
    //convert a timezoned time string to UTC time string
      $UTC = new \DateTimeZone('UTC');
      $date = new \DateTime($str, new \DateTimeZone($tz));
      $date->setTimezone($UTC);
      return $date->format($fmt);
  }

  public function generateFromDayTimeList()
  {
    $result=[];
    for ($i=0;$i<144;$i++){
      $result[strval($i)]=sprintf('%02d',floor($i/6)).':'.sprintf('%02d',floor($i%6)*10);
    }
    return $result;
  }

  public function generateToDayTimeList()
  {
    $result=[];
    for ($i=0;$i<144;$i++){
      $result[strval($i)]=sprintf('%02d',floor(($i+1)/6)).':'.sprintf('%02d',floor(($i+1)%6)*10);
    }
    return $result;
  }

  public function override_1008($str_old, $str_override)
  {
    for ($i=0;$i<1008;$i++){
      if ($str_override[$i]=='B')
        $str_old[$i]='B';
    }
    return $str_old;
  }

  public function create_override($start_position,$length)
  {
    $r='';
    $r.=str_repeat('F', $start_position);
    $r.=str_repeat('B',$length);
    $r.=str_repeat('F',1008-strlen($r));
    return $r;
  }

  public function time_diff_m10($time1, $time2)
  {
      $d_diff=strval($time2->format('d')-$time1->format('d'));
      $h_diff=strval($time2->format('H')-$time1->format('H'));
      $m_diff=strval($time2->format('i')-$time1->format('i'));
      return ($d_diff*1440+$h_diff*60+$m_diff)/10;
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
