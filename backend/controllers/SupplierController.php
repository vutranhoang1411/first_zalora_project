<?php

namespace MyApp\Controllers;

use Exception;


class SupplierController extends BaseController{

    public function getAllSupplier(){
        try{
            $reqQuery = $this->request->getQuery();

            $suppliers=$this->supplier_repo->getActiveSuppliers($reqQuery);
            //map to map stock to appropriate supplier
            $m_map=[];
            foreach ($suppliers as $supplier){
                $m_map[$supplier->id]=(array)$supplier;
                $m_map[$supplier->id]["total_stock"]=0;
            }

            //get stock
            $stock_list=$this->productsup_repo->getTotalStockOfOwners();
            
            //map stock to supplier
            foreach ($stock_list as $stock){
                if (array_key_exists($stock->supplierid,$m_map)){
                    $m_map[$stock->supplierid]["total_stock"]=(int)$stock->total_stock;
                } 
            }

            //get the result
            $res=[];
            foreach ($m_map as $key=>$val){
                $res[]=(object)$val;
            }
            $this->response->setJsonContent($res);
            return $this->response;
        }catch (Exception $e){
            $this->setErrorMsg(400,$e->getMessage());
            return $this->response;
        }
    }

    //write as a transaction
    public function newSupplier(){
        $reqPost=$this->request->getJsonRawBody();
        $needField=["name","email","number"];
        if (!$this->checkExistField($needField,$reqPost)){
            return $this->response;
        }
        if (!filter_var($reqPost->email, FILTER_VALIDATE_EMAIL)){
            $this->setErrorMsg(400,"invalid email");
            return $this->response;
        }
        try{
            //start transaction
            $this->db->begin();

            //insert supplier
            $param=[];
            foreach ($needField as $field){
                $param[$field]=$reqPost->{$field};
            }
            $PHQL="insert into MyApp\Models\Supplier(name,email,number) values(:name:,:email:,:number:)";
            $record=$this->modelsManager->executeQuery($PHQL,$param);
            if (!$record->success()){
                $this->db->rollback();
                $this->setErrorMsg(400,$record->getMessages()[0]);
                return $this->response;
            }
            
            //insert address
            $supplierid=$this->db->query("select last_insert_id() as supplier_id")->fetch()["supplier_id"];
            $PHQL="insert into MyApp\Models\Address(addr,type,supplierid) values(:addr:,:type:,:supplierid:)";
            $addrArray=$reqPost->address;

            foreach ($addrArray as $addr){
                $record=$this->modelsManager->executeQuery($PHQL,[
                    "addr"=>$addr->addr,
                    "type"=>$addr->type,
                    "supplierid"=>$supplierid
                ]);
                if (!$record->success()){
                    $this->db->rollback();
                    $this->setErrorMsg(400,$record->getMessages()[0]);
                    return $this->response;
                }
            }
            $this->db->commit();
            $this->response->setJsonContent([
                "msg"=>"success",
            ]);
            return $this->response;
            
        }catch (Exception $e){
            $this->db->rollback();
            $this->setErrorMsg(400,$e->getMessage());
            return $this->response;
        } 
    }

    public function updateSupplier(){
        $reqPost=$this->request->getJsonRawBody();
        $PHQL="update MyApp\Models\Supplier set name=:name:,email=:email:,number=:number:,status=:status: where id=:id:";
        //validate input
        $needField=["name","email","number","status","id"];
        if (!$this->checkExistField($needField)){
            return $this->response;
        }
        if (!filter_var($reqPost->email, FILTER_VALIDATE_EMAIL)){
            $this->setErrorMsg(400,"invalid email");
            return $this->response;
        }
        if ($reqPost->status!=="active"&&$reqPost->status!=="inactive"){
            $this->setErrorMsg(400,"invalid status");
            return $this->response;
        }
        if (!is_numeric($reqPost->id)){
            $this->setErrorMsg(400,"invalid id");
        }
        $param=[];
        foreach ($needField as $field){
            $param[$field]=$reqPost->{$field};
        }

        //query
        try{ 
            $record=$this->modelsManager->executeQuery($PHQL,$param);
        }catch(Exception $e){
            $this->setErrorMsg(400,$e->getMessage());
            return $this->response;
        }

        if (!$record->success()){
            $this->setErrorMsg(400,$record->getMessages()[0]);
            return $this->response;
        }
        $this->response->setJsonContent([
            "msg"=>"success",
        ]);
        return $this->response;    


    }
    public function deleteSupplier($id){
        $PHQL="delete from MyApp\Models\Supplier where id=:id:";
        try{
            $record=$this->modelsManager->executeQuery($PHQL,["id"=>$id]);
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
    public function getSuppliersByProductId($productId) {
        try {
            $reqPost=$this->request->getPost();
            $PHQL = 'select S.id, S.name, S.stock FROM MyApp\Models\Supplier AS S
                    join MyApp\Models\ProductSupplier as PS
                    on PS.supplierid = S.id
                    WHERE P.productid = :productId:';
            $query = $this->modelsManager->executeQuery($PHQL, 
                [
                    'productId' => productId,
                ]);
            echo '---GET SUPPLIERS -> ', $productId;
            $this->response->setJsonContent([
                "msg"=>"success",
            ]);
            return $this->response;
        } catch (Exception $error) {
            $this->setErrorMsg(400,$e->getMessage());
            return $this->response;
        }
    }

    public function createNewSupplierForProduct() {

    }
}