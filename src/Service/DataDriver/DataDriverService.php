<?php

namespace App\Service\DataDriver;

class DataDriverService
{
    private $driverType;
    private $driver;

    /**
     * DataDriverService constructor.
     * @param string $driverType
     * @throws \Exception
     */
    public function __construct(string $driverType)
    {
        $this->driverType = $driverType;
        $driverFactory = new DriverFactory();
        $this->driver = $driverFactory->initializeDriver($this->driverType);
    }

    /**
     * @param string $id
     * @return string
     * @throws \Exception
     */
    public function getProductById(string $id)
    {
        if ($this->driverType === 'mysql'){
            return $this->driver->findProudct($id);
        } elseif ($this->driverType === 'elastic'){
            return $this->driver->findById($id);
        } else {
            throw new \Exception("Driver not found in DataDriver");
        }
    }
}