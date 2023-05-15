<?php
    namespace MyApp\Controllers;

    use Exception;
    class AddressController extends BaseController{
        public function getAddress(){
            try{
                $this->setHeader();
                $reqQuery=$this->request->getQuery();
                $PHQL="select * from MyApp\Models\Address";
                $param=[];
                if (array_key_exists("supplierid",$reqQuery)){
                    $PHQL=$PHQL." where supplierid=:supplierid:";
                    $param["supplierid"]=$reqQuery["supplierid"];
                }
                $addresses=$this->modelsManager->executeQuery($PHQL,$param);
                $this->response->setJsonContent($addresses);
                return $this->response;
            }catch (Exception $e){
                $this->setErrorMsg(400,$e->getMessage());
                return $this->response;
            }
        }

        // public function newAddress(){
        //     try{
        //         $reqPost=$this->request->getPost();
        //         $PHQL="insert into MyApp\Models\Address(addr,type,supplierid) values(:addr:,:type:,:supplierid:)";

        //         //validate input
        //         $needField=["addr","type","supplierid"];
        //         if (!$this->checkExistField($needField)){
        //             return $this->response;
        //         }
        //         if (!is_numeric($reqPost["supplierid"])){
        //             $this->setErrorMsg(400,"invalid supplier id");
        //             return $this->response;
        //         }

        //         $param=[];
        //         foreach ($needField as $field){
        //             $param[$field]=$reqPost[$field];
        //         }
        //         $this->modelsManager->executeQuery($PHQL,$param);
        //         $this->response->setJsonContent([
        //             "msg"=>"success"
        //         ]);
        //         return $this->response;
                
        //     }catch(Exception $e){
        //         $this->setErrorMsg(400,$e->getMessage());
        //         return $this->response;
        //     }
        // }
        // public function updateAddress(){
        //     try{
        //         $reqPost=$this->request->getPost();
        //         $PHQL="update MyApp\Models\Address set addr=:addr:,type=:type: where id=:id:";
        //         //validate input
        //         $needField=["addr","type","id"];
        //         if (!$this->checkExistField($needField)){
        //             return $this->response;
        //         }
        //         if (!is_numeric($reqPost["id"])){
        //             $this->setErrorMsg(400,"invalid id");
        //             return $this->response;
        //         }
        //         $param=[];
        //         foreach ($needField as $field){
        //             $param[$field]=$reqPost[$field];
        //         }

        //         $this->modelsManager->executeQuery($PHQL,$param);
        //         $this->response->setJsonContent([
        //             "msg"=>"success",
        //         ]);
        //         return $this->response;    
    
        //     }catch(Exception $e){
        //         $this->setErrorMsg(400,$e->getMessage());
        //         return $this->response;
        //     }
        // }
        // public function deleteAddress(){
        //     try{
        //         $reqPost=$this->request->getPost();
        //         $PHQL="delete from MyApp\Models\Address where id=:id:";
    
        //         if (!array_key_exists("id",$reqPost)){
        //             $this->setErrorMsg(400,"missing id");
        //             return $this->response;
        //         }
        //         if (!is_numeric($reqPost["id"])){
        //             $this->setErrorMsg(400,"invalid id");
        //             return $this->response;
        //         }
        //         $this->modelsManager->executeQuery($PHQL,["id"=>$reqPost["id"]]);
        //         $this->response->setJsonContent([
        //             "msg"=>"success",
        //         ]);
        //         return $this->response;
        //     }catch(Exception $e){
        //         $this->setErrorMsg(400,$e->getMessage());
        //         return $this->response;
        //     }
        // }
    }
