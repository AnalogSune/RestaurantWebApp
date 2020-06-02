<?php
$changes;
$times;
if (isset($_POST['changes']))
$changes = json_decode($_POST['changes'], true);
if (isset($_POST['times']))
$times = $_POST['times'];
include('connect.php');

if (isset($changes) || isset($times)){
    $conn;
    $query;
    $finalmessage = "";
    try{
        $conn = connectToDb();

        if (isset($changes['tables'])){
            $table_changes = $changes['tables'];
            $query = $conn->prepare("UPDATE days_default_time SET available_tables=?");
            $query->bind_param("i", $table_changes);
            if ($query->execute()){
                $finalmessage .= "Available tables changed <br>";
            } else {
                $finalmessage .= "Available tables failed to change <br>";
            }
            $query->close();
        }

        if (isset($changes['duration'])){
            $duration_changes = $changes['duration'];
            $query = $conn->prepare("UPDATE days_default_time SET reservation_duration=?");
            $query->bind_param("i", $duration_changes);
            if ($query->execute()){
                $finalmessage .= "Reservation duration changed <br>";
            } else {
                $finalmessage .= "Reservation duration failed to change <br>";
            }
            $query->close();
        }

        if (isset($times)){
            $success = false;
            for ($i = 0; $i < sizeof($times); $i++){
                $is_open_time = $times[$i]['open'];
                $time = date('H:i:s', strtotime($times[$i]['value'] . ":00:00"));
                $day = $times[$i]['id'];
                $query = $conn->prepare("UPDATE days_default_time SET " . ($is_open_time == "true" ? "open_time=?" : "close_time=?") . "
                WHERE id=?");
                $query->bind_param("si", $time, $day);
                $success = $query->execute();
                $query->close();
            }
            if ($success)
                $finalmessage .= "Times changed <br>";
            else
                $finalmessage .= "Times failed to change <br>";
        }
        http_response_code(200);
        echo $finalmessage;
    } catch(Exception $e){
        http_response_code(400);
        $message = "Error connecting to DB!";
        echo $message;
    }
    disconnectFromDb($conn);
    exit();
}else{
    http_response_code(400);
    $message = "No changes found";
    echo $message;
    exit();
}

?>