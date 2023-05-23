<?php

namespace App\Repository;

use App\Entity\Devis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<Devis>
 *
 * @method Devis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Devis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Devis[]    findAll()
 * @method Devis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Devis::class);
    }

    public function add(Devis $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Devis $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function getAllDevisInformations()
    {
        $qb = $this->createQueryBuilder('d');
        $qb->select('d.id', 'd.date', 'u.nom as user_nom', 'u.prenom', 'h.nom as haie_nom', 'h.prix', 'd.longueur', 'd.hauteur')
            ->innerJoin('d.user', 'u')
            ->innerJoin('d.haie', 'h')
            ->orderBy('d.date', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function getDevisInformationById(Devis $devis)
    {
        $qb = $this->createQueryBuilder('d');
        $qb->select('d.id', 'd.date', 'u.nom as user_nom', 'u.prenom', 'u.cp', 'u.roles', 'u.adresse', 'u.ville', 'u.email', 'u.type_client', 'h.nom as haie_nom', 'h.prix', 'd.longueur', 'd.hauteur')
            ->innerJoin('d.user', 'u')
            ->innerJoin('d.haie', 'h')
            ->setParameter('id', $devis->getId())
            ->where('d.id = :id')
            ->orderBy('d.date', 'DESC');

        return $qb->getQuery()->getResult();
    }

}

//    /**
//     * @return Devis[] Returns an array of Devis objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Devis
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
