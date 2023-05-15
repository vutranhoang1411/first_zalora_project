<?php
    namespace MyApp\Controllers;
    use Exception;

    class ProductSupplyController extends BaseController{
        public function getProductSupply(){
            try{
                $_GET();
                $reqQuery=$this->request->getQuery();
                $PHQL="select * from MyApp\Models\ProductSupply where true";
                $param=[];

                if (array_key_exists("productid",$reqQuery)){
                    $PHQL=$PHQL." and productid=:productid:";
                    $param["productid"]=$reqQuery["productid"];
                }

                if (array_key_exists("supplierid",$reqQuery)){
                    $PHQL=$PHQL." and supplierid=:supplierid:";
                    $param["supplierid"]=$reqQuery["supplierid"];
                }
                $productsupplies=$this->modelsManager->executeQuery($PHQL,$param);
                $this->response->setJsonContent($productsupplies);
                return $this->response;
            }catch (Exception $e){
                $this->setErrorMsg(400,$e->getMessage());
                return $this->response;
            }
        }
        public function newProductSupply(){
            try{
                $reqPost=$this->request->getJsonRawBody();
                $PHQL="insert into MyApp\Models\ProductSupply(supplierid,productid,stock) values(:supplierid:,:productid:,:stock:)";

                //validate input
                $needField=["supplierid","productid","stock"];
                if (!$this->checkExistField($needField)){
                    return $this->response;
                }
                if (!is_numeric($reqPost->supplierid)){
                    $this->setErrorMsg(400,"invalid supplier id");
                    return $this->response;
                }
                if (!is_numeric($reqPost->productid)){
                    $this->setErrorMsg(400,"invalid product id");
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
                $record=$this->modelsManager->executeQuery($PHQL,$param);
                if (!$record->success()){
                    $this->setErrorMsg(400,$record->getMessages()[0]);
                    return $this->response;
                }
                $this->response->setJsonContent([
                    "msg"=>"success"
                ]);
                return $this->response;
                
            }catch(Exception $e){
                $this->setErrorMsg(400,$e->getMessage());
                return $this->response;
            }
        }
        public function updateProductSupply(){
            try{
                $reqPost=$this->request->getJsonRawBody();
                $PHQL="update MyApp\Models\ProductSupply set stock=:stock: where id=:id:";
                //validate input
                $needField=["stock","id"];
                if (!$this->checkExistField($needField)){
                    return $this->response;
                }
                if (!is_numeric($reqPost->id)){
                    $this->setErrorMsg(400,"invalid id");
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

                $record=$this->modelsManager->executeQuery($PHQL,$param);
                if (!$record->success()){
                    $this->setErrorMsg(400,$record->getMessages()[0]);
                    return $this->response;
                }
                $this->response->setJsonContent([
                    "msg"=>"success",
                ]);
                return $this->response;    
    
            }catch(Exception $e){
                $this->setErrorMsg(400,$e->getMessage());
                return $this->response;
            }
        }
        public function deleteProductSupply($id){
            try{
                $PHQL="delete from MyApp\Models\ProductSupply where id=:id:";
                $record=$this->modelsManager->executeQuery($PHQL,["id"=>$id]);
                if (!$record->success()){
                    $this->setErrorMsg(400,$record->getMessages()[0]);
                    return $this->response;
                }
                $this->response->setJsonContent([
                    "msg"=>"success",
                ]);
                return $this->response;
            }catch(Exception $e){
                $this->setErrorMsg(400,$e->getMessage());
                return $this->response;
            }
        }
    }