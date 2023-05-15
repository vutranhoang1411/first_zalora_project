<?php
    namespace MyApp\Repository;
    use Phalcon\Di\Injectable;

    class AddressRepo extends Injectable{
        public function addAddress($param){
            $PHQL="insert into MyApp\Models\Address(addr,type,supplierid) values(:addr:,:type:,:supplierid:)";
            return $this->modelsManager->executeQuery($PHQL,$param);
        }
    }