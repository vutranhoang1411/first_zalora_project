<?php
namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\InclusionIn;
use Phalcon\Filter\Validation\Validator\Uniqueness;

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
    public function beforeValidationOnCreate()
    {
        $this->sku =$this->generateNewSku($this->name, $this->brand, $this->size, $this->color);
    }
    public function beforeValidationOnUpdate()
    {
        $this->sku = $this->generateNewSku($this->name, $this->brand, $this->size, $this->color);
    }

    protected function generateNewSku($product_name, $brand_name, $size, $color) {
        $string = sprintf("%d%d%s%s", $product_name, $brand_name, $size, $color);
        $hash = md5($string);
        return substr($hash, 0, 20);
    }
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'sku',
            new Uniqueness(
                [
                    'message' => 'The SKU must be unique. That means this combination name-brand-size-color is exist in our database',
                ]
            )
        );

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