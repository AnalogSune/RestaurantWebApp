<?php

include('connect.php');
include('calculateTables.php');

$id = $_POST['id'];
$time = date('H:i:s', strtotime($_POST['time'].":00:00"));
$num_of_people = $_POST['num_of_people'];
$date = $_POST['date'];
$tables_needed = calculateTables($num_of_people);

if (!empty($id) && !empty($time) && !empty($num_of_people) && !empty($date)){
    $conn = connectToDb();
    $query = $conn->prepare("UPDATE tables_reservations 
    SET tables_needed=?, time=?, date=?, num_of_people=?
    WHERE id=?");
    $query->bind_param("issii", $tables_needed, $time, $date, $num_of_people, $id);
    if ($query->execute()){
        http_response_code(200);
        $message = "Reservation altered";
        echo $message;
    } else {
        http_response_code(400);
        $message = "Error connecting to database";
        echo $message;
    }
    $query->close();
    disconnectFromDb($conn);
    exit();
} else {
    http_response_code(400);
    $message = "Error";
    echo $message;
    exit();
}

?>