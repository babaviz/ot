<?php

namespace OT\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Weekplan controller.
 *
 */
class WeekplanController extends Controller
{
    /**
     * Lists all Weekplan entities.
     *
     */
    public function listAction(Request $request, $date_start = null)
    {
        date_default_timezone_set("UTC");
        $calendar = $this->get('ot_calendar_v2');
        //$calendar->create_or_update_event(null,'1','2014-09-29 05:00','2014-09-29 07:00','status',1,3,2);
        $userid=$this->get('security.context')->getToken()->getUser()->getId();

        $is_current_week = ($date_start===null || $date_start=='today')?true:false;

        $date_start = new \Datetime($date_start, new \Datetimezone('Asia/Hong_Kong'));

        $date_end = clone $date_start;
        $date_end->add(new \DateInterval('P1W'));

        $previous_week = clone $date_start;
        $previous_week->sub(new \DateInterval('P1W'));

        $response = $calendar->fetch_events(null,$date_start->format('Y-m-d H:i:s'),$date_end->format('Y-m-d H:i:s'));

        return $this->render('OTBackendBundle:Teacher:weekplan_list.html.twig',
        	['response'=>$response,
             'usertz'=>'Asia/Hong_Kong',
             'date_start'=>$date_start,
             'date_end'=>$date_end,
             'previous_week'=>$previous_week->format('Y-m-d H:i:s'),
             'next_week'=>$date_end->format('Y-m-d H:i:s'),
             'is_current_week'=>$is_current_week,
             ]);
    }

    public function deleteAction($event_id)
    {
        date_default_timezone_set("UTC");
        $calendar = $this->get('ot_calendar_v2');
        $calendar->delete_events($event_id);

        $this->get('session')->getFlashBag()->add(
            'success',
            $this->get('translator')->trans('The plan has been removed.')
        );

        return $this->redirect($this->getRequest()->headers->get('referer'));
    }

    public function copyToNextWeekAction($event_id)
    {
        date_default_timezone_set("UTC");
        $calendar = $this->get('ot_calendar_v2');
        $event = $calendar->fetch_events($event_id)[0];

        $start = new \DateTime($event->getStringStart());
        $end = new \DateTime($event->getStringEnd());
        
        $calendar->create_or_update_event(
            null,null,
            $start->add(new \DateInterval('P1W'))->format('Y-m-d H:i:s'),
            $end->add(new \DateInterval('P1W'))->format('Y-m-d H:i:s'),
            $event->getStatus(),
            $event->getUserId()->getId(),
            $event->getTeacherId()->getId(),
            $event->getLearnerId()->getId()
        );

        $this->get('session')->getFlashBag()->add(
            'success',
            $this->get('translator')->trans('The plan has been copied to next %date%.',['%date%'=>$start->format('l, M   d')])
        );

        return $this->redirect($this->getRequest()->headers->get('referer'));

    }
}
