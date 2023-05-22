<?php
    namespace MyApp\Repository;
    use Phalcon\Di\Injectable;

    class ProductSupRepo extends Injectable{
        public function getTotalStockOfOwners(){
            $PHQL="select supplierid , SUM(stock) as total_stock from MyApp\Models\ProductSupply as P group by supplierid";
            return $this->modelsManager->executeQuery($PHQL);
        }
        public function getSupplierOfProduct(array $filter){
            $PHQL = "select PS.id as id, S.name as suppliername, S.id as supplierid, PS.productid as productid , PS.stock as stock from MyApp\Models\ProductSupply as PS
            LEFT JOIN MyApp\Models\Supplier as S
            ON PS.supplierid = S.id
            WHERE true";
            $param=[];

            if (array_key_exists('productId',$filter)){
                $param["productId"]=$filter["productId"];
                $PHQL = $PHQL." and PS.productid = :productId:";
            }
        
            if (array_key_exists('supplierId',$filter)){
              $PHQL = $PHQL. " and S.id = :supplierId:";
              $param["supplierId"]=$filter["supplierId"];
            }

            return $this->modelsManager->executeQuery($PHQL,$param);
        }
        public function insertProductSupply(array $param){
            $PHQL = "insert into MyApp\Models\ProductSupply(productid,supplierid,stock) values (:productid:,:supplierid:,:stock:)";
            return $this->modelsManager->executeQuery($PHQL,$param);
        }
        public function deleteProductSupply($id){
            $PHQL = "delete from MyApp\Models\ProductSupply WHERE id=:id:";
            return $this->modelsManager->executeQuery($PHQL, [
                "id"=>$id
            ]);
        }
    }