<?php

namespace MyApp\Controllers;

use MyApp\Repository\AddressRepo;
use MyApp\Repository\ProductRepo;
use Phalcon\Mvc\Controller;
use MyApp\Repository\SupplierRepo;
use MyApp\Repository\ProductSupRepo;

class BaseController extends Controller
{
    protected SupplierRepo $supplier_repo;
    protected ProductSupRepo $productsup_repo;
    protected AddressRepo $address_repo;
    protected ProductRepo $product_repo;
    public function onConstruct()
    {
        $this->supplier_repo = $this->di->get('supplier_repo');
        $this->productsup_repo = $this->di->get('productsup_repo');
        $this->address_repo = $this->di->get('address_repo');
        $this->product_repo = $this->di->get('product_repo');
    }
    protected function setErrorMsg(int $code, string $msg)
    {
        $this->response->setStatusCode($code);
        $this->response->setJsonContent([
            "error" => $msg,
        ]);
    }
    protected function checkExistField(array $needField): bool
    {
        $reqPost = $this->request->getJsonRawBody();
        foreach ($needField as $field) {
            if (!property_exists($reqPost, $field)) {
                $this->setErrorMsg(400, "missing field " . $field);
                return false;
            }
        }
        return true;
    }
    protected function setHeader()
    {
        $this->response->setHeader("Access-Control-Allow-Origin", "*");
        //$this->response->setHeader("Access-Control-Allow-Credentials", "true");
        //$this->response->setHeader("Access-Control-Allow-Headers", "Content-Type");
        //$this->response->setHeader("Access-Control-Allow-Methods", "POST,HEAD,PATCH,OPTIONS,GET,PUT,DELETE");
    }
    protected function createErrorMessage($messages)
    {
        $messageString = "";
        //$messages = $modelInstance->getMessages();
        foreach ($messages as $message) {
            $messageString = $messageString . $message . "\n";
        }
        return $messageString;
    }
}
