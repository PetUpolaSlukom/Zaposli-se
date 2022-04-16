<?php
require_once "../../config/connection.php";
require_once "../functions.php";

if (!isset($_GET["id"]) || !isset($_GET["status"])) {
    header("Location: index.php?page=home");
    die();
}

$id = $_GET["id"];
$status = $_GET["status"] == "0" ? 0 : 1;

if (changeActiveStatusForUser($id, $status)) {
    header("Location: ../../index.php?page=admin&userMessage=Uspesno menjanje statusa#admin-user");
    //http_response_code(200);
}
else {
    header("Location: ../../index.php?page=admin&userError=Trenutno nije moguce uraditi operaciju#admin-user");
    //http_response_code(200);
}
