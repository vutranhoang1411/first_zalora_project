<?php
namespace MyApp\Controllers;

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;
use MyApp\Models as Models;
use Exception;
use Phalcon\Paginator\Adapter\Model as PaginateModel;


/**
 * @property Response $response
 */
class ProductController extends BaseController
{
    public function getProductsList()
    {
        $this->setHeader();
        try {
            $reqQuery = $this->request->getQuery();

            $conditions = [];
            $bindParams = [];
            $limit = 5;
            $page = 1;

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

            if (isset($reqQuery['limit'])) {
                $limit = $reqQuery['limit'];
            }

            if (isset($reqQuery['page'])) {
                $page = $reqQuery['page'];
            }

            $paginator = new PaginateModel(
                [
                    "model" => Models\Product::class,
                    "parameters" => [
                        'conditions' => implode(' AND ', $conditions),
                        'bind' => $bindParams,
                        "order" => "id"
                    ],
                    "limit" => $limit,
                    "page"  => $page,
                ]
            );

            $results = $paginator->paginate();

            $totalStock = Models\ProductSupply::sum([
                    'column' => 'stock',
                    'group'  => 'productid',
                ]
            );

            $items = $results->getItems()->toArray();
            $totalStockArray = $totalStock->toArray();

            foreach ($items as &$item) {
                $found = false;
                for ($j = 0; $j < count($totalStockArray); $j++) {
                    if ($item['id'] == $totalStockArray[$j]['productid']) {
                        $item['totalStock'] = $totalStockArray[$j]['sumatory'];
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $item['totalStock'] = 0;
                }
            }

            $this->response->setStatusCode(200);
            $resultsArray = [];
            $resultsArray['items']=$items;
            $resultsArray['total_items']= $results->getTotalItems();
            return $this->response->setJsonContent(
                $resultsArray
            );
        } catch (Exception $e) {
            $this->setErrorMsg(400,$e->getMessage());
            return $this->response;
        }
    }
    public function addProduct()
    {
        $this->setHeader();
        try {
            $data = $this->request->getJsonRawBody();
            if (!$this->checkRequestData($data)) {
                $this->setErrorMsg('409', "Data validation Failed");
                return $this->response;
            }

            $product = new Models\Product();
            $product->assign(get_object_vars($data),[
                    'name',
                    'brand',
                    'size',
                    'color',
                ]
            );
            $product->status = 'active';
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
    private function checkRequestData($data, $edit=false) {
        $attr = ['name', 'brand', 'size','color'];
        $color = ['Black', 'White', 'Blue', 'Red'];
        $size = ['XXL', 'XL', 'L'];
        foreach ($attr as $item) {
            if (!property_exists($data, $item)) {
                return false;
            }
        }
        $matchingColor = array_search($data->color, $color);
        $matchingSize = array_search($data->size, $size);
        if (($matchingColor === false) or ($matchingSize === false) or !$data->name or !$data->brand) {
            return false;
        }

        if ($edit) {
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
    public function deleteProduct($id) {
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
    public function editProduct()
    {
        $this->setHeader();
        try {
            $data = $this->request->getJsonRawBody();
            if (!$this->checkRequestData($data, true)) {
                $this->setErrorMsg('409', "Data validation Failed");
                return $this->response;
            }

            $product = Models\Product::findFirst($data->id);
            if (!$product) {
                $this->setErrorMsg('409', "Can't find the edited item");
                return $this->response;
            }
            $product->assign(get_object_vars($data),[
                    'name',
                    'brand',
                    'size',
                    'color',
                    'status',
                ]
            );

            $result = $product->save();

            if ($result === true) {
                $this->response->setJsonContent(
                    [
                        $product
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
