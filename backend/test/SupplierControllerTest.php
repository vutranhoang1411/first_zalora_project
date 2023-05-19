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
                [//invalid email
                    "request"=>"{
                        \"name\":\"".Util::randomName(10)."\",
                        \"email\":\"".Util::randomName(10)."\",
                        \"number\":\"".Util::randomPhoneNumber(10)."\",
                        \"status\":\"active\",
                        \"id\":\"".Util::randomNumber(1,15)."\"
                    }",
                    "response"=>[
                        "code"=>400,
                        "body"=>"{\"error\":\"invalid email\"}"
                    ]
                ],
                [///invalid id
                    "request"=>"{
                        \"name\":\"".Util::randomName(10)."\",
                        \"email\":\"".Util::randomEmail(10)."\",
                        \"number\":\"".Util::randomPhoneNumber(10)."\",
                        \"status\":\"active\",
                        \"id\":\""."thisIsReallyInvalid"."\"
                    }",
                    "response"=>[
                        "code"=>400,
                        "body"=>"{\"error\":\"invalid id\"}"
                    ]
                ],
                [///missing field input
                    "request"=>"{
                        \"name\":\"".Util::randomName(10)."\",
                        \"email\":\"".Util::randomEmail(10)."\",
                        \"status\":\"active\",
                        \"id\":\""."thisIsReallyInvalid"."\"
                    }",
                    "response"=>[
                        "code"=>400,
                        "body"=>"{\"error\":\"missing field number\"}"
                    ]
                ],
                [//valid request body
                    "request" => "{
                        \"name\":\"".Util::randomName(10)."\",
                        \"email\":\"".Util::randomEmail(10)."\",
                        \"number\":\"".Util::randomPhoneNumber(10)."\",
                        \"status\":\"active\",
                        \"id\":\"".Util::randomNumber(1,15)."\"
                    }",
                    "response" => [
                        "code"=>200,
                        "body"=>"{\"msg\":\"success\"}"
                    ]
                ]
            ];
            
            foreach ($tcs as $tc){       
                //set new request service for each testcase     
                $DI=DI\Di::getDefault();
                $requestMock=$this->getMockBuilder(Request::class)->getMock();
                $requestMock->expects($this->any())->method("getJsonRawBody")->willReturn(json_decode($tc["request"]));
                $DI->remove('request');
                $DI->set('request',$requestMock);

                //new controller since the old one will use the old DI
                $controller=new SupplierController(); 

                //testing part
                $res=$controller->updateSupplier();
                $this->assertEquals($tc["response"]["code"],$res->getStatusCode());
                $this->assertEquals($tc["response"]["body"],$res->getContent());
            }
        }
        
    }