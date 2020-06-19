<?php
//Computes the tables needed based on the number of people that client requested
function calculateTables($num_of_people){
    if ($num_of_people <= 2) return 1;
    return ceil(($num_of_people - 2.0) / 2.0);
}
?>