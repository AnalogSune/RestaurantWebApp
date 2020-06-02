<?php
class TimeSlot{
    public $time;
    public $end_time;
    public $available_tables;
    public $duration;
    public $tables_needed;
    function __construct($t, $et, $a, $d, $n) {
        $this->time = $t;
        $this->end_time = $et;
        $this->available_tables = $a;
        $this->duration = $d;
        $this->tables_needed = $n;
    }
}
?>