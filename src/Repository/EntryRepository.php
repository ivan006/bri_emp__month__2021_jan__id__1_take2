<?php

namespace App\Repository;

use App\Entity\Entry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
* @method Entry|null find($id, $lockMode = null, $lockVersion = null)
* @method Entry|null findOneBy(array $criteria, array $orderBy = null)
* @method Entry[]    findAll()
* @method Entry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
*/
class EntryRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Entry::class);
  }

  // /**
  //  * @return Entry[] Returns an array of Entry objects
  //  */

  // public function findByExampleField($value)
  // {
  //     return $this->createQueryBuilder('e')
  //         ->andWhere('e.exampleField = :val')
  //         ->setParameter('val', $value)
  //         ->orderBy('e.id', 'ASC')
  //         ->setMaxResults(10)
  //         ->getQuery()
  //         ->getResult()
  //     ;
  // }
  //
  //
  //
  // public function findOneBySomeField($value): ?Entry
  // {
  //     return $this->createQueryBuilder('e')
  //         ->andWhere('e.exampleField = :val')
  //         ->setParameter('val', $value)
  //         ->getQuery()
  //         ->getOneOrNullResult()
  //     ;
  // }

  public function transform(Entry $entry)
  {
    return [
      'id'    => (int) $entry->getId(),
      'name' => (string) $entry->getName(),
      'email' => (string) $entry->getEmail(),
      'message' => (string) $entry->getMessage()
    ];
  }

  public function transformAll()
  {
    $entries = $this->findAll();
    $entriesArray = [];

    foreach ($entries as $entry) {
      $entriesArray[] = $this->transform($entry);
    }

    return $entriesArray;
  }

}
