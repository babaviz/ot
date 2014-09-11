<?php
namespace OT\BackendBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class BookedTime
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $start_time;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $end_time;

    /**
     * @ORM\Column(type="string", length=16)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="BookedTimes")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     */
    private $Course;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="BookedTimes")
     * @ORM\JoinColumn(name="teacher_id", referencedColumnName="id", nullable=false)
     */
    private $Teacher;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="BookedTimes")
     * @ORM\JoinColumn(name="learner_id", referencedColumnName="id", nullable=false)
     */
    private $Learner;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set start_time
     *
     * @param integer $startTime
     * @return BookedTime
     */
    public function setStartTime($startTime)
    {
        $this->start_time = $startTime;

        return $this;
    }

    /**
     * Get start_time
     *
     * @return integer 
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    /**
     * Set end_time
     *
     * @param integer $endTime
     * @return BookedTime
     */
    public function setEndTime($endTime)
    {
        $this->end_time = $endTime;

        return $this;
    }

    /**
     * Get end_time
     *
     * @return integer 
     */
    public function getEndTime()
    {
        return $this->end_time;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return BookedTime
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }


    /**
     * Set Course
     *
     * @param \OT\BackendBundle\Entity\Course $course
     * @return BookedTime
     */
    public function setCourse(\OT\BackendBundle\Entity\Course $course = null)
    {
        $this->Course = $course;

        return $this;
    }

    /**
     * Get Course
     *
     * @return \OT\BackendBundle\Entity\Course 
     */
    public function getCourse()
    {
        return $this->Course;
    }

    /**
     * Set User
     *
     * @param \OT\BackendBundle\Entity\User $user
     * @return BookedTime
     */
    public function setUser(\OT\BackendBundle\Entity\User $user)
    {
        $this->User = $user;

        return $this;
    }

    /**
     * Get User
     *
     * @return \OT\BackendBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->User;
    }

    /**
     * Set Teacher
     *
     * @param \OT\BackendBundle\Entity\User $teacher
     * @return BookedTime
     */
    public function setTeacher(\OT\BackendBundle\Entity\User $teacher)
    {
        $this->Teacher = $teacher;

        return $this;
    }

    /**
     * Get Teacher
     *
     * @return \OT\BackendBundle\Entity\User 
     */
    public function getTeacher()
    {
        return $this->Teacher;
    }

    /**
     * Set Learner
     *
     * @param \OT\BackendBundle\Entity\User $learner
     * @return BookedTime
     */
    public function setLearner(\OT\BackendBundle\Entity\User $learner)
    {
        $this->Learner = $learner;

        return $this;
    }

    /**
     * Get Learner
     *
     * @return \OT\BackendBundle\Entity\User 
     */
    public function getLearner()
    {
        return $this->Learner;
    }
}
