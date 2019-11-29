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

if(isset($_POST['re_fpass'])){
    global $db_init;
    
  $f_type = $db_init->escape(htmlentities($_POST ['f_type']));
  $query = User::find_sql("SELECT id, email, ref_id FROM users WHERE email='{$f_type}' OR ref_id='{$f_type}' LIMIT 1");
  if($db_init->num_rows($query)>0){
    while($r=$db_init->fetch_array($query)){
        $ref_id=$r['ref_id'];
        $email=$r['email'];
    }
    require 'phpmailer/PHPMailerAutoload.php';

    $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPSecure = "ssl";
        $mail->Port = 465;
        $mail->SMTPAuth = true;
    $username= User::get_email_address(); 
        $pass=User::get_email_password();
    $mail->Username = $username; 
        $mail->Password = $pass;

    $mail->setFrom(User::get_email_address(), User::get_company_name());
    $mail->addAddress($email);
    $mail->Subject = 'PASSWORD RECOVERY';
    $mail ->AddEmbeddedImage('images/wt_logo.png', 'logoimg');
    $mail->MsgHTML(User::forgotten_password_message($ref_id, $pass));

    if ($mail->send())
        echo "<script> alert_func('success', 'Password recovery link sent to your email!', 'login.php'); </script>";

    }else{
    echo "<script> alert_func('warning', 'No record found!', ''); </script>";
  }
}
?>
    <!--Breadcrumb-->

    <section id="breadcrumb" class="space nav-bar">

        <div class="container">

            <div class="row">

                <div class="col-sm-6 breadcrumb-block">

                    <h2>Western Trade | Login | Forgot Password</h2>

                </div>

                <div class="col-sm-6 breadcrumb-block text-right">

                    <ol class="breadcrumb">

                        <li><a href="index.php">Home</a></li>

                        <li ><a href="login.php">Login</a></li>
                        <li class="active">forgot password</li>

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

                    <form action="#" id="contact-form" role="form" method="POST">

                        <div class="form-group col-sm-12 padding-left">

                            <input type="text" class="form-control" name="f_type" id="mail" required placeholder="Enter Email or Ref Id">

                        </div>


                        <div class="col-sm-12  no-padding">

                            <input type="submit" name="re_fpass" class="btn btn-default" value="Request">

                        </div>

                    </form>

                </div>



            </div>

        </div>

    </section>


<?php require_once('includes/footer.php'); ?>