<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use App\Entity\Product;
use App\Entity\Warehouse;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
#[ORM\Table(name: "reservations")]
class Reservation
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: "App\Entity\Product")]
    #[ORM\JoinColumn(name: "product_code", referencedColumnName: "code")]
    private Product $product;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: "App\Entity\Warehouse")]
    #[ORM\JoinColumn(name: "warehouse_id", referencedColumnName: "id")]
    private Warehouse $warehouse;

    public function __construct(Product $product = null, Warehouse $warehouse = null)
    {
        $this->product = $product;
        $this->warehouse = $warehouse;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function getWarehouse(): Warehouse
    {
        return $this->warehouse;
    }

    public function setWarehouse(Warehouse $warehouse): void
    {
        $this->warehouse = $warehouse;
    }
}
