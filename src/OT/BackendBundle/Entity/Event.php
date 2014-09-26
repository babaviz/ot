<?php
namespace OT\BackendBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="bigint")
     */
    private $start;

    /**
     * @ORM\Column(type="bigint")
     */
    private $end;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="events")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="learning_events")
     * @ORM\JoinColumn(name="learner_id", referencedColumnName="id")
     */
    private $learner_id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="teaching_events")
     * @ORM\JoinColumn(name="teacher_id", referencedColumnName="id")
     */
    private $teacher_id;
    

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
     * Set title
     *
     * @param string $title
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set start
     *
     * @param integer $start
     * @return Event
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return integer 
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param integer $end
     * @return Event
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    public function getStringStart()
    {
        $start_string = new \DateTime('@'.$this->start);

        return $start_string->format('Y-m-d H:i:s');
    }

    public function getStringEnd()
    {
        $end_string = new \DateTime('@'.$this->end);

        return $end_string->format('Y-m-d H:i:s');
    }

    /**
     * Get end
     *
     * @return integer 
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Event
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Event
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
     * Set user_id
     *
     * @param \OT\BackendBundle\Entity\User $userId
     * @return Event
     */
    public function setUserId(\OT\BackendBundle\Entity\User $userId = null)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get user_id
     *
     * @return \OT\BackendBundle\Entity\User 
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set learner_id
     *
     * @param \OT\BackendBundle\Entity\User $learnerId
     * @return Event
     */
    public function setLearnerId(\OT\BackendBundle\Entity\User $learnerId = null)
    {
        $this->learner_id = $learnerId;

        return $this;
    }

    /**
     * Get learner_id
     *
     * @return \OT\BackendBundle\Entity\User 
     */
    public function getLearnerId()
    {
        return $this->learner_id;
    }

    /**
     * Set teacher_id
     *
     * @param \OT\BackendBundle\Entity\User $teacherId
     * @return Event
     */
    public function setTeacherId(\OT\BackendBundle\Entity\User $teacherId = null)
    {
        $this->teacher_id = $teacherId;

        return $this;
    }

    /**
     * Get teacher_id
     *
     * @return \OT\BackendBundle\Entity\User 
     */
    public function getTeacherId()
    {
        return $this->teacher_id;
    }
}
