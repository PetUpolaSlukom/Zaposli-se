<?php
//session_start();
header('Content-type: application/json');
require_once "../../config/connection.php";
require_once "../functions.php";
//
//

$stringQuery = "";
$params_array = [];

$search = isset($_GET["search"]) ? trim($_GET["search"]) : false;
$sort = isset($_GET["sortBy"]) ? $_GET["sortBy"] : false;
$direction = isset($_GET["orderDirection"]) ? $_GET["orderDirection"] : false;

if($search != ""){
    global $stringQuery, $params_array;

    $stringQuery .= " AND LOWER(name) LIKE ?";
    $params_array []= "%$search%";
}

if ($sort && $direction){

        $sort == 'job' ? $sort = 'totalJobs' : $sort = 'ranking';
        $stringQuery .= " ORDER BY $sort $direction";

}

try {
    global $conn;

    $query = 'SELECT *, (select COUNT(*) from job where id_company = c.id_company) totalJobs 
                FROM company c INNER JOIN company_profile cp ON c.id_company = cp.id_company    
                WHERE cp.active_status = 1'.$stringQuery;
    //$query = 'SELECT * FROM company';
    $select_query = $conn->prepare($query);
    $select_query->execute($params_array);

    $companies = $select_query->fetchAll();


//INNER JOIN job j on j.id_company = c.id_company
    if(!$companies){
        $companies = [];
    }
    $admin = false;
    if(isset($_SESSION['user'])){
        $admin = $_SESSION['user']->role == 2;
    }

    $response_code = 200;
} catch (PDOException $ex) {
    echo json_encode(["companies"=>$ex]);
    $companies = [];
    $response_code = 500;
}

echo json_encode([
    "companies"=>$companies,
    "admin"=>$admin
]);
http_response_code($response_code);