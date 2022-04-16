<div class="d-flex justify-content-around flex-wrap py-5 m-0 col-12">
    <div id="contact-info" class="col-10 col-md-5 p-5 bg-light d-flex flex-wrap mb-5">
        <h2 class="col-12 mb-4 text-dark border-bottom pb-5">Kontakt informacije</h2>
        <div class="col-12">
            <ul id="contact-info-list" class="p-0">
                <li class="py-3 d-flex align-items-center">
                    <span class="mr-4 fas fa-map-marked-alt text-muted"></span><p class="text-dark mb-0">Cara Dušana 16, Beograd</p>
                </li>
                <li class="py-3 d-flex align-items-center">
                    <span class="mr-4 fas fa-map-marked-alt text-muted"></span><p class="text-dark mb-0">  Milana Rakića 77, Beograd</p>
                </li>
                <li class="py-3 d-flex align-items-center">
                    <span class="mr-4 far fa-clock text-muted"></span><p class="text-dark mb-0">Svim danima od 10:00 do 21:00</p>
                </li>
                <li class="py-3 d-flex align-items-center">
                    <span class="fas fa-phone mr-3 text-muted"></span><a class="text-muted td-u" href="tel:+381694301312">+381 69 420 1312</a>
                </li>
                <li class="py-3 d-flex align-items-center">
                    <span class="fas fa-envelope mr-3 text-muted"></span><a class="text-muted td-u" href="mailto:djordje.minic.135.19@ict.edu.rs">kafeterija.centar@gmail.com</a>
                </li>
            </ul>
        </div>
    </div>
    <form name="contact-form" id="contact-form" class="col-10 col-md-5 p-5 pb-0" method="POST" action="models/contact/contactMessage.php">
        <h2 class="col-12 mb-4 text-light border-bottom pb-5">Pošalji nam poruku</h2>
        <div class="container-fluid col-12">
            <div>
                <input type="text" name="name" id="name" class="container border-bottom-green py-2" placeholder="Ime i prezime">
            </div>
            <div>
                <input type="email" name="email" id="email" class="container border-bottom-green py-2 mt-2" placeholder="Email">
            </div>
            <div>
                <textarea name="text" id="text" cols="22" maxlength="200" rows="4" class="container border-bottom-green py-2 mt-2" placeholder="Tekst poruke..."></textarea>
            </div>
            <div class="d-flex align-items-center flex-column py-3">
                <input type="submit" id="contact-button" name="contact-button" class="btn btn-light" value="Pošalji">
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
                if (isset($_GET['message'])){
                echo '<p class="form-message alert alert-success">'.$_GET['message'].'</p>';
            }
            ?>
    </form>
</div>