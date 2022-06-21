<?php

/**
 * This file contains Meals repository methods
 */

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
    
    /**
     * Main method for getting data filtered by parameters array
     *
     * @param  array $parameters
     * @return void
     */
    public function getMeals($parameters)
    {
        $query = $this->createQueryBuilder('m')
                ->select('m');

        /**
         * With filter
         */
        if (isset($parameters['with'])) {
            $with = array_filter(explode(',', $parameters['with']));

            if (in_array('tags', $with)) {
                $query->leftJoin('m.tags', 't');
                    // ->addSelect('t');
            }

            if (in_array('ingredients', $with)) {
                $query->leftJoin('m.ingredients', 'i');
                    // ->addSelect('i');
            }

            if (in_array('category', $with)) {
                $query->leftJoin('m.category_id', 'c', 'with', 'm.category_id = c.id');
                    // ->addSelect('c');
            }
        }

        /**
         * Category filter
         */
        if (isset($parameters['category'])) {
            switch ($parameters['category']) {
                case('NULL'):
                    $query->andWhere('m.category_id IS NULL');
                    break;
                case('!NULL'):
                    $query->andWhere('m.category_id IS NOT NULL');
                    break;
                default:
                    $query->andWhere('m.category_id = '. $parameters['category']);
                    break;
            }
        }

        /**
         * Diff_time filter
         */
        if (isset($parameters['diff_time'])) {
            $timestamp = Carbon::createFromTimestamp($parameters['diff_time']);

            $query->andWhere('m.updated_at >= :timestamp')
              ->setParameter('timestamp', $timestamp);
        }

        /**
         * Tags filter
         */
        if (isset($parameters['tags'])) {
            $tagArray = explode(',', $parameters['tags']);
            
            $query->andWhere($query->expr()->exists('SELECT 1
                                            FROM App\Entity\MealsTags mt
                                            WHERE m.id = mt.meals 
                                            AND mt.tags IN (:tagsArray)
                                            HAVING COUNT(1) = :count'))
                  ->setParameter('tagsArray', $tagArray)
                  ->setParameter('count', count($tagArray));
        }

        /**
         * Return query for paginator (not results!)
         */
        return $query->getQuery();
    }
}
