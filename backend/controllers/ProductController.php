<?php
namespace MyApp\Controllers;

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;
use MyApp\Models as Models;

/**
 * @property Response $response
 */
class ProductController extends Controller
{
    public function index()
    {
        $phql = "
            SELECT 
                p.*, 
                ps.*,
                s.name 
            FROM 
                 MyApp\Models\Product p            
            JOIN MyApp\Models\Productsupply ps ON p.id = ps.productid
            JOIN MyApp\Models\Supplier s ON s.id = ps.supplierid";
        $query = $this->modelsManager->executeQuery($phql);
        $output_array = [];
        foreach ($query as $item) {
            // Check if the ID already exists in the output array
            $key = array_search($item->p->id, array_column($output_array, 'id'));

            if ($key === false) {
                // ID does not exist, create a new object for it
                $output_item = new \stdClass;
                $output_item->id = $item->p->id;
                $output_item->name = $item->p->name;
                $output_item->brand = $item->p->brand;
                $output_item->sku = $item->p->sku;
                $output_item->size = $item->p->size;
                $output_item->color = $item->p->color;
                $output_item->status = $item->p->status;
                $output_item->total_stock = $item->p->total_stock;
                $output_item->supllier = [];

                $supplier_item = new \stdClass;
                $supplier_item->supplier = $item->name;
                $supplier_item->stock = $item->ps->stock;

                $output_item->supllier[] = $supplier_item;

                $output_array[] = $output_item;

            } else {
                // ID exists, add the age to the existing object
                $supplier_item = new \stdClass;
                $supplier_item->suppliername = $item->name;
                $supplier_item->stock = $item->ps->stock;

                $output_array[$key]->supllier[] = $supplier_item;
            }
        }
        return json_encode($output_array);
    }

    public function post()
    {
        $data = $this->request->getJsonRawBody();
        if (!$this->checkattr($data)) {
            $response = new Response();
            $response->setStatusCode(400);
            $response->setJsonContent(
                [
                    'status' => "Fail",
                    'message'=> 'Field should be not null'
                ]
            );
            return $response;
        }


        $product = $this->getData($data);
        // Store and check for errors
        $success = $product->save();

        $response = new Response();
        $response->setStatusCode(201, 'Created');
        $response->setJsonContent(
            [
                'status' => $success,
                'data'   => $product
            ]
        );
        return $response;
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
        $product = Models\Product::findFirst($id);
        if ($product) {
            $result = $product->delete();
        } else {
            $result = false;
        }

        $response = new Response();

        if ($result === true) {
            $response->setJsonContent(
                [
                    'status' => 'OK'
                ]
            );
        } else {
            $response->setStatusCode(409, 'Conflict');

            $response->setJsonContent(
                [
                    'status'   => 'ERROR',
                    'messages' => "Can't delete this item",
                ]
            );
        }
        return $response;
    }
    private function getData($data, $id =0) {
        if (($id) == 0) {
            $product = new Models\Product();
        }  else {
            $product = Models\Product::findFirst($id);
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
        $data = $this->request->getJsonRawBody();
        if (!$this->checkattr($data,true)) {
            $response = new Response();
            $response->setStatusCode(400);
            $response->setJsonContent(
                [
                    'status' => "Fail",
                    'message'=> 'Field should be not null'
                ]
            );
            return $response;
        }

        $product = $this->getData($data,$id);
        $result = $product->save();

        $response = new Response();

        if ($result === true) {
            $response->setJsonContent(
                [
                    'status' => 'OK',
                    'data'   => $product,
                ]
            );
        } else {
            $response->setStatusCode(409, 'Conflict');
            $messages_tring = "";
            $messages = $product->getMessages();
            foreach ($messages as $message) {
                //$name = $message.getMessage();
                $name = " Error";
                $messages_tring."Validation error: ".$name."\n";
            }
            $response->setJsonContent(
                [
                    'status'   => 'ERROR',
                    'messages' => $messages_tring
                ]
            );
        }
        return $response;
    }
}
