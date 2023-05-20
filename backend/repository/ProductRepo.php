<?php
    namespace MyApp\Repository;
    use Phalcon\Di\Injectable;
    use MyApp\Models;
    use Phalcon\Paginator\Adapter\Model as PaginateModel;

    class ProductRepo extends Injectable{
        public function deleteProduct($id) {
            $product = Models\Product::findFirst($id);
            if (!$product) {
                return array('result'=> false, 'message' => array("Can't find product with id"));
            }
            $result = $product->delete();
            return array('result'=> $result, 'message' => $product->getMessages());
        }
        public function editProduct($data) {
            $field = ['name', 'brand', 'size', 'color', 'status'];
            $product = Models\Product::findFirst($data->id);
            if (!$product) {
                return array('result'=> false, 'message' => array("Can't find product with id"));
            }
            $product->assign(get_object_vars($data),$field);
            $result = $product->save();
            return array('result'=> $result, 'product'=>$product, 'message' => $product->getMessages());
        }

        public function addProduct($data) {
            $field = ['name', 'brand', 'size', 'color'];
            $product = new Models\Product();
            $product->assign(get_object_vars($data),$field);
            $product->status = 'active';
            $result = $product->save();
            return array('result'=> $result, 'product'=>$product, 'message' => $product->getMessages());
        }

        public function getProductWithStock($query) {
            $conditions = $query['conditions'];
            $bindParams = $query['bindParams'];
            $limit = $query['limit'];
            $page = $query['page'];
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

            $resultsArray = [];
            $resultsArray['items']=$items;
            $resultsArray['total_items']= $results->getTotalItems();
            return $resultsArray;
        }
    }