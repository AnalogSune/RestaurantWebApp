<?php

session_start();

function connectToDb() {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $db_servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "restor";

    $conn = mysqli_connect($db_servername, $db_username, $db_password, $db_name);

    if (!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

function disconnectFromDb($db) {
    $db->close();
}

?>