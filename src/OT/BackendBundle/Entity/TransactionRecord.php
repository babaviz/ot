<?php
namespace OT\BackendBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class TransactionRecord
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
    private $note;

    /**
     * @ORM\Column(type="string", length=16, nullable=false)
     */
    private $type;

    /**
     * @ORM\Column(type="string", unique=true, length=64, nullable=false)
     */
    private $transaction_id;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_time;

    /**
     * @ORM\OneToOne(targetEntity="BookedTime", inversedBy="TransactionRecord")
     * @ORM\JoinColumn(name="booked_time_id", referencedColumnName="id", unique=true)
     */
    private $BookedTime;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="TransactionRecords")
     * @ORM\JoinColumn(name="from_id", referencedColumnName="id")
     */
    private $From;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="TransactionRecords")
     * @ORM\JoinColumn(name="to_id", referencedColumnName="id")
     */
    private $To;

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
     * Set note
     *
     * @param string $note
     * @return TransactionRecord
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return TransactionRecord
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
     * Set transaction_id
     *
     * @param string $transactionId
     * @return TransactionRecord
     */
    public function setTransactionId($transactionId)
    {
        $this->transaction_id = $transactionId;

        return $this;
    }

    /**
     * Get transaction_id
     *
     * @return string 
     */
    public function getTransactionId()
    {
        return $this->transaction_id;
    }

    /**
     * Set amount
     *
     * @param float $amount
     * @return TransactionRecord
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set created_time
     *
     * @param \DateTime $createdTime
     * @return TransactionRecord
     */
    public function setCreatedTime($createdTime)
    {
        $this->created_time = $createdTime;

        return $this;
    }

    /**
     * Get created_time
     *
     * @return \DateTime 
     */
    public function getCreatedTime()
    {
        return $this->created_time;
    }

    /**
     * Set BookedTime
     *
     * @param \OT\BackendBundle\Entity\BookedTime $bookedTime
     * @return TransactionRecord
     */
    public function setBookedTime(\OT\BackendBundle\Entity\BookedTime $bookedTime = null)
    {
        $this->BookedTime = $bookedTime;

        return $this;
    }

    /**
     * Get BookedTime
     *
     * @return \OT\BackendBundle\Entity\BookedTime 
     */
    public function getBookedTime()
    {
        return $this->BookedTime;
    }

    /**
     * Set User
     *
     * @param \OT\BackendBundle\Entity\User $User
     * @return TransactionRecord
     */
    public function setUser(\OT\BackendBundle\Entity\User $User = null)
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

    /**
     * Set from_id
     *
     * @param \OT\BackendBundle\Entity\User $fromId
     * @return TransactionRecord
     */
    public function setFromId(\OT\BackendBundle\Entity\User $fromId = null)
    {
        $this->from_id = $fromId;

        return $this;
    }

    /**
     * Get from_id
     *
     * @return \OT\BackendBundle\Entity\User 
     */
    public function getFromId()
    {
        return $this->from_id;
    }

    /**
     * Set to_id
     *
     * @param \OT\BackendBundle\Entity\User $toId
     * @return TransactionRecord
     */
    public function setToId(\OT\BackendBundle\Entity\User $toId = null)
    {
        $this->to_id = $toId;

        return $this;
    }

    /**
     * Get to_id
     *
     * @return \OT\BackendBundle\Entity\User 
     */
    public function getToId()
    {
        return $this->to_id;
    }

    /**
     * Set From
     *
     * @param \OT\BackendBundle\Entity\User $from
     * @return TransactionRecord
     */
    public function setFrom(\OT\BackendBundle\Entity\User $from = null)
    {
        $this->From = $from;

        return $this;
    }

    /**
     * Get From
     *
     * @return \OT\BackendBundle\Entity\User 
     */
    public function getFrom()
    {
        return $this->From;
    }

    /**
     * Set To
     *
     * @param \OT\BackendBundle\Entity\User $to
     * @return TransactionRecord
     */
    public function setTo(\OT\BackendBundle\Entity\User $to = null)
    {
        $this->To = $to;

        return $this;
    }

    /**
     * Get To
     *
     * @return \OT\BackendBundle\Entity\User 
     */
    public function getTo()
    {
        return $this->To;
    }
}
