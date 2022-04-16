<?php
header('Content-type: application/json');
require_once "../../config/connection.php";
require_once "../functions.php";

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : false;
$tech = isset($_GET['tech']) ? $_GET['tech'] : false;
$seniority = isset($_GET['seniority']) ? $_GET['seniority'] : false;
$publicDateOrder = isset($_GET['publicDate']) ? $_GET['publicDate'] : false;
$remote = isset($_GET['remote']) ? $_GET['remote'] : false;
$salary = isset($_GET['salary']) ? $_GET['salary'] : false;
$internship = isset($_GET['internship']) ? $_GET['internship'] : false;
$premium = isset($_GET['premium']) ? $_GET['premium'] : false;

$stringQuery = "";
$params_array = [];


if ($keyword){
    $stringQuery .= " AND (LOWER(c.name) LIKE ? OR LOWER(j.position) LIKE ?)";
    $params_array [] = "%$keyword%";
    $params_array [] = "%$keyword%";
}
if ($tech){
    $stringQuery .= " AND j.id_job = ANY (SELECT jt.id_job
                                        FROM job_technology jt INNER JOIN technology t
                                        ON t.id_technology = jt.id_technology
                                        WHERE t.name LIKE ?)";
    $params_array [] = "%$tech%";
}
if ($seniority){
    $stringQuery .= " AND sen.id_seniority = ?";
    $params_array [] = $seniority;
}
if ($remote){
    $remote = $remote == "remote" ? 1 : 0;
    $stringQuery .= " AND j.remote = ?";
    $params_array [] = $remote;
}
if ($salary == "yes"){
    $stringQuery .= " AND j.id_job = ANY (SELECT s.id_job FROM salary s)";
}
if ($internship == "yes"){
    $stringQuery .= " AND j.internship = 1";
}
if ($premium == "yes"){
    $stringQuery .= " AND j.premium = 1";
}
if($publicDateOrder){
    $stringQuery .= " ORDER BY date_public " . $publicDateOrder;
}


try {
    global $conn;
    $query = 'SELECT j.*, c.logo_img as img, c.name as company_name, s.starting_salary, s.max_salary, sen.name as seniority 
                FROM job j 
                INNER JOIN company c ON j.id_company = c.id_company 
                LEFT JOIN salary s ON s.id_job = j.id_job 
                INNER JOIN seniority sen ON sen.id_seniority = j.id_seniority 
                WHERE (j.active = 1 OR j.active = 0) ' . $stringQuery;

    $select_query = $conn->prepare($query);
    $select_query->execute($params_array);
    $jobs = $select_query->fetchAll();

    // dohvatanje tehnologija za svaki dobijen job
    $jobsTechnologies = [];
    if($jobs != []){
        $idsArray = [];
        foreach ($jobs as $j){
            $idsArray[] = $j->id_job;
        }
        $jobsTechnologies = getTechnologiesForJobs($idsArray);
    }

    if(!$jobs){
        $jobs = [];
    }

    $admin = false;
    if(isset($_SESSION['user'])){
        $admin = $_SESSION['user']->role == 2;
    }

    $response_code = 200;
} catch (PDOException $ex) {
    //createLog(ERROR_LOG_FAJL, $ex->getMessage());
    $jobs = [];
    $response_code = 500;
}

echo json_encode([
    "jobs"=>$jobs,
    "technologies" => $jobsTechnologies,
    "admin"=>$admin
]);
http_response_code($response_code);