<?php
namespace App\Service\DataDriver;


class MySqlDriver
{
    public function findProudct(string $id)
    {
        $product = new class {
            public $id;
            public $name = '';
        };
        $product->id = $id;
        $product->name = "Name - ".$id;

        return $product;
    }
}