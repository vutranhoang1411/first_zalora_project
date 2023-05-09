<?php
namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\Filter\Validation;

class Supplier extends Model
{
    public $id;
    public $name;
    public $email;
    public $number;
    public $total_stock;
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
            'supplierid',
            'productid',
            Product::class,
            'id'
        );

        $this->hasMany(
            'id',
            Productsupply::class,
            'supplierid'
        );

        $this->hasMany(
            'id',
            Address::class,
            'supplierid'
        );
    }

    public function validation()
    {
    }
}
