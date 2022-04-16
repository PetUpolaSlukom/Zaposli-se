<?php

include_once "../../config/connection.php";

if (!isset($_POST["changeCompContact-button"])) {
    header("Location: ../../index.php?page=home");
}

else {
    $id = $_POST["idHidden"];

    $regAddress = "/^[\w\.]+(,?\s[\w\.]+){2,8}$/";
    if(!preg_match($regAddress, $_POST["compAddress"])){
        header("Location: ../../index.php?page=company&id=".$id."&contactError=Neispravno napisana adresa.");
        die();
    }

    $regEmail = "/^[a-z]((\.|-|_)?[a-z0-9]){2,}@[a-z]((\.|-|_)?[a-z0-9]+){2,}\.[a-z]{2,6}$/i";
    if(!preg_match($regEmail, $_POST["compMail"])){
        header("Location: ../../index.php?page=company&id=".$id."&contactError=Neispravan%20email.");
        die();
    }

    //var_dump($_POST["compWebsite"]);
    //die();
    $regUrl = "/(?i)\b((?:https?:|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4})(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";
    if(!preg_match($regUrl, $_POST["compWebsite"])){
        header("Location: ../../index.php?page=company&id=".$id."&contactError=Neispravna%20websajt%20putanja.");
        die();
    }

    $regPhone = "/[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.0-9]*/";
    if(!preg_match($regPhone, $_POST["compPhone"])){
        header("Location: ../../index.php?page=company&id=".$id."&contactError=Neispravan broj telefona.");
        die();
    }

    $address = $_POST["compAddress"];
    $mail = $_POST["compMail"];
    $website = $_POST["compWebsite"];
    $phone =  $_POST["compPhone"];

    try {
        global $conn;

        $query = $conn->prepare("UPDATE company_profile SET address = ?,mail = ?,phone = ?,website = ? WHERE id_company = ?");
        $result = $query->execute([$address, $mail, $phone, $website, $id]);
        if ($result) {
            $message = "Uspešna izmena.";
            header("Location: ../../index.php?page=company&id=".$id."&contactMessage=".$message);
        }
        else {
            $error = "Greška na serveru. Molimo pokušajte malo kasnije.";
            header("Location: ../../index.php?page=company&id=".$id."&contactError=".$error);
        }
    } catch (PDOException $ex) {

        $error = "Greška pri komunikaciji sa serverom, probajte kasnije ponovo.";
        header("Location: ../../index.php?page=company&id=".$id."&contactError=".$error);
        die();
    }

}