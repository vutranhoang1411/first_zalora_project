<?php
namespace MyApp\Models;

use Phalcon\Mvc\Model;

class ProductSupply extends Model
{
    public $id;
    public $productid;
    public $supplierid;
    public $stock;
    public function initialize()
    {
        $this->setSource(
            'productsupply'
        );
        $this->skipAttributes([
            'id',
        ]);

        $this->belongsTo('productid', Product::class, 'id');
        $this->belongsTo('supplierid', Supplier::class, 'id');
    }
}