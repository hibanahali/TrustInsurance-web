<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArticlesCommentaires
 *
 * @ORM\Table(name="articles_commentaires")
 * @ORM\Entity(repositoryClass="BackBundle\Repository\ArticlesCommentairesRepository")
 */
class ArticlesCommentaires
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
     * @ORM\Column(name="commentaire", type="string", length=255)
     */
    private $commentaire;

     /**
     * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Article",inversedBy="commentaires",cascade={"persist"})
     * @ORM\JoinColumn(name="article",referencedColumnName="id")
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity="FrontBundle\Entity\User",inversedBy="commentaires",cascade={"persist"})
     * @ORM\JoinColumn(name="utilisateur",referencedColumnName="id")
     */
    private $utilisateur;

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
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return ArticlesCommentaires
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set article
     *
     * @param \BackBundle\Entity\Article $article
     *
     * @return ArticlesCommentaires
     */
    public function setArticle(\BackBundle\Entity\Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \BackBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set utilisateur
     *
     * @param \FrontBundle\Entity\User $utilisateur
     *
     * @return ArticlesCommentaires
     */
    public function setUtilisateur(\FrontBundle\Entity\User $utilisateur = null)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \FrontBundle\Entity\User
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }
}
