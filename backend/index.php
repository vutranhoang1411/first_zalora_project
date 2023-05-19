<?php
    require __DIR__ . '/vendor/autoload.php';
    use Phalcon\Autoload\Loader as PLoader;
    use Phalcon\Mvc\Micro\Collection as MicroCollection;    
    use Phalcon\Mvc\Micro;


    //load needed module
    $loader=new PLoader();
    $loader->setNamespaces(
        [
            'MyApp\Repository'=>'repository',
            'MyApp\Models' => 'models',
            'MyApp\Controllers' => 'controllers',
            'MyApp\DI'=>'di',
        ]
    );

    $loader->register();
    //Load DI container
    $MyDI=MyApp\DI\MyDI::getMyDI();
    //router object;
    $suppliers=new MicroCollection();
    $suppliers
        ->setHandler(MyApp\Controllers\SupplierController::class,true)
        ->setPrefix("/api/supplier")
        ->get("/","getAllSupplier")
        ->post("/","newSupplier")
        ->put("/","updateSupplier")
        ->delete("/{id:[0-9]+}","deleteSupplier");

    $addresses=new MicroCollection();
    $addresses
        ->setHandler(MyApp\Controllers\AddressController::class,true)
        ->setPrefix("/api/address")
        ->get("/","getAddress")
        ->put("/","updateAddress")
        ->delete("/{id:[0-9]+}","deleteAddress")
        ->post("/","newAddress");
    $products = new MicroCollection();
    $products
        ->setHandler(MyApp\Controllers\ProductController::class,True)
        ->setPrefix('/api/product')
        ->get('/', 'getProductsList')
        ->post("/","addProduct")
        ->delete("/{id:[0-9]+}",'deleteProduct')
        ->put("/",'editProduct');
    $productSupply = new MicroCollection();
    $productSupply
        -> setHandler(MyApp\Controllers\ProductSupplyController::class,true)
        -> setPrefix("/api/productsupply")
        -> get("/supplier", "getSuppliersOfProduct")
        -> delete("/{id:[0-9]+}", "deleteProductSupply")
        -> post("/","newProductSupply");

    $app=new Micro($MyDI);

    $app->mount($suppliers);
    $app->mount($addresses);
    $app->mount($products);
    $app->mount($productSupply);
    $app->notFound(function(){
        echo "Page not found";
    });
    $app->handle($_SERVER["REQUEST_URI"]);


    


