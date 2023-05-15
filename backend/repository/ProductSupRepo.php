<?php
    namespace MyApp\Repository;
    use Phalcon\Di\Injectable;

    class ProductSupRepo extends Injectable{
        public function getTotalStockOfOwners(){
            $PHQL="select supplierid , SUM(stock) as total_stock from MyApp\Models\ProductSupply as P group by supplierid";
            return $this->modelsManager->executeQuery($PHQL);
        }
    }