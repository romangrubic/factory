<?php

namespace App\Repository;

use App\Entity\Meals;
use Carbon\Carbon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Meals>
 *
 * @method Meals|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meals|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meals[]    findAll()
 * @method Meals[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MealsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Meals::class);
    }

    public function add(Meals $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Meals $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getMeals($parameters)
    {
        // dd($parameters);
        $q = $this->createQueryBuilder('m')
            ->select('m');

        /**
         * With filter
         */
        if (isset($parameters['with'])) {
            $with = array_filter(explode(',', $parameters['with']));

            if (in_array('tags', $with)) {
                $q->leftJoin('m.tags', 't')
                    ->addSelect('t');
            }

            if (in_array('ingredients', $with)) {
                $q->leftJoin('m.ingredients', 'i')
                    ->addSelect('i');
            }

            if (in_array('category', $with)) {
                $q->leftJoin('m.category_id', 'c', 'with', 'm.category_id = c.id')
                    ->addSelect('c');
            }
        }

        /**
         * Category filter
         */
        if (isset($parameters['category'])) {
            switch ($parameters['category']) {
                case('NULL'):
                    $q->andWhere('m.category_id IS NULL');
                    break;
                case('!NULL'):
                    $q->andWhere('m.category_id IS NOT NULL');
                    break;
                default:
                    $q->andWhere('m.category_id = '. $parameters['category']);
                    break;
            }
        }

        // if (isset($parameters['tags'])) {
        //     $tagArray = explode(',', $parameters['tags']);
        //     $count = count($tagArray);
            
        //     $q->expr()->exists('SELECT 1
        //                         FROM meals_tags mt
        //                         WHERE m.id = mt.meals AND
        //                             mt.tags IN (14)
        //                             HAVING COUNT(1) = 1');
        // }

        /**
         * Diff_time filter
         */
        if (isset($parameters['diff_time'])) {
            $timestamp = Carbon::createFromTimestamp($parameters['diff_time']);

            $q->andWhere('m.updated_at >= :timestamp')
              ->setParameter('timestamp', $timestamp);
        }

        $query = $q->getQuery();
        
        // dd($query);

        return $query;
    }

//    /**
//     * @return Meals[] Returns an array of Meals objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Meals
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
