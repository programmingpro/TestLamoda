<?php

namespace App\Controller;

use App\Dto\Requests\GetRemainingProductsRequest;
use App\Dto\Requests\ReleaseReservedProductsRequest;
use App\Repository\ProductRepository;
use App\Repository\ReservationRepository;
use App\Repository\WarehouseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Dto\Requests\ReserveProductsRequest;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;


class WarehouseManagerController extends AbstractController
{
    #[Route('/warehouse/manager/reserve-products', name: 'reserve_products', methods: ['POST'])]
    public function reserveProducts(
        #[MapRequestPayload] ReserveProductsRequest $reserveProductsRequest,
        ProductRepository $productRepository,
        ReservationRepository $reservationRepository,
        WarehouseRepository $warehouseRepository
    ): JsonResponse
    {
        $warehouseData = $warehouseRepository->findOneBy(['id' => $reserveProductsRequest->warehouseId]);

        if(!isset($warehouseData)) {
            return new JsonResponse([
                'status' => 'fail',
                'reason' => 'The warehouse was not found',
            ]);
        }

        if(!$warehouseData->isAvailable()) {
            return new JsonResponse([
                'status' => 'fail',
                'reason' => 'The warehouse is unavailable',
            ]);
        }

        foreach ($reserveProductsRequest->listOfProducts as $product_code) {
            $productData = $productRepository->findOneBy(['code' => $product_code]);

            if(!isset($productData)) {
                return new JsonResponse([
                    'status' => 'fail',
                    'reason' => "The product with code {$product_code} was not found",
                ]);
            }

            if (count($reservationRepository->findReservationsByProductCode($product_code)) > 0) {
                return new JsonResponse([
                    'status' => 'fail',
                    'reason' => "The product with code {$product_code} has been reserved",
                ]);
            }
        }

        $reservationRepository->createReservationsByProductCodeList(
            $reserveProductsRequest->listOfProducts,
            $reserveProductsRequest->warehouseId
        );

        return new JsonResponse(['status' => 'success']);
    }

    #[Route('/warehouse/manager/release-reserved-products', name: 'release_reserved_products', methods: ['POST'])]
    public function releaseProducts(
        #[MapRequestPayload] ReleaseReservedProductsRequest $releaseReservedProductsRequest,
        ProductRepository $productRepository,
        ReservationRepository $reservationRepository,
    ): JsonResponse
    {
        foreach ($releaseReservedProductsRequest->listOfProducts as $product_code) {
            $productData = $productRepository->findOneBy(['code' => $product_code]);

            if(!isset($productData)) {
                return new JsonResponse([
                    'status' => 'fail',
                    'reason' => "The product with code {$product_code} was not found",
                ]);
            }

            if (count($reservationRepository->findReservationsByProductCode($product_code)) === 0) {
                return new JsonResponse([
                    'status' => 'fail',
                    'reason' => "The product with code {$product_code} has been released",
                ]);
            }
        }

        $reservationRepository->releaseReservationsByProductCodeList($releaseReservedProductsRequest->listOfProducts);

        return new JsonResponse(['status' => 'success']);
    }

    #[Route('/warehouse/manager/remaining-products/', name: 'remaining_products_count', methods: ['POST'])]
    public function getRemainingProductsByWarehouseId(
        #[MapRequestPayload] GetRemainingProductsRequest $getRemainingProductsRequest,
        WarehouseRepository $warehouseRepository,
        ReservationRepository $reservationRepository,
    ): JsonResponse
    {
        $warehouseData = $warehouseRepository->findOneBy(['id' => $getRemainingProductsRequest->warehouseId]);

        if(!isset($warehouseData)) {
            return new JsonResponse([
                'status' => 'fail',
                'reason' => 'The warehouse was not found',
            ]);
        }

        $remainingProducts = $reservationRepository->findReservationByWarehouseId($getRemainingProductsRequest->warehouseId);

        return new JsonResponse([
            'status' => 'success',
            'count_remaining_products' => count($remainingProducts)
        ]);
    }
}
