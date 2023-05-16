<?php
    require __DIR__ . '/vendor/autoload.php';
    use Phalcon\Autoload\Loader as PLoader;
    use Phalcon\Mvc\Micro\Collection as MicroCollection;
    use Phalcon\Di\FactoryDefault;
    use Phalcon\Db\Adapter\Pdo\Mysql;
    use josegonzalez\Dotenv\Loader as ConfLoader;
    use Phalcon\Mvc\Micro;


    //load needed module
    $loader=new PLoader();
    $loader->setNamespaces(
        [
            'MyApp\Repository'=>'repository',
            'MyApp\Models' => 'models',
            'MyApp\Controllers' => 'controllers',
        ]
    );

    $loader->register();
    //Load DI container
    $DIcontainer = new FactoryDefault();
    $DIcontainer->set(
        'app_conf',
        function (){
            return (new ConfLoader('.env'))->parse()->toArray();
        }
    );
    $DIcontainer->set(
        'db',
        function (){
            $config=$this->get('app_conf');
            return new Mysql(
                [
                    "host"=>$config["DB_ADDRESS"],
                    "dbname"=>$config["DB_NAME"],
                    "port"=>$config["DB_PORT"],
                    "username"=> $config["DB_USER"],
                    "password"=>$config["DB_PASSWORD"]
                ]
            );
        }
    );

    
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
        ->get("/","getAddress");

    $products = new MicroCollection();
    $products
        ->setHandler(MyApp\Controllers\ProductController::class,True)
        ->setPrefix('/api/product')
        ->get('/', 'index')
        ->post("/","post")
        ->delete("/{id:[0-g9]+}",'delete')
        ->put("/",'edit');
    $productSupply = new MicroCollection();
    $productSupply
        -> setHandler(MyApp\Controllers\ProductSupplyController::class,true)
        -> setPrefix("/api/productsupply")
        -> get("/supplier", "getSuppliersOfProduct")
        -> delete("/{id:[0-9]+}", "deleteProductSupply")
        -> post("/","newProductSupply");

    $app=new Micro($DIcontainer);

    $app->mount($suppliers);
    $app->mount($addresses);
    $app->mount($products);
    $app->mount($productSupply);
    $app->notFound(function(){

        echo "Page not found";
    });
    $app->handle($_SERVER["REQUEST_URI"]);


    


