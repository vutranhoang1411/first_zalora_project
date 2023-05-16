<?php
    namespace MyApp\Repository;
    use Phalcon\Di\Injectable;

    class AddressRepo extends Injectable{
        public function getAddress(array $filter){
            $PHQL="select * from MyApp\Models\Address";
            $param=[];
            if (array_key_exists("supplierid",$filter)){
                $PHQL=$PHQL." where supplierid=:supplierid:";
                $param["supplierid"]=$filter["supplierid"];
            }
            return $this->modelsManager->executeQuery($PHQL,$param);
        }
        public function deleteAddress($id){
            $PHQL="delete from MyApp\Models\Address where id=:id:";
            return $this->modelsManager->executeQuery($PHQL,["id"=>$id]);
        }
        public function updateAddress($param){
            $PHQL="update MyApp\Models\Address set addr=:addr:,type=:type: where id=:id:";
            return $this->modelsManager->executeQuery($PHQL,$param);
        }
        public function addAddress(array $param){
            $PHQL="insert into MyApp\Models\Address(addr,type,supplierid) values(:addr:,:type:,:supplierid:)";
            return $this->modelsManager->executeQuery($PHQL,$param);
        }
    }