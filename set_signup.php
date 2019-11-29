<?php
echo "
<link href='vendor/sweetalert2/sweetalert2.min.css' rel='stylesheet'>
<script src='vendor/sweetalert2/sweetalert2.all.min.js'></script>
<script>
function alert_func(type, message, loc) {
    Swal.fire({
        position: 'center',
        type: type,
        title: message,
        showConfirmButton: false,
        timer: 3000
    }).then(function(){
        if(loc!=''){
            window.location=loc;
        }
    });
    
}

function alert_funcion(type, message, loc) {
    Swal.fire({
        position: 'center',
        type: type,
        title: message,
        showConfirmButton: true
    }).then(function(){
        if(loc!=''){
            window.location=loc;
        }
    });
    
}
</script>
";
?>
<?php
require_once("init/init_all.php");      

if(isset($_POST['signup'])){
    global $db_init;
    
    // if(isset($_POST['ref_id']) && $_POST['ref_id'] == "GPseDxW8C7Mu"){
    if(!isset($_POST['ref_id'])){
        $go = false;
        while($go == false){
            $ref_id = generate_ref_id();
            $query = User::find_sql("SELECT ref_id FROM users WHERE ref_id='$ref_id'");
            if(mysqli_num_rows($query)>0){
                $ref_id = generate_ref_id();
            }else{
                $go = true;
            }
        }
    }else{
        $ref_id = $_POST['ref_id'];
    }
    
    
    //SETTING ALL THE VALUES TO A VARIABLE
    //$ref_id = $ref_id;
    $fname = $db_init->escape(htmlentities($_POST ['fname']));
    $lname = $db_init->escape(htmlentities($_POST ['lname']));
    $email = $db_init->escape(htmlentities($_POST ['email']));
    $phone = $db_init->escape(htmlentities($_POST ['phone']));
    $country = $db_init->escape(htmlentities($_POST ['country']));
    $continent = $db_init->escape(htmlentities($_POST ['continent']));
    $pass = $db_init->escape(htmlentities($_POST ['pass']));
    $repass = $db_init->escape(htmlentities($_POST ['repass']));

    //CHECKING FOR pass LENGTH LESS THAN 6
    if( strlen($pass) < 6  ){
        //MAKE PUP UP
        echo "<script> alert_func('warning', 'password Less than six!', 'signup.php'); </script>";
        // die();
    }

    //CHECKING IF pass IS THESAME WITH THE SECOND pass FIELD
    if( $pass !=$repass  ){
        //MAKE PUP UP
        echo "<script> alert_func('warning', 'password not the same!', 'signup.php'); </script>";
        // die();
    }

    //CHECKING IF EMAIL ALREADY REGISTERED
    $confirm_email = User::confirm_email_users($email);
    if($db_init->num_rows($confirm_email)>0){
        //MAKE PUP UP
        echo "<script> alert_func('warning', 'Email already exists!', 'signup.php'); </script>";
        // die();
    }
    $confirm_email = User::confirm_email_admins($email);
    if($db_init->num_rows($confirm_email)>0){
        //MAKE PUP UP
        echo "<script> alert_func('warning', 'Email already exists!', 'signup.php'); </script>";
        // die();
    }

    //CHECKING IF ALL FIELDS ARE FILLED OUT
    if(empty($ref_id) || empty($fname) ||  empty($lname) || empty($phone) || empty($email) || empty($country) || empty($continent)){
        //MAKE PUP UP
        echo "<script> alert_func('warning', 'All fields must be filled!', 'signup.php'); </script>";
        // die();
    }else{
        //REGISTERS USER IF EVERY THING IS CORRECT
        $register_user = User::register_user($ref_id, $fname, $lname, $email, $phone, $country, $pass, $continent); 
        if($register_user){
            $last_insert_id = $db_init->insert_id();
            if(isset($_SESSION['ref'])){
                $referal = $_SESSION['ref'];
                $get_user = User::find_sql("SELECT id FROM users WHERE ref_id='{$referal}' LIMIT 1");
                if($db_init->num_rows($get_user)==1){
                    while ($col=$db_init->fetch_array($get_user)) {
                        $referal_user_id = $col['id'];
                    }
                    $update_referal = User::find_sql("UPDATE users SET referal_id='{$referal_user_id}' WHERE id='$last_insert_id'");
                    if($update_referal){
                        $update_ref=User::find_sql("UPDATE agents SET members=members+1 WHERE user_id='{$referal_user_id}'");
                        if($update_ref){
                            unset($_SESSION['ref']);
                        }
                    }
                }
            }
            require 'phpmailer/PHPMailerAutoload.php';

            $mail = new PHPMailer();

                $mail->isSMTP();
                $mail->Host = "westerntradehub.com";
                $mail->SMTPSecure = "ssl";
                $mail->Port = 465;
                $mail->SMTPAuth = true;
            $username= User::get_email_address(); 
                $pass2=User::get_email_password();
            $mail->Username = $username; 
                $mail->Password = $pass2;
        
            $mail->setFrom(User::get_email_address(), User::get_company_name());
            $mail->addAddress($email);
            
            $mail->Subject = 'ACCOUNT VERIFICATION';
            $mail ->AddEmbeddedImage('images/wt_logo.png', 'logoimg');
            $mail->MsgHTML(User::verification_mail_message($ref_id, $pass, $email));
            if ($mail->send())
                echo "<script> alert_funcion('success', 'Registration Successful, kindly visit your email address to activate your signup!', 'login.php'); </script>";
        }
    }
}

?>