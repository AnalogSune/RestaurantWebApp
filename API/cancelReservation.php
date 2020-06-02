<?php

$order_id = $_POST['id'];

if (!empty($order_id)){
    include('connect.php');
    $conn = connectToDb();
    $query = $conn->prepare("DELETE FROM tables_reservations WHERE id=?");
    $query->bind_param("i", $order_id);
    if ($query->execute()){
        http_response_code(200);
        $message = "Reservation has been succesfully deleted";
        echo $message;
    } else {
        http_response_code(400);
        $message = "Error deleting reservation";
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