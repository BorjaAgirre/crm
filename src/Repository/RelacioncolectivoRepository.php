<?php

namespace App\Repository;

use App\Entity\Relacioncolectivo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Relacioncolectivo>
 *
 * @method Relacioncolectivo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Relacioncolectivo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Relacioncolectivo[]    findAll()
 * @method Relacioncolectivo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RelacioncolectivoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Relacioncolectivo::class);
    }

    public function add(Relacioncolectivo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Relacioncolectivo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Relacioncolectivo[] Returns an array of Relacioncolectivo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Relacioncolectivo
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
