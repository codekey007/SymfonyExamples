<?php

namespace App\Controller\Product;

use App\Service\ProductAtemptLogger\ProductAtemptLoggerFileService;
use App\Service\DataDriver\DataDriverService;

use App\Service\ProductAtemptLogger\ProductAtemptLoggerInterface;
use Psr\Cache\CacheItemInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


class ProductController extends AbstractController
{
    /**
     *
     * @param Request $request
     * @param string $id
     * @param AdapterInterface $cache
     * @param DataDriverService $dataDriver
     * @param ProductAtemptLoggerInterface $fileLoggerService
     * @return JsonResponse
     *
     * @Route("/product/{id}", name="product_product")
     */
    public function index(Request $request, string $id, AdapterInterface $cache, DataDriverService $dataDriver, ProductAtemptLoggerInterface $AtemptLoggerService)
    {
        $productCacheKey = "product.$id";

        // Get item product form cache
        $cacheItem = $cache->getItem($productCacheKey);

        if (!$cacheItem->isHit() && $cacheItem instanceof CacheItemInterface){
            // product not in cache get from db/elasic
            $product = $dataDriver->getProductById($id);
            $cacheItem->set($product);
            $cache->save($cacheItem);

        }
        $product = $cacheItem->get();

        // Increst value in atempt logger by id
        $AtemptLoggerService->updateIdValue($id);

        // Return response in Json
        return new JsonResponse($product);
    }
}
