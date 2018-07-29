<?php

namespace TestAnnotationsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GENERATE ENTITY:
 * php bin/console doctrine:generate:entity
 *
 * Update Getters & Setters.
 * php bin/console doctrine:generate:entities TestAnnotationsBundle/Entity/Events
 *
 * [--dump-sql] shows the instruction.
 * php bin/console doctrine:schema:update --dump-sql
 * This command creates the tables.
 * php bin/console doctrine:schema:update --force
 */

/**
 * Events
 *
 * @ORM\Table(name="events")
 * @ORM\Entity(repositoryClass="TestAnnotationsBundle\Repository\EventsRepository")
 */
class Events
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="poblation", type="string", length=64)
     */
    private $population;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Events
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Events
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
     * Set city
     *
     * @param string $city
     *
     * @return Events
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set poblation
     *
     * @param string $population
     *
     * @return Events
     */
    public function setPopulation($population)
    {
        $this->population = $population;

        return $this;
    }

    /**
     * Get poblation
     *
     * @return string
     */
    public function getPopulation()
    {
        return $this->population;
    }
}