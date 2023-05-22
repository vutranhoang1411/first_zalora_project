<?php
    namespace MyApp\DI;
    require __DIR__ . '/../vendor/autoload.php';
    use Phalcon\Di\FactoryDefault;
    use josegonzalez\Dotenv\Loader as ConfLoader;
    use Phalcon\Db\Adapter\Pdo\Mysql;

    class MyDI{
        private static $di;
        public static function getMyDI(){
            if (is_null(MyDI::$di)){
                $DIcontainer = new FactoryDefault();
                $DIcontainer->set(
                    'app_conf',
                    function (){
                        return (new ConfLoader(__DIR__.'/../.env'))->parse()->toArray();
                    }
                );
                $DIcontainer->set(
                  'product_repo', new \MyApp\Repository\ProductRepo()
                );
                $DIcontainer->set(
                    'supplier_repo',new \MyApp\Repository\SupplierRepo()
                );
                $DIcontainer->set(
                    'productsup_repo',new \MyApp\Repository\ProductSupRepo()
                );
                $DIcontainer->set(
                    'address_repo',new \MyApp\Repository\AddressRepo()
                );
                $DIcontainer->set(
                    'db',
                    function ()use ($DIcontainer){
                        $config=$DIcontainer->get('app_conf');
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
                MyDI::$di=$DIcontainer;
            }
            return MyDI::$di;
        }
    }