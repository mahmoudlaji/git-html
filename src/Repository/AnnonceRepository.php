<?php

namespace App\Repository;

use App\Entity\Annonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AnnonceRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Annonce::class);
    }

    public function getAnnonces($titre, $description, $slug, $enabled) {
        $qb = $this->createQueryBuilder("a");

        if ($titre) {
            $qb->andWhere("a.titre LIKE :titre")->setParameter("titre", '%' . trim($titre) . '%');
        }

        if ($description) {
            $qb->andWhere("a.discreption LIKE :discreption")->setParameter("discreption", '%' . trim($description) . '%');
        }

        if ($slug) {
            $qb->andWhere("a.slug = :slug")->setParameter("slug", trim($slug));
        }
        if ($enabled) {
            $qb->andWhere("a.enabled = :enabled")->setParameter("enabled", trim($enabled));
        }


        return $qb;
    }

}
