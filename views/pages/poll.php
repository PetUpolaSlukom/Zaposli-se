<!--<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">-->
<!--<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>-->
<!--<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>-->
<!------ Include the above in your HEAD tag ---------->

<div class="container my-5" id="poll">
<!--    anketa-->
    <div class="row d-flex justify-content-around align-items-center">
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title text-light">
                        <span class="glyphicon glyphicon-arrow-right"></span>
                        Koliko ste zadovoljni uslugama na sajtu?
                        <span class="text-danger">*</span>
                    </h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group" id="radioDiv">
                        <li class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" class="optionsRadios" name="optionsRadios" value="5">
                                    Veoma
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" class="optionsRadios" name="optionsRadios" value="4">
                                    Zadovoljan sam
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" class="optionsRadios" name="optionsRadios" value="3">
                                    Okej je
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" class="optionsRadios" name="optionsRadios" value="2">
                                    Moze bolje
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" class="optionsRadios" name="optionsRadios" value="1">
                                    Nisam zadovoljan
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title text-light">
                        <span class="glyphicon glyphicon-hand-right"></span>
                        Gde se informišete o IT poslovima?
                        <span class="text-danger text-sm">*</span>
                    </h3>
                </div>
                <div class="panel-body">
                    <ul class="list-group" id="checkBoxDiv">
                        <li class="list-group-item">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="pollCheckGroup" value="Internet">
                                    Internet
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="pollCheckGroup" value="Television">
                                    Televizija
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="pollCheckGroup" value="Radio">
                                    Radio
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="pollCheckGroup" value="Newspapers">
                                    Novine
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" class="pollCheckGroup" value="Other">
                                    Ostalo
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!--    dugme -->
    <div class="text-light text-center mt-5" id="buttonDiv">
        <h2>Ako ste sigurni u vase ogovore </h2>
        <button type="button" class="btn btn-light mt-2" id="buttonPoll">
            Predaj odgovor
        </button>
    </div>
</div>
<!--error blok-->
<div class="errorPoll mt-4 text-center">

</div>

