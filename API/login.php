<?php
$username = $_POST['username'];
$password = md5($_POST['password']);
$id = 00;
$cust_type;

if (!empty($username) && !empty($password)){
    include('connect.php');
    try {
        $conn = connectToDb();
        $query = $conn->prepare("SELECT username, id, cust_type FROM users_table WHERE (username=? 
        OR email=?) AND password=?");
        $query->bind_param("sss", $username, $username, $password);
        $query->execute();
        $query->bind_result($username, $id, $cust_type);
        $query->store_result();
        if ($query->num_rows() == 1){
            if ($query->fetch()){
                http_response_code(200); 
                $data = array(
                    "username" => $username,
                    "customer_id" => $id,
                    "customer_type" => $cust_type
                );
                echo json_encode($data);
            }
        }else{
            http_response_code(400);
            $message = "Error executing query";
            echo $message;
        }
    }catch(Exception $e) {
        http_response_code(400);
        $message = "Error connecting to db";
        echo $message;
    }
    $query->close();
    disconnectFromDb($conn);
    exit();
}else{
    http_response_code(404);
    $message = "Unknown error";
    echo $message;
    exit();
}
?>