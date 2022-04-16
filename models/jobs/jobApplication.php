<?php

include_once "../../config/connection.php";

$id_job = $_POST["hidden-job"];
if (!isset($_POST['job-application-button'])) {
    header("Location: ../../index.php?page=home");
}
else {
    $regFullName = "/^[A-ZŠĐŽĆČ][a-zšđžćč]{2,15}(\s[A-ZŠĐŽĆČ][a-zšđžćč]{2,15}){0,2}$/";
    if(!preg_match($regFullName, $_POST["name"])){
        header("Location: ../../index.php?page=job_application&id=".$id_job."&error=Neispravno%20ime%20i%20prezime.");
        die();
    }

    $regEmail = "/^[a-z]((\.|-|_)?[a-z0-9]){2,}@[a-z]((\.|-|_)?[a-z0-9]+){2,}\.[a-z]{2,6}$/i";
    if(!preg_match($regEmail, $_POST["email"])){
        header("Location: ../../index.php?page=job_application&id=".$id_job."&error=Neispravan%20email.");
        die();
    }

    $name =  $_POST["name"];
    $email = $_POST["email"];
    $text = $_POST["text"];


    try {
        global $conn;

        $query = $conn->prepare("INSERT INTO job_application(id_job, candidate_full_name, candidate_email, candidate_message) VALUES(?,?,?,?)");
        $result = $query->execute([$id_job, $name, $email, $text]);
        if ($result) {

            $message = "Poruka je uspešno prosleđena.";
            header("Location: ../../index.php?page=job_application&id=".$id_job."&message=Poruka je uspešno prosleđena");
        }
        else {

            $error = "Greška na serveru. Molimo pokušajte malo kasnije.";
            header("Location: ../../index.php?page=job_application&id=".$id_job."&error=".$error);
        }
    } catch (PDOException $ex) {

        $error = "Greška pri komunikaciji sa serverom, probajte kasnije ponovo.";
        header("Location: ../../index.php?page=job_application&id=".$id_job."&error=".$error);
        die();
    }
}