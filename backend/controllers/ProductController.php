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
    public function getProductsList()
    {
        $this->setHeader();
        try {
            $reqQuery = $this->request->getQuery();

            $query = $this->getQuery($reqQuery);
            if (!$query['result']) {
                $this->setErrorMsg('409', "Query params failed");
                return $this->response;
            }
            $resultsArray = $this->product_repo->getProductWithStock($query);

            $this->response->setStatusCode(200);
            return $this->response->setJsonContent(
                $resultsArray
            );
        } catch (Exception $e) {
            $this->setErrorMsg(400, $e->getMessage());
            return $this->response;
        }
    }
    private function getQuery($reqQuery)
    {
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
            $bindParams['brand'] = '%' . $reqQuery['brand'] . '%';
        }

        if (isset($reqQuery['name'])) {
            $conditions[] = 'name LIKE :name:';
            $bindParams['name'] = '%' . $reqQuery['name'] . '%';
        }

        if (isset($reqQuery['limit'])) {
            $limit = $reqQuery['limit'];
        }

        if (isset($reqQuery['page'])) {
            $page = $reqQuery['page'];
        }

        if (!is_numeric($page) or !is_numeric($limit)) {
            return array('result' => false);
        }

        $conditions[] = 'status = :status:';
        $bindParams['status'] = 'active';

        return array('result' => true, 'conditions' => $conditions, 'bindParams' => $bindParams, 'limit' => $limit, 'page' => $page);
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

            $results = $this->product_repo->addProduct($data);
            $result = $results['result'];

            if ($result === true) {
                $product = $results['product'];
                $this->response->setJsonContent(
                    [
                        $product
                    ]
                );
            } else {
                $message = $results['message'];
                $messageError = $this->createErrorMessage($message);
                $this->setErrorMsg('409', $messageError);
            }
            return $this->response;
        } catch (Exception $e) {
            $this->setErrorMsg(400, $e->getMessage());
            return $this->response;
        }
    }
    private function checkRequestData($data, $edit = false)
    {
        $attr = ['name', 'brand', 'size', 'color'];
        $color = ['Green', 'Yellow', 'Black', 'White', 'Red', 'Ombre', 'Silver', 'Gray', 'Purple', 'Lime', 'Teal', 'Olive', 'Blue'];
        $upperColor = [];
        foreach ($color as $c) {
            $upperColor[] = strtoupper($c);
        }
        $size = ['S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
        foreach ($attr as $item) {
            if (!property_exists($data, $item)) {
                return false;
            }
        }
        // $matchingColor = array_search($data->color, $color);
        $matchingColor = array_search($data->color, $upperColor);
        $matchingSize = array_search($data->size, $size);
        if (($matchingColor === false) or ($matchingSize === false) or !$data->name or !$data->brand) {
            return false;
        }

        if ($edit) {
            if (!property_exists($data, 'id')) {
                return false;
            }
            if (!is_int($data->id)) {
                return false;
            }
            if (!property_exists($data, 'status')) {
                return false;
            }
        }
        return true;
    }
    public function deleteProduct($id)
    {
        $this->setHeader();
        try {
            $results = $this->product_repo->deleteProduct($id);
            $result = $results['result'];
            if ($result === true) {
                $this->response->setJsonContent(
                    [
                        'msg' => 'success'
                    ]
                );
            } else {
                $message = $results['message'];
                $messageError = $this->createErrorMessage($message);
                $this->setErrorMsg('409', $messageError);
            }
            return $this->response;
        } catch (Exception $e) {
            $this->setErrorMsg(400, $e->getMessage());
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

            $results = $this->product_repo->editProduct($data);
            $result = $results['result'];
            if ($result === true) {
                $product = $results['product'];
                $this->response->setJsonContent(
                    [
                        $product
                    ]
                );
            } else {
                $message = $results['message'];
                $messageError = $this->createErrorMessage($message);
                $this->setErrorMsg('409', $messageError);
            }
            return $this->response;
        } catch (Exception $e) {
            $this->setErrorMsg(400, $e->getMessage());
            return $this->response;
        }
    }
    public function getProductById($id)
    {
        $this->setHeader();
        try {
            $results = $this->product_repo->getProductById($id);
            if (!$results['result']) {
                $message = $results['message'];
                $messageError = $this->createErrorMessage($message);
                $this->setErrorMsg('409', $messageError);
            } else {
                $this->response->setJsonContent(
                    $results['product']
                );
            }
            return $this->response;
        } catch (Exception $e) {
            $this->setErrorMsg(400, $e->getMessage());
            return $this->response;
        }
    }
}
