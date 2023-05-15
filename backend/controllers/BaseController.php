<?php
    namespace MyApp\Controllers;

    use MyApp\Repository\AddressRepo;
    use Phalcon\Mvc\Controller;
    use MyApp\Repository\SupplierRepo;
    use MyApp\Repository\ProductSupRepo;
    
    class BaseController extends Controller{
        protected SupplierRepo $supplier_repo;
        protected ProductSupRepo $productsup_repo;
        protected AddressRepo $address_repo;
        public function onConstruct(){
            $this->supplier_repo=new SupplierRepo();
            $this->productsup_repo=new ProductSupRepo();
            $this->address_repo=new AddressRepo();
        }
        protected function setErrorMsg(int $code,string $msg){
            $this->response->setStatusCode($code);
            $this->response->setJsonContent([
                "error"=>$msg,
            ]);
        }
        protected function checkExistField(array $needField):bool{
            $reqPost=$this->request->getJsonRawBody();
            foreach ($needField as $field){
                if (!property_exists($reqPost,$field)){
                    $this->setErrorMsg(400,"missing field ".$field);
                    return false;
                }
            }
            return true;  
        }
        protected function setHeader () {
            $this->response->setHeader('Access-Control-Allow-Origin', '*');
        }
    }