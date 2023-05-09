<?php
    require __DIR__ . '/vendor/autoload.php';
    use Phalcon\Autoload\Loader as PLoader;
    use Phalcon\Mvc\Micro\Collection as MicroCollection;
    use Phalcon\Di\FactoryDefault;
    use Phalcon\Db\Adapter\Pdo\Mysql;
    use josegonzalez\Dotenv\Loader as ConfLoader;
    use MyApp\Controllers;

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
    $Di->set(
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


    


