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
     * @ORM\Column(type="string", length=16, nullable=false)
     */
    private $status;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Teacher_comment;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Learner_comment;

    /**
     * @ORM\OneToOne(targetEntity="TransactionRecord", mappedBy="BookedTime")
     */
    private $TransactionRecord;

    /**
     * @ORM\ManyToOne(targetEntity="FreeTime", inversedBy="BookedTimes")
     * @ORM\JoinColumn(name="free_time_id", referencedColumnName="id", nullable=false)
     */
    private $FreeTime;

    /**
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="BookedTimes")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     */
    private $Course;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="BookedTimes")
     * @ORM\JoinColumn(name="User_id", referencedColumnName="id", nullable=false)
     */
    private $User;

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
     * Set Teacher_comment
     *
     * @param string $TeacherComment
     * @return BookedTime
     */
    public function setTeacherComment($TeacherComment)
    {
        $this->Teacher_comment = $TeacherComment;

        return $this;
    }

    /**
     * Get Teacher_comment
     *
     * @return string 
     */
    public function getTeacherComment()
    {
        return $this->Teacher_comment;
    }

    /**
     * Set Learner_comment
     *
     * @param string $LearnerComment
     * @return BookedTime
     */
    public function setLearnerComment($LearnerComment)
    {
        $this->Learner_comment = $LearnerComment;

        return $this;
    }

    /**
     * Get Learner_comment
     *
     * @return string 
     */
    public function getLearnerComment()
    {
        return $this->Learner_comment;
    }

    /**
     * Set TransactionRecord
     *
     * @param \OT\BackendBundle\Entity\TransactionRecord $transactionRecord
     * @return BookedTime
     */
    public function setTransactionRecord(\OT\BackendBundle\Entity\TransactionRecord $transactionRecord = null)
    {
        $this->TransactionRecord = $transactionRecord;

        return $this;
    }

    /**
     * Get TransactionRecord
     *
     * @return \OT\BackendBundle\Entity\TransactionRecord 
     */
    public function getTransactionRecord()
    {
        return $this->TransactionRecord;
    }

    /**
     * Set FreeTime
     *
     * @param \OT\BackendBundle\Entity\FreeTime $freeTime
     * @return BookedTime
     */
    public function setFreeTime(\OT\BackendBundle\Entity\FreeTime $freeTime)
    {
        $this->FreeTime = $freeTime;

        return $this;
    }

    /**
     * Get FreeTime
     *
     * @return \OT\BackendBundle\Entity\FreeTime 
     */
    public function getFreeTime()
    {
        return $this->FreeTime;
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
     * @param \OT\BackendBundle\Entity\User $User
     * @return BookedTime
     */
    public function setUser(\OT\BackendBundle\Entity\User $User)
    {
        $this->User = $User;

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
}
