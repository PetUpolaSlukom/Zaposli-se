<?php

if(!isset($_SESSION['user'])){
    header("Location: index.php?page=home");
    die();
}
else{
    $user = $_SESSION['user'];
    if($_SESSION['user']->role != 2){
        header("Location: index.php?page=home");
        die();
    }
}
require_once "models/functions.php";
?>
<!--HEADER-->
<div class="col-12 d-flex justify-content-center p-0">
    <div id="companies-header" class="background-page-header bg-dark-gradient bg-companies d-flex flex-wrap justify-content-center col-12">
        <div class="col-6 col-sm-4 d-flex flex-wrap align-items-end">
            <div class="d-flex justify-content-center col-3">
                <img src="assets/img/admin.jpg" class="responsive-img bg-white rounded p-2 col-12" alt="user">
            </div>
            <div class="col-12 d-flex">
                <h1 class="mb-0">Admin - <?=$user->first_name?> <?=$user->last_name?></h1>
            </div>
        </div>

    </div>
</div>
<!--NAVIGATION-->
<div id="admin-n av" class="col-12 d-flex justify-content-center pb-5">
    <div class="d-flex justify-content-center border-bottom">

        <a href="#admin-user" class="text-light transpBgHover my-3 mx-4">
            <h4>Upravljanje korisnicima</h4>
        </a>

        <a href="#admin-message" class="text-light transpBgHover my-3 mx-4">
            <h4>Upravljanje porukama</h4>
        </a>

        <a href="#admin-poll" class="text-light transpBgHover my-3 mx-4">
            <h4>Rezultati ankete</h4>
        </a>
    </div>
</div>


<!-- USERS -->
<div class="col-12 col-md-10 mx-auto py-5 border-bottom" id="admin-user">
    <?php
        $users = queryFunction("SELECT * FROM user", true);
    ?>
    <h3 class="text-light text-center mb-4">Korisnici (<?=count($users)?>)</h3>
    <?php
        if (isset($_GET["userError"])){
            echo '<p class="alert alert-danger col-12 col-md-6">'.$_GET["userError"].'</p>';
        }
        if (isset($_GET["userMessage"])){
            echo '<p class="alert alert-success col-12 col-md-6">'.$_GET["userMessage"].'</p>';
        }
    ?>
    <table class="table table-striped table-success">
        <thead>
        <tr class="table-light">
            <th scope="col">#</th>
            <th scope="col">Ime i prezime</th>
            <th scope="col">Email</th>
            <th scope="col">Upravljaj</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $i = 1;
            foreach ($users as $u):
        ?>
        <tr class="<?=$u->active == 1 ? "table-success" : "table-danger"?>">
            <th scope="row"><?=$i++?></th>
            <td><?=$u->first_name?> <?=$u->last_name?></td>
            <td><?=$u->email?></td>
            <?php
                if ($u->role == 2):
            ?>
                <td class="text-dark">Admin</td>
            <?php
                else:
            ?>
                <!--       PROVERA JE LI USER AKTIVAN I U SKLADU SA TIM DEFINISANJE AKCIJE         -->
                <td><a href="models/admin/changeUserStatus.php?id=<?=$u->id_user?>&status=<?=$u->active == 1 ? "1" : "0"?>" class="btn btn-<?=$u->active == 1 ? "danger" : "success"?>"><?=$u->active == 1 ? "Deaktiviraj" : "Aktiviraj"?></a></td>
            <?php
                endif;
            ?>
        </tr>
        <?php
            endforeach;
        ?>
        </tbody>
    </table>
</div>

<!-- MESSAGES -->
<div class="col-12 col-md-10 mx-auto py-5 border-bottom" id="admin-message">
    <?php
        // prvo se prikazuju poruke koje nisu procitane
        $messages = queryFunction("SELECT * FROM message ORDER BY seen asc", true);
    ?>
    <h3 class="text-light text-center mb-4">Poruke (<?=count($messages)?>)</h3>
    <?php
    if (isset($_GET["messageError"])){
        echo '<p class="alert alert-danger col-12 col-md-6">'.$_GET["messageError"].'</p>';
    }
    if (isset($_GET["messageMessage"])){
        echo '<p class="alert alert-success col-12 col-md-6">'.$_GET["messageMessage"].'</p>';
    }
    ?>
    <table class="table table-striped">
        <thead>
        <tr class="table-light">
            <th scope="col">#</th>
            <th scope="col">Ime i prezime</th>
            <th scope="col">Email</th>
            <th scope="col">Tekst poruke</th>
            <th scope="col">Upravljaj</th>
            <th scope="col">Brisanje</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        foreach ($messages as $m):
            ?>
            <tr class="<?=$m->seen == 1 ? "table-light" : "table-primary"?>">
                <th scope="row"><?=$i++?></th>
                <td><?=$m->full_name?></td>
                <td><?=$m->email?></td>
                <td><?=$m->text?></td>
                <td><a href="models/admin/changeMessageStatus.php?id=<?=$m->id_message?>&status=<?=$m->seen == 1 ? "1" : "0"?>" class="btn btn-<?=$m->seen == 1 ? "primary" : "light"?>"><?=$m->seen == 1 ? "Označi kao nepročitano" : "Označi kao pročitano"?></a></td>
                <td><a href="models/admin/daleteMessage.php?id=<?=$m->id_message?>" class="btn btn-danger">Obriši</a></td>
            </tr>
        <?php
        endforeach;
        ?>
        </tbody>
    </table>
</div>


<!-- POLL SATISTIC -->

<div class="col-12 col-md-10 mx-auto py-5 border-bottom" id="admin-poll">
    <?php
    $quality = queryFunction("SELECT * FROM poll_quality", true);
    $interest = queryFunction("SELECT * FROM poll_interest", true);
    ?>
    <h3 class="text-light text-center mb-4">Rezultati Ankete</h3>
    <h5 class="text-light text-center mb-4"><p class="text-info"># </p> Glasanje za interesovanja</h5>
    <table class="table table-striped table-light">
        <thead>
        <tr class="table-info">
            <th scope="col">#</th>
            <?php
            foreach ($interest as $i):
            ?>
            <th scope="col"><?= $i->name?></th>
            <?php endforeach;?>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td class="font-weight-bold">Broj glasova</td>
            <?php
                $sum = 0;
                foreach ($interest as $i):
                    $sum += $i->votes;
            ?>
                <td><?= $i->votes?></td>
            <?php endforeach;?>
            </tr>
            <tr>
                <td class="font-weight-bold">Procenat</td>
                <?php
                //PRETVARAMO U DRUGOM REDU U PROCENTE
                $oneOfHundred = $sum / 100;
                foreach ($interest as $i):
                    ?>
                    <td><?= round($i->votes/$oneOfHundred, 1)?>%</td>
                <?php endforeach;?>
            </tr>
        <tr>
            <td class="font-weight-bold">Ukupno glasova</td>
            <td class="font-weight-bold"><?= $sum?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tbody>
    </table>
<!--    SITE QUALITY SECTION-->
    <h5 class="text-light text-center mt-5 mb-4"><p class="text-warning"># </p> Procena kvaliteta sajta</h5>
    <table class="table table-striped table-light">
        <thead>
        <tr class="table-warning">
            <th scope="col">#</th>
            <th scope="col">Veoma loš</th>
            <th scope="col">Loš</th>
            <th scope="col">Prihvatljiv</th>
            <th scope="col">Dobar</th>
            <th scope="col">Veoma dobar</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="font-weight-bold">Broj glasova</td>
            <?php
            $sum = 0;
            foreach ($quality as $q):
                $sum += $q->votes;
                ?>
                <td><?= $q->votes?></td>
            <?php endforeach;?>
        </tr>
        <tr>
            <td class="font-weight-bold">Procenat</td>
            <?php
            //PRETVARAMO U DRUGOM REDU U PROCENTE
            $oneOfHundred = $sum / 100;
            foreach ($quality as $q):
                ?>
                <td><?= round($q->votes/$oneOfHundred, 1)?>%</td>
            <?php endforeach;?>
        </tr>
        <tr>
            <td class="font-weight-bold">Ukupno glasova</td>
            <td class="font-weight-bold"><?= $sum?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tbody>
    </table>
</div>