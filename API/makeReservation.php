<?php
include('connect.php');
include('calculateTables.php');

$date = $_POST['date'];
$num_of_people = $_POST['num_of_people'];
$time = date('H:i:s', strtotime($_POST['time'].":00:00"));
$id = $_POST['id'];
$status = 2;
$tables_needed = calculateTables($num_of_people);

if (!empty($date) && !empty($num_of_people) && !empty($time)){
    $conn;
    $query;
    try {
    $conn = connectToDb();
    $query = $conn -> prepare("INSERT INTO tables_reservations (tables_needed, customer_id,
    time, date, num_of_people, status) VALUES (?,?,?,?,?,?)");
    $query->bind_param("iissii", $tables_needed, $id, $time, $date,
    $num_of_people, $status);
    $ifsuccess = $query->execute();
    $query->store_result();
    if ($ifsuccess){
        http_response_code(200);
        $message = "A new reservation has been made";
        echo $message;
        exit();
    } else {
        http_response_code(200);
        $message = "Request denied";
        echo $message;
        exit();
    }
    $query->close();
    disconnectFromDb($conn);
    }catch (Exception $e){
        if ($conn)
            disconnectFromDb($conn);
        if ($query)
            $query->close();
            http_response_code(400);
        echo $e;
        exit();
    }
} else {
    http_response_code(400);
    $message = "You need to select date and a number of people";
    echo $message;
    exit();
}
?>