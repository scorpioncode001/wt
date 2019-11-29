<?php
$user_id = $session->user_id;
$result = User::get_user_details($user_id);
if ($db_init->num_rows($result)==1) {
    while ($row=$db_init->fetch_array($result)) {
        $ref_id = $row['ref_id'];
        $fname = $row['fname'];
        $lname = $row['lname'];
        $email = $row['email'];
        $phone = $row['phone'];
        $country = $row['country'];
        $continent = $row['continent'];
        $fplan = $row['fplan'];
        $pass = $row['pass'];
        $image = $row['image'];
        $picture = "../images/".$row['image'];
        $status = $row['status'];
        $created = $row['created'];
        $updated = $row['updated'];
        $last_logged = $row['last_logged'];
        $full_name = $fname." ".$lname;
        $referal_id = $row['referal_id'];

        $date_array=string_to_time($last_logged);
        $ll_date_string = $date_array[0]." | ".$date_array[1];
        $date_array=string_to_time($created);
        $created_date_string = $date_array[0];

    }
}
$check_msgs_q = User::find_sql("SELECT * FROM contact_response WHERE user_id='{$session->user_id}' AND status=0");
$total_msg_counter=0;
if ($db_init->num_rows($check_msgs_q)>0) {
    $total_msg_counter=$db_init->num_rows($check_msgs_q); //HOLDS TOTAL NUMBER OF UNREAD MESSAGES
}
$check_msgs_q = User::find_sql("SELECT * FROM contact_response WHERE user_id='{$session->user_id}' AND status=0 ORDER BY id DESC LIMIT 3 ");
if ($db_init->num_rows($check_msgs_q)>0) {
    while ($row=$db_init->fetch_array($check_msgs_q)) {
        $admin_ids[]=$row['admin_id'];  //HOLDS ARRAY OF ADMIN IDS
        $msgs_ids[]=$row['id'];         //HOLDS ARRAY OF MESSAGES IDS
            $trunc_msg = wordwrap($row['message'], 20, "[{@}]");
            $exp = explode("[{@}]",$trunc_msg);
        $user_unred_msgs_array[]=$exp[0]."..."; //HOLDS ARRAY OF MESSAGES
        $user_unred_created_array[]=$row['created']; //HOLDS ARRAY OF MESSAGES DATES
        $message_validity_array[] = check_date_time_validity($row['created']);  //HOLDS ARRAY OF DATES VALIDITY
    }
}else{
    $admin_ids=array();
}
for($x=0;$x<count($admin_ids);$x++){
    $admin_id = $admin_ids[$x];
    $get_admin_picture_q=User::find_sql("SELECT image FROM admins WHERE id='{$admin_id}'");
    while($row=$db_init->fetch_array($get_admin_picture_q)){
        $admin_profile_pictures[] = "../images/".$row['image'];  //HOLDS ARRAY OF ADMINS PROFILE PICTURES
    }
}


$total_inv_q = User::find_sql("SELECT * FROM invested WHERE user_id='{$session->user_id}'");
$user_total_investments=0;
if ($db_init->num_rows($total_inv_q)>0) {
    $user_total_investments=$db_init->num_rows($total_inv_q); //HOLDS TOTAL NUMBER OF INVESTMENTS
}

$bonus_q = User::find_sql("SELECT * FROM bonus WHERE user_id='{$session->user_id}' AND kill_status=0");
If($db_init->num_rows($bonus_q)>0){
    while($row=$db_init->fetch_array($bonus_q)){
        $bonus_id = $row['id'];
        $reg_date = $row['date'];
        $active_status = $row['activate'];
        $default_bonus = $row['default_bonus'];
        if(empty($row['cashed_out'])){
            $cashed_out=0;
        }else{
            $cashed_out = $row['cashed_out'];
        }
        if($active_status==0){
            $registered = $reg_date;                    //fetch stored datetime from database;
            $today = time();                            //CURRENT datetime
            $interval = $today-strtotime($registered);  //gets the difference datetime format
            $days = floor($interval/86400);             //CONVERTS THE DIFFERENCE TO DAYS
            if($days>7){                                //CHECKING IF DAYS IS GREATHER THAN 7 DAYS
                //activate bonus
                $query = User::find_sql("UPDATE bonus SET activate=1, bonus='{$default_bonus}' WHERE id='{$bonus_id}'");
            }
        }else{
            //when its already active, it check maturity so as to multiply
            $registered = $reg_date;                    
            $today = time();                             
            $interval = $today-strtotime($registered);
            $days = floor($interval/86400);
            $weeks = floor($days/7);
            $new_bonus = ($weeks * $default_bonus)-$cashed_out;
            $bonus_new = $weeks * $default_bonus;
            $update_new_bonus = User::find_sql("UPDATE bonus SET main_bonus='{$new_bonus}', bonus='{$bonus_new}' WHERE id='{$bonus_id}'");
        }
    }
}

$check_balance_q = User::find_sql("SELECT * FROM ecnalab WHERE user_id='{$session->user_id}' LIMIT 1");
$user_balance='0';
if ($db_init->num_rows($check_balance_q)>0) {
    while ($row=$db_init->fetch_array($check_balance_q)) {
        $user_balance=$row['ecnalab'];  //HOLDS USER BALANCE
    }
}
$check_bonus_q=User::find_sql("SELECT *, SUM(main_bonus) AS sum FROM bonus WHERE user_id='{$session->user_id}' AND kill_status=0");
$total_bonus_sum=0;
if ($db_init->num_rows($check_bonus_q)>0) {
    while ($row=$db_init->fetch_array($check_bonus_q)) {
        $total_bonus_sum=$row['sum'];   //HOLDS USER BONUS BALANCE
        if(empty($total_bonus_sum)){
            $total_bonus_sum = 0;
        }
    }
}
$user_balance += $total_bonus_sum;      //HOLDS SUM OF BALANCE AND BONUS

?>

<?php
$check3 = User::find_sql("SELECT * FROM agents WHERE user_id = '{$session->user_id}' LIMIT 1");
if($db_init->num_rows($check3)==1){
    $agent_applied = true;
    while ($rcol=$db_init->fetch_array($check3)) {
        $agent_balance = $rcol['bonus'];
        if($rcol['status']==1){
            $agent_confirmed = true;
            $get_no_agents = User::find_sql("SELECT * FROM users WHERE referal_id='{$session->user_id}'");
            if($db_init->num_rows($get_no_agents)>0){
                $no_of_referals = $db_init->num_rows($get_no_agents);
            }else{
                $no_of_referals = 0;
            }
        }else{
            $agent_confirmed = false;
        }
    }
}else{
    $agent_applied = false;
}
?>