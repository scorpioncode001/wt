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
?>
<?php require_once('joins/header.php'); ?>
<?php require_once('joins/nav.php'); ?>
<?php
$user_full_name2='';
if(isset($_GET['m_id']) && isset($_GET['u_id']) ){
  // $_SESSION['message_id']=$db_init->escape(htmlentities($_GET['m_id']));
  // $_SESSION['u_id']=$db_init->escape(htmlentities($_GET['u_id']));
  //echo "<script> window.location='message-admin.php'; </script>";
  $user_id1=$_GET['u_id'];
  $get_username_q = User::find_sql("SELECT fname, lname FROM users WHERE id='{$user_id1}'");
  while($row=mysqli_fetch_array($get_username_q)){
    $user_full_name2 = $row['fname']." ".$row['lname'];
  }
}elseif(isset($_SESSION['message_id']) && isset($_SESSION['u_id'])){
  $user_id=$_SESSION['u_id'];
  $get_username_q = User::find_sql("SELECT fname, lname FROM users WHERE id='{$user_id}'");
  while($row=mysqli_fetch_array($get_username_q)){
    $user_full_name2 = $row['fname']." ".$row['lname'];
  }
}else{
  echo "<script> window.location='messages.php'; </script>";
}

if(isset($_POST['send_msg'])){
  $msg = $db_init->escape(htmlentities($_POST['message_content']));
  $msg_id = $db_init->escape(htmlentities($_POST['msg_id']));
  $user_id =  $db_init->escape(htmlentities($_POST['user_id']));
  if(!empty($msg) && !empty($msg_id) && !empty($user_id)){
    $send_msg_q=User::find_sql("INSERT INTO contact_response SET contact_admin_msg_id='{$msg_id}', user_id='{$user_id}', admin_id='{$session->user_id}', message='{$msg}', created=NOW()");
    if($send_msg_q){
      // unset($_SESSION['message_id']);
      // unset($_SESSION['u_id']);
      echo "<script> alert_func('success', 'Message delivered!', 'messages.php'); </script>";
    }else{
      echo "<script> alert_func('warning', 'Service Timeout!', ''); </script>";
    }
  }else{
    echo "<script> alert_func('warning', 'Service Timeout!', ''); </script>";
  }
}
?>
<?php
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Send Message
      </h1>
      <ol class="breadcrumb">
        <li><a href="./index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">message admin</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-8 col-md-offset-2">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Send Mail</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="">
              <div class="box-body">
                  <div class="form-group">
                      <label for="exampleInputEmail1">To </label>
                      <input value="<?php echo $user_full_name2; ?>" type="text" class="form-control"placeholder="send to..." disabled>
                      <input type="hidden" name="user_id" value="<?php echo  $_GET['u_id']; ?>">
                      <input type="hidden" name="msg_id" value="<?php echo  $_GET['m_id']; ?>">
                    </div>
                <!-- <div class="form-group">
                  <label for="exampleInputEmail1">Topic </label>
                  <input  type="text" class="form-control"placeholder="Enter topic">
                </div> -->
                <div class="form-group">
                        <label>Message Content </label>
                        <textarea name="message_content" class="form-control" style="resize:none" rows="7" placeholder="type your message here"></textarea>
                      </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button name="send_msg" type="submit" class="btn btn-facebook btn-block">Send <i class="fa fa-send"></i></button>
              </div>
            </form>
          </div>
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
    <?php
    // unset($_SESSION['message_id']);
    // unset($_SESSION['u_id']);
    ?>
  <?php require_once('joins/footer.php'); ?>