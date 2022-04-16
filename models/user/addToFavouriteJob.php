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

// ako zahtev za dodavanje stize sa stranice "user" onda treba da ostane na njoj
$userPage = false;
if ($_GET['page'] == "user"){
    $userPage = true;
}
//
$id_job = $_GET['id'];
$id_user = $_SESSION['user']->id_user;

//provera postoji li u tabeli
try {
    global $conn;

    $query = $conn->prepare("SELECT id_job FROM user_favourite_job WHERE id_user = ? AND id_job = ?");
    $query->execute([$id_user, $id_job]);
    $usersFavouriteJob = $query->fetch();

} catch (PDOException $ex) {

    //create_log(ERROR_LOG_FAJL, $ex->getMessage());
    $error = "Greška pri komunikaciji sa serverom, probajte kasnije ponovo.";
    header("Location: ../../index.php?page=register&error=".$error);
}

//ako ne postoji => upis
if (!$usersFavouriteJob) {
    try {
        $query = $conn->prepare("INSERT INTO user_favourite_job(id_user, id_job) VALUES(?,?) ");
        $result = $query->execute([$id_user, $id_job]);

        if ($result) {
            if ($userPage){
                //poseban url za stranicu user
                $message = "Uspešno opozvano uklanjanje.";
                header("Location: ../../index.php?page=user&undo=1&id=".$id_user."&id-job=".$id_job."&message=".$message.".#user-job");
            }
            else{
                $message = "Uspešno dodat u omiljene poslove.";
                header("Location: ../../index.php?page=jobs&message=".$message);
            }
        }
        else {
            $error = "Greška na serveru. Molimo pokušajte malo kasnije.";

            header("Location: ../../index.php?page=jobs&error=".$error);
        }
    } catch (PDOException $ex) {


        //create_log(ERROR_LOG_FAJL, $ex->getMessage());
        $error = "Greška pri komunikaciji sa serverom, probajte kasnije ponovo.";
        header("Location: ../../index.php?page=jobs&error=".$error);
        die();
    }
}
else{
    $message = "Posao se vec nalazi u listi poslova.";
    header("Location: ../../index.php?page=jobs&error=".$message);

}
