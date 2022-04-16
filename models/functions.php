<?php
function getPageDetails($page_name){
    try {
        global $conn;

        $result = $conn->prepare("SELECT * FROM page WHERE name LIKE ?");
        $result->execute([$page_name]);

        return$result->fetch();
    } catch (PDOException $ex) {
        //createLog(ERROR_LOG_FAJL, $ex->getMessage());
        return false;
    }

}
function queryFunction($queryString, $fetchAll = false){
    try {
        global $conn;

        if ($fetchAll){
            return $conn->query($queryString)->fetchAll();
        }

        return $conn->query($queryString)->fetch();

    } catch (PDOException $ex) {
        //createLog(ERROR_LOG_FAJL, $ex->getMessage());
        return false;
    }
}

function selectQuery($table, $fetchAll = false){
    try {

        global $conn;

        $query = "SELECT * FROM " . $table;
        return $conn->query($query)->fetchAll();

    } catch (PDOException $ex) {
        //createLog(ERROR_LOG_FAJL, $ex->getMessage());
        return false;
    }
}

function getCompany($id){
    global $conn;

    try {
        $result = $conn->prepare("SELECT * FROM company c INNER JOIN company_profile cp ON c.id_company = cp.id_company WHERE c.id_company = ?");
        $result->execute([$id]);
        return $result->fetchAll();

    } catch (PDOException $ex) {
        //createLog(ERROR_LOG_FAJL, $ex->getMessage());
        return false;
    }
}
function getCompanySocNetwork($id){
    global $conn;

    try {
        $result = $conn->prepare("SELECT * FROM socnet_company sc INNER JOIN social_network sn ON sc.id_socNet = sn.id_socNet WHERE sc.id_company = ?");
        $result->execute([$id]);
        return $result->fetchAll();

    } catch (PDOException $ex) {
        //createLog(ERROR_LOG_FAJL, $ex->getMessage());
        return false;
    }
}
function getEmployeesForCompany($id, $adminView = false){
    global $conn;

    //AKO JE ADMIN PRISUTAN NA STRANICI PRIKAZUJU SE SVI ZAPOSLENI
    try {
        $adminViewString = $adminView ? "" : " AND active = 1";

        $result = $conn->prepare("SELECT * FROM employee WHERE id_company = ?" . $adminViewString);
        $result->execute([$id]);
        return $result->fetchAll();

    } catch (PDOException $ex) {
        //createLog(ERROR_LOG_FAJL, $ex->getMessage());
        return false;
    }
}
function getTechnologyForCompany($id){
    global $conn;

    try {
        $result = $conn->prepare("SELECT t.name FROM technology as t INNER JOIN comprofile_technology ct ON t.id_technology = ct.id_technology WHERE ct.id_comProfile = ?");
        $result->execute([$id]);
        return $result->fetchAll();

    } catch (PDOException $ex) {
        //createLog(ERROR_LOG_FAJL, $ex->getMessage());
        return false;
    }
}

function getPhotosForCompany($id){
    global $conn;

    try {
        $result = $conn->prepare("SELECT image FROM company_photo WHERE id_company = ?");
        $result->execute([$id]);
        return $result->fetchAll();

    } catch (PDOException $ex) {
        //createLog(ERROR_LOG_FAJL, $ex->getMessage());
        return false;
    }
}
function getJobsForCompany($id){
    global $conn;

    try {
        $result = $conn->prepare("SELECT * FROM job WHERE id_company = ?");
        $result->execute([$id]);
        return $result->fetchAll();

    } catch (PDOException $ex) {
        //createLog(ERROR_LOG_FAJL, $ex->getMessage());
        return false;
    }
}
function getJob($id){
    global $conn;

    try {
        $result = $conn->prepare("SELECT j.*, c.logo_img as img, c.name as company_name, c.id_company as id_company, s.starting_salary, s.max_salary, sen.name as seniority 
                                        FROM job j 
                                        INNER JOIN company c ON j.id_company = c.id_company 
                                        LEFT JOIN salary s ON s.id_job = j.id_job 
                                        INNER JOIN seniority sen ON sen.id_seniority = j.id_seniority 
                                        WHERE j.active = 1 AND j.id_job = ?");
        $result->execute([$id]);
        return $result->fetchAll();

    } catch (PDOException $ex) {
        //createLog(ERROR_LOG_FAJL, $ex->getMessage());
        return false;
    }
}
function getTechnologiesForJobs($jobsIds){
    global $conn;

    $technologies = [];


        try {
            foreach ($jobsIds as $id_job){
                $result = $conn->prepare("SELECT t.name FROM technology t INNER JOIN job_technology jt ON t.id_technology = jt.id_technology WHERE jt.id_job = ?");
                $result->execute([$id_job]);
                $technologies[] = $result->fetchAll();
            }
            return $technologies;

        } catch (PDOException $ex) {
            //createLog(ERROR_LOG_FAJL, $ex->getMessage());
            return false;
        }
}
function getTechnologiesForJob($id){
    global $conn;

    try {
            $result = $conn->prepare("SELECT t.name FROM technology t INNER JOIN job_technology jt ON t.id_technology = jt.id_technology WHERE jt.id_job = ?");
            $result->execute([$id]);
            $technologies = $result->fetchAll();
        return $technologies;

    } catch (PDOException $ex) {
        //createLog(ERROR_LOG_FAJL, $ex->getMessage());
        return false;
    }
}

//========= USER =========
function getUser($id){
    global $conn;

    try {
        $result = $conn->prepare("SELECT * FROM user WHERE id_user = ?");
        $result->execute([$id]);
        return $result->fetch();

    } catch (PDOException $ex) {
        //createLog(ERROR_LOG_FAJL, $ex->getMessage());
        return false;
    }
}
function getUserFromUserCompany($id){
    global $conn;

    try {
        $result = $conn->prepare("SELECT * FROM user_favourite_company ufc
                                        LEFT JOIN company c on c.id_company = ufc.id_company
                                        WHERE ufc.id_user = ?");
        $result->execute([$id]);
        return $result->fetchAll();

    } catch (PDOException $ex) {
        //createLog(ERROR_LOG_FAJL, $ex->getMessage());
        return false;
    }
}
function getUserFromUserJob($id){
    global $conn;

    try {
        $result = $conn->prepare("SELECT * FROM user_favourite_job ufj
                                        LEFT JOIN job j on j.id_job = ufj.id_job
                                        WHERE ufj.id_user = ?");
        $result->execute([$id]);
        return $result->fetchAll();

    } catch (PDOException $ex) {
        //createLog(ERROR_LOG_FAJL, $ex->getMessage());
        return false;
    }
}
//========= ADMIN =========

function changeActiveStatusForUser($id, $status){
    global $conn;

    try {
        $status = !$status;

        $result = $conn->prepare("UPDATE user SET active = ? WHERE id_user = ?");
        $result = $result->execute([$status, $id]);

        return $result;
    } catch (PDOException $ex) {
        //createLog(ERROR_LOG_FAJL, $ex->getMessage());
        return false;
    }
}
function changeMessageSeenStatus($id, $status){
    global $conn;

    try {
        $status = !$status;

        $result = $conn->prepare("UPDATE message SET seen = ? WHERE id_message = ?");
        $result = $result->execute([$status, $id]);

        return $result;
    } catch (PDOException $ex) {
        //createLog(ERROR_LOG_FAJL, $ex->getMessage());
        return false;
    }
}
