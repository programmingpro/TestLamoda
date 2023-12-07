<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;
use App\Entity\Warehouse;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Reservation>
 *
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Reservation::class);
        $this->entityManager = $entityManager;
    }

    public function createReservationsByProductCodeList(array $productCodeList, int $warehouseId): void
    {
        $entityManager = $this->entityManager;

        $connection = $entityManager->getConnection();

        $connection->beginTransaction();

        foreach ($productCodeList as $productCode) {
            $product = $entityManager->find(Product::class, $productCode);
            $warehouse = $entityManager->find(Warehouse::class, $warehouseId);
            $reservation = new Reservation($product, $warehouse);

            $entityManager->persist($reservation);
        }

        $entityManager->flush();

        $connection->commit();
    }

    public function releaseReservationsByProductCodeList(array $productCodeList): void
    {
        $entityManager = $this->entityManager;

        $connection = $entityManager->getConnection();

        $connection->beginTransaction();


        foreach ($productCodeList as $productCode) {
            $reservations = $this->findReservationsByProductCode($productCode);
            foreach ($reservations as $reservation) {
                $entityManager->remove($reservation);
            }
        }

        $entityManager->flush();

        $connection->commit();
    }

    public function findReservationsByProductCode(string $productCode): array
    {
        $qb = $this->createQueryBuilder('r');
        $qb->where('r.product = :productCode')
            ->setParameter('productCode', $productCode);

        return $qb->getQuery()->getResult();
    }

    public function findReservationByWarehouseId(int $warehouseId): array
    {
        $qb = $this->createQueryBuilder('r');
        $qb->where('r.warehouse = :warehouseId')
            ->setParameter('warehouseId', $warehouseId);

        return $qb->getQuery()->getResult();
    }
}
