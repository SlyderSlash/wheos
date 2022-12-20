<?php

namespace App\Repository;

use App\Entity\ForumMessages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ForumMessages>
 *
 * @method ForumMessages|null find($id, $lockMode = null, $lockVersion = null)
 * @method ForumMessages|null findOneBy(array $criteria, array $orderBy = null)
 * @method ForumMessages[]    findAll()
 * @method ForumMessages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ForumMessagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ForumMessages::class);
    }

    public function add(ForumMessages $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ForumMessages $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return ForumMessages[] Returns an array of ForumMessages objects
     */
    public function findByForumMessages(): array
    {
        return $this->createQueryBuilder('f')
            ->select('IDENTITY(f.forum) AS forum,count(f.forum) AS NB')
            ->groupBy('f.forum')
            ->orderBy('f.forum', 'ASC')
            ->getQuery()
            ->getResult()
       ;
    }

    public function findAllForumMessages(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT f.id as forum,f.category_id as category,u.first_name as prenom, 
                    f.title as titre,count(f.id) as nb  FROM forums f
            LEFT JOIN forum_messages fm ON f.id = fm.forum_id
            LEFT JOIN users u ON f.user_id = u.id
            group by f.id
            ORDER BY f.category_id asc,f.id ASC
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function findByForums($forumId): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT 
                fm.user_id as user, 
                fm.forum_id as forum, 
                f.title as titre,
                f.category_id as category,
                c.name as cName,
                fm.content as message, 
                fm.created_at as dt 
            FROM forum_messages fm
            LEFT JOIN forums f ON fm.forum_id = f.id
            LEFT JOIN categories c ON f.category_id = c.id
            WHERE fm.forum_id= :val
            ORDER BY fm.created_at DESC
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['val' => $forumId]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

    public function findByLastMessages($forumId): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT 
                fm.user_id as user, 
                fm.forum_id as forum, 
                f.title as titre,
                f.category_id as category,
                c.name as cName,
                fm.content as message, 
                fm.created_at as dt 
            FROM forum_messages fm
            LEFT JOIN forums f ON fm.forum_id = f.id
            LEFT JOIN categories c ON f.category_id = c.id
            WHERE f.category_id= :val
            ORDER BY fm.created_at DESC
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['val' => $forumId]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }

//    public function findOneBySomeField($value): ?ForumMessages
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
