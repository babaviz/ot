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
    private $roles;

    /**
     * 
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
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $is_admin;

    /**
     * @ORM\OneToMany(targetEntity="TransactionRecord", mappedBy="User")
     */
    private $TransactionRecords;

    /**
     * @ORM\OneToMany(targetEntity="FreeTime", mappedBy="User")
     */
    private $FreeTimes;

    /**
     * @ORM\ManyToMany(targetEntity="Course", inversedBy="Users")
     * @ORM\JoinTable(
     *     name="CourseHasUser",
     *     joinColumns={@ORM\JoinColumn(name="User_id", referencedColumnName="id", nullable=false)},
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
        $this->FreeTimes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Courses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    function getSalt()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
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
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
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
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
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
     * Set is_admin
     *
     * @param boolean $isAdmin
     * @return User
     */
    public function setIsAdmin($isAdmin)
    {
        $this->is_admin = $isAdmin;

        return $this;
    }

    /**
     * Get is_admin
     *
     * @return boolean 
     */
    public function getIsAdmin()
    {
        return $this->is_admin;
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
     * Add FreeTimes
     *
     * @param \OT\BackendBundle\Entity\FreeTime $freeTimes
     * @return User
     */
    public function addFreeTime(\OT\BackendBundle\Entity\FreeTime $freeTimes)
    {
        $this->FreeTimes[] = $freeTimes;

        return $this;
    }

    /**
     * Remove FreeTimes
     *
     * @param \OT\BackendBundle\Entity\FreeTime $freeTimes
     */
    public function removeFreeTime(\OT\BackendBundle\Entity\FreeTime $freeTimes)
    {
        $this->FreeTimes->removeElement($freeTimes);
    }

    /**
     * Get FreeTimes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFreeTimes()
    {
        return $this->FreeTimes;
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
     * Set roles
     *
     * @param array $roles
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array 
     */
    public function getRoles()
    {
        return str_split($this->roles,16);
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

}
