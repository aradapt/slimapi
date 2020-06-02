<?php
// Exam:
//http://localhost:8888/loc8api/public/entitys

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

// Get All entitys
$app->get('/api/entitys', function(Request $request, Response $response){
    $sql = "SELECT * FROM entitys";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $entitys = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($entitys);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Get Single entitys
$app->get('/api/pakak/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM entitys WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $entitys = $stmt->fetch(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($entitys);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


// Add entitys
$app->post('/api/entitys/add', function(Request $request, Response $response){
    $bitio = $request->getParam('bitio');
    $dmy = $request->getParam('dmy');
    $shft = $request->getParam('shft');
    $nodeid = $request->getParam('nodeid');
    $mcid = $request->getParam('mcid');
    $am12 = $request->getParam('am12');
    $am01 = $request->getParam('am01');
    $am02 = $request->getParam('am02');
    $am03 = $request->getParam('am03');
    $am04 = $request->getParam('am04');
    $am05 = $request->getParam('am05');
    $am06 = $request->getParam('am06');
    $am07 = $request->getParam('am07');
    $am08 = $request->getParam('am08');
    $am09 = $request->getParam('am09');
    $am10 = $request->getParam('am10');
    $am11 = $request->getParam('am11');
    $pm12 = $request->getParam('pm12');
    $pm01 = $request->getParam('pm01');
    $pm02 = $request->getParam('pm02');
    $pm03 = $request->getParam('pm03');
    $pm04 = $request->getParam('pm04');
    $pm05 = $request->getParam('pm05');
    $pm06 = $request->getParam('pm06');
    $pm07 = $request->getParam('pm07');
    $pm08 = $request->getParam('pm08');
    $pm09 = $request->getParam('pm09');
    $pm10 = $request->getParam('pm10');
    $pm11 = $request->getParam('pm11');
    $hdrld= $request->getParam('hdrld');

    $sql = "INSERT INTO entitys (bitio,dmy,shft,nodeid,mcid,am12,am01,am02,am03,am04,am05,am06,am07,am08,am09,am10,am11,pm12,pm01,pm02,pm03,pm04,pm05,pm06,pm07,pm08,pm09,pm10,pm11,hdrld) VALUES
    (:bitio,:dmy,:shft,:nodeid,:mcid,:am12,:am01,:am02,:am03,:am04,:am05,:am06,:am07,:am08,:am09,:am10,:am11,:pm12,:pm01,:pm02,:pm03,:pm04,:pm05,:pm06,:pm07,:pm08,:pm09,:pm10,:pm11,:hdrld)";

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
		$stmt->bindParam(':am12', $am12);
		$stmt->bindParam(':am01', $am01);
		$stmt->bindParam(':am02', $am02);
		$stmt->bindParam(':am03', $am03);
		$stmt->bindParam(':am04', $am04);
		$stmt->bindParam(':am05', $am05);
		$stmt->bindParam(':am06', $am06);
		$stmt->bindParam(':am07', $am07);
		$stmt->bindParam(':am08', $am08);
		$stmt->bindParam(':am09', $am09);
		$stmt->bindParam(':am10', $am10);
		$stmt->bindParam(':am11', $am11);
		$stmt->bindParam(':pm12', $pm12);
		$stmt->bindParam(':pm01', $pm01);
		$stmt->bindParam(':pm02', $pm02);
		$stmt->bindParam(':pm03', $pm03);
		$stmt->bindParam(':pm04', $pm04);
		$stmt->bindParam(':pm05', $pm05);
		$stmt->bindParam(':pm06', $pm06);
		$stmt->bindParam(':pm07', $pm07);
		$stmt->bindParam(':pm08', $pm08);
		$stmt->bindParam(':pm09', $pm09);
		$stmt->bindParam(':pm10', $pm10);
		$stmt->bindParam(':pm11', $pm11);
		$stmt->bindParam(':hdrld', $hdrld);

        $stmt->execute();

        echo '{"notice": {"text": "entitys Added"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

/*
// Update entitys
$app->put('/api/entitys/update/{id}', function(Request $request, Response $response){
    $bitio = $request->getParam('bitio');
    $dmy = $request->getParam('dmy');
    $shft = $request->getParam('shft');
    $nodeid = $request->getParam('nodeid');
    $mcid = $request->getParam('mcid');
    $am12 = $request->getParam('am12');
    $am01 = $request->getParam('am01');
    $am02 = $request->getParam('am02');
    $am03 = $request->getParam('am03');
    $am04 = $request->getParam('am04');
    $am05 = $request->getParam('am05');
    $am06 = $request->getParam('am06');
    $am07 = $request->getParam('am07');
    $am08 = $request->getParam('am08');
    $am09 = $request->getParam('am09');
    $am10 = $request->getParam('am10');
    $am11 = $request->getParam('am11');
    $pm12 = $request->getParam('pm12');
    $pm01 = $request->getParam('pm01');
    $pm02 = $request->getParam('pm02');
    $pm03 = $request->getParam('pm03');
    $pm04 = $request->getParam('pm04');
    $pm05 = $request->getParam('pm05');
    $pm06 = $request->getParam('pm06');
    $pm07 = $request->getParam('pm07');
    $pm08 = $request->getParam('pm08');
    $pm09 = $request->getParam('pm09');
    $pm10 = $request->getParam('pm10');
    $pm11 = $request->getParam('pm11');

    $sql = "UPDATE entitys SET
				bitio	= :bitio,
				dmy		= :dmy,
				shft	= :shft,
				nodeid	= :nodeid,
				mcid	= :mcid,
				am12	= :am12,
				am01	= :am01,
				am02	= :am02,
				am03	= :am03,
				am04	= :am04,
				am05	= :am05,
				am06	= :am06,
				am07	= :am07,
				am08	= :am08,
				am09	= :am09,
				am10	= :am10,
				am11	= :am11,
				pm12	= :pm12,
				pm01	= :pm01,
				pm02	= :pm02,
				pm03	= :pm03,
				pm04	= :pm04,
				pm05	= :pm05,
				pm06	= :pm06,
				pm07	= :pm07,
				pm08	= :pm08,
				pm09	= :pm09,
				pm10	= :pm10,
				pm11	= :pm11,
				hdrld	= :hdrld,
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
		$stmt->bindParam(':am12', $am12);
		$stmt->bindParam(':am01', $am01);
		$stmt->bindParam(':am02', $am02);
		$stmt->bindParam(':am03', $am03);
		$stmt->bindParam(':am04', $am04);
		$stmt->bindParam(':am05', $am05);
		$stmt->bindParam(':am06', $am06);
		$stmt->bindParam(':am07', $am07);
		$stmt->bindParam(':am08', $am08);
		$stmt->bindParam(':am09', $am09);
		$stmt->bindParam(':am10', $am10);
		$stmt->bindParam(':am11', $am11);
		$stmt->bindParam(':pm12', $pm12);
		$stmt->bindParam(':pm01', $pm01);
		$stmt->bindParam(':pm02', $pm02);
		$stmt->bindParam(':pm03', $pm03);
		$stmt->bindParam(':pm04', $pm04);
		$stmt->bindParam(':pm05', $pm05);
		$stmt->bindParam(':pm07', $pm07);
		$stmt->bindParam(':pm07', $pm07);
		$stmt->bindParam(':pm08', $pm08);
		$stmt->bindParam(':pm09', $pm09);
		$stmt->bindParam(':pm10', $pm10);
		$stmt->bindParam(':pm11', $pm11);
		$stmt->bindParam(':hdrld', $hdrld);

        $stmt->execute();

        echo '{"notice": {"text": "entitys Updated"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

// Delete entitys
$app->delete('/api/entitys/delete/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = "DELETE FROM entitys WHERE id = $id";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);
        $stmt->execute();
        $db = null;
        echo '{"notice": {"text": "entitys Deleted"}';
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
*/