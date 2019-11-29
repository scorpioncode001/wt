<?php require_once('includes/header.php') ?>
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
        showConfirmButton: true
    }).then(function(){
        if(loc!=''){
            window.location=loc;
        }
    });
    
}
</script>
";

if(isset($_POST['update_pass'])){
    global $db_init;

    if(isset($_SESSION['ref_id']) && isset($_SESSION['email'])){
      $pass = $db_init->escape(htmlentities($_POST ['pass']));
      $re_pass = $db_init->escape(htmlentities($_POST ['re_pass']));
      if(strlen($pass)<6){
        echo "<script> alert_func('warning', 'Password too short, must be more than 6!', 'repass.php'); </script>";
        // die();
      }
      if($pass != $re_pass){
        echo "<script> alert_func('warning', 'The two passwords mismatch!', 'repass.php'); </script>";
        // die();
      }
      $epassword = md5($pass);
      $user_unique_id = $_SESSION['ref_id'];
      $email = $_SESSION['email'];
      $update = User::find_sql("UPDATE users SET pass='{$epassword}' WHERE ref_id = '$user_unique_id' AND email = '{$email}'");
          if($update){
            require 'phpmailer/PHPMailerAutoload.php';

            $mail = new PHPMailer();
        
                $mail->isSMTP();
                $mail->Host = "smtp.gmail.com";
                $mail->SMTPSecure = "ssl";
                $mail->Port = 465;
                $mail->SMTPAuth = true;
            $username= User::get_email_address(); 
                $pass2=User::get_email_password();
            $mail->Username = $username; 
                $mail->Password = $pass2;
        
            $mail->setFrom(User::get_email_address(), User::get_company_name());
            $mail->addAddress($email);

            $mail->Subject = 'ACCOUNT AUTHENTICATION SUCCESSFUL';
            $mail ->AddEmbeddedImage('images/wt_logo.png', 'logoimg');
            $mail->MsgHTML(User::completed_forgotten_password_message($user_unique_id, $pass, $email));
        
            if ($mail->send())
                unset($_SESSION['ref_id']);
                unset($_SESSION['email']);
                echo "<script> alert_func('success', 'Password Updated Successfully, experience the best from us!', 'login.php'); </script>";
            }
    }else{
        echo "<script> alert_func('warning', 'Session timeout!', 'index.php'); </script>";
    }
  }
?>
   
<!-- HERE -->


<?php require_once('includes/header.php') ?>
<?php

?>
    <!--Breadcrumb-->

    <section id="breadcrumb" class="space nav-bar">

        <div class="container">

            <div class="row">

                <div class="col-sm-6 breadcrumb-block">

                    <h2>Western Trade | Login | Recover Password</h2>

                </div>

                <div class="col-sm-6 breadcrumb-block text-right">

                    <ol class="breadcrumb">

                        <li><a href="index.php">Home</a></li>

                        <li ><a href="login.php">Login</a></li>
                        <li class="active">recover password</li>

                    </ol>

                </div>

            </div>

        </div>

    </section>

    <!--Contact Us-->

    <section id="contact" class="space">

        <div class="container">

            <div class="row">


                <div class="col-sm-5 col-sm-offset-4 contact-block" style="box-shadow:1px 1px 2px  #000;padding:10px">

                    <div class="col-sm-12 main-heading">

                        <h3>Request For New Password</h3>

                    </div>
                    <div class="col-sm-12" style="padding:20px;text-align: center">
                        <i class="fa fa-lock fa-5x"></i>
                    </div>

                    <form action="" method="post" accept-charset="utf-8" class="block">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" name="pass" class="form-control" value="" placeholder="Enter new Password">
                        </div>

                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" name="re_pass" autocomplete="new-password" class="form-control" placeholder="Retype Password">
                        </div>

                        <input type="submit" name="update_pass" value="Update" class="btn btn-default">
                    </form> 

                </div>



            </div>

        </div>

    </section>


<?php require_once('includes/footer.php'); ?>