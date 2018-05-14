<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bench
 *
 * @ORM\Table(name="bench")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BenchRepository")
 */
class Bench
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="numberOfPerson", type="integer")
     */
    private $numberOfPerson;

    /**
     * One Bench has Many Reservations.
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Reservation", mappedBy="bench")
     */
    private $reservations;


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
     * Set name
     *
     * @param string $name
     * @return Bench
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
     * @return Bench
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
     * Set numberOfPerson
     *
     * @param integer $numberOfPerson
     * @return Bench
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
     * @return Reservation
     */
    public function getReservations()
    {
        return $this->reservations;
    }

    /**
     * @param Reservation $reservations
     */
    public function setReservations($reservations)
    {
        $this->reservations = $reservations;
    }
}
