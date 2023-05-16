<?php
    namespace MyApp\Controllers;

    use Exception;
    class AddressController extends BaseController{
        public function getAddress(){
            try{
                $this->setHeader();
                $reqQuery=$this->request->getQuery();
                $addresses=$this->address_repo->getAddress($reqQuery);
                $this->response->setJsonContent($addresses);
                return $this->response;
            }catch (Exception $e){
                $this->setErrorMsg(400,$e->getMessage());
                return $this->response;
            }
        }
        public function updateAddress(){
            $this->setHeader();
            $reqBody=$this->request->getJsonRawBody();

            $needField=["addr","type","id"];
            if (!$this->checkExistField($needField)){
                return $this->response;
            }
            $param=[];
            foreach ($needField as $field){
                $param[$field]=$reqBody->{$field};
            }
            try{
                $record=$this->address_repo->updateAddress($param);
                if (!$record->success()){
                    $this->setErrorMsg(400,$record->getMessages()[0]);
                    return $this->response;
                }
                $this->response->setJsonContent([
                    "msg"=>"success"
                ]);
                return $this->response;
            }catch (Exception $e){
                $this->setErrorMsg(400,$e->getMessage());
                return $this->response;
            }
        }
        public function deleteAddress($id){
            $this->setHeader();
            try{
                $record=$this->address_repo->deleteAddress($id);
                if (!$record->success()){
                    $this->setErrorMsg(400,$record->getMessages()[0]);
                    return $this->response;
                }
                $this->response->setJsonContent([
                    "msg"=>"success"
                ]);
                return $this->response;
            }catch (Exception $e){
                $this->setErrorMsg(400,$e->getMessage());
                return $this->response;
            }
        }


         public function newAddress(){
             try{
                 $reqPost=$this->request->getJsonRawBody();
                 //validate input
                 $needField=["addr","type","supplierid"];
                 if (!$this->checkExistField($needField)){
                     return $this->response;
                 }
                 if (!is_numeric($reqPost["supplierid"])){
                     $this->setErrorMsg(400,"invalid supplier id");
                     return $this->response;
                 }

                 $param=[];
                 foreach ($needField as $field){
                     $param[$field]=$reqPost->{$field};
                 }
                 $record=$this->address_repo->addAddress($param);
                 if (!$record->success()) {
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
