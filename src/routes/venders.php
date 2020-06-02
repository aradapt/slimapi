<?php
//http://localhost:8888/loc8api/public/api/venders

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

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

// Get All venders
$app->get('/api/venders', function(Request $request, Response $response){
    $sql = "SELECT * FROM venders";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $venders = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($venders);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Get Single venders
$app->get('/api/venders/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id'); //รับค่า id จาก URL มา

    $sql = "SELECT * FROM venders WHERE id = $id"; // เตรียมคำสั่ง SQL

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

// Add venders
$app->post('/api/venders/add', function(Request $request, Response $response){
    $company = $request->getParam('company_name');
    $address = $request->getParam('address');
    $contact_no= $request->getParam('contact_no');
    $email = $request->getParam('email');
    $website = $request->getParam('website');
    $establisher = $request->getParam('establisher');
    $payment_terms = $request->getParam('payment_terms');
    $bank_account = $request->getParam('bank_account');
    $contact_name = $request->getParam('contact_name');

    $sql = "INSERT INTO venders (company_name,address,contact_no,email,website,establisher,payment_terms,bank_account,contact_name) VALUES
    (:company,:address,:contact_no,:email,:website,:establisher,:payment_terms,:bank_account,:contact_name)";
    //echo $sql; 
    //exit();
    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':company_name', $company);
        $stmt->bindParam(':address',  $address);
        $stmt->bindParam(':contact_no', $contact_no);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':website', $website);
        $stmt->bindParam(':establisher', $establisher);
        $stmt->bindParam(':payment_terms', $state);
        $stmt->bindParam(':bank_account',  $bank_account);
        $stmt->bindParam(':contact_name',  $contact_name);
        
        $stmt->execute();

        echo '{"notice": {"text": "venders Added"}';

    } catch(PDOException $e){
        echo '{"errorab": {"text": '.$e->getMessage().'}';
    }
});

// Update venders
$app->put('/api/venders/update/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    
    $company_name = $request->getParam('company_name');
    $address = $request->getParam('address');
    $contact_no= $request->getParam('contact_no');
    $email = $request->getParam('email');
    $website = $request->getParam('website');
    $establisher = $request->getParam('establisher');
    $payment_terms = $request->getParam('payment_terms');
    $bank_account = $request->getParam('bank_account');
    $contact_name = $request->getParam('contact_name');

    $sql = "UPDATE venders SET
				company_name 	= :company_name,
				address 	    = :address,
                contact_no		= :phone,
                email		    = :contact_no,
                website 	    = :website,
                establisher     = :establisher,
                payment_terms   = :payment_terms,
                bank_account    = :bank_account,
                contact_name    = :contact_name,

			WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':company_name', $company_name);
        $stmt->bindParam(':address',  $address);
        $stmt->bindParam(':contact_no', $contact_no);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':website', $website);
        $stmt->bindParam(':establisher', $establisher);
        $stmt->bindParam(':payment_terms', $state);
        $stmt->bindParam(':bank_account',  $bank_account);
        $stmt->bindParam(':contact_name',  $contact_name);
        $stmt->execute();

        echo '{"notice": {"text": "venders Updated"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Delete venders
$app->delete('/api/venders/delete/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "DELETE FROM venders WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "venders Deleted"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});