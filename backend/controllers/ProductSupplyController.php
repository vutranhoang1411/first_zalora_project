<?php

namespace MyApp\Controllers;

use Exception;
use Phalcon\Mvc\Controller;
use Phalcon\Http\ResponseInterface;

class ProductSupplyController extends BaseController{
  public function getSuppliersByQuery() {
    $this->setHeader();
    try {
      $reqQuery = $this->request->getQuery();
      $PHQL = "select PS.id as id, S.name as suppliername, PS.stock as stock from MyApp\Models\ProductSupply as PS
              LEFT JOIN MyApp\Models\Supplier as S
              ON PS.supplierid = S.id
              WHERE true";
      $param=[];

      if (array_key_exists('productId',$reqQuery)){
          $param["productId"]=$reqQuery["productId"];
          $PHQL = $PHQL." and PS.productid = :productId:";
      }

      if (array_key_exists('supplierId',$reqQuery)){
        $PHQL = $PHQL. " and S.id = :supplierId:";
        $param["supplierId"]=$reqQuery["supplierId"];
      }
      
      $queryRequest = $this->modelsManager->executeQuery($PHQL, $param);
      $this->response->setJsonContent($queryRequest);
      return $this->response;
        
    } catch (Exception $error) {
      $this->setErrorMsg(400,$error->getMessage());
      return $this->response;
    }
  }

  public function deleteSupplierByProductSupplierId($id) {
    $this->setHeader();
    try {
      // $reqQuery = $this->request->getQuery();
      $PHQL = "delete from MyApp\Models\ProductSupply WHERE id=:productsupplyid:";
      $param=[];
      $param["productsupplyid"]=$id;    
      $queryRequest = $this->modelsManager->executeQuery($PHQL, $param);
      $this->response->setStatusCode(200);
      $this->response->setJsonContent([
        'msg' => 'success'
      ]);
      return $this->response;
        
    } catch (Exception $error) {
      $this->setErrorMsg(400,$error->getMessage());
      return $this->response;
    }

  }
}
