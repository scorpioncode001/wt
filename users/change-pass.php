<?php require_once('joins/header.php'); ?>
<?php require_once('joins/nav.php'); ?>
<?php
if(isset($_POST['change_pass'])){
  $old_pass = $db_init->escape(htmlentities($_POST['old_pass']));
  $pass = $db_init->escape(htmlentities($_POST['pass']));
  $repass=$db_init->escape(htmlentities($_POST['repass']));

  if(!empty($pass) && !empty($repass) && !empty($old_pass)){
    //CONFIRMING OLD PASSWORD
    $confirm_old_pass_q = User::find_sql("SELECT pass FROM users WHERE id='{$session->user_id}' LIMIT 1");
    if($db_init->num_rows($confirm_old_pass_q)==1){
      while($row=$db_init->fetch_array($confirm_old_pass_q)){
        $db_current_pass=$row['pass'];
      }
      if($db_current_pass!=md5($old_pass)){
        //MAKE PUP UP
        echo "<script> alert('Old password Incorrect!'); window.location='change-pass.php'; </script>";
        die();
      }
    }

    //CHECKING FOR pass LENGTH LESS THAN 6
    if( strlen($pass) < 6  ){
      //MAKE PUP UP
      echo "<script> alert('password Less than six!'); window.location='change-pass.php'; </script>";
      die();
    }

  //CHECKING IF pass IS THESAME WITH THE SECOND pass FIELD
  if( $pass !=$repass  ){
      //MAKE PUP UP
      echo "<script> alert('password not the same!'); window.location='change-pass.php'; </script>";
      die();
    }
    $epass = md5($pass);
    $chang_pass_q=User::find_sql("UPDATE users SET pass='{$epass}' WHERE id='{$session->user_id}'");
    if($chang_pass_q){
      echo "<script> alert('Password Updated!'); window.location='index.php'; </script>";
    }else{
      echo "<script> alert('Unable to Change password!'); window.location=''; </script>";
    }

  }
}

?>

<!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header" style="text-align:center">
                <h1>
                    Western Trade | Change Password
                </h1>
                <ol class="breadcrumb">
                    <li><a href="./index.html"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Profile</li>
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
                                <h3 class="box-title">User Profile</h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <form role="form" method="POST" action="" enctype="multipart/form-data">
                                <div class="box-body">
                                    <div class="box box-widget widget-user">
                                        <!-- Add the bg color to the header using any of the bg-* classes -->
                                        <div class="widget-user-header bg-blue-active">
                                            <h3 class="widget-user-username">User Name</h3>
                                        </div>
                                        <div class="widget-user-image">
                                            <img class="img-circle" src="<?php echo $picture ?>"
                                                alt="User Avatar">
                                        </div>
                                        <div class="box-footer">
                                            <div class="row">
                                                <div class="col-sm-4 border-right">
                                                    <div class="description-block">
                                                        <h5 class="description-header"><?php echo $created_date_string; ?></h5>
                                                        <span class="description-text">Joined</span>
                                                    </div>
                                                    <!-- /.description-block -->
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-sm-4 border-right">
                                                    <div class="description-block">
                                                        <h5 class="description-header">Active</h5>
                                                        <span class="description-text">Member</span>
                                                    </div>
                                                    <!-- /.description-block -->
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-sm-4">
                                                    <div class="description-block">
                                                        <h5 class="description-header">User</h5>
                                                        <span class="description-text">Status</span>
                                                    </div>
                                                    <!-- /.description-block -->
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <!-- /.row -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                            <label for="fname"><i class="fa fa-lock"></i> Old Password </label>
                                            <input type="password" name="old_pass" class="form-control" placeholder="old password" name='pass'>
                                        </div>
                                    <div class="form-group">
                                            <label for="fname"><i class="fa fa-lock"></i> New Password </label>
                                            <input type="password" name="pass" class="form-control" placeholder="new password" name='pass'>
                                        </div>
                                            <div class="form-group">
                                                    <label for="pnumber"><i class="fa fa-lock"></i> Retype Password</label>
                                                    <input type="password" name="repass" class="form-control" placeholder="retype password" name='repass'>
                                                </div>
                                                
                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer" style="text-align:center">
                                    <button type="submit" name="change_pass" class="btn btn-primary">Update Password</button>
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
  <?php require_once('joins/footer.php'); ?>