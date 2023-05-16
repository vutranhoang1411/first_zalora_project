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
                $conditions[] = 'brand LIKE :brand:';
                $bindParams['brand'] = '%'.$reqQuery['brand'].'%';
            }

            if (isset($reqQuery['name'])) {
                $conditions[] = 'name LIKE :name:';
                $bindParams['name'] = '%'.$reqQuery['name'].'%';
            }

            $results = Models\Product::find([
                'conditions' => implode(' AND ', $conditions),
                'bind' => $bindParams,
            ]);

            $totalStock = Models\ProductSupply::sum([
                    'column' => 'stock',
                    'group'  => 'productid',
                ]
            );

            $productArray = $results->toArray();
            $totalStockArray = $totalStock->toArray();

            for ($i = 0; $i < count($productArray); $i++) {
                $found = false;
                for ($j = 0; $j < count($totalStockArray); $j++) {
                    if ($productArray[$i]['id'] == $totalStockArray[$j]['productid']) {
                        $productArray[$i]['totalStock'] = $totalStockArray[$j]['sumatory'];
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $productArray[$i]['totalStock'] = 0;
                }
            }

            $this->response->setStatusCode(200);
            return $this->response->setJsonContent(
                $productArray
            );
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
                $messageError = $this->createErrorMessage($product);
                $this->setErrorMsg('409', $messageError);
            }
            return $this->response;
        } catch(Exception $e){
            $this->setErrorMsg(400,$e->getMessage());
            return $this->response;
        }
    }
    private function checkattr($data,$put=false) {
        $attr = ['name', 'brand', 'size','color'];
        foreach ($attr as $item) {
            if (!property_exists($data, $item)) {
                return false;
            }
        }
        if ($put) {
            if (!property_exists($data, 'id')) {
                return false;
            }
            if(!is_int($data->id)) {
                return false;
            }
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
                $messageError = $this->createErrorMessage($product);
                $this->setErrorMsg('409', $messageError);
            }
            return $this->response;
        } catch(Exception $e){
            $this->setErrorMsg(400,$e->getMessage());
            return $this->response;
        }
    }
    private function createErrorMessage($product) {
        $messageString = "";
        $messages = $product->getMessages();
        foreach ($messages as $message) {
            $messageString = $messageString.$message."\n";
        }
        return $messageString;
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
        $product->size = $data->size;
        $product->color = $data->color;

        if ($id ==0) {
            $product->status = 'active';
        } else {
            $product->status = $data->status;
        }
        return $product;
    }
    public function edit()
    {
        $this->setHeader();
        try {
            $data = $this->request->getJsonRawBody();
            if (!$this->checkattr($data, true)) {
                $this->setErrorMsg('409', "Data validation Failed");
                return $this->response;
            }

            $product = $this->getDatafromRequest($data, $data->id);
            $result = $product->save();

            if ($result === true) {
                $this->response->setJsonContent(
                    [
                        'status' => 'OK',
                        'data' => $product,
                    ]
                );
            } else {
                $messageError = $this->createErrorMessage($product);
                $this->setErrorMsg('409', $messageError);
            }
            return $this->response;
        } catch (Exception $e) {
            $this->setErrorMsg(400, $e->getMessage());
            return $this->response;
        }
    }
}
