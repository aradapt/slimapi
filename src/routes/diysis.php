<?php
// Exam:
//http://localhost:8888/loc8api/public/diysis

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

// Get All diysis
$app->get('/api/diysis', function(Request $request, Response $response){
    $sql = "SELECT * FROM diysis";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $diysis = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($diysis);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Get Single diysis
$app->get('/api/diysi/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM diysis WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $diysis = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($diysis);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Add diysis
$app->post('/api/diysis/add', function(Request $request, Response $response){
    $bitio = $request->getParam('bitio');
    $dmy = $request->getParam('dmy');
    $shft = $request->getParam('shft');
    $nodeid = $request->getParam('nodeid');
    $mcid = $request->getParam('mcid');
    

    $sql = "INSERT INTO diysis (bitio,dmy,shft,nodeid,mcid) VALUES
    (:bitio,:dmy,:shft,:nodeid,:mcid)";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':bitio', $bitio);
		$stmt->bindParam(':dmy', $dmy);
		$stmt->bindParam(':shft', $shft);
		$stmt->bindParam(':nodeid', $nodeid);
		$stmt->bindParam(':mcid', $mcid);


        $stmt->execute();

        echo '{"notice": {"text": "diysis Added"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
/*
// Update diysis
$app->put('/api/diysis/update/{id}', function(Request $request, Response $response){
    $bitio = $request->getParam('bitio');
    $dmy = $request->getParam('dmy');
    $shft = $request->getParam('shft');
    $nodeid = $request->getParam('nodeid');
    $mcid = $request->getParam('mcid');


    $sql = "UPDATE diysis SET
				bitio	= :bitio,
				dmy		= :dmy,
				shft	= :shft,
				nodeid	= :nodeid,

			WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':bitio', $bitio);
		$stmt->bindParam(':dmy', $dmy);
		$stmt->bindParam(':shft', $shft);
		$stmt->bindParam(':nodeid', $nodeid);
		$stmt->bindParam(':mcid', $mcid);


        $stmt->execute();

        echo '{"notice": {"text": "diysis Updated"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Delete diysis
$app->delete('/api/diysi/delete/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "DELETE FROM diysis WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "diysis Deleted"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
*/