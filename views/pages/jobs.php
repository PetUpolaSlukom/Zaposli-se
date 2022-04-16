
<div class="col-12 d-flex justify-content-center flex-wrap pt-5">
    <form class="needs-validation col-9" action="" method="get" id="formFilterJobs">
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <input type="text" class="form-control" id="tbKeyword" name="tbKeyword" placeholder="Trazi po ključnoj reči...">
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <input type="text" class="form-control" id="tbTech" name="tbTech" placeholder="Tehnologija...">
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <select class="custom-select" id="DDSeniority">
                    <option selected value="">Senioritet</option>
                    <option value="1">Junior</option>
                    <option value="2">Medior</option>
                    <option value="3">Senior</option>
                </select>
                <div class="invalid-feedback">
                    Please provide a valid city.
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <select class="custom-select" id="DDRemote">
                    <option value="0" selected>Prikaži i rad od kuće</option>
                    <option value="noremote">Ne prikazuj rad od kuće</option>
                    <option value="remote">Prikaži samo rad od kuće</option>
                </select>
                <div class="invalid-feedback">
                    Please provide a valid zip.
                </div>
            </div>
        </div>
        <div class="form-group form-check-inline">
            <div class="form-check form-check-inline" id="salaryFilter">
                <input class="form-check-input" type="checkbox" name="chSalary" value="chSalary" id="chSalary">
                <label class="form-check-label text-light" for="chInternship">
                    Plata
                </label>
            </div>
            <div class="form-check form-check-inline"id="internshipFilter">
                <input class="form-check-input ml-5" type="checkbox" name="chInternship" value="chInternship" id="chInternship">
                <label class="form-check-label text-light" for="chInternship">
                    Praksa
                </label>
                <div class="invalid-feedback">
                    You must agree before submitting.
                </div>
            </div>
            <div class="form-check form-check-inline"id="internshipFilter">
                <input class="form-check-input ml-5" type="checkbox" name="chPremium" value="chPremium" id="chPremium">
                <label class="form-check-label text-light" for="chPremium">
                    Premium oglasi
                </label>
                <div class="invalid-feedback">
                    You must agree before submitting.
                </div>
            </div>
        </div>
        <input type="submit" id="jobFilterSubmit" name="jobFilterSubmit" value="Pretrazi" class="btn btn-light transpBgHover">
    </form>
    <?php
    if(isset($_GET['adminError'])){
        $e = $_GET['adminError'];
        echo '<div class="alert alert-danger col-5 mx-auto text-center mt-5" role="alert">'.
                $e
            .'</div>';
    }
    ?>
    <?php
    if(isset($_GET['adminMessage'])){
        $m = $_GET['adminMessage'];
        echo '<div class="alert alert-success col-5 mx-auto text-center mt-5" role="alert">'.
                    $m
            .'</div>';
    }
    ?>

    <?php
        if(isset($_GET['error'])){
            $e = $_GET['error'];
            echo '<div class="alert alert-danger col-5 mx-auto text-center mt-5" role="alert">'.
                    $e . '<a class="ml-1 td-u" href="index.php?page=user&id='. $_SESSION["user"]->id_user .'#user-job">Pogledaj listu.</a>'
                .'</div>';
        }
    ?>
    <?php
    if(isset($_GET['message'])){
        $m = $_GET['message'];
        echo '<div class="alert alert-success col-5 mx-auto text-center mt-5" role="alert">'.
                $m . '<a class="ml-1 td-u" href="index.php?page=user&id='. $_SESSION["user"]->id_user .'#user-job">Pogledaj listu.</a>'
            .'</div>';
    }
    ?>




    <div id="jobs" class="mt-5 col-12 col-lg-10 d-flex justify-content-center flex-wrap">
<!--       ispis-->

    </div>
<!--</div>-->