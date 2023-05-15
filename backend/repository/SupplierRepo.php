<?php
    namespace MyApp\Repository;
    use Phalcon\Di\Injectable;
    use Phalcon\Di\DiInterface;

    class SupplierRepo extends Injectable{
        public function getActiveSuppliers(array $filter){
            $PHQL = "select * from MyApp\Models\Supplier where status='active'";
            $param=[];
            if (array_key_exists('name',$filter)){
                $PHQL=$PHQL." and name like CONCAT(:name:,'%')";
                $param["name"]=$filter["name"];
            }
            if (array_key_exists('email',$filter)){
                $PHQL=$PHQL." and email like CONCAT(:email:,'%')";
                $param["email"]=$filter["email"];
            }
            if (array_key_exists('number',$filter)){
                $PHQL=$PHQL." and number like CONCAT(:number:,'%')";
                $param["number"]=$filter["number"];
            }
            return $this->modelsManager->executeQuery($PHQL,$param);
        }
    }