<?php

namespace MyApp\Controllers;

use Exception;
use Phalcon\Mvc\Controller;
use Phalcon\Http\ResponseInterface;

class SupplierController extends BaseController{

    public function get(){
        try{
            $reqQuery = $this->request->getQuery();
            $PHQL = "select S.*,A.* from MyApp\Models\Supplier as S left join MyApp\Models\Address as A on S.id=A.supplierid  where status='active'";
            $param=[];
            if (array_key_exists('name',$reqQuery)){
                $PHQL=$PHQL." and name like CONCAT(:name:,'%')";
                $param["name"]=$reqQuery["name"];
            }
            if (array_key_exists('email',$reqQuery)){
                $PHQL=$PHQL." and email like CONCAT(:email:,'%')";
                $param["email"]=$reqQuery["email"];
            }
            if (array_key_exists('number',$reqQuery)){
                $PHQL=$PHQL." and number like CONCAT(:number:,'%')";
                $param["number"]=$reqQuery["number"];
            }
            $queryRes=$this->modelsManager->executeQuery($PHQL,$param);
            
            $m_map=[];
            foreach ($queryRes as $row){
                if (!array_key_exists($row->S->id,$m_map)){
                    $m_map[$row->S->id]=(array)$row->S;
                }
                $m_map[$row->S->id]["address"][]=$row->A;
            }
               
            $res=[];
            foreach ($m_map as $row){
                array_push($res,(object)$row);
            }

            $this->response->setJsonContent($res);
            return $this->response;
        }catch (Exception $e){
            $this->setErrorMsg(400,$e->getMessage());
            return $this->response;
        }
    }

    public function post(){
        try{
            $reqPost=$this->request->getPost();
            $PHQL="insert into MyApp\Models\Supplier(name,email,number) values(:name:,:email:,:number:)";
            
            //validate input, could seperate into another func
            $needField=["name","email","number"];

            if (!$this->checkExistField($needField)){
                return $this->response;
            }
            if (!filter_var($reqPost["email"], FILTER_VALIDATE_EMAIL)){
                $this->setErrorMsg(400,"invalid email");
                return $this->response;
            }

            foreach ($needField as $field){
                $param[$field]=$reqPost[$field];
            }
            $this->modelsManager->executeQuery($PHQL,$param);
            $this->response->setJsonContent([
                "msg"=>"success",
            ]);
            return $this->response;
            
        }catch (Exception $e){
            $this->setErrorMsg(400,$e->getMessage());
            return $this->response;
        }
        
        
    }
    public function put(){
        try{
            $reqPost=$this->request->getPost();
            $PHQL="update MyApp\Models\Supplier set name=:name:,email=:email:,number=:number:,status=:status: where id=:id:";
            
            //validate input
            $needField=["name","email","number","status","id"];
            if (!$this->checkExistField($needField)){
                return $this->response;
            }
            if (!filter_var($reqPost["email"], FILTER_VALIDATE_EMAIL)){
                $this->setErrorMsg(400,"invalid email");
                return $this->response;
            }
            if ($reqPost["status"]!=="active"&&$reqPost["status"]!=="inactive"){
                $this->setErrorMsg(400,"invalid status");
                return $this->response;
            }
            if (!is_numeric($reqPost["id"])){
                $this->setErrorMsg(400,"invalid id");
            }

            
            $param=[];
            foreach ($needField as $field){
                $param[$field]=$reqPost[$field];
            }
            

            $this->modelsManager->executeQuery($PHQL,$param);
            $this->response->setJsonContent([
                "msg"=>"success",
            ]);
            return $this->response;    

        }catch(Exception $e){
            $this->setErrorMsg(400,$e->getMessage());
            return $this->response;
        }
    }
    public function delete(){
        try{
            $reqPost=$this->request->getPost();
            $PHQL="delete from MyApp\Models\Supplier where id=:id:";

            if (!array_key_exists("id",$reqPost)){
                $this->setErrorMsg(400,"missing id");
                return $this->response;
            }
            if (!is_numeric($reqPost["id"])){
                $this->setErrorMsg(400,"invalid id");
            }
            $this->modelsManager->executeQuery($PHQL,["id"=>$reqPost["id"]]);
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