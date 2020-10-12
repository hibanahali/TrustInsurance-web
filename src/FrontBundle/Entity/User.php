<?php
// src/AppBundle/Entity/User.php

namespace FrontBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="BackBundle\Entity\ArticlesCommentaires",mappedBy="utilisateur")
     */
    private $commentaires;

    

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Add commentaire
     *
     * @param \BackBundle\Entity\ArticlesCommentaires $commentaire
     *
     * @return User
     */
    public function addCommentaire(\BackBundle\Entity\ArticlesCommentaires $commentaire)
    {
        $this->commentaires[] = $commentaire;

        return $this;
    }

    /**
     * Remove commentaire
     *
     * @param \BackBundle\Entity\ArticlesCommentaires $commentaire
     */
    public function removeCommentaire(\BackBundle\Entity\ArticlesCommentaires $commentaire)
    {
        $this->commentaires->removeElement($commentaire);
    }

    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }
}
