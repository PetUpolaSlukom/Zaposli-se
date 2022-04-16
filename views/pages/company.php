<?php
require_once "models/functions.php";
if (isset($_GET['id'])){
    $c_id = $_GET['id'];
}
$company_obj = getCompany($c_id);
$company = $company_obj[0];
if ($company == null){
    header('Location: index.php?page=companies');
}

if (isset($_SESSION['user'])){
    $user = $_SESSION['user'];
}else{
    $user = false;
}


$employees_obj = getEmployeesForCompany($c_id);
if ($user){
    if ($user->role == 2)
        $employees_obj = getEmployeesForCompany($c_id, true);
}

$tech_obj = getTechnologyForCompany($c_id);
$photos_obj = getPhotosForCompany($c_id);
$jobs_obj = getJobsForCompany($c_id);

?>
<!--header-->
<div class="col-12 d-flex justify-content-center p-0">
    <div id="companies-header" class="background-page-header bg-dark-gradient bg-companies d-flex flex-wrap justify-content-center col-12">
        <div class="col-6 col-sm-4 d-flex flex-wrap align-items-end">
            <div class="col-12 d-flex align-items-end">
                <div class="d-flex justify-content-center">
                    <img src="assets/img/<?=$company->logo_img?>" class="bg-white rounded p-2 w-75" alt="<?=$company->name?>">
                </div>
            </div>

            <div class="col-12 d-flex align-items-end">
                <h1 class="mb-0"><?=$company->name?></h1>
            </div>
        </div>
        <div class="col-3 d-flex align-items-end justify-content-end">
            <?php
                if( $company->ranking):
            ?>
            <button class="btn bg-white border-3 mr-2 text-dark mb-0 cursorDefault  d-flex align-items-center">
                <h5 class="mb-0 mr-2"><?= $company->ranking?></h5>
                <i class="fa fa-star"></i>
            </button>
            <?php
                endif;
            ?>
        </div>
    </div>
</div>
<?php

?>
<div id="company-n av" class="col-12 d-flex justify-content-center pb-5">
    <div class="d-flex justify-content-center border-bottom">
        <a href="#company-description" class="text-light transpBgHover my-3 mx-4">
            <h4>O nama</h4>
        </a>
        <?php
            if (count($employees_obj)):
        ?>
        <a href="#company-employee" class="text-light transpBgHover my-3 mx-4">
            <h4>Zaposleni</h4>
        </a>
        <?php
            endif;
        ?>
        <?php
        if (count($tech_obj)):
            ?>
            <a href="#company-tech" class="text-light transpBgHover my-3 mx-4">
                <h4>Tehnologije</h4>
            </a>
        <?php
        endif;
        ?>
        <?php
        if (count($photos_obj)):
            ?>
            <a href="#company-gallery" class="text-light transpBgHover my-3 mx-4">
                <h4>Galerija</h4>
            </a>
        <?php
        endif;
        ?>
        <?php
        if (count($jobs_obj)):
            ?>
            <a href="#company-jobs" class="text-light transpBgHover my-3 mx-2">
                <h4>Poslovi</h4>
            </a>
        <?php
        endif;
        ?>
    </div>
</div>
<!--description and links-->
<div id="company-description" class="d-flex justify-content-center py-5">
    <div class="col-9 d-flex align-items-center">
        <div class="col-8">
            <h4 class="text-light text-center">O NAMA</h4>
            <?php
            if (isset($_GET["aboutCompanyError"])){
                echo '<p class="alert alert-danger col-12 col-md-6">'.$_GET["aboutCompanyError"].'</p>';
            }
            if (isset($_GET["aboutCompanyMessage"])){
                echo '<p class="alert alert-success col-12 col-md-6">'.$_GET["aboutCompanyMessage"].'</p>';
            }
            ?>
            <?php

            $role = $user ? $user->role : 0;

                if ($role == 2):?>
                    <form action="models/admin/changeAbotCompanySection.php" method="POST">
                        <div class="form-group">
                            <label for="aboutTextarea" class="text-muted">Izmena sekcije o nama</label>
                            <textarea class="form-control" id="aboutTextarea" name="aboutTextarea" rows="12"><?=$company->description?></textarea>
                            <input type="hidden" value="<?=$company->id_company?>" name="idCompanyHidden">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Potvrdi izmenu" class="btn btn-warning">
                        </div>
                    </form>
            <?php
                else:
            ?>
                <h5 class="text-light my-4"><?=$company->description?></h5>
            <?php endif;?>
        </div>
        <div class="col-4">
            <div class="bg-light text-white rounded p-3 shadow <?= $user->role == 2 ? "d-none" : ""?>">
                <h5 class="mb-3 text-dark text-center">KONTAKT</h5>
                <div class="d-block mb-3">
                    <h6 class="d-inline"><i class="fas fa-map-marker-alt mr-1 text-muted"></i></h6>
                    <p class="ml-1 d-inline text-dark"><?=$company->address . ", " . $company->location?></p>
                </div>
                <div class="d-block mb-3">
                    <h6 class="d-inline"><i class="fas fa-envelope mr-1 text-muted"></i></h6>
                    <p class="ml-1 d-inline"><a href="mailto:<?=$company->mail?>" class=" text-dark"><?=$company->mail?></a></p>
                </div>
                <div class="d-block mb-3">
                    <h6 class="d-inline"><i class="fas fa-globe-africa mr-1 text-muted"></i></h6>
                    <p class="ml-1 d-inline"><a href="https://www.<?=$company->website?>" class="text-dark"><?=$company->website?></a></p>
                </div>
                <?php
                    if($company->phone):
                ?>
                <div class="d-block mb-3">
                    <h6 class="d-inline"><i class="fas fa-mobile-alt mr-1 text-muted"></i></h6>
                    <p class="ml-1 d-inline"><a href="tel:<?=$company->phone?>" class="text-dark"><?=$company->phone?></a></p>
                </div>
                <?php
                    endif;
                ?>
                <?php
                    $company_socNet_obj = getCompanySocNetwork($c_id);
                    if ($company_socNet_obj):
                ?>
                <h5 class="mt-4 mb-3">
                    <?php
                        foreach ($company_socNet_obj as $socNet):
                    ?>
                    <a href="<?=$socNet->link?>" class="text-dark transpBgHover mr-3"><i class="fab fa-<?=$socNet->name?>"></i></a>

                    <?php
                        endforeach;
                    ?>
                </h5>
                <?php
                    endif;
                ?>

            </div>
            <!--      ADMIN PRIKAZ:      -->
            <?php
            if (isset($_GET["contactError"])){
                echo '<p class="alert alert-danger col-12 col-md-6">'.$_GET["contactError"].'</p>';
            }
            if (isset($_GET["contactMessage"])){
                echo '<p class="alert alert-success col-12 col-md-6">'.$_GET["contactMessage"].'</p>';
            }
            ?>
            <div class="bg-light text-white rounded p-3 shadow <?= $user->role == 2 ? "" : "d-none"?>">
                <h5 class="mb-3 text-dark text-center">KONTAKT</h5>
                <form action="models/admin/changeCompanyContactSection.php" method="POST">
                    <div class="d-block mb-3">
                        <h6 class="d-inline"><i class="fas fa-map-marker-alt mr-1 text-muted"></i></h6>
                        <input class="p-1" type="text" name="compAddress" id="compAddress" value="<?=$company->address?>">
<!--                        <p class="ml-1 d-inline text-dark">//=$company->address . ", " . $company->location</p>-->
                    </div>
                    <div class="d-block mb-3">
                        <h6 class="d-inline"><i class="fas fa-envelope mr-1 text-muted"></i></h6>
                        <input class="p-1" type="text" name="compMail" id="compMail" value="<?=$company->mail?>">
                    </div>
                    <div class="d-block mb-3">
                        <h6 class="d-inline"><i class="fas fa-globe-africa mr-1 text-muted"></i></h6>
                        <input class="p-1" type="text" name="compWebsite" id="compWebsite" value="<?=$company->website?>">
                    </div>

                <?php
                if($company->phone):
                    ?>
                    <div class="d-block mb-3">
                        <h6 class="d-inline"><i class="fas fa-mobile-alt mr-1 text-muted"></i></h6>
                        <input class="p-1" type="text" name="compPhone" id="compPhone" value="<?=$company->phone?>">
                    </div>
                <?php
                endif;
                ?>
                    <input type="hidden" name="idHidden" value="<?=$company->id_company?>">
                    <input type="submit" name="changeCompContact-button" value="Potvrdi izmenu" class="btn btn-warning">
                </form>
            </div>
        </div>
    </div>
</div>


<!--employee-->
<?php
//    $employees_obj = getEmployeesForCompany($c_id);
    if ($employees_obj):
?>
<div id="company-employee" class="d-flex justify-content-center py-5">
    <div class="col-9 d-flex justify-content-center flex-wrap">
<?php
    if (isset($_GET["employeeError"])) {
        echo '<p class="alert alert-danger col-12 col-md-6">' . $_GET["employeeError"] . '</p>';
    }
    if (isset($_GET["employeeMessage"])) {
        echo '<p class="alert alert-success col-12 col-md-6">' . $_GET["employeeMessage"] . '</p>';
    }
?>
        <h4 class="text-light text-center col-12">ZAPOSLENI</h4>
        <?php
        foreach ($employees_obj as $emp):
        ?>
        <div class="text-center col-9 col-sm-6 col-md-4 mb-5">
            <img class="card-img-top rounded-circle mx-auto col-8 mb-3 p-4" src="assets/img/<?=$emp->photo?>" alt="<?=$emp->full_name?>">
            <div class="pb-4">
                <h4 class="text-light"><?=$emp->full_name?></h4>
                <h6 class="text-muted mb-4"><?=$emp->position?></h6>
                <p class="text-light"><?=$emp->about_company?></p>
            </div>
            <?php
                if (isset($_SESSION['user'])){
                    $user = $_SESSION['user'];
                    if ($user->role == 2):
                    ?>
                        <a href="models/admin/changeEmployeeStatus.php?idCompany=<?=$company->id_company?>&id=<?=$emp->id_employee?>&status=<?=$emp->active == 1 ? "1" : "0"?>" class="btn btn-<?=$emp->active == 1 ? "danger" : "success"?>"><?=$emp->active == 1 ? "Ne prikazuj zaposlenog" : "Prikaži zaposlenog"?></a>

                <?php
                    endif;
                }
                ?>
        </div>
        <?php
            endforeach;
        ?>
    </div>
</div>
<?php endif;
?>


<!--tech-->
<?php
//$tech_obj = getTechnologyForCompany($c_id);
if ($tech_obj):
?>
    <div id="company-tech" class="d-flex justify-content-center py-5">
        <div class="col-9 d-flex justify-content-center flex-wrap">
            <h4 class="text-light text-center col-12 mb-5">TEHNOLOGIJE KOJE KORISTIMO</h4>
            <div class="text-center col-12 col-sm-7 mb-5 autor">
                <?php
                foreach ($tech_obj as $tch):
                ?>
                    <h2 class="btn bg-light cursorDefault mx-1"><?=$tch->name?></h2>
                <?php
                endforeach;
                ?>
            </div>
        </div>
    </div>
<?php endif;
?>


<!--gallery-->
<?php
//$photos_obj = getPhotosForCompany($c_id);
if ($photos_obj):
?>
<div id="company-gallery" class="d-flex justify-content-center py-5">
    <div class="col-9 d-flex justify-content-center flex-wrap">
        <h4 class="text-light text-center col-12 mb-5">GALERIJA</h4>
        <div class="container d-flex flex-wrap col-12 pt-3 mt-4 mb-5">
            <div class="col d-flex flex-wrap align-items-between col-12 p-0 ">
                <!--alt atributes-->
                <!--    svaka treca slika ima drugaciji stil    -->
                <?php
                    $third=0;
                    foreach ($photos_obj as $photo):
                        if ($third % 3):
                ?>
                                <div class=" container col-12 col-md-11 col-lg-6 mb-5"><img src="assets/img/<?=$photo->image?>" class="mw-100" alt=""> </div>
                        <?php
                            else:
                        ?>
                                <div class=" container col-12 col-md-6 col-lg-5 mb-5"><img src="assets/img/<?=$photo->image?>" class="mw-100" alt=""> </div>
                        <?php
                            endif;
                        ?>

                <?php
                    $third++;
                    endforeach;
                ?>
            </div>
        </div>
    </div>
</div>
<?php endif;
?>


<!--jobs-->
<?php
if ($jobs_obj):
?>
<div id="company-jobs" class="d-flex justify-content-center flex-wrap py-5">
    <h4 class="text-light text-center col-12 mb-5">POSLOVI</h4>
    <?php
    if (isset($_GET["adminError"])) {
        echo '<p class="alert alert-danger col-12 col-md-6">' . $_GET["adminError"] . '</p>';
    }
    if (isset($_GET["adminMessage"])) {
        echo '<p class="alert alert-success col-12 col-md-6">' . $_GET["adminMessage"] . '</p>';
    }
    ?>
    <div class="col-12 col-sm-9 d-flex justify-content-center flex-wrap">

        <?php
            foreach ($jobs_obj as $job):
                if ($role != 2 && !$job->active) continue;
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
                    <?php
                        if ($role == 2):?>

                            <a href="models/admin/changeJobStatus.php?id=<?=$job->id_job?>&status=<?=$job->active?>&page=<?=$company->id_company?>" class="btn btn-<?=$job->active ? "danger" : "success"?> mr-2"><?=$job->active ? "Deaktiviraj" : "Aktiviraj"?></a>
                    <?php else:?>
                            <a href="models/user/addToFavouriteJob.php?id=<?=$job->id_job?>" class="text-dark btn bg-white border-3 mr-2 transpBgHover">
                                <h5 class="mb-0"><i class="far fa-heart"></i></h5>
                            </a>
                            <a href="index.php?page=job_application&id=<?=$job->id_job?>" class="btn btn-dark mr-2">Apliciraj</a>

                    <?php endif;?>
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