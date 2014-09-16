<?php
namespace OT\BackendBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="OT\BackendBundle\Entity\UserRepository")
 * 
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true, length=32, nullable=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="string", unique=true, length=32, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", unique=true, length=64, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=16, nullable=false)
     */
    private $role;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private $account_balance;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $create_time;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $timezone;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $introduction;

    /**
     * @ORM\OneToMany(targetEntity="TransactionRecord", mappedBy="From")
     */
    private $SentTransactions;

    /**
     * @ORM\OneToMany(targetEntity="TransactionRecord", mappedBy="To")
     */
    private $ReceivedTransactions;

    /**
     * @ORM\OneToOne(targetEntity="Weekplan", mappedBy="teacher")
     */
    private $Weekplan;

    /**
     * @ORM\OneToMany(targetEntity="BookedTime", mappedBy="teacher")
     */
    private $TeachingBookedTimes;

        /**
     * @ORM\OneToMany(targetEntity="BookedTime", mappedBy="learner")
     */
    private $LearningBookedTimes;

    /**
     * @ORM\ManyToMany(targetEntity="Course", inversedBy="Teachers")
     * @ORM\JoinTable(
     *     name="CourseHasTeacher",
     *     joinColumns={@ORM\JoinColumn(name="teacher_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="course_id", referencedColumnName="id", nullable=false)}
     * )
     */
    private $Courses;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->TransactionRecords = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Weekplans = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Courses = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set roles
     *
     * @param array $roles
     * @return User
     */
    public function setRoles($roles)
    {
        $this->role = $roles[0];

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return [$this->role];
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password,PASSWORD_BCRYPT);

        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set account_balance
     *
     * @param float $accountBalance
     * @return User
     */
    public function setAccountBalance($accountBalance)
    {
        $this->account_balance = $accountBalance;

        return $this;
    }

    /**
     * Get account_balance
     *
     * @return float 
     */
    public function getAccountBalance()
    {
        return $this->account_balance;
    }

    /**
     * Set create_time
     *
     * @param \DateTime $createTime
     * @return User
     */
    public function setCreateTime($createTime)
    {
        $this->create_time = $createTime;

        return $this;
    }

    /**
     * Get create_time
     *
     * @return \DateTime 
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }

    /**
     * Set timezone
     *
     * @param string $timezone
     * @return User
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Get timezone
     *
     * @return string 
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * Set introduction
     *
     * @param string $introduction
     * @return User
     */
    public function setIntroduction($introduction)
    {
        $this->introduction = $introduction;

        return $this;
    }

    /**
     * Get introduction
     *
     * @return string 
     */
    public function getIntroduction()
    {
        return $this->introduction;
    }

    /**
     * Add TransactionRecords
     *
     * @param \OT\BackendBundle\Entity\TransactionRecord $transactionRecords
     * @return User
     */
    public function addTransactionRecord(\OT\BackendBundle\Entity\TransactionRecord $transactionRecords)
    {
        $this->TransactionRecords[] = $transactionRecords;

        return $this;
    }

    /**
     * Remove TransactionRecords
     *
     * @param \OT\BackendBundle\Entity\TransactionRecord $transactionRecords
     */
    public function removeTransactionRecord(\OT\BackendBundle\Entity\TransactionRecord $transactionRecords)
    {
        $this->TransactionRecords->removeElement($transactionRecords);
    }

    /**
     * Get TransactionRecords
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTransactionRecords()
    {
        return $this->TransactionRecords;
    }

    /**
     * Add Weekplans
     *
     * @param \OT\BackendBundle\Entity\Weekplan $weekplans
     * @return User
     */
    public function addWeekplan(\OT\BackendBundle\Entity\Weekplan $weekplans)
    {
        $this->Weekplans[] = $weekplans;

        return $this;
    }

    /**
     * Remove Weekplans
     *
     * @param \OT\BackendBundle\Entity\Weekplan $weekplans
     */
    public function removeWeekplan(\OT\BackendBundle\Entity\Weekplan $weekplans)
    {
        $this->Weekplans->removeElement($weekplans);
    }

    /**
     * Get Weekplans
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWeekplans()
    {
        return $this->Weekplans;
    }

    /**
     * Add Courses
     *
     * @param \OT\BackendBundle\Entity\Course $courses
     * @return User
     */
    public function addCourse(\OT\BackendBundle\Entity\Course $courses)
    {
        $this->Courses[] = $courses;

        return $this;
    }

    /**
     * Remove Courses
     *
     * @param \OT\BackendBundle\Entity\Course $courses
     */
    public function removeCourse(\OT\BackendBundle\Entity\Course $courses)
    {
        $this->Courses->removeElement($courses);
    }

    /**
     * Get Courses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCourses()
    {
        return $this->Courses;
    }

    /**
     * Add BookedTimes
     *
     * @param \OT\BackendBundle\Entity\BookedTime $bookedTimes
     * @return User
     */
    public function addBookedTime(\OT\BackendBundle\Entity\BookedTime $bookedTimes)
    {
        $this->BookedTimes[] = $bookedTimes;

        return $this;
    }

    /**
     * Add SentTransactions
     *
     * @param \OT\BackendBundle\Entity\TransactionRecord $sentTransactions
     * @return User
     */
    public function addSentTransaction(\OT\BackendBundle\Entity\TransactionRecord $sentTransactions)
    {
        $this->SentTransactions[] = $sentTransactions;

        return $this;
    }

    /**
     * Remove SentTransactions
     *
     * @param \OT\BackendBundle\Entity\TransactionRecord $sentTransactions
     */
    public function removeSentTransaction(\OT\BackendBundle\Entity\TransactionRecord $sentTransactions)
    {
        $this->SentTransactions->removeElement($sentTransactions);
    }

    /**
     * Get SentTransactions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSentTransactions()
    {
        return $this->SentTransactions;
    }

    /**
     * Add ReceivedTransactions
     *
     * @param \OT\BackendBundle\Entity\TransactionRecord $receivedTransactions
     * @return User
     */
    public function addReceivedTransaction(\OT\BackendBundle\Entity\TransactionRecord $receivedTransactions)
    {
        $this->ReceivedTransactions[] = $receivedTransactions;

        return $this;
    }

    /**
     * Remove ReceivedTransactions
     *
     * @param \OT\BackendBundle\Entity\TransactionRecord $receivedTransactions
     */
    public function removeReceivedTransaction(\OT\BackendBundle\Entity\TransactionRecord $receivedTransactions)
    {
        $this->ReceivedTransactions->removeElement($receivedTransactions);
    }

    /**
     * Get ReceivedTransactions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReceivedTransactions()
    {
        return $this->ReceivedTransactions;
    }

    /**
     * Add TeachingBookedTimes
     *
     * @param \OT\BackendBundle\Entity\BookedTime $teachingBookedTimes
     * @return User
     */
    public function addTeachingBookedTime(\OT\BackendBundle\Entity\BookedTime $teachingBookedTimes)
    {
        $this->TeachingBookedTimes[] = $teachingBookedTimes;

        return $this;
    }

    /**
     * Remove TeachingBookedTimes
     *
     * @param \OT\BackendBundle\Entity\BookedTime $teachingBookedTimes
     */
    public function removeTeachingBookedTime(\OT\BackendBundle\Entity\BookedTime $teachingBookedTimes)
    {
        $this->TeachingBookedTimes->removeElement($teachingBookedTimes);
    }

    /**
     * Get TeachingBookedTimes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTeachingBookedTimes()
    {
        return $this->TeachingBookedTimes;
    }

    /**
     * Add LearningBookedTimes
     *
     * @param \OT\BackendBundle\Entity\BookedTime $learningBookedTimes
     * @return User
     */
    public function addLearningBookedTime(\OT\BackendBundle\Entity\BookedTime $learningBookedTimes)
    {
        $this->LearningBookedTimes[] = $learningBookedTimes;

        return $this;
    }

    /**
     * Remove LearningBookedTimes
     *
     * @param \OT\BackendBundle\Entity\BookedTime $learningBookedTimes
     */
    public function removeLearningBookedTime(\OT\BackendBundle\Entity\BookedTime $learningBookedTimes)
    {
        $this->LearningBookedTimes->removeElement($learningBookedTimes);
    }

    /**
     * Get LearningBookedTimes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLearningBookedTimes()
    {
        return $this->LearningBookedTimes;
    }

    /**
     * Set Weekplan
     *
     * @param \OT\BackendBundle\Entity\Weekplan $weekplan
     * @return User
     */
    public function setWeekplan(\OT\BackendBundle\Entity\Weekplan $weekplan = null)
    {
        $this->Weekplan = $weekplan;

        return $this;
    }

    /**
     * Get Weekplan
     *
     * @return \OT\BackendBundle\Entity\Weekplan 
     */
    public function getWeekplan()
    {
        return $this->Weekplan;
    }
}
