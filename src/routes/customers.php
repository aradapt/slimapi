<?php
//http://localhost:8888/loc8api/public/api/customer/2
//http://localhost:8888/loc8api/public/api/customers
//http://localhost:8888/loc8api/public/api/venders

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// arada joint 020520

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

// Get All Customers
$app->get('/api/customers', function(Request $request, Response $response){
    $sql = "SELECT * FROM customers";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $customers = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($customers);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Get Single Customer
$app->get('/api/customer/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id'); //รับค่า id จาก URL มา

    $sql = "SELECT * FROM customers WHERE id = $id"; // เตรียมคำสั่ง SQL

    try{
        $db = new db(); // สร้าง Object รอ
        $db = $db->connect(); // เปิดใช้ ฐานข้อมูล

        $stmt = $db->query($sql); // เอาคำสั่ง sql เข้าไปจัดการ แล้วเอาผลลัพธ์มาใส่ตัวแปน $stmt
        $customer = $stmt->fetch(PDO::FETCH_OBJ); // เอาผลลัพธ์ที่ได้มากระจายใส่ตัวแปร $customer
        $db = null; // คืนค่าตัวแปรให้ระบบ
        echo json_encode($customer); // เอาตัวแปร $customer มาเขียนเป็น JSON เพื่อเอาไปใช้งาน
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Add Customer
$app->post('/api/customer/add', function(Request $request, Response $response){
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');
    $fax = $request->getParam('fax');
    $age = $request->getParam('age');
    $idcar = $request->getParam('idcar');
    $iddriver = $request->getParam('iddriver');
    $idtax = $request->getParam('idtax');

    $sql = "INSERT INTO customers (first_name,last_name,phone,email,address,city,state,fax,age,idcar,iddriver,idtax) VALUES
    (:first_name,:last_name,:phone,:email,:address,:city,:state,:fax,:age,:idcar,:iddriver,:idtax)";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name',  $last_name);
        $stmt->bindParam(':phone',      $phone);
        $stmt->bindParam(':email',      $email);
        $stmt->bindParam(':address',    $address);
        $stmt->bindParam(':city',       $city);
        $stmt->bindParam(':state',      $state);
        $stmt->bindParam(':fax',      $fax);
        $stmt->bindParam(':age',      $age);
        $stmt->bindParam(':idcar',      $idcar);
        $stmt->bindParam(':iddriver',      $iddriver);
        $stmt->bindParam(':idtax',      $idtax);

        $stmt->execute();

        echo '{"notice": {"text": "Customer Added"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Update Customer
$app->put('/api/customer/update/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    $phone = $request->getParam('phone');
    $email = $request->getParam('email');
    $address = $request->getParam('address');
    $city = $request->getParam('city');
    $state = $request->getParam('state');
    $fax = $request->getParam('fax');
    $age = $request->getParam('age');
    $idcar = $request->getParam('idcar');
    $iddriver = $request->getParam('iddriver');
    $idtax = $request->getParam('idtax');

    $sql = "UPDATE customers SET
				first_name 	= :first_name,
				last_name 	= :last_name,
                phone		= :phone,
                email		= :email,
                address 	= :address,
                city 		= :city,
                state		= :state,
                fax         = :fax,
                age         = :age,
                idcar       = :idcar,
                iddriver    = :iddriver,
                idtax       = :idtax

			WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name',  $last_name);
        $stmt->bindParam(':phone',      $phone);
        $stmt->bindParam(':email',      $email);
        $stmt->bindParam(':address',    $address);
        $stmt->bindParam(':city',       $city);
        $stmt->bindParam(':state',      $state);
        $stmt->bindParam(':fax',      $fax);
        $stmt->bindParam(':age',      $age);
        $stmt->bindParam(':idcar',      $idcar);
        $stmt->bindParam(':iddriver',      $iddriver);
        $stmt->bindParam(':idtax',      $idtax);

        $stmt->execute();

        echo '{"notice": {"text": "Customer Updated"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Delete Customer
$app->delete('/api/customer/delete/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "DELETE FROM customers WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "Customer Deleted"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

