<?php

class GenerateCalendar
{
    function __construct($month, $year){
    }

    public function Generate($month, $year){
        $totaldays = cal_days_in_month(CAL_GREGORIAN, $month, $year)
    }
}
