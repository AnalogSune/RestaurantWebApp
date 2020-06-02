<?php
$username = $_POST['username'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$password = md5($_POST['password']);
$cust_type = $_POST['cust_type'];

if (!empty($username) && !empty($password) && !empty($email) && !empty($phone_number) &&
!empty($fname) && !empty($lname)){
    include('connect.php');

    $conn = connectToDb();
    $query = $conn->prepare("SELECT username, email FROM users_table WHERE username=? OR email=? LIMIT 1");
    $query->bind_param("ss", $username, $email);
    $query->execute();
    $query->store_result();
    if ($query->num_rows() > 0){
        $query->close();
        http_response_code(400);
        $message = "Email or Username already exists";
        echo $message;
    } else {
        try {
            $query = $conn->prepare("INSERT INTO users_table (username, email, phone_number, fname, lname, password, cust_type)
            VALUES (?,?,?,?,?,?,?)");
            $query->bind_param("ssssssi", $username, $email, $phone_number, $fname, $lname, $password, $cust_type);
            if ($query->execute()){
                http_response_code(200);
                $message = "New customer has been added";
                echo $message;
            } else {
                http_response_code(400);
                $message = "Error executing query";
                echo $message;
            }
        }catch(Exception $e) {
            http_response_code(400);
            $message = "Error connecting to database";
            echo $message . $cust_type;
        }
        $query->close();
    }
    disconnectFromDb($conn);
    exit();
}
else{
    http_response_code(404);
    $message = "Uknown Error";
    echo $message;
    exit();
}
?>