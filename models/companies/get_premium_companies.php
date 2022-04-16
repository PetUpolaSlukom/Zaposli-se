<?php
header('Content-type: application/json');
require_once "../../config/connection.php";
require_once "../functions.php";

try {
    $premium_companies = queryFunction('SELECT * FROM company c INNER JOIN company_profile cp ON c.id_company = cp.id_company WHERE cp.premium = 1', true);
    if(!$premium_companies){
        $premium_companies = [];
    }
    $response_code = 200;
} catch (PDOException $ex) {
    //createLog(ERROR_LOG_FAJL, $ex->getMessage());
    $premium_companies = [];
    $response_code = 500;
}

echo json_encode(["premium_companies"=>$premium_companies]);
http_response_code(200);
