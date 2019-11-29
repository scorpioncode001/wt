<?php
function redirect($loc=NULL){
    if($loc != NULL){
        header("Location: {$loc}");
        exit;
    }
}

function full_name($fname="", $lname=""){
    return $fname." ".$lname;
}

function string_to_time($date){
    $date = date('jS F, Y', strtotime($date));
    $time = date('h:i:s a', strtotime($date));
    return $date_array = array($date, $time);
}

function generate_ref_id(){
    $explode = uniqid('', true);
    $exp = explode('.', $explode);
    $registration_id = end($exp);
    return $registration_id;
}

function check_date_time_validity($date){
    $explode1 = explode(" ", $date); $explode2 = explode("-", $explode1[0]); $message_year = $explode2[0];
    $message_month = $explode2[1]; $message_day = $explode2[2];
    $explode3 = explode(":", $explode1[1]); $message_hour = $explode3[0]; $message_min = $explode3[1]; $message_sec = $explode3[2];
    $current_year = date('Y'); $current_month = date('m'); $current_day = date('d'); $current_hour = date('H'); $current_min = date('i'); $current_sec = date('s');
    if($message_year == $current_year && $message_month == $current_month){
    $days = $current_day - $message_day;
        if($current_day == $message_day){
            $check_hrs = $current_hour - $message_hour;
            $check_min = $current_min - $message_min;
            if($current_hour == $message_hour){
                $period = $check_min." minutes";
            }else{
                $period = $check_hrs." hours";
            }
        }else if($days == 1){
            $period = "yesterday";
        }else if($days > 1){
            $period = $days." days"; 
        }
    }else if($message_year == $current_year && $current_month > $message_month){
        $chech_months = $current_month - $message_month;
        if($chech_months == 1){
            $period = $chech_months." month";
        }else{
        $period = $chech_months." months";
        }
    }else{
        $check_year = $current_year - $message_year;
        if($check_year == 1){
        $period = $check_year." year"; 
        }else{
        $period = $check_year." years";
        }
    }
    return $period;
}

function __autoload($class_name){
    $class_name = strtolower($class_name);
    $path = "../init/{$class_name}.php";
    if(file_exists($path)){
        require_once($path);
    }else{
        die("The file {$class_name}.php could not be found.");
    }
}

?>