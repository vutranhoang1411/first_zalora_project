<?php
namespace MyApp\Controllers;

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;
use MyApp\Models as Models;
use Exception;

/**
 * @property Response $response
 */
class ProductController extends BaseController
{
    public function index()
    {
        $this->setHeader();
        try {
            $reqQuery = $this->request->getQuery();

            $conditions = [];
            $bindParams = [];

            if (isset($reqQuery['color'])) {
                $conditions[] = 'color = :color:';
                $bindParams['color'] = $reqQuery['color'];
            }

            if (isset($reqQuery['size'])) {
                $conditions[] = 'size = :size:';
                $bindParams['size'] = $reqQuery['size'];
            }

            if (isset($reqQuery['brand'])) {
                $conditions[] = 'brand = :brand:';
                $bindParams['brand'] = $reqQuery['brand'];
            }

            if (isset($reqQuery['name'])) {
                $conditions[] = 'name LIKE :name:';
                $bindParams['name'] = '%'.$reqQuery['name'].'%';
            }

            $results = Models\Product::find([
                'conditions' => implode(' AND ', $conditions),
                'bind' => $bindParams,
            ]);
            $this->setHeader();
            $this->response->setStatusCode(200);
            return $this->response->setJsonContent([
                "content" => $results,
            ]);
        } catch (Exception $e) {
            $this->setErrorMsg(400,$e->getMessage());
            return $this->response;
        }
    }
    public function post()
    {
        $this->setHeader();
        try {
            $data = $this->request->getJsonRawBody();
            if (!$this->checkattr($data)) {
                $this->setErrorMsg('409', "Data validation Failed");
                return $this->response;
            }

            $product = $this->getDatafromRequest($data);
            // Store and check for errors

            $result = $product->save();

            if ($result === true) {
                $this->response->setJsonContent(
                    [
                        'status' => 'OK',
                        'data'   => $product,
                    ]
                );
            } else {
                $this->setErrorMsg('409', "Can't create this item");
            }
            return $this->response;
        } catch(Exception $e){
            $this->setErrorMsg(400,$e->getMessage());
            return $this->response;
        }
    }
    private function checkattr($data,$put=false) {
        $attr = ['name', 'brand', 'sku', 'size','color'];
        foreach ($attr as $item) {
            if (!property_exists($data, $item)) {
                return false;
            }
        }
        if ($put) {
            if (!property_exists($data, 'status')) {
                return false;
            }
        }
        return true;
    }
    public function delete($id) {
        $this->setHeader();
        try {
            $product = Models\Product::findFirst($id);
            if (!$product) {
                $this->setErrorMsg('409', "Can't find the deleted item");
                return $this->response;
            }
            $result = $product->delete();

            if ($result === true) {
                $this->response->setJsonContent(
                    [
                        'msg' => 'success'
                    ]
                );
            } else {
                $this->setErrorMsg('409', "Can't delete this item");
            }
            return $this->response;
        } catch(Exception $e){
            $this->setErrorMsg(400,$e->getMessage());
            return $this->response;
        }
    }
    private function getDatafromRequest($data, $id =0) {
        if (($id) == 0) {
            $product = new Models\Product();
        }  else {
            $product = Models\Product::findFirst($id);
            if (!$product) {
                return null;
            }
        }
        $product->name  = $data->name;
        $product->brand = $data->brand;
        $product->sku = $data->sku;
        $product->size = $data->size;
        $product->color = $data->color;

        if ($id ==0) {
            $product->status = 'active';
            $product->total_stock = 0;
        } else {
            $product->status = $data->status;
        }
        return $product;
    }
    public function edit($id) {
        $this->setHeader();
        try {
            $data = $this->request->getJsonRawBody();
            if (!$this->checkattr($data,true)) {
                $this->setErrorMsg('409', "Data validation Failed");
                return $this->response;
            }

            $product = $this->getDatafromRequest($data,$id);
            $result = $product->save();

            if ($result === true) {
                $this->response->setJsonContent(
                    [
                        'status' => 'OK',
                        'data'   => $product,
                    ]
                );
            } else {
                $this->setErrorMsg('409', "Can't edit this item");
            }
            return $this->response;
        } catch(Exception $e){
            $this->setErrorMsg(400,$e->getMessage());
            return $this->response;
        }
    }
}
