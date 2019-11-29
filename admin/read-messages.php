<?php require_once('joins/header.php'); ?>
<?php require_once('joins/nav.php'); ?>
<?php 
if(isset($_GET['msg_id']) && !empty($_GET['msg_id'])){
  $msg_id = $db_init->escape(htmlentities($_GET['msg_id']));
  $query = User::find_sql("SELECT * FROM contact_admins WHERE id='{$msg_id}'");
  if($db_init->num_rows($query)>0){
    $update=User::find_sql("UPDATE contact_admins SET status=1 WHERE id='{$msg_id}'");
    while($row=$db_init->fetch_array($query)){
      $user_id = $row['user_id'];
      $get_user_q=User::find_sql("SELECT fname, lname FROM users WHERE id='{$user_id}' ");
      while($col=$db_init->fetch_array($get_user_q)){
          $user_fullname=$col['fname']." ".$col['lname'];
      }
      $message = $row['message'];
      $topic = $row['topic'];
      $createda = $row['created'];
      $date_arraya=string_to_time($createda);
      $ll_date_stringa = $date_arraya[0]." | ".$date_arraya[1];
    }
  }else{
    echo "<script> window.location='messages.php'; </script>";
  }
}else{
  echo "<script> window.location='messages.php'; </script>";
}

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Mailbox
      </h1>
      <ol class="breadcrumb">
        <li><a href="./index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Mailbox</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-8 col-md-offset-2">
                <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">Read Mail</h3>
                          <div class="pull-right">
                            <a href="./message-admin.php?u_id=<?php echo $user_id ?>&m_id=<?php echo $msg_id ?>" class="btn btn-warning">Reply</a>
                          </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                          <div class="mailbox-read-info">
                            <h3><?php echo $topic; ?></h3>
                            <h5>From: <?php echo $user_fullname; ?>
                              <span class="mailbox-read-time pull-right"><?php echo $ll_date_stringa; ?></span></h5>
                          </div>
                          <!-- /.mailbox-read-info -->
                          <div class="mailbox-read-message">
                            <p>Dear Sir,</p>
            
                            <p><?php echo $message; ?></p>
            
                            <p>Thanks,<br><?php echo $lname; ?></p>
                          </div>
                          <!-- /.mailbox-read-message -->
                        </div>
                        <!-- /.box-body -->
                       
                      </div>

        </div>
        <!--/.col (left) -->

      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

    <?php require_once('joins/footer.php'); ?>