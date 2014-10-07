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
        $usertz=$this->getDoctrine()->getRepository('OTBackendBundle:User')->findOneById($userid)->getTimezone();

        $is_current_week = ($date_start===null || $date_start=='today')?true:false;

        $date_start = new \Datetime($date_start, new \Datetimezone($usertz));

        $date_end = clone $date_start;
        $date_end->add(new \DateInterval('P1W'));

        $previous_week = clone $date_start;
        $previous_week->sub(new \DateInterval('P1W'));

        $response = $calendar->fetch_events(null,$date_start->format('Y-m-d H:i:s'),$date_end->format('Y-m-d H:i:s'),'FREE',$userid);

        return $this->render('OTBackendBundle:Teacher:weekplan_list.html.twig',
        	['response'=>$response,
             'usertz'=>$usertz,
             'date_start'=>$date_start,
             'date_end'=>$date_end,
             'previous_week'=>$previous_week->format('Y-m-d H:i:s'),
             'next_week'=>$date_end->format('Y-m-d H:i:s'),
             'is_current_week'=>$is_current_week,
             ]);
    }

    public function addAction(Request $request)
    {
        date_default_timezone_set("UTC");
        $calendar = $this->get('ot_calendar_v2');
        $userid=$this->get('security.context')->getToken()->getUser()->getId();
        $usertz=$this->getDoctrine()->getRepository('OTBackendBundle:User')->findOneById($userid)->getTimezone();

        $start_string = $request->request->get('date_start');
        $end_string = $request->request->get('date_end');

        $start_string = $calendar->convert_time_string_to_another_timezone($start_string, $usertz, 'UTC');
        $end_string = $calendar->convert_time_string_to_another_timezone($end_string, $usertz, 'UTC');

        $calendar->create_or_update_event(null, "", $start_string, $end_string,
                                 'FREE', $userid, $userid,null);

        return $this->redirect($this->getRequest()->headers->get('referer'));

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
            $event->getTeacherId()->getId()
        );

        $this->get('session')->getFlashBag()->add(
            'success',
            $this->get('translator')->trans('The plan has been copied to next %date%.',['%date%'=>$start->format('l, M   d')])
        );

        return $this->redirect($this->getRequest()->headers->get('referer'));

    }

    public function learnerCourseSelectAction(Request $request, $date_start = null)
    {

        $course_selected = $request->request->get('form')['course'];
        $teacher_selected = $request->request->get('form')['teacher'];

        $form = $this->createFormBuilder()
            //->setMethod('GET')
            ->add('course', 'entity', ['class'=>'OTBackendBundle:Course',
                                        'property'=>'name',
                                        'empty_value'=>'',
                                        'data'=>($course_selected=='')?'0':$this->getDoctrine()->getManager()->getReference("OTBackendBundle:Course", $course_selected),
                                        'query_builder'=> function($er) {
                                                                return $this->getDoctrine()
                                                                ->getManager()
                                                                ->createQueryBuilder()
                                                                ->select('c')
                                                                ->from('OTBackendBundle:Course','c')
                                                                ->where('c.status=:status')
                                                                ->setParameter('status','ACTIVE');
                                                        },
                                        'attr'=>['onclick'=>'this.form.submit();'],
                                        ]
                    )
            ->add('teacher', 'entity', ['class'=>'OTBackendBundle:User',
                                        'property'=>'name',
                                        'empty_value'=>'',
                                        'data'=>($teacher_selected=='')?'0':$this->getDoctrine()->getManager()->getReference("OTBackendBundle:User", $teacher_selected),
                                        'query_builder'=> function($er) {
                                                                return $this->getDoctrine()
                                                                ->getManager()
                                                                ->createQueryBuilder()
                                                                ->select('u')
                                                                ->from('OTBackendBundle:User','u')
                                                                ->where('u.role=:role')
                                                                ->setParameter('role','ROLE_TEACHER');
                                                        },
                                        'attr'=>['onclick'=>'this.form.submit();'],
                                        ]
                    )
            //->add('view','submit')
            ->getForm();

        $weekplan = null; $date_start=null; $date_end=null; 
        $is_current_week=null; $previous_week=null;


        if ($course_selected!='' && $teacher_selected!=''){
            date_default_timezone_set("UTC");
            $calendar = $this->get('ot_calendar_v2');
            $userid=$this->get('security.context')->getToken()->getUser()->getId();
            $usertz=$this->getDoctrine()->getRepository('OTBackendBundle:User')->findOneById($userid)->getTimezone();
            $is_current_week = true;
            $date_start = 'today';
            $date_start = new \Datetime($date_start, new \Datetimezone('Asia/Hong_Kong'));
            $date_start->add(new \DateInterval('P1D'));
            $date_end = clone $date_start;
            $date_end->add(new \DateInterval('P2W'));
            $previous_week = clone $date_start;
            $previous_week->sub(new \DateInterval('P2W'));
            $weekplan = $calendar->fetch_events(null,$date_start->format('Y-m-d H:i:s'),$date_end->format('Y-m-d H:i:s'),'FREE', null, $teacher_selected);

            return $this->render('OTBackendBundle:Learner:course_selection.html.twig',
            [
             'form'=>$form->createView(),
             'response'=>$weekplan,
             'usertz'=>$usertz,
             'date_start'=>$date_start,
             'date_end'=>$date_end,
             'previous_week'=>$previous_week->format('Y-m-d H:i:s'),
             'next_week'=>$date_end->format('Y-m-d H:i:s'),
             'is_current_week'=>$is_current_week,
             'course_id'=>$course_selected,
             ]);

        }

        return $this->render('OTBackendBundle:Learner:course_selection.html.twig',
            [
             'form'=>$form->createView(),
             ]);
    }

    public function learnerTimeSelectFinishAction()
    {
        $request = $this->getRequest();

        date_default_timezone_set("UTC");
        $calendar = $this->get('ot_calendar_v2');
        $time_selected = intval($request->request->get('form')['time_selected']);
        $userid=$this->get('security.context')->getToken()->getUser()->getId();
        $usertz=$this->getDoctrine()->getRepository('OTBackendBundle:User')->findOneById($userid)->getTimezone();
        $event_id = $request->request->get('form')['event_id'];
        $course_id = $request->request->get('form')['course_id'];
        $course=$this->getDoctrine()->getRepository('OTBackendBundle:Course')->findOneById($course_id);
        $event=$this->getDoctrine()->getRepository('OTBackendBundle:Event')->findOneById($event_id);
        $teacher_id = $event->getTeacherId();
        $teacher_name=$this->getDoctrine()->getRepository('OTBackendBundle:User')->findOneById($teacher_id)->getName();
        $learner_name=$this->getDoctrine()->getRepository('OTBackendBundle:User')->findOneById($userid)->getName();

        $event_created_id = $calendar->create_or_update_event(null,
                                         $teacher_name . ' - ' . $learner_name . ' - ' . $course->getName() . ' - ' . $course->getDuration() . 'mins',
                                         gmdate('r', $time_selected),
                                         gmdate('r',$time_selected+$course->getDuration()*60),
                                         'BOOKED',
                                         $userid,
                                         $teacher_id,
                                         $userid);

        #return new Response($time_selected.','.$event_id.','.$course_id);
        return $this->render('OTBackendBundle:Learner:time_selection_finish.html.twig',
            [
                'course_id'=>$course->getCourseId(),
                'course_name'=>$course->getName(),
                'teacher_name'=>$teacher_name,
                'learner_name'=>$learner_name,
                'date'=>$calendar->convert_time_string_to_another_timezone(gmdate('r', $time_selected),'GMT',$usertz, 'D, Y-m-d'),
                'time_start'=>$calendar->convert_time_string_to_another_timezone(gmdate('r', $time_selected),'GMT',$usertz, 'H:i'),
                'time_end'=>$calendar->convert_time_string_to_another_timezone(gmdate('r', $time_selected+$course->getDuration()*60),'GMT',$usertz, 'H:i'),
                'ref_num'=>base64_encode(str_pad($event_created_id, 6, '0', STR_PAD_LEFT)),
            ]
            );
        
    }

    public function learnerTimeSelectAction($event_id, $course_id)
    {
        date_default_timezone_set("UTC");
        $calendar = $this->get('ot_calendar_v2');

        $event=$this->getDoctrine()->getRepository('OTBackendBundle:Event')->findOneById($event_id);
        $teacher=$event->getTeacherId();
        $userid=$this->get('security.context')->getToken()->getUser()->getId();
        $usertz=$this->getDoctrine()->getRepository('OTBackendBundle:User')->findOneById($userid)->getTimezone();
        $course=$this->getDoctrine()->getRepository('OTBackendBundle:Course')->findOneById($course_id);

        $start = $event->getStart();
        $end = $event->getEnd();

        $bookedtime=$calendar->fetch_events(null, gmdate('r',$start), gmdate('r',$end),
                                 $status='BOOKED', null ,
                                 $teacher , null);

        for ($i=$start;$i<=$end-$course->getDuration()*60;$i+=600){
            $timespans[strval($i)] = $calendar->convert_time_string_to_another_timezone(gmdate('r',strval($i)), 'GMT', $usertz, 'D, m-d, H:i').' - '.
                                    $calendar->convert_time_string_to_another_timezone(gmdate('r',strval($i+$course->getDuration()*60)), 'GMT', $usertz, 'H:i');
        }

        $timespans=$this->createFormBuilder()
         ->setAction($this->generateUrl('learner_weekplan_time_select_finish'))
         ->add('time_selected', 'choice',
                [
                    'choices'=>$timespans,
                    'label'=>' ',
                ]
               )
         ->add('event_id','hidden',['data'=>$event_id])
         ->add('course_id','hidden',['data'=>$course_id])
         ->add('submit','submit',['label'=>$this->get('translator')->trans('Make a Reservation')])
         ->getForm();

        return $this->render('OTBackendBundle:Learner:time_selection.html.twig',
            ['event'=>$event,
             'teacher'=>$teacher,
             'course'=>$course,
             'userid'=>$userid,
             'usertz'=>$usertz,
             'bookedtime'=>$bookedtime,
             'timespans'=>$timespans->createView(),
            ]
            );
    }
}
