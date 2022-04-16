<?php
require_once "../../config/connection.php";
require_once "../functions.php";

if (!isset($_GET["id"]) || !isset($_GET["status"])) {
    header("Location: index.php?page=home");
    die();
}
//u zavisnosti odakle se  salje zahtev za izmenu , vraca se na istu stranicu
$page = isset($_GET["page"]) ? "company&id=".$_GET["page"] : "jobs";
$id = $_GET["id"];
$status = $_GET["status"] == "0" ? 0 : 1;

try {
    global $conn;

    $status = !$status;

    $result = $conn->prepare("UPDATE job SET active = ? WHERE id_job = ?");
    $result = $result->execute([$status, $id]);

    if ($result) {
        header("Location: ../../index.php?page=".$page."&adminMessage=Uspesno menjanje statusa oglasa.");

    }
    else {
        header("Location: ../../index.php?page=".$page."&adminError=Trenutno nije moguce uraditi operaciju");

    }
} catch (PDOException $ex) {
    return false;
}

