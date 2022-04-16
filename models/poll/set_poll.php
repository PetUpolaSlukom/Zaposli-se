<?php
header('Content-type: application/json');
require_once "../../config/connection.php";

$interest = isset($_GET["interest"]) ? $_GET["interest"] : false;
$qualityId = isset($_GET["quality"]) ? $_GET["quality"] : false;

global $conn;

try {

    $query = $conn->prepare('SELECT votes FROM poll_quality WHERE id_quality = ?');
    $query->execute([$qualityId]);
    $votes = $query->fetch();
    $votes = $votes->votes + 1;


    $query = $conn->prepare('UPDATE poll_quality SET votes='.$votes.' WHERE id_quality = ?');
    $resultQuality = $query->execute([$qualityId]);

    if (!$resultQuality){
        $votes_q = false;
    }

    foreach ($interest as $i){

        $query = $conn->prepare('SELECT votes FROM poll_interest WHERE name LIKE ?');
        $query->execute([$i]);
        $votes_i = $query->fetch();
        $votes_i = $votes_i->votes + 1;


        $query = $conn->prepare('UPDATE poll_interest SET votes='.$votes_i.' WHERE name = ?');
        $resultInterest = $query->execute([$i]);
    }

    if (!$resultInterest){
        $votes_i = false;
    }

    $response_code = 201;
}
catch (PDOException $ex){
    echo json_encode(["result"=>$ex]);
    $votes = false;
    $response_code = 500;
}


echo json_encode([
    "resultInterest"=>$resultInterest,
    "resultQuality"=>$resultQuality
]);


