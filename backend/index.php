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
        ->setPrefix("/supplier")
        ->get("/","get")
        ->post("/new","post")
        ->post("/update","put")
        ->post("/delete","delete");
    // $addresses=new MicroCollection();
    // $addresses
    //     ->setHandler(MyApp\Controllers\AddressController::class,true)
    //     ->setPrefix("/address")
    //     ->post("/new","post")
    //     ->post("/update","put")
    //     ->post("/delete","delete");
    $products = new MicroCollection();
    $products
        ->setHandler(ProductController::class,True)
        ->setPrefix('/api/product')
        ->get('/', 'index')
        ->post("/","post")
        ->delete("/{id:[0-9]+}",'delete')
        ->put("/{id:[0-9]+}",'edit')
    ;


    $app=new Micro($DIcontainer);
    $app->mount($suppliers);
    $app->mount($products);
    // $app->mount($addresses);
    $app->notFound(function(){
        echo "Page not found";
    });
    try {
        $app->handle($_SERVER["REQUEST_URI"]);
    }catch (Exception $e){
        $app->response->setJsonContent([
            "code"=>$e->getCode(),
            "message"=>$e->getMessage()
        ]);
    }


    


