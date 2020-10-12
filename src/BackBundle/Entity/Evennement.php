<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evennement
 *
 * @ORM\Table(name="evennement")
 * @ORM\Entity(repositoryClass="BackBundle\Repository\EvennementRepository")
 */
class Evennement
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="text")
     */
    private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer",nullable=true)
     */
    private $status;

    /**
     * @var int
     *
     * @ORM\Column(name="participants", type="integer")
     */
    private $participants;
    

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_modification", type="datetime",nullable=true)
     */
    private $lastModification;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="due_date", type="datetime",nullable=true)
     */
    private $DueDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime")
     */
    private $StartDate;

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
     * Set titre
     *
     * @param string $titre
     *
     * @return Evennement
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Evennement
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
     * Set image
     *
     * @param string $image
     *
     * @return Evennement
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Evennement
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return Evennement
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }



    /**
     * Set lastModification
     *
     * @param \DateTime $lastModification
     *
     * @return Evennement
     */
    public function setLastModification($lastModification)
    {
        $this->lastModification = $lastModification;

        return $this;
    }

    /**
     * Get lastModification
     *
     * @return \DateTime
     */
    public function getLastModification()
    {
        return $this->lastModification;
    }

    /**
     * Set dueDate
     *
     * @param \DateTime $dueDate
     *
     * @return Evennement
     */
    public function setDueDate($dueDate)
    {
        $this->DueDate = $dueDate;

        return $this;
    }

    /**
     * Get dueDate
     *
     * @return \DateTime
     */
    public function getDueDate()
    {
        return $this->DueDate;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->participants = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add participant
     *
     * @param \FrontBundle\Entity\User $participant
     *
     * @return Evennement
     */
    public function addParticipant(\FrontBundle\Entity\User $participant)
    {
        $this->participants[] = $participant;

        return $this;
    }

    /**
     * Remove participant
     *
     * @param \FrontBundle\Entity\User $participant
     */
    public function removeParticipant(\FrontBundle\Entity\User $participant)
    {
        $this->participants->removeElement($participant);
    }

    /**
     * Get participants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Evennement
     */
    public function setStartDate($startDate)
    {
        $this->StartDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->StartDate;
    }

    /**
     * Set participants
     *
     * @param integer $participants
     *
     * @return Evennement
     */
    public function setParticipants($participants)
    {
        $this->participants = $participants;

        return $this;
    }
}
