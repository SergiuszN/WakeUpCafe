<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="numberOfPerson", type="integer")
     */
    private $numberOfPerson;

    /**
     * Many Reservation have One Author.
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Bench", inversedBy="reservations")
     * @ORM\JoinColumn(name="bench", referencedColumnName="id")
     */
    private $bench;

    /**
     * @var bool
     *
     * @ORM\Column(name="state", type="boolean")
     */
    private $state;

    /**
     * Many Reservation have One Author.
     * @ORM\ManyToOne(targetEntity="User", inversedBy="reservations")
     * @ORM\JoinColumn(name="author", referencedColumnName="id")
     */
    private $author;

    /**
     * Reservation constructor.
     */
    public function __construct()
    {
        $this->date = new \DateTime();
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
     * @return Reservation
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
     * Set name
     *
     * @param string $name
     * @return Reservation
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
     * Set numberOfPerson
     *
     * @param integer $numberOfPerson
     * @return Reservation
     */
    public function setNumberOfPerson($numberOfPerson)
    {
        $this->numberOfPerson = $numberOfPerson;

        return $this;
    }

    /**
     * Get numberOfPerson
     *
     * @return integer 
     */
    public function getNumberOfPerson()
    {
        return $this->numberOfPerson;
    }

    /**
     * Get state
     *
     * @return bool
     */
    public function isState()
    {
        return $this->state;
    }

    /**
     * Set state
     *
     * @param bool $state
     * @return Reservation
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get author
     *
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set author
     *
     * @param User $author
     * @return Reservation
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return Bench
     */
    public function getBench()
    {
        return $this->bench;
    }

    /**
     * @param Bench $bench
     */
    public function setBench($bench)
    {
        $this->bench = $bench;
    }
}
