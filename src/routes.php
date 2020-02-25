<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    // $container = $app->getContainer();
    $app->get('/', function (Request $request, Response $response, array $args) {
       echo "<h1 style='margin-top:50vh; text-align:center; font-size:60px;'>Stock API</h1>";
    });


    //==================================================================
    // CRUD TABLE Products
    //=================================================================
    // ดึงข้อมูลจากตาราง products ออกมาแสดงเป็น json
    $app->group('/api', function() use ($app){

        $app->get('/', function (Request $request, Response $response, array $args) {
            echo "<h1 style='margin-top:50vh; text-align:center; font-size:60px;'>Stock API</h1>";
         });

        // List product
    	$app->get('/products', function (Request $request, Response $response, array $args) {
    		$sth = $this->db->prepare("SELECT * FROM products ORDER BY id");
    		$sth->execute();
    		$product = $sth->fetchAll();
    		// แสดงผลออกมาเป็น JSON
    		return $this->response->withJson($product);
    	});

        // User login
        $app->post('/user/login', function (Request $request, Response $response, array $args) {

            // รับค่า username และ password จากผู้ใช้
            $body = $this->request->getParsedBody();

            $username =  $body['username'];
            $password = sha1($body['password']);

            $sqlstr = "SELECT id,username,password FROM users WHERE username=:username and password=:password";

            $sql = $this->db->prepare($sqlstr, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));

            $sql->bindParam("username", $username);
            $sql->bindParam("password", $password);
            $sql->execute();

            // นับจำนวนแถวที่พบ
            $count = $sql->rowCount();
            // echo $count;

            // อ่านข้อมูลออกมาแสดง
            $result = $sql->fetchAll();

            // print_r($result);

            if($count >= 1){
                $input = [
                    'userid' => $result[0]['id'],
                    'status' => 'success'
                ];
            }else{
                $input = [
                    'userid' => '',
                    'status' => 'fail'
                ];
            }

            return $this->response->withJson($input);

        });

    });
    

};
