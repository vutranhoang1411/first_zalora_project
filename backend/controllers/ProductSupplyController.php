<?php

namespace MyApp\Controllers;

use Exception;
use Phalcon\Mvc\Controller;
use Phalcon\Http\ResponseInterface;

class ProductSupplyController extends BaseController{
	public function getSuppliersOfProduct() {
    	$this->setHeader();
    	try {
    	  $reqQuery = $this->request->getQuery();  
    	  $res = $this->productsup_repo->getSupplierOfProduct($reqQuery);	
    	} catch (Exception $error) {
    	  $this->setErrorMsg(400,$error->getMessage());
    	  return $this->response;
    	}
		$this->response->setJsonContent($res);
    	return $this->response;
  	}
  	public function newProductSupply(){
        $this->setHeader();
  	  	$reqPost=$this->request->getJsonRawBody();
  	  	$needField=["productid","supplierid","stock"];
  	  	if (!$this->checkExistField($needField,$reqPost)){
  	  	  	return $this->response;
  	  	} 
  	  	if (!is_numeric($reqPost->productid)){
  	  	  	$this->setErrorMsg(400,"invalid productid");
  	  	  	return $this->response;
  	  	}
  	  	if (!is_numeric($reqPost->supplierid)){
  	  	  	$this->setErrorMsg(400,"invalid supplierid");
  	  	  	return $this->response;
  	  	}
  	  	if (!is_numeric($reqPost->stock)){
  	  	  	$this->setErrorMsg(400,"invalid stock");
  	  	  	return $this->response;
  	  	}
		$param=[];
		foreach ($needField as $field){
			$param[$field]=$reqPost->{$field};
		}
		try{
			$record=$this->productsup_repo->insertProductSupply($param);
			if (!$record->success()){
				$this->setErrorMsg(400,$record->getMessages()[0]);
				return $this->response;
			}

		}catch(Exception $e){
			$this->setErrorMsg(400,$e->getMessage());
			return $this->response;
		}
		$this->response->setJsonContent([
            "msg"=>"success",
        ]);
        return $this->response;  
		
  	}
  	public function deleteProductSupply($id) {
    	$this->setHeader();
    	try {  
    		$record= $this->productsup_repo->deleteProductSupply($id);
    	  	if (!$record->success()){
    	  	  	$this->setErrorMsg(400,$record->getMessages()[0]);
    	  	  	return $this->response;
    	  	}
    	}catch (Exception $error) {
    	  	$this->setErrorMsg(400,$error->getMessage());
    	  	return $this->response;
    	}
		$this->response->setJsonContent([
			'msg' => 'success'
		]);
		return $this->response;
	}
}
