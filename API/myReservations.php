<?php
include("connect.php");

$id = $_POST["id"];
$num_of_people;
$time;
$status;
$date;
$order_id;
if (!empty($id)){
    $conn = connectToDb();
    $query = $conn->prepare("SELECT id, time, date, status, num_of_people
    FROM tables_reservations WHERE customer_id=? ORDER BY date");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    if (count($data)){
        http_response_code(200);
        echo json_encode($data);
    } else {
        http_response_code(400);
        $message = "No reservations made";
        echo $message;
    }
    $query->close();
    disconnectFromDb($conn);
    exit();
} else {
    http_response_code(400);
    $message = "Error, please try again";
    echo $message;
    exit();
}
?>