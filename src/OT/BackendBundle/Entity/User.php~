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
     * @ORM\OneToMany(targetEntity="TransactionRecord", mappedBy="User")
     */
    private $TransactionRecords;

    /**
     * @ORM\OneToMany(targetEntity="Weekplan", mappedBy="User")
     */
    private $Weekplans;

    /**
     * @ORM\OneToMany(targetEntity="BookedTime", mappedBy="User")
     */
    private $BookedTimes;

    /**
     * @ORM\ManyToMany(targetEntity="Course", inversedBy="Teachers")
     * @ORM\JoinTable(
     *     name="CourseHasTeacher",
     *     joinColumns={@ORM\JoinColumn(name="teacher_id", referencedColumnName="id", nullable=false)},
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
        $this->password = $password;

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
}
