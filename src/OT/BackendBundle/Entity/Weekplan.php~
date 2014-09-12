<?php
namespace OT\BackendBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Weekplan
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
    private $weekday;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $start_hour;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $start_minute;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $end_hour;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $end_minute;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="Weekplans")
     * @ORM\JoinColumn(name="teacher_id", referencedColumnName="id", nullable=false)
     */
    private $teacher;
    /**
     * Constructor
     */
    public function __construct()
    {

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
     * Set weekday
     *
     * @param string $weekday
     * @return Weekplan
     */
    public function setWeekday($weekday)
    {
        $this->weekday = $weekday;

        return $this;
    }

    /**
     * Get weekday
     *
     * @return string 
     */
    public function getWeekday()
    {
        return $this->weekday;
    }

    /**
     * Set start_hour
     *
     * @param integer $startHour
     * @return Weekplan
     */
    public function setStartHour($startHour)
    {
        $this->start_hour = $startHour;

        return $this;
    }

    /**
     * Get start_hour
     *
     * @return integer 
     */
    public function getStartHour()
    {
        return $this->start_hour;
    }

    /**
     * Set start_minute
     *
     * @param integer $startMinute
     * @return Weekplan
     */
    public function setStartMinute($startMinute)
    {
        $this->start_minute = $startMinute;

        return $this;
    }

    /**
     * Get start_minute
     *
     * @return integer 
     */
    public function getStartMinute()
    {
        return $this->start_minute;
    }

    /**
     * Set end_hour
     *
     * @param integer $endHour
     * @return Weekplan
     */
    public function setEndHour($endHour)
    {
        $this->end_hour = $endHour;

        return $this;
    }

    /**
     * Get end_hour
     *
     * @return integer 
     */
    public function getEndHour()
    {
        return $this->end_hour;
    }

    /**
     * Set end_minute
     *
     * @param integer $endMinute
     * @return Weekplan
     */
    public function setEndMinute($endMinute)
    {
        $this->end_minute = $endMinute;

        return $this;
    }

    /**
     * Get end_minute
     *
     * @return integer 
     */
    public function getEndMinute()
    {
        return $this->end_minute;
    }

    /**
     * Set User
     *
     * @param \OT\BackendBundle\Entity\User $user
     * @return Weekplan
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
     * Set teacher
     *
     * @param \OT\BackendBundle\Entity\User $teacher
     * @return Weekplan
     */
    public function setTeacher(\OT\BackendBundle\Entity\User $teacher)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get teacher
     *
     * @return \OT\BackendBundle\Entity\User 
     */
    public function getTeacher()
    {
        return $this->teacher;
    }
}
