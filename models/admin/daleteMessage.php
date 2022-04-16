<?php
require_once "../../config/connection.php";
require_once "../functions.php";

if (!isset($_GET["id"])) {
    header("Location: index.php?page=home");
    die();
}

$id = $_GET["id"];
try {
    global $conn;

    $result = $conn->prepare("DELETE FROM message WHERE id_message = ?");
    $result = $result->execute([$id]);

    if ($result) {
        header("Location: ../../index.php?page=admin&messageMessage=Uspesno brisanje poruke.#admin-message");
        //http_response_code(200);
    }
    else {
        header("Location: ../../index.php?page=admin&messageError=Trenutno nije moguce uraditi operaciju#admin-message");
        //http_response_code(200);
    }
}
catch (PDOException $ex){
    $error = "Greška pri komunikaciji sa serverom, probajte kasnije ponovo.";
    header("Location: ../../index.php?page=admin&messageError=".$error);
    die();
}

