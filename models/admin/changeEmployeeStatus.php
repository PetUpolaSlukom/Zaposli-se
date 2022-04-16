<?php
require_once "../../config/connection.php";
require_once "../functions.php";

if (!isset($_GET["id"]) || !isset($_GET["status"]) || !isset($_GET["idCompany"])) {
    header("Location: index.php?page=home");
    die();
}

$id = $_GET["id"];
$idCompany = $_GET["idCompany"];
$status = $_GET["status"] == "0" ? 0 : 1;

try {
    global $conn;

    $status = !$status;

    $result = $conn->prepare("UPDATE employee SET active = ? WHERE id_employee = ?");
    $result = $result->execute([$status, $id]);

    if ($result) {
        header("Location: ../../index.php?page=company&id=".$idCompany."&employeeMessage=Uspesno menjanje prikaza.#company-employee");
        //http_response_code(200);
    }
    else {
        header("Location: ../../index.php?page=company&id=".$idCompany."employeeError=Trenutno nije moguce uraditi operaciju#company-employee");
        //http_response_code(200);
    }
} catch (PDOException $ex) {
    //createLog(ERROR_LOG_FAJL, $ex->getMessage());
    return false;
}

