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
        'supplier_repo',
        new MyApp\Repository\SupplierRepo($DIcontainer)
    );
    $DIcontainer->set(
        'productsup_repo',
        new MyApp\Repository\ProductSupRepo($DIcontainer)
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
        ->setPrefix("/supplier")
        ->get("/","getAllSupplier")
        ->post("/","newSupplier")
        ->put("/","updateSupplier")
        ->delete("/{id:[0-9]+}","deleteSupplier");
    $addresses=new MicroCollection();
    $addresses
        ->setHandler(MyApp\Controllers\AddressController::class,true)
        ->setPrefix("/address")
        ->get("/","getAddress");

    $products = new MicroCollection();
    $products
        ->setHandler(ProductController::class,True)
        ->setPrefix('/api/product')
        ->get('/', 'index')
        ->post("/","post")
        ->delete("/{id:[0-g9]+}",'delete')
        ->post("/{id:[0-9]+}",'edit');
        
    // $addresses=new MicroCollection();
    // $addresses
    //     ->setHandler(MyApp\Controllers\AddressController::class,true)
    //     ->setPrefix("/address")
    //     ->post("/new","post")
    //     ->post("/update","put")
    //     ->post("/delete","delete");

    $productSupply = new MicroCollection();
    $productSupply
        -> setHandler(MyApp\Controllers\ProductSupplierController::class,true)
        -> setPrefix("/api/productsupply")
        -> get("/", getSuppliersByQuery);

    $app=new Micro($DIcontainer);
    $app->mount($suppliers);
    $app->mount($productSupply);
    $app->mount($addresses);
    $app->mount($products);
    $app->mount($addresses);
    $app->notFound(function(){
        echo "Page not found";
    });
    $app->handle($_SERVER["REQUEST_URI"]);


    


