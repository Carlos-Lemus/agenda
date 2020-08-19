<?php 

    define("DB_HOST", "localhost");
    define("DB_USERNAME", "root");
    define("DB_PASSWORD", "");
    define("DB_NOMBRE", "agenda");

    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NOMBRE);

    // echo $conn->ping();

?>