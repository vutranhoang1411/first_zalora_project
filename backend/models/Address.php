<?php
namespace MyApp\Models;

use Phalcon\Mvc\Model;
class Address extends Model
{
    public $id;
    public $addr;
    public $type;
    public  $supplierid;
    public function initialize()
    {
        $this->skipAttributes(
            [
                'id',
            ]
        );
        $this->belongsTo(
            'supplierid',
            Supplier::class,
            'id'
        );
    }

}