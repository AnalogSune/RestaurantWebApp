<?php
//Get the restaurant schedule from database
include('connect.php');

$conn = connectToDb();
$query = $conn->prepare("SELECT day, open_time, close_time, reservation_duration, available_tables 
FROM days_default_time"); 
$query->execute();
$result = $query->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC);
if (count($data)){
    http_response_code(200);
    echo json_encode($data);
} else {
    http_response_code(400);
    $message = "Error retrieving schedule";
    echo $message;
}
$query->close();
disconnectFromDb($conn);
exit();
?>