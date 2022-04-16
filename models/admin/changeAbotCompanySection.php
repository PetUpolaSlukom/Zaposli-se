<?php
require_once "../../config/connection.php";
require_once "../functions.php";

if (!isset($_POST["aboutTextarea"]) || !isset($_POST["idCompanyHidden"])) {
    header("Location: index.php?page=home");
    die();
}

$text = $_POST["aboutTextarea"];
$id = $_POST["idCompanyHidden"];

try {
    global $conn;

    $result = $conn->prepare("UPDATE company_profile SET description = ? WHERE id_company = ?");
    $result = $result->execute([$text, $id]);

    if ($result) {
        header("Location: ../../index.php?page=company&id=".$id."&aboutCompanyMessage=Uspesna izmena.#company-description");
        //http_response_code(200);
    }
    else {
        header("Location: ../../index.php?page=company&id=".$id."aboutCompanyError=Trenutno nije moguce uraditi operaciju#company-description");
        //http_response_code(200);
    }
} catch (PDOException $ex) {
    //createLog(ERROR_LOG_FAJL, $ex->getMessage());
    return false;
}
