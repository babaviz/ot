<?php

namespace OT\BackendBundle\Controller;

use Doctrine\ORM\EntityManager;
use OT\BackendBundle\Entity\Event;

class CalendarService
{

  protected $em;

  function __construct($entityManager) {
    date_default_timezone_set('UTC');
    $this->em = $entityManager;
  }
  
  function convert_time_string_to_another_timezone($time_string, $tz_from_string, $tz_to_string)
  {
  	return date_create($time_string, new \DateTimeZone($tz_from_string))
		->setTimezone(new \DateTimeZone($tz_to_string))->format("Y-m-d H:i:s");
  }

  function convert_time_string_to_timestamp_bigint($time_string)
  {
  	$time = new \DateTime($time_string);
  	return $time->format('U');
  }

  function create_or_update_event($event_id=null, $title=null, $start_string=null, $end_string=null,
  								 $status=null, $user_id=null,
  								 $teacher_id=null, $learner_id=null)
  {
  	if ($event_id === null)
  		$event = new Event();
  	else{
  		$event = $this->em->getRepository('OTBackendBundle:Event')->find($event_id);
  	}

  	if ($title !== null){
  		$event->setTitle($title);
  	}
  	
  	if ($start_string !== null){
  		$event->setStart($this->convert_time_string_to_timestamp_bigint($start_string));
  	}

  	if ($end_string !== null){
  		$event->setEnd($this->convert_time_string_to_timestamp_bigint($end_string));
  	}

  	if ($status !== null){
  		$event->setStatus($status);
  	}

  	if ($user_id !== null){
	  	$user = $this->em->getRepository('OTBackendBundle:User')->find($user_id);
	  	$event->setUserId($user);
	}

  	if ($teacher_id !== null){
	  	$teacher = $this->em->getRepository('OTBackendBundle:User')->find($teacher_id);
	  	$event->setTeacherId($teacher);
	}

	if ($learner_id !== null){
	  	$learner = $this->em->getRepository('OTBackendBundle:User')->find($learner_id);
	  	$event->setLearnerId($learner);
	}

  	$this->em->persist($event);
  	$this->em->flush();

  }

  function fetch_events($event_id=null, $start_string=null, $end_string=null,
  								 $status=null, $user_id=null,
  								 $teacher_id=null, $learner_id=null)
  {
  	$query = $this->em->getRepository('OTBackendBundle:Event')->createQueryBuilder('e');

  	if ($event_id !== null){
  		$query->andWhere('e.id = :event_id')
  			  ->setParameter('event_id',$event_id);
  	}

  	if ($start_string !== null){
  		$query->andWhere('e.start >= :start')
  			  ->setParameter('start',$this->convert_time_string_to_timestamp_bigint($start_string));
  	}

  	if ($end_string !== null){
  		$query->andWhere('e.end <= :end')
  			  ->setParameter('end',$this->convert_time_string_to_timestamp_bigint($end_string));
  	}

  	if ($status !== null){
  		$query->andWhere('e.status = :status')
  			  ->setParameter('status',$status);
  	}

  	if ($user_id !== null){
  		$query->andWhere('e.user_id = :user_id')
  			  ->setParameter('user_id',$user_id);
  	}

  	if ($learner_id !== null){
  		$query->andWhere('e.learner_id = :learner_id')
  			  ->setParameter('learner_id',$learner_id);
  	}

  	if ($teacher_id !== null){
  		$query->andWhere('e.user_id = :teacher_id')
  			  ->setParameter('teacher_id',$teacher_id);
  	}

    $query->orderBy('e.start');

  		//->setParameter('start',convert_time_string_to_timestamp_bigint($start_string))
  		//->andwhere('e.end <= :end')
  		//->setParameter('end',convert_time_string_to_timestamp_bigint($end_string))

  	return $query->getQuery()->getResult();
  }

  function delete_events($event_id=null, $start_string=null, $end_string=null,
                   $status=null, $user_id=null,
                   $teacher_id=null, $learner_id=null)
  {
    $events = $this->fetch_events($event_id, $start_string, $end_string, $status, $user_id, $teacher_id, $learner_id);
    foreach ($events as $event){
      $this->em->remove($event);
    }
    $this->em->flush();
  }

}
