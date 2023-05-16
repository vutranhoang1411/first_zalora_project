<?php
    namespace MyApp\Repository;
    use Phalcon\Di\Injectable;

    class SupplierRepo extends Injectable{
        public function getSupplier($id){
            $PHQL="select * from MyApp\Models\Supplier where id=:id:";
            return $this->modelsManager->executeQuery($PHQL,["id"=>$id]);
        }
        public function getActiveSuppliers(array $filter){
            $PHQL = "select * from MyApp\Models\Supplier where status='active'";
            $param=[];
            if (array_key_exists('name',$filter)){
                $PHQL=$PHQL." and name like CONCAT('%',:name:,'%')";
                $param["name"]=$filter["name"];
            }
            if (array_key_exists('email',$filter)){
                $PHQL=$PHQL." and email like CONCAT('%',:email:,'%')";
                $param["email"]=$filter["email"];
            }
            if (array_key_exists('number',$filter)){
                $PHQL=$PHQL." and number like CONCAT('%',:number:,'%')";
                $param["number"]=$filter["number"];
            }
            return $this->modelsManager->executeQuery($PHQL,$param);
        }
        public function addSupplier(array $param){
            $PHQL="insert into MyApp\Models\Supplier(name,email,number) values(:name:,:email:,:number:)";
            return $this->modelsManager->executeQuery($PHQL,$param);
        }
        public function updateSupplier(array $param){
            $PHQL="update MyApp\Models\Supplier set name=:name:,email=:email:,number=:number:,status=:status: where id=:id:";
            return $this->modelsManager->executeQuery($PHQL,$param);
        }
        public function deleteSupplier($id){
            $PHQL="delete from MyApp\Models\Supplier where id=:id:";
            return $this->modelsManager->executeQuery($PHQL,["id"=>$id]);
        }
    }