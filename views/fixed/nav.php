<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand text-warning" href="index.php?page=home">ZaposliSe</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <?php
                $pages = queryFunction("SELECT * FROM page", true);
                foreach ($pages as $p):
                    if ($p->name == "job_application" || $p->name == "login" ||$p->name == "register" ||$p->name == "admin" ||$p->name == "user" ||$p->name == "company"){
                        continue;
                    }
            ?>
                <li class="nav-item active">
                    <a class="nav-link" href="index.php?page=<?=$p->name?>"><?=$p->name == "home" ? "Početna" : $p->title?></a>
                </li>
            <?php
                endforeach;
            ?>
        </ul>
    </div>
    <?php
    if (isset($_SESSION["user"])):
    ?>
        <a class="nav-link float-right text-light" href="models/user/doLogout.php">Odjavi se</a>
        <?php
            if ($_SESSION["user"]->role == 2)
                echo '<a class="btn btn-light float-right px-2 py-1" href="index.php?page=admin"><i class="fas fa-user-cog text-dark mr-2"></i></i>Admin panel</a>';
            else
                echo '<a class="nav-link float-right text-light" href="index.php?page=user&id='.$_SESSION["user"]->id_user.'"><i class="fas fa-user-alt mr-2"></i>'.$_SESSION["user"]->first_name.'</a>';
        ?>
    <?php
    else:
        if ($page != "register" && $page != "login"){
            echo '<a class="nav-link float-right text-light" href="index.php?page=login">Prijavi se</a>
                <a class="nav-link float-right text-light" href="index.php?page=register">Registruj se</a>';
        }
    endif;
    ?>

</nav>

