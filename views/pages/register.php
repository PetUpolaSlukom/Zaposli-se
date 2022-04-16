<?php

if(isset($_SESSION['user'])){
    header("Location: index.php?page=home");
    die();
}
?>
<div class="col-12 pl-0 d-flex justify-content-around">
    <form name="register-form" id="register-form" class="col-8 col-md-4  pt-5 pb-3 bg-light" method="POST" action="models/user/doRegister.php">
        <h2 class="col-12 mb-5 text-center">Registruj se</h2>
        <div class="container-fluid col-12">

            <p class='text-danger'><small>*Sva polja su obavezna.</small></p>

            <div>
                <input type="text" name="firstName" id="firstName" class="container border-bottom-green  py-3" placeholder="Ime">
            </div>
            <div>
                <input type="text" name="lastName" id="lastName" class="container border-bottom-green  py-3 mt-2" placeholder="Prezime">
            </div>
            <div>
                <input type="email" name="email" id="email" class="container border-bottom-green  py-3 mt-2" placeholder="Email">
            </div>
            <div>
                <input type="password" name="password" id="password" class="container border-bottom-green py-3 mt-2" placeholder="Lozinka">
            </div>
            <div>
                <input type="password" name="confirm-password" id="confirm-password" class="container border-bottom-green py-3 mt-2" placeholder="Potvrda lozinke">
            </div>
            <div class="d-flex align-items-center flex-column py-3">
                <input type="submit" name="register-button" id="register-button" class="btn btn-dark" value="Registruj se">
            </div>
        </div>
        <p class='text-center text-muted'>Imate nalog?<a href="index.php?page=login" class='ml-2 text-danger transpBgHover td-u'>Prijavi se.</a></p>
        <?php
        if(isset($_GET["error"])){
            echo "<p class='alert alert-danger col-9 mt-3 mx-auto'>".$_GET["error"]."</p>";
        }
        if(isset($_GET["message"])){
            echo "<p class='alert alert-info col-8 mt-3 mx-auto'>".$_GET["message"]."</p>";
        }
        ?>
    </form>
</div>