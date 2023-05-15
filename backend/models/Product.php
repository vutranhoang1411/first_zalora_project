<?php
namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\InclusionIn;
use Phalcon\Filter\Validation\Validator\GreaterThan;

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
            'productid',
            [
                'alias'    => 'ProductSupply'
            ]
        );
    }

    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            "status",
            new InclusionIn(
                [
                    'message' => 'Type must be "active", "inactive"',
                    'domain'  => [
                        'active',
                        'inactive',
                    ],
                ]
            )
        );
        //status: activate
        return $this->validate($validator);
    }
}