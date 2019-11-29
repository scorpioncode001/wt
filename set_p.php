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
</script>
";
?>
<?php
require_once("init/init_all.php");
if(isset($_POST['signin'])){
    global $db_init;

    $email  = $db_init->escape($_POST ['email']);
    $pass = md5($db_init->escape($_POST ['pass']));

    $result_set = User::login_admin($email, $pass);
    if($db_init->num_rows($result_set)==1){
        while($row=$db_init->fetch_array($result_set)){
            if($row['status']=='1'){
                //ACTIVE ACCOUNT
                $session->login($row['id']);
                $_SESSION['location']="admin";
                $update_last_logged_q=User::find_sql("UPDATE admins SET last_logged=NOW() WHERE id='{$session->user_id}'");
                echo "<script> window.location='admin/'; </script>";
                //header("Location: admin/");
            }elseif($row['status']=='0'){
                //ACCOUNT INACTIVE
                echo "<script> alert_func('warning', 'Sorry, your account is not active!', ''); </script>";
                // die();
            }
        }
    }else{
        echo "<script> alert_func('warning', 'Incorrect username or pass!', ''); </script>";
        // die();
    }
}

?>