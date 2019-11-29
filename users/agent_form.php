<?php require_once('joins/header.php'); ?>
<?php require_once('joins/nav.php'); ?>
<?php
echo "
<link href='../vendor/sweetalert2/sweetalert2.min.css' rel='stylesheet'>
<script src='../vendor/sweetalert2/sweetalert2.all.min.js'></script>
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
$check1 = User::find_sql("SELECT * FROM invested WHERE user_id='{$session->user_id}' AND status=1 LIMIT 1");
if(empty($db_init->num_rows($check1))){
    echo "<script> alert_func('warning', 'You are not qualified because you have not funded your account!', 'apply_agent.php'); </script>";
}
$check2 = User::find_sql("SELECT created FROM users WHERE id='{$session->user_id}' LIMIT 1");
if($db_init->num_rows($check2)==1){
    while ($row=$db_init->fetch_array($check2) ){
        $registered = $row['created'];                 
        $today = time();                             
        $interval = $today-strtotime($registered);
        $days = floor($interval/86400);
        $weeks = floor($days/7);
        if($weeks<4){
            echo "<script> alert_func('warning', 'You are not qualified because your account is not upto 1 month!', 'apply_agent.php'); </script>";
        }
    }    
}
$check3 = User::find_sql("SELECT * FROM agents WHERE user_id = '{$session->user_id}' LIMIT 1");
if($db_init->num_rows($check3)==1){
    echo "<script> alert_func('warning', 'you have applied as an agent!', 'apply_agent.php'); </script>";
}else{
    echo "<script> alert_func('success', 'Your account is qualified to apply as an agent!', ''); </script>";
}
?>
<?php
if(isset($_POST['apply'])){
  $fb = $db_init->escape(htmlentities($_POST ['fb']));
  $wa = $db_init->escape(htmlentities($_POST ['wa']));
  $tw = $db_init->escape(htmlentities($_POST ['tw']));

  if(!empty($fb) && !empty($wa) && !empty($tw)){
    $check = User::find_sql("SELECT * FROM agents WHERE user_id = '{$session->user_id}' LIMIT 1");
    if($db_init->num_rows($check)==1){
        echo "<script> alert_func('warning', 'you have applied as an agent!', 'index.php'); </script>";
    }else{
        $insert = User::find_sql("INSERT INTO agents SET user_id='{$session->user_id}', fb='{$fb}', wa='{$wa}', tw='{$tw}', created=NOW()");
        if($insert){
            echo "<script> alert_func('success', 'Agent application details submitted successfully!', 'index.php'); </script>";
        }
    }
  }else{
      echo "<script> alert_func('warning', 'All fields must be filled out!', ''); </script>";
  }
}

?>
  <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header" style="text-align:center">
                <h1>
                    Agent Application
                </h1>
                <ol class="breadcrumb">
                    <li><a href="./index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Agent</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-8 col-md-offset-2">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header with-border text-center">
                                <h3 class="box-title">Application form</h3>
                            </div>
                            <hr>
                            <!-- form start -->
                            <form role="form" method="POST" action="" enctype="multipart/form-data">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="fb"><i class="fa fa-facebook" style="color:blue;"></i> Facebook Display Name </label>
                                        <input type="text" class="form-control" placeholder="facebook accout name" name='fb' value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="wa"><i class="fa fa-whatsapp" style="color:green;"></i> Whatsapp Phone Number </label>
                                        <input type="text" class="form-control" placeholder="whatsapp phone number (copy from your whatsapp profile to specify the country code eg {+1})" name='wa' value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="tw"><i class="fa fa-twitter" style="color:blue;"></i> Twitter Username </label>
                                        <input type="text" class="form-control" placeholder="twitter username" name='tw' value="">
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer" style="text-align:center">
                                    <button name="apply" type="submit" class="btn btn-primary">Apply</button>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
  <?php require_once('joins/footer.php'); ?>