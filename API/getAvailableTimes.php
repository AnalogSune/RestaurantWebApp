<?php
include('connect.php');
include('models/DefaultSchedule.php');
include('models/TimeSlot.php');
include('calculateTables.php');

$date = $_GET['date'];
$num_of_people = $_GET['num_of_people'];

if (!empty($date) && !empty($num_of_people) && is_numeric($num_of_people)){
    $day = date('l', strtotime($date));
    $schedule = getDefaultTimes($day);
    $tables_needed = calculateTables($num_of_people);
    $timeSlots = getDefaultTimeSlots($schedule, $tables_needed);
    $finalTimeSlots = getFinalTimeSlots($timeSlots, $date);
    echo json_encode($finalTimeSlots);
    http_response_code(200);
    exit();
}
else{
    $message = "You need to provide a Date and a number of people";
    echo $message;
    http_response_code(400);
    exit();
}

function getDefaultTimes($day) : DefaultSchedule {
    try{
        $schedule = new DefaultSchedule();
        $conn = connectToDb();
        $query = $conn->prepare("SELECT open_time, close_time, 
        reservation_duration, available_tables
        FROM days_default_time
        WHERE day=? LIMIT 1");
        $query->bind_param("s", $day);
        $query->execute();
        $query->bind_result($schedule->opentime, $schedule->closetime,
        $schedule->reservationDuration, $schedule->availableTables);
        $query->store_result();
        if ($query->num_rows() == 1){
            if ($query->fetch()){
                return $schedule;
            }
        }
        $query->close();
        disconnectFromDb($conn);
    } catch (Exception $e){
        http_response_code(400);
        $message = "Couldn't connect to database";
        echo $message;
        exit();
    }
}

function timeToIndex($time){
    $t = $time;
    if ($t >= 0 && $t < 7){
        $t += 24;
    }
    return $t;
}

function getDefaultTimeSlots(DefaultSchedule $schedule, $tables_needed) : array {
    $final_reservations = array();
    $current_time = $schedule->GetOpenTime();
    if ($schedule->reservationDuration > 0){
        while(timeToIndex($current_time) < timeToIndex($schedule->GetCloseTime())){
            $end_time = $current_time + $schedule->reservationDuration;
            if (timeToIndex($end_time) > timeToIndex($schedule->GetCloseTime())){
                $end_time = $schedule->GetCloseTime();
            }
            array_push($final_reservations, new TimeSlot($current_time, $end_time, 
                $schedule->availableTables, $schedule->reservationDuration, $tables_needed));
            $current_time += $schedule->reservationDuration;
            if ($current_time >= 24) $current_time = $current_time % 24;
        }
    }
    return $final_reservations;
}

function getFinalTimeSlots(array $defaultTimeSlots, $date) : array{
    $finalTimeSlots = $defaultTimeSlots;
    $conn = connectToDb();
    $query = $conn->prepare("SELECT tables_needed, time
    FROM tables_reservations 
    WHERE date=? AND status=?");
    $status = 2;
    $query->bind_param("si", $date, $status);
    $query->execute();
    $result = $query->get_result();
    while ($row = $result->fetch_assoc()){
        for ($i = 0; $i < count($finalTimeSlots); $i++){
            if ($finalTimeSlots[$i]->time == $row['time']){
                $finalTimeSlots[$i]->available_tables -= $row['tables_needed'];
            }
        }
    }     
    return $finalTimeSlots;
}
?>