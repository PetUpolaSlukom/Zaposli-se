window.onload = () => {
    let today = new Date();

    if ($('#companies').length) {
        loadCompanies();
        sortCompany();
    }
    if ($('#home-companies').length) {
        loadPremiumCompanies();
    }
    if ($('#jobs').length) {
        loadJobs();
        checkJobsFilter();
    }
    if ($('#poll').length) {
        Poll();
    }
    //ajax
    function ajaxFunction(url, method, fun, data = {}) {
        $.ajax({
            url: url,
            method: method,
            data: data,
            success: fun,
            error: function (xhr) {
                console.log(xhr)
            }
        })
    }
    //======= POLL CODE ==========================================================================================================================//


    //$("#checkBoxDiv").change(loadPoll);
    //$("#radioDiv").change(loadPoll);
    function Poll() {
        document.querySelector("#buttonPoll").onclick = function(e){
            console.log(123)
            let qualityRadios = false
            let interestArray = []
            $("#checkBoxDiv input:checked").get().map(x => interestArray.push(x.value))
            qualityRadios = $("input:radio[name='optionsRadios']:checked").val()

            let ajaxData = {
                "interest": interestArray,
                "quality": qualityRadios
            };

            if (qualityRadios && interestArray.length){
                $(".errorPoll").html('');
                ajaxFunction("models/poll/set_poll.php", "get", function (data) {
                    $("#poll").html('');
                    $(".errorPoll").html('<p class="alert alert-success">Vaš odgovor je zabeležen. Hvala na izdvojenom vremenu! Povratak na početnu stranicu <a href="index.php?page=home" class="td-u"> ovde.</a></p>');
                }, ajaxData)
            }
            else{
                $(".errorPoll").html('<p class="alert alert-danger">Oba polja su obavezna</p>');
                e.preventDefault();
            }
        }
    }


    //======= USER CODE ==========================================================================================================================//

    //LOGIN
    var validationError = false;

    $("#login-form").submit(function (event) {
        resetFormMessages();
        validationError = false;

        if ($("#email").val().length < 3) {
            formErrorMessage("Unesite ispravanu email adresu.", $("#email"));
        }
        if ($("#password").val().length < 8) {
            formErrorMessage("Unesite ispravnu lozinku.", $("#password"));
        }
        if (validationError) {
            event.preventDefault();
        }
    });
    //REGISTER
    $("#register-form").submit(function (event) {
        resetFormMessages();
        validationError = false;


        let firstName = $("#firstName").val();
        let lastName = $("#lastName").val();
        let email = $("#email").val();
        let password = $("#password").val();
        let confPassword = $("#confirm-password").val();

        regexValidate(firstName, regexName, $("#firstName"));
        regexValidate(lastName, regexName, $("#lastName"));
        regexValidate(email, regexEmail, $("#email"));
        regexValidate(password, regexPassword, $("#password"), true);


        if(!confPassword.length){
            formErrorMessage("Polje ne moze biti prazno.", $("#confirm-password"));
        }
        else{
            if (password !== confPassword) {
                formErrorMessage("Neispravno uneta potvrda lozinke.", $("#confirm-password"))
            }
        }

        if (validationError) {
            event.preventDefault();
        }

    });

    ////////////// REGULAR EXPRESSION //////////////////
    let regexName = /^[A-ZŠĐŽĆČ][a-zšđžćč]{2,15}(\s[A-ZŠĐŽĆČ][a-zšđžćč]{2,15})?$/;
    let regexEmail = /^[a-z]((\.|-|_)?[a-z0-9]){2,}@[a-z]((\.|-|_)?[a-z0-9]+){2,}\.[a-z]{2,6}$/i;
    let regexPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;
    let regexFullName = /^[A-ZŠĐŽĆČ][a-zšđžćč]{2,15}(\s[A-ZŠĐŽĆČ][a-zšđžćč]{2,15}){0,2}$/;
    let regexAddress = /^[\w\.]+(,?\s[\w\.]+){2,8}$/;

    //////////////// LOGIN & REGISTER FUNCTIONS ////////////////
    // validation functions
    function regexValidate(string, regex, htmlElement, pass = false) {
        if (string == "") {
            return formErrorMessage("Polje ne moze biti prazno.", htmlElement);
        }
        else if (!regex.test(string)) {
            if(pass){
                return formErrorMessage("Lozinka mora da sadrzi minimum 8 karaktera, bar jedno malo slovo, veliko slovo i cifru.", htmlElement);
            }
            return formErrorMessage("Neispravno unet podatak.", htmlElement);
        }
    }
    function textboxValidate(string, htmlElement) {
        if (string == "") {
            return formErrorMessage("Polje Teksta poruke je obavezno.", htmlElement);
        }
        if (string.length < 15) {
            return formErrorMessage("Tekst je prekratak za poruku.", htmlElement);
        }
    }

    function resetFormMessages() {
        validationError = false;
        $(".form-error").remove();
        $(".form-success").remove();
    }

    function formErrorMessage(message, element) {
        validationError = true;
        $(`<p class="form-error small text-danger">${message}</p>`).insertAfter($(element));
    }


    //======CONTACT MESSAGE VALIDATION =========================================================================================================================//
    $("#contact-form").submit(function (event) {
        resetFormMessages();
        validationError = false;


        let fullName = $("#name").val();
        let email = $("#email").val();
        let text = $("#text").val();

        regexValidate(fullName, regexFullName, $("#name"));
        regexValidate(email, regexEmail, $("#email"));
        textboxValidate(text, $("#text"));

        if (validationError) {
            console.log('greska ima');
            event.preventDefault();
        }
        //event.preventDefault();
    });

    //======= JOBS CODE ==========================================================================================================================//
    function loadJobs(ajaxData = {}) {
        ajaxFunction("models/jobs/get_jobs.php", "get", function (data) {
            console.log(data)
            printJobs(data)
        }, ajaxData)
    }

    function printJobs(data) {
        let admin = data.admin
        let jobs = data.jobs
        const activeJobs = jobs.filter(job => job.active == 1);
        let technologies = data.technologies
        let html = '';

        if (!jobs.length) {
            html = getFilterError()
        }
        else if (!activeJobs.length && !admin){
            html = getFilterError()
        }
        else {
            let i = 0;
            if (admin) html += `<h3 class="text-light col-12 text-center mb-3">Pronađenih poslova -> ${jobs.length}</h3>`
            else html += `<h3 class="text-light col-12 text-center mb-3">Pronađenih poslova -> ${activeJobs.length}</h3>`


            for (const job of jobs) {
                if(job.active == "0" && !admin){
                    continue;
                }
                html += `<div class="card col-10 mb-5 shadow">
                    <div class="d-flex justify-content-between p-0 flex-wrap">`
                if (job.premium != 0) {
                    html += `
                            <div>
                                <h6 class="bg-primary py-2 px-2 h-100 text-white d-inline">Premium</h6>
                            </div>`
                }
                if (isJobNew(job.date_public)) {
                    html += `<div>
                                <h6 class="bg-danger py-2 px-2 h-100 text-white d-inline">Novo</h6>
                            </div>`
                }
                html += `</div>
                <div class="card-body d-flex justify-content-center py-5 flex-wrap">
                    <div class="col-12 col-sm-5 d-flex flex-wrap align-items-center">
                        <a href="index.php?page=company&id=${job.id_company}" class="ml-auto mr-auto transpBgHover">
                            <img src="assets/img/${job.img}" alt="${job.company_name}" class="">
                        </a>
                        <div class=" pt-1 pb-4 px-2 shadow col-12 bg-dark fora  bg-dark-gradient">
                            <h5 class="text-center">
                                <a href="#" class="card-title job-comapny-name text-white transpBgHover">${job.company_name}</a>
                            </h5>
                        </div>
                    </div>
                    <div class="col-12 col-sm-7">
                    
                        <h4 class="card-title text-left col-12 mt-3 mb-4 ml-0 pl-0">${job.position}</h4>
                        <p class="card-text text-dark border-bottom pb-2">${job.short_description}</p></hr>
                        <p class="text-muted"><i class="far fa-clock"></i> ${job.date_deadline.replace(/-/g, '.')}.</p>`

                html += getJobDetails(job)
                for (const tech of technologies[i]) {
                    html += `<h2 class="btn bg-outline-dark border cursorDefault mr-1">${tech.name}</h2>`
                }
                html += `<div class="d-flex mt-2">`

                console.log(job.active == "1")
                    if (admin){
                        if(job.active == "1"){
                            html += `<a href="models/admin/changeJobStatus.php?id=${job.id_job}&status=${job.active}" class="btn btn-danger mr-2">Deaktiviraj</a>`
                        }
                        else{
                            html += `<a href="models/admin/changeJobStatus.php?id=${job.id_job}&status=${job.active}" class="btn btn-success mr-2">Aktiviraj</a>`
                        }
                    }
                    else{
                        html += `<a href="models/user/addToFavouriteJob.php?id=${job.id_job}" class="text-dark btn bg-white border-3 mr-2 transpBgHover d-flex align-items-center">
                                    <h5 class="mb-0"><i class="far fa-heart"></i></h5>
                                </a>
                                <a href="index.php?page=job_application&id=${job.id_job}" class="btn btn-dark mr-2">Apliciraj</a>`
                    }
                    html += `
                        </div>
                    </div>
                </div>
            </div>`

            i++;
            }
        }
        document.querySelector("#jobs").innerHTML = html
    }

    function checkJobsFilter() {
        document.querySelector("#formFilterJobs").onsubmit = function (e) {
            e.preventDefault();
            console.log(1)
            let salaryCheck = "no"
            let internshipCheck = "no"
            let premiumCheck = "no"
            if (document.querySelector('#chSalary').checked) {
                salaryCheck = "yes"
            }
            if (document.querySelector('#chInternship').checked) {
                internshipCheck = "yes"
            }
            if (document.querySelector('#chPremium').checked) {
                premiumCheck = "yes"
            }

            let dataForAjax = {
                "keyword": document.querySelector("#tbKeyword").value,
                "tech": document.querySelector("#tbTech").value,
                "seniority": document.querySelector("#DDSeniority").value,
                //"publicDate": document.querySelector("#DDPublicDate").value,
                "remote": document.querySelector("#DDRemote").value,
                "salary": salaryCheck,
                "internship": internshipCheck,
                "premium" : premiumCheck
            }
            //console.log(dataForAjax)
            loadJobs(dataForAjax);

        }
    }

    $("#application-form").submit(function (event) {
        console.log(123)
        resetFormMessages();
        validationError = false;


        let fullName = $("#name").val();
        let email = $("#email").val();
        let text = $("#text").val();

        regexValidate(fullName, regexFullName, $("#name"));
        regexValidate(email, regexEmail, $("#email"));
        textboxValidate(text, $("#text"));

        if (validationError) {
            console.log('greska ima');
            event.preventDefault();
        }
        //event.preventDefault();
    });

    // JOB FUNCTIONS
    function getJobDetails(job){
        let html = '';
        if (job.remote != 0){
            html +=`<p class="text-muted"><i class="fas fa-map-marker-alt text-muted"></i> Remote</p>`
        }
        if (job.starting_salary != null){
            html +=`<p class="text-muted"><i class="fa fa-coins text-muted"></i> ${job.starting_salary}${job.max_salary != null ? " - "+job.max_salary : ""}</p>`
        }
        if (job.internship != 0){
            html +=`<p class="text-muted"><i class="fas fa-briefcase text-muted"></i> Praksa</p>`
        }
        if (job.for_students != 0){
            html +=`<p class="text-muted"><i class="fas fa-graduation-cap text-muted"></i> Oglas dostupan studentima</p>`
        }
        if (job.disabled_person != 0){
            html +=`<p class="text-muted"><i class="fas fa-wheelchair text-muted"></i> Oglas dostupan osobama sa invaliditetom</p>`
        }
        return html;
    }

    function isJobNew(jobDatePublic) {
        let jobDate = new Date(jobDatePublic);
        let newJob = false;

        if (jobDate.getFullYear() === today.getFullYear())
            if (jobDate.getMonth() === today.getMonth()) {
                newJob = true
            }
        if (jobDate.getMonth() === today.getMonth() - 1){
            if ((30 - jobDate.getDate()) + today.getDate() < 31)
                newJob = true
        }
        if (jobDate.getFullYear() === today.getFullYear() - 1){
            if (jobDate.getMonth() === 11 && today.getMonth() === 0){
                if ((30 - jobDate.getDate() + today.getDate()) < 31)
                    newJob = true
            }
        }
        return newJob;
    }


    //===== COMPANIES CODE ===================================================================================================================//
    function loadCompanies(data = {}) {
        ajaxFunction("models/companies/get_companies.php", "get", function (data) {
            //console.log(data.companies)
            printCompanies(data)
        }, data)
    }

    function sortCompany(){
        //search
        $("#search").on('change input', checkCompaniesFilter);

        //sort companies by
        document.getElementById('sortByJob').onclick = function (){
            document.getElementById('sortByJob').classList.add("btn-light")
            document.getElementById('sortByJob').classList.remove("btn-dark")
            document.getElementById('sortByJob').setAttribute("value", "active")

            document.getElementById('sortByRank').classList.add("btn-dark")
            document.getElementById('sortByRank').classList.remove("btn-light")
            document.getElementById('sortByRank').setAttribute("value", "inactive")

            checkCompaniesFilter()
        }
        document.getElementById('sortByRank').onclick = function (){
            document.getElementById('sortByRank').classList.add("btn-light")
            document.getElementById('sortByRank').classList.remove("btn-dark")
            document.getElementById('sortByRank').setAttribute("value", "active")

            document.getElementById('sortByJob').classList.add("btn-dark")
            document.getElementById('sortByJob').classList.remove("btn-light")
            document.getElementById('sortByJob').setAttribute("value", "inactive")

            checkCompaniesFilter()
        }

        //order companies by
        document.getElementById('orderByAsc').onclick = function (){
            document.getElementById('orderByAsc').classList.remove("btn-dark")
            document.getElementById('orderByAsc').classList.add("btn-light")
            document.getElementById('orderByAsc').setAttribute("value", "active")

            document.getElementById('orderByDesc').classList.remove("btn-light")
            document.getElementById('orderByDesc').classList.add("btn-dark")
            document.getElementById('orderByDesc').setAttribute("value", "inactive")

            checkCompaniesFilter()
        }
        document.getElementById('orderByDesc').onclick = function (){
            document.getElementById('orderByDesc').classList.remove("btn-dark")
            document.getElementById('orderByDesc').classList.add("btn-light")
            document.getElementById('orderByDesc').setAttribute("value", "active")

            document.getElementById('orderByAsc').classList.remove("btn-light")
            document.getElementById('orderByAsc').classList.add("btn-dark")
            document.getElementById('orderByAsc').setAttribute("value", "inactive")

            checkCompaniesFilter()
        }
    }

    function checkCompaniesFilter(){
        let search = document.getElementById('search').value
        let sortType;
        document.getElementById('sortByJob').getAttribute("value") == "active" ? sortType = "job" : sortType = "ranking";
        let orderDirection
        document.getElementById('orderByDesc').getAttribute("value") == "active" ? orderDirection = "desc" : orderDirection = "asc";
        filterChange(sortType, orderDirection, search)
    }

    function filterChange(sortBy, orderBy, search) {

        let dataForAjax = {
            "search": search,
            "sortBy" : sortBy,
            "orderDirection" : orderBy
        };


        loadCompanies(dataForAjax);
    }

    function printCompanies(data) {
        //console.log(data.length)
        let admin = data.admin
        data = data.companies
        let html = '';
        if(data.length == 0){
            html = getFilterError()
        }
        else{
            for (let company of data) {
                if(!company.active_status) continue;
                html += `
                    <div class="card col-9 col-md-5 col-lg-3 mx-4 my-5 shadow">
                        <div class="cardCompLogo position-absolute">
                            <a href="index.php?page=company&id=${company.id_company}"><img src="assets/img/${company.logo_img}" class="card-img-top p-2 transpBgHover" alt="${company.name}"></a>
                        </div>`

                if(company.premium){
                    html+= "<div class=\"premiumTagHome position-absolute\">" +
                                "<h4 class=\"btn bg-white text-dark cursorDefault\">Premium</h4>" +
                            "</div>"
                }

                html += `
                    <img src="assets/img/${company.cover_photo}" class="card-img-top img-fluid" alt="${company.name}">
                    <div class="card-body">
                        <h5 class="card-title">${company.name}</h5>
                        <p class="card-text text-muted">${company.location}</p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">`

                console.log(admin)
                    if (admin){
                        html += `<a href="index.php?page=company&id=${company.id_company}" class="btn btn-danger">Upravljaj</a>`
                    }
                    else{
                        html += `
                            <div class="bg-dark-gradient d-flex justify-content-center align-items-center transpBgHover pointer rounded">
                            <a href="index.php?page=company&id=${company.id_company}" class="text-white px-3 py-1">Detaljnije</a>
                        </div>`
                    }

                   html +=`</div>
                </div>`
            }
        }
        document.getElementById("companies").innerHTML = html
    }

    //======HOME=========================================================================================================================//
    function loadPremiumCompanies(){
        ajaxFunction("models/companies/get_premium_companies.php", "get", function (data) {
            //console.log(data.premium_companies)
            printPremiumCompanies(data.premium_companies)
        })
    }

    function printPremiumCompanies(data) {

        let html = ''
        let iterator = 0
        for (let company of data) {
            if (iterator>5)break
            iterator++
            if(!company.active_status) continue;
            html += `
            <div class="card col-9 col-md-5 col-lg-3 mx-4 my-5 pr-0 shadow">
                <div class="cardCompLogo position-absolute">
                    <a href="index.php?page=company&id=${company.id_company}"><img src="assets/img/${company.logo_img}" class="card-img-top p-2 transpBgHover" alt="${company.name}"></a>
                </div>
                <div class="premiumTagHome position-absolute">
                    <h4 class="btn bg-white text-dark cursorDefault">Premium</h4>    
                </div>
                <div class="starTagHome position-absolute">
                    <h4 class="btn bg-white text-dark cursorDefault">4.6 <i class="fa fa-star"></i></h4>    
                </div>
                <img src="assets/img/${company.cover_photo}" class="card-img-top img-fluid" alt="${company.name}">
                <div class="card-body">
                <a href="index.php?page=company&id=${company.id_company}" class="text-dark transpBgHover"><h5 class="card-title">${company.name}</h5></a>
                    <p class="card-text text-muted">${company.location}</p>
                </div>
                
            </div>`
        }
        $('#home-companies').html(html)
    }

    //======FUNCTIONS=========================================================================================================================//

    function getFilterError(){
        let errorElement = `
                <div class="row">
                    <h2 class="text-light text-center col-12 pt-5">Uuups!</h2>
                    <h2 class="text-light text-center col-12">Nema rezultata za zadate kriterijume..</h2>
                    <div class="d-flex justify-content-around col-12 pt-5">
                        <img src="assets/img/cantFindCompany.png" alt="Nema proizvoda" class="col-4">
                    </div>
                </div>
            `
        return errorElement
    }










}