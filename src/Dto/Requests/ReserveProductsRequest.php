<?php

namespace App\Dto\Requests;

use Symfony\Component\Validator\Constraints as Assert;

class ReserveProductsRequest
{
    public function __construct(
        #[Assert\All([
            new Assert\NotBlank,
            new Assert\Length(max: 25),
        ])]
        #[Assert\Unique]
        public readonly array $listOfProducts,

        #[Assert\Type(type: 'numeric')]
        public readonly int $warehouseId,
    )
    {
    }
}