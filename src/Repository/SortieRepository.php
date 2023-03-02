<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Participant;
use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sortie>
 *
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function add(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Sortie[] Returns an array of Sortie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sortie
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    /**
     * @return Sortie[]
     */
    public function findSearch(SearchData $search, Participant $participant): array
    {
       $query = $this
           ->createQueryBuilder('s')
           ->select('c','s','e')
           ->join('s.campus', 'c')
            ->join('s.etat', 'e');

            if(!empty($search->q)){
                $query = $query
                    ->andWhere('s.nom LIKE :q')
                    ->setParameter('q',"%{$search->q}%");
            }
            if (!empty($search->campus)){
                $query = $query
                    ->andWhere('s.campus = :campus')
                    ->setParameter('campus', $search->campus);
            }
            if (!empty($search->dateFrom)){
                $query = $query
                ->andWhere('s.dateHeureDebut >= :dateFrom')
                ->setParameter('dateFrom', $search->dateFrom);
            }
            if (!empty($search->dateTo)) {
                $query = $query
                ->andWhere('s.dateHeureDebut <= :dateTo')
                ->setParameter('dateTo', $search->dateTo);
            }
            if ($search->sortiesOrga){
                $query = $query
                ->andWhere('s.organisateur = :sortiesOrga')
                ->setParameter('sortiesOrga', $participant);
            }
            if ($search->sortiesInscrit){
                $query = $query
                ->andWhere(':sortiesInscrit MEMBER OF s.participants')
                ->setParameter('sortiesInscrit', $participant);
            }
            if ($search->sortiesNonInscrit){
                $query = $query
                ->andWhere(':sortiesnonInscrit NOT MEMBER OF s.participants')
                ->setParameter('sortiesnonInscrit', $participant);
            }
             if ($search->sortiesPassees){
                $query = $query
                    ->andWhere('e.libelle = :etat')
                    ->setParameter('etat', 'Passée' );
            }
        return $query->getQuery()->getResult();

    }
}
