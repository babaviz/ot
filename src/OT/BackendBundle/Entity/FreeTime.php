<?php
namespace OT\BackendBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class FreeTime
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $date;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $start_time;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $end_time;

    /**
     * @ORM\OneToMany(targetEntity="BookedTime", mappedBy="FreeTime")
     */
    private $BookedTimes;

    /**
     * @ORM\ManyToOne(targetEntity="Teacher", inversedBy="FreeTimes")
     * @ORM\JoinColumn(name="teacher_id", referencedColumnName="id", nullable=false)
     */
    private $Teacher;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->BookedTimes = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set date
     *
     * @param \DateTime $date
     * @return FreeTime
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set start_time
     *
     * @param integer $startTime
     * @return FreeTime
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
     * @return FreeTime
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
     * Add BookedTimes
     *
     * @param \OT\BackendBundle\Entity\BookedTime $bookedTimes
     * @return FreeTime
     */
    public function addBookedTime(\OT\BackendBundle\Entity\BookedTime $bookedTimes)
    {
        $this->BookedTimes[] = $bookedTimes;

        return $this;
    }

    /**
     * Remove BookedTimes
     *
     * @param \OT\BackendBundle\Entity\BookedTime $bookedTimes
     */
    public function removeBookedTime(\OT\BackendBundle\Entity\BookedTime $bookedTimes)
    {
        $this->BookedTimes->removeElement($bookedTimes);
    }

    /**
     * Get BookedTimes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBookedTimes()
    {
        return $this->BookedTimes;
    }

    /**
     * Set Teacher
     *
     * @param \OT\BackendBundle\Entity\Teacher $teacher
     * @return FreeTime
     */
    public function setTeacher(\OT\BackendBundle\Entity\Teacher $teacher)
    {
        $this->Teacher = $teacher;

        return $this;
    }

    /**
     * Get Teacher
     *
     * @return \OT\BackendBundle\Entity\Teacher 
     */
    public function getTeacher()
    {
        return $this->Teacher;
    }
}
