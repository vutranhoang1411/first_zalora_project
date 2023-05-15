<?php
    namespace MyApp\Controllers;

    use Phalcon\Mvc\Controller;
    class BaseController extends Controller{
        protected function setErrorMsg(int $code,string $msg){
            $this->response->setStatusCode($code);
            $this->response->setJsonContent([
                "error"=>$msg,
            ]);
        }
        protected function checkExistField(array $needField):bool{
            $reqPost=$this->request->getPost();
            foreach ($needField as $field){
                if (!array_key_exists($field,$reqPost)){
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