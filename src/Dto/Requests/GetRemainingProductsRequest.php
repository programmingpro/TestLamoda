<?php

namespace App\Dto\Requests;

use Symfony\Component\Validator\Constraints as Assert;

class GetRemainingProductsRequest
{
    public function __construct(
        #[Assert\Type(type: 'numeric')]
        public readonly int $warehouseId,
    )
    {
    }
}