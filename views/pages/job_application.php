<?php
require_once "models/functions.php";
if (isset($_GET['id'])){
    $j_id = $_GET['id'];
}
$job_obj = getJob($j_id);
$job = $job_obj[0];

if ($job == null){
    header('Location: index.php?page=companies');
}

if (isset($_SESSION['user'])){
    $user = $_SESSION['user'];
}else{
    $user = false;
}
?>
<div class="col-12 d-flex justify-content-center p-0">
    <div id="companies-header" class="background-page-header bg-dark-gradient bg-companies d-flex flex-wrap justify-content-center col-12">
        <div class="col-6 col-sm-4 d-flex flex-wrap align-items-center">
            <div class="col-12 d-flex">
                <h1 class="mb-0">APLICIRAJ ZA POSAO</h1>
            </div>
        </div>

    </div>
</div>
<div class="col-12 d-flex justify-content-center">
    <div class="card col-10 mb-5 mt-5 d-flex justify-content-center">
        <div class="d-flex justify-content-between p-0 flex-wrap">

            <div>
                <h6 class="bg-primary py-2 px-2 h-100 text-white d-inline">Premium</h6>
            </div>
            <div>
                <h6 class="bg-danger py-2 px-2 h-100 text-white d-inline">Novo</h6>
            </div>
        </div>
        <div class="card-body d-flex justify-content-center py-5 flex-wrap">
            <div class="col-12 col-sm-7">
                <h4 class="card-title text-left col-12 mt-3 mb-4 ml-0 pl-0"><?= $job->position?></h4>
                <p class="card-text text-dark border-bottom pb-2"><?= $job->short_description?></p></hr>
                <p class="text-muted"><i class="far fa-clock mr-2"></i><?=  $job->date_deadline?>.</p>
            </div>
        </div>
    </div>
</div>

<!--    poruka u slucaju greske na serverskoj validaciji    -->
<?php
if (isset($_GET['error'])){
    echo '<p class="form-error alert alert-danger">'.$_GET['error'].'</p>';
}
?>
<!--    poruka u slucaju uspeha slanja    -->
<?php
$show = true;
if (isset($_GET['message'])){
    $show = false;
    echo '<p class="form-message alert alert-success">'.$_GET['message'].'</p>';
}
?>
<form name="application-form" id="application-form" class="col-10 col-md-8 p-5 pb-0 mx-auto <?=$show ? "" : "d-none"?>" method="POST" action="models/jobs/jobApplication.php">
    <h2 class="col-12 mb-4 text-light border-bottom pb-5">Pošalji nam motivaciono pismo. Zašto baš ti prava osoba za ovaj posao?</h2>
    <div class="container-fluid col-12">

        <div>
            <input type="text" name="name" id="name" class="container border-bottom-green py-2" placeholder="Ime i prezime" value="<?=$user ? $user->first_name." ".$user->last_name : ""?>">
        </div>
        <div>
            <input type="email" name="email" id="email" class="container border-bottom-green py-2 mt-2" placeholder="Email" value="<?=$user ? $user->email : ""?>">
        </div>
        <div>
            <textarea name="text" id="text" cols="22" maxlength="200" rows="4" class="container border-bottom-green py-2 mt-2" placeholder="Tekst poruke..."></textarea>
        </div>
        <input type="hidden" name="hidden-job" value="<?=$job->id_job?>">
        <div class="d-flex align-items-center flex-column py-3">
            <input type="submit" id="job-application-button" name="job-application-button" class="btn btn-light" value="Apliciraj">
        </div>
    </div>
</form>