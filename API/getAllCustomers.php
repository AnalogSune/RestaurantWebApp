<?php
include('connect.php');
$cust_type = 0;

$conn = connectToDb();
$query = $conn->prepare("SELECT id, username, email, fname, lname, phone_number 
FROM users_table WHERE cust_type=?");
$query->bind_param("i", $cust_type);
$query->execute();
$result = $query->get_result();
$data = $result->fetch_all(MYSQLI_ASSOC);
if (count($data)){
    http_response_code(200);
    echo json_encode($data);
} else {
    http_response_code(400);
    $message = "Error connecting to database";
    echo $message;
}
$query->close();
disconnectFromDb($conn);
exit();
?>