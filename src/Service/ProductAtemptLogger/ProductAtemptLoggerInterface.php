<?php
namespace App\Service\ProductAtemptLogger;

interface ProductAtemptLoggerInterface
{
    /**
     * @param string $id
     * @return mixed
     */
    public function updateCacheValue(string $id);

    /**
     * @param string $id
     * @return mixed
     */
    public function storeData();

    /**
     * @param int $id
     * @return mixed
     */
    public function updateIdValue(string $id);


}