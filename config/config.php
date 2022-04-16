<?php
define("ABSOLUTE_PATH", $_SERVER["DOCUMENT_ROOT"] . "/sajt_php1");

define("ENV_FAJL", ABSOLUTE_PATH . "/config/.env");

// Podesavanja za bazu
define("SERVER", env("SERVER"));
define("DATABASE", env("DBNAME"));
define("USERNAME", env("USERNAME"));
define("PASSWORD", env("PASSWORD"));


function env($naziv)
{
    $open = fopen(ENV_FAJL, "r");
    $podaci = file(ENV_FAJL);
    $vrednost = "";
    foreach ($podaci as $key => $value) {
        $konfig = explode("=", $value);
        if ($konfig[0] == $naziv) {
            $vrednost = trim($konfig[1]);
        }
    }
    return $vrednost;
}
