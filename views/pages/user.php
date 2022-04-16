<?php
require_once "models/functions.php";

if(isset($_GET['id'])){
    $u_id = $_GET['id'];
}
else{
    header('Location: index.php?page=home');
    die();
}

$user = getUser($u_id);

if ($user == null){
    header('Location: index.php?page=home');
    die();
}
if (isset($_SESSION['user'])){
    if (!($user->id_user == $_SESSION['user']->id_user)){
        header('Location: index.php?page=home');
        die();
    }
}



//$companies = getUserFromUserCompany($u_id);
$jobs = getUserFromUserJob($u_id);

?>
<!--HEADER-->
<div class="col-12 d-flex justify-content-center p-0">
    <div id="companies-header" class="background-page-header bg-dark-gradient bg-companies d-flex flex-wrap justify-content-center col-12">
        <div class="col-6 col-sm-4 d-flex flex-wrap align-items-end">
            <div class="d-flex justify-content-center col-3">
               <img src="assets/img/user.jpg" class="responsive-img bg-white rounded p-2 col-12" alt="user">
           </div>
            <div class="col-12 d-flex">
                <h1 class="mb-0"><?=$user->first_name?></h1>
                <h1 class="mb-0 ml-2"><?=$user->last_name?></h1>
            </div>
        </div>

    </div>
</div>

<!--NAVIGATION-->
<div id="company-n av" class="col-12 d-flex justify-content-center pb-5">
    <div class="d-flex justify-content-center border-bottom">
        <?php
        if (count($jobs)):
            ?>
            <a href="#user-job" class="text-light transpBgHover my-3 mx-4">
                <h4>Sačuvani poslovi</h4>
            </a>
        <?php
        endif;
        ?>
    </div>
</div>


<!--saved jobs-->
<?php
if (isset($_GET['message'])) {
    if(isset($_GET['id-job']) && !isset($_GET['undo'])){
        echo "<p class='alert alert-success col-8 mt-3 mx-auto text-center'>"
            .$_GET["message"]
            ."<a class='td-u ml-2' href='models/user/addToFavouriteJob.php?page=user&id=".$_GET['id-job']. "'>Opozovi brisanje.</a>"
            ."</p>";
    }
    else{
        echo "<p class='alert alert-success col-8 mt-3 mx-auto text-center'>"
            .$_GET["message"]
            ."</p>";
    }
}

if ($jobs):
    ?>
    <div id="user-job" class="d-flex justify-content-center flex-wrap py-5">
        <h4 class="text-light text-center col-12 mb-5">Sačuvani poslovi (<?=count($jobs)?>)</h4>
        <div class="col-12 col-sm-9 d-flex justify-content-center flex-wrap">

            <?php

            foreach ($jobs as $job):
                ?>
                <div class="container d-flex justify-content-center flex-wrap col-6 my-3 h-inherit">
                    <div class="card col-12 col-lg-10 shadow bg-light text-dark">
                        <?php
                        if ($job->premium):
                            ?>
                            <div class="d-flex justify-content-between p-0 flex-wrap">
                                <div class=" mx-2 my-2">
                                    <h6 class="bg-primary pt-2 pb-1 px-2 h-100 bg-dark text-light">Premium</h6>
                                </div>
                            </div>
                        <?php
                        endif;
                        ?>

                        <div class="card-body">
                            <h4 class="card-title"><?=$job->position?></h4><hr>
                            <p class="card-text mx-2 ">• <?=$job->short_description?></p>

                            <?php
                            if ($job->active):
                                ?>
                                <p class=" mx-2"><i class="far fa-clock mr-1 text-dark"></i> <?=str_replace("-",".", $job->date_deadline)?></p>
                            <?php
                            else:
                                ?>
                                <p class="text-danger mx-2"><i class="fas fa-ban"></i> Istekao</p>
                            <?php
                            endif;
                            ?>
                            <?php
                            if ($job->remote):
                                ?>
                                <p class=" mx-2"><i class="fas fa-map-marker-alt text-dark"></i> Remote</p>
                            <?php
                            endif;
                            ?>
                            <?php
                            if ($job->for_students):
                                ?>
                                <p class=" mx-2"><i class="fas fa-graduation-cap text-dark"></i> Oglas dostupan studentima</p>
                            <?php
                            endif;
                            ?>
                            <?php
                            if ($job->disabled_person):
                                ?>
                                <p class=" mx-2"><i class="fas fa-wheelchair  text-dark"></i> Oglas dostupan osobama sa invaliditetom</p>
                            <?php
                            endif;

                            ?>
                            <a href="models/user/deleteFavouriteJob.php?id=<?=$job->id_job?>" class="btn btn-danger mt-3 mr-3 mx-auto">Ukloni sa liste</a>
                            <a href="#" class="btn btn-dark mt-3">Detaljnije</a>
                        </div>
                    </div>
                </div>
            <?php
            endforeach;
            ?>
        </div>
    </div>
<?php endif;
?>