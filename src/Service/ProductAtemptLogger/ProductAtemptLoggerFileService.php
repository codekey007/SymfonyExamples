<?php
namespace App\Service\ProductAtemptLogger;


use mysql_xdevapi\Exception;

class ProductAtemptLoggerFileService implements ProductAtemptLoggerInterface
{
    private $fileAtemptPath = '';
    private $cacheData = [];

    public function __construct(string $fileAtemptPath = '')
    {
        $this->fileAtemptPath = $fileAtemptPath;
        // get file with stored data
        if (!file_exists($this->fileAtemptPath)){
            $file = fopen($this->fileAtemptPath, "x");
        }

        $fileContent = file_get_contents($this->fileAtemptPath);
        $this->cacheData = json_decode($fileContent, true);
    }

    public function updateCacheValue(string $id){
        if (isset($this->cacheData[$id])){
            $this->cacheData[$id]++;
        } else {
            $this->cacheData[$id] = 1;
        }
    }

    public function storeData()
    {
       try {
            $fileContent = json_encode($this->cacheData);
            $fileWireResult = file_put_contents($this->fileAtemptPath, $fileContent);
            return true;
        } catch (\Exception $exception){
            throw new Exception("Cache write error");
        }
    }

    public function updateIdValue(string $id)
    {
        $this->updateCacheValue($id);
        $this->storeData();

        return true;
    }
}