<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->group('/api', function () use ($app){
            
        $app->get('/customers', function (Request $request, Response $response, array $args)  {
            $result = $this->customer->number_of_customers();
            return $response->withJson($result)->withStatus(200);
           
        });

        $app->post('/customers', function (Request $request, Response $response, array $args){
            $customer_data = $request->getParsedBody();
            $result = $this->customer->create_customer($customer_data);
            
             if($result){
             return $response->withJson(["result"=>"customer created"])->withStatus(201);
             } else{
             return $response->withJson(["result"=>"customer not created"])->withStatus(422);
            }
        });

            $app->get('/customers/{id}', function (Request $request, Response $response, array $args){
            $id = $args['id'];
            $customer = $this->customer->get_customer($id);
            return $response->withJson($customer)->withStatus(200);
        });

            $app->post('/customers/{id}', function (Request $request, Response $response, array $args){
               
               $data = $request->getParsedBody();
               $result = $this->customer->update_customer($args['id'], $data);
               if($result == true){
                   return $response->withJson(["result" => "record updated"])->withStatus(200);
               }elseif(!$result){
                   return $response->withJson(["result" => "unable to updated record"])->withStatus(422);
               }else {
                   return "Error";
               }

            });

            $app->delete('/customers/{id}', function(Request $request, Response $response, array $args){
                $id = $args['id'];
                $customer = $this->customer->delete_customer($id);
                if($customer){
                    return $response->withJson(["result"=>"deleted"])->withStatus(200);
                }else {
                    return $response->withStatus(204)->withJson(["result"=>"no record"]);
                }
            });
            /**
             * GET request returns all of the products in the database
             */
            $app->get('/products',function(Request $request, Response $response, array $args) {
                $results = $this->products->get_all_products();
                return $response->withJson($results)->withStatus(200);
            });

            /**
             * GET request returns the recordsd for one product
             */
            $app->get('/products/{id}', function(Request $request, Response $response, array $args){
                $id = $args['id'];
                $result = $this->products->get_product($id);
                if(isset($result)){
                   return  $response->withJson($result)->withStatus(200);
                } else{
                    return $response->withJson(["result"=>"record not found"])->withStatus(404);
                }
        
            }); 

            /**
             * 
             */
            $app->put('/products/{id}', function(Request $request, Response $response, array $args){
                $product_id = $args['id'];
                $product_data = $request->getParsedBody();
                $result = $this->products->update_product($product_id, $product_data);
                if($result){
                    return $response->withJson(["result"=>"product updated"])->withStatus(200);
                }else {
                    return $response->withJson(["result"=>"product not updated"])->withStatus(422);
                }
                
            });


       

    });

   


    
};
