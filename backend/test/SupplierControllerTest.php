<?php
    namespace Test;
    require __DIR__."/../vendor/autoload.php";
    use MyApp\Repository\AddressRepo;
    use MyApp\Controllers\SupplierController;
    use MyApp\Repository\SupplierRepo;
    use MyApp\Repository\ProductSupRepo;
    use PHPUnit\Framework\TestCase;
    use Phalcon\DI;
    use Phalcon\Http\Request;
    use Phalcon\Mvc\Model\Query\Status;
    use MyApp\Util\Util;

    class SupplierControllerTest extends TestCase{
        protected function setUp(): void
        {
            parent::setUp();
            $DI=new DI\FactoryDefault();


            //mock the repository'
            $statusMock=$this->getMockBuilder(Status::class)->setConstructorArgs([true])->getMock();
            $statusMock->expects($this->any())->method('success')->willReturn(true);

            $supplier_repo=$this->getMockBuilder(SupplierRepo::class)->getMock();
            $supplier_repo
                ->expects($this->any())
                ->method('updateSupplier')
                ->willReturn($statusMock);
            $productsup_repo=$this->getMockBuilder(ProductSupRepo::class)->getMock();
            $address_repo=$this->getMockBuilder(AddressRepo::class)->getMock();
            $DI->setShared('supplier_repo',$supplier_repo);
            $DI->setShared('productsup_repo',$productsup_repo);
            $DI->setShared('address_repo',$address_repo);
        }
        public function testUpdateSupplier(){
            $tcs=[
                [
                    "request" => "{
                        \"name\":\"".Util::randomName(10)."\",
                        \"email\":\"".Util::randomEmail(10)."\",
                        \"number\":\"".Util::randomPhoneNumber(10)."\",
                        \"status\":\"active\",
                        \"id\":\"".Util::randomNumber(1,15)."\"
                    }",
                    "response" => [
                        "code"=>200,
                        "body"=>""
                    ]
                ],
            ];
            $controller=new SupplierController();
            foreach ($tcs as $tc){
                $DI=DI\Di::getDefault();
                $requestMock=$this->getMockBuilder(Request::class)->getMock();
                $requestMock->expects($this->any())->method("getJsonRawBody")->willReturn(json_decode($tc["request"]));
                $DI->set('request',$requestMock);
                $res=$controller->updateSupplier();
                var_dump($res->getContent());
                $this->assertEquals($tc["response"]["code"],$res->getStatusCode());
                
            }
        }
        
    }