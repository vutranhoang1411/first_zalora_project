<?php

namespace MyApp\Controllers;

use Exception;
use Phalcon\Mvc\Controller;
use Phalcon\Http\ResponseInterface;

class ProductSupplyController extends BaseController{
  public function getSuppliersByQuery() {
    try {
      $request = $this->request->getQuery();
      $PHQL = "select S.id, S.name, S.stock FROM MyApp\Models\ProductSupply PS
              JOIN MyApp\Models\Supplier S
              ON PS.supplierid = S.id
              WHERE S.status = 'active'";
      $param=[];

      if (array_key_exists('productId',$reqQuery)){
          $param["productId"]=$reqQuery["productId"];
          $PHQL = $PHQL. " PS.productid = :productId:";
      }

      if (array_key_exists('supplierId',$reqQuery)){
        $PHQL = $PHQL. " S.id = :supplierId:";
        $param["supplierId"]=$reqQuery["supplierId"];
      }
      
      $queryRequest = $this->modelManager->executeQuery($PHQL, $param);
      
      $this->response->setJsonContent($res);
      return $this->response;
        
    } catch (Exception $error) {
      $this->setErrorMsg(400,$e->getMessage());
      return $this->response;
    }
  }
}
