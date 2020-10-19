<?php
namespace App\Service\DataDriver;

class DriverFactory
{
    public function initializeDriver ($driverType){
        if  ($driverType === 'mysql'){
            return new MySqlDriver();
        } elseif ($driverType === 'elastic'){
            return new ElasticSearchDriver();
        } else {
            throw new \Exception("Driver not found");
        }
    }
}