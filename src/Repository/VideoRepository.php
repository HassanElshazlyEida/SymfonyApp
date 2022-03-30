<?php

namespace App\Repository;

use App\Entity\Video;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\DependencyInjection\Container;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Video|null find($id, $lockMode = null, $lockVersion = null)
 * @method Video|null findOneBy(array $criteria, array $orderBy = null)
 * @method Video[]    findAll()
 * @method Video[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoRepository extends ServiceEntityRepository
{
    protected $container;
    public function __construct(ManagerRegistry $registry,PaginatorInterface $paginator)
    {
        parent::__construct($registry, Video::class);
        $this->paginator=$paginator;
     
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Video $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Video $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    public function findByChildIds(array $arr,$page= null,?string $sort){
        $sort= $sort != 'rating' ? $sort : 'ASC';
        $dbquery = $this->createQueryBuilder('v')
        ->where('v.category IN(:val)')
        ->setParameter('val',$arr)
        ->orderBy('v.title',$sort)
        ->getQuery ();
        if($page){
           $dbquery= $this->Paginated($dbquery,$page);
        } 
        return  $dbquery;
    }
    public function Paginated($dbquery,$page) {
        return  $this->paginator->paginate($dbquery, $page, 3);
    }
    public function findByTitle(string $query,?string $sort,$page=null){

        $sort= $sort != 'rating' ? $sort : 'ASC';
        $searchTerms= $this->prepareQuery($query);  
        $querybuilder = $this->createQueryBuilder('v');
        foreach($searchTerms as  $key=> $term) {
            $querybuilder
            ->orwhere ('v.title LIKE :t_'.$key)
            ->setParameter ('t_'. $key, '%'.trim($term). '%');
        }

        $dbquery= $querybuilder
        ->orderBy('v.title',$sort)
        ->getQuery();
        if($page){
            $dbquery= $this->Paginated($dbquery,$page);
        } 
        return  $dbquery;

    }

    private function prepareQuery(string $query){
        return explode(' ',$query);
    }
    // /**
    //  * @return Video[] Returns an array of Video objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Video
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
