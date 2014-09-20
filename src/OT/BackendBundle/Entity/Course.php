<?php
namespace OT\BackendBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="OT\BackendBundle\Entity\CourseRepository")
 *
 */
class Course
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true, length=32, nullable=false)
     */
    private $course_id;

    /**
     * @ORM\Column(type="string", length=64, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $duration;

    /**
     * @ORM\Column(type="float", nullable=false)
     */
    private $price;

    /**
     * @ORM\Column(type="text", length=16, nullable=false)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="BookedTime", mappedBy="Course")
     */
    private $BookedTimes;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="Courses")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $Category;


    /**
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="course_teacher",
     *      joinColumns={@ORM\JoinColumn(name="teacher_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="course_id", referencedColumnName="id")}
     *      )
     **/
    private $teachers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->BookedTimes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->Users = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set course_id
     *
     * @param string $courseId
     * @return Course
     */
    public function setCourseId($courseId)
    {
        $this->course_id = $courseId;

        return $this;
    }

    /**
     * Get course_id
     *
     * @return string
     */
    public function getCourseId()
    {
        return $this->course_id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Course
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
     * Set description
     *
     * @param string $description
     * @return Course
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     * @return Course
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Course
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Course
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
     * Add BookedTimes
     *
     * @param \OT\BackendBundle\Entity\BookedTime $bookedTimes
     * @return Course
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
     * Set Category
     *
     * @param \OT\BackendBundle\Entity\Category $category
     * @return Course
     */
    public function setCategory(\OT\BackendBundle\Entity\Category $category = null)
    {
        $this->Category = $category;

        return $this;
    }

    /**
     * Get Category
     *
     * @return \OT\BackendBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->Category;
    }


    /**
     * Add teachers
     *
     * @param \OT\BackendBundle\Entity\User $teachers
     * @return Course
     */
    public function addTeacher(\OT\BackendBundle\Entity\User $teachers)
    {
        $this->teachers[] = $teachers;

        return $this;
    }

    /**
     * Remove teachers
     *
     * @param \OT\BackendBundle\Entity\User $teachers
     */
    public function removeTeacher(\OT\BackendBundle\Entity\User $teachers)
    {
        $this->teachers->removeElement($teachers);
    }

    /**
     * Get teachers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTeachers()
    {
        return $this->teachers;
    }
}
