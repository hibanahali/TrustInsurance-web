<?php
namespace FrontBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class ArticleRepository extends EntityRepository
{
    /*
    public function findTitle($title)
    {
        $q=$this->createQueryBuilder('m')
            ->where('m.title LIKE :title')
            ->setParameter(':title',"%$title%");
        return $q->getQuery()->getResult();
    }
    */
    /*
    public function findMulti($find)
    {
        $q=$this->createQueryBuilder('m')
            ->where('m.titre LIKE :find')->orWhere('m.texte LIKE :find')->orWhere('m.lastModification LIKE :find')
            ->setParameter(':find',"%$find%");
        return $q->getQuery()->getResult();
    }
    */
}
