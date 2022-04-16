<?php
include_once "../../config/connection.php";

if(!isset($_SESSION['user'])){
    header("Location: ../../index.php?page=login&error=Morate biti ulogovani da bi dodavali u listu omiljenih poslova.");
    die();
}


if (!isset($_GET['id'])){
    header("Location: ../../index.php?page=jobs");
    die();
}

$id_job = $_GET['id'];
$id_user = $_SESSION['user']->id_user;

try {
    global $conn;

    $query = $conn->prepare("SELECT * FROM user_favourite_job WHERE id_user = ? AND id_job = ?");
    $result = $query->execute([$id_user, $id_job]);
    $usersFavouriteJob = $query->fetch();

    if ($usersFavouriteJob != null){
        try {
            global $conn;

            $query = $conn->prepare("DELETE FROM user_favourite_job WHERE id_user = ? AND id_job = ?");
            $result = $query->execute([$id_user, $id_job]);

            if ($result){
                $message = "Uspesno uklanjanje oglasa sa liste";
                header("Location: ../../index.php?page=user&id-job=$id_job&id=$id_user&message=".$message."#user-job");
            }
        }
        catch (PDOException $ex) {

            //create_log(ERROR_LOG_FAJL, $ex->getMessage());
            $error = "Greška pri komunikaciji sa serverom, probajte kasnije ponovo.";
            header("Location: ../../index.php?page=register&error=".$error);
        }
    }

} catch (PDOException $ex) {

    //create_log(ERROR_LOG_FAJL, $ex->getMessage());
    $error = "Greška pri komunikaciji sa serverom, probajte kasnije ponovo.";
    header("Location: ../../index.php?page=register&error=".$error);
}


