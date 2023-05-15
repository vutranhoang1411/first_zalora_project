<?php
namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\Filter\Validation;

class Product extends Model
{
    public $id;
    public $name;
    public $brand;
    public $sku;
    public $size;
    public $color;
    public $status;

    public function initialize()
    {
        $this->skipAttributes(
            [
                'id',
            ]
        );

        $this->hasManyToMany(
            'id',
            Productsupply::class,
            'productid',
            'supplierid',
            Supplier::class,
            'id'
        );
        $this->hasMany(
            'id',
            Productsupply::class,
            'productid'
        );
    }

    public function validation()
    {

    }
}