<?php

namespace MyApp\Controllers;

use Exception;


class SupplierController extends BaseController{

    public function getAllSupplier(){
        try{
            $this->setHeader();
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
            $this->db->begin();
            
            $param=[];
            foreach ($needField as $field){
                $param[$field]=$reqPost->{$field};
            }
            //insert supplier
            $record=$this->supplier_repo->addSupplier($param);

            if (!$record->success()){
                $this->db->rollback();
                $this->setErrorMsg(400,$record->getMessages()[0]);
                return $this->response;
            }
            
            //get previous inserted supplierid
            $supplierid=$this->db->query("select last_insert_id() as supplier_id")->fetch()["supplier_id"];

            //insert address
            foreach ($reqPost->address as $addr){
                if (!property_exists($addr,"addr")){
                    $this->setErrorMsg(400,"missing address name in inserted address");
                    return $this->response;
                }
                if (!property_exists($addr,"type")){
                    $this->setErrorMsg(400,"missing address type in inserted address");
                    return $this->response;
                }
                $record=$this->address_repo->addAddress([
                    "addr"=>$addr->addr,
                    "type"=>$addr->type,
                    "supplierid"=>$supplierid,
                ]);
                if (!$record->success()){
                    $this->db->rollback();
                    $this->setErrorMsg(400,$record->getMessages()[0]);
                    return $this->response;
                }
            }
            //commit if all query success
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
            $record=$this->supplier_repo->updateSupplier($param);
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
    public function deleteSupplier($id){
        try{
            $record=$this->supplier_repo->deleteSupplier($id);
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
}