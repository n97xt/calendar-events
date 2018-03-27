<?php

// Define DB Params
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "ads");

// Define URL
define("ROOT_PATH", "/");
define("ROOT_URL", "http://localhost/");

foreach (glob("app/*.php") as $filename) {
    include $filename;
}

foreach (glob("controllers/*.php") as $filename) {
    include $filename;
}

foreach (glob("models/*.php") as $filename) {
    include $filename;
}
?>