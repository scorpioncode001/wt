<?php require_once('joins/header.php'); ?>
<?php require_once('joins/nav.php'); ?>
<?php 
if(isset($_GET['msg_id']) && !empty($_GET['msg_id'])){
  $msg_id = $db_init->escape(htmlentities($_GET['msg_id']));
  $query = User::find_sql("SELECT * FROM contact_response WHERE id='{$msg_id}' AND user_id='{$session->user_id}'");
  if($db_init->num_rows($query)>0){
    $update=User::find_sql("UPDATE contact_response SET status=1 WHERE id='{$msg_id}'");
    while($row=$db_init->fetch_array($query)){
      
      $message = $row['message'];
      
      $subject = "WESTERN TRADE";
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
        <li><a href="../index.html"><i class="fa fa-dashboard"></i> Home</a></li>
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
            
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                          <div class="mailbox-read-info">
                            <h3><?php echo $subject; ?></h3>
                            <h5>From: Admin
                              <span class="mailbox-read-time pull-right"><?php echo $ll_date_stringa; ?></span></h5>
                          </div>
                          <!-- /.mailbox-read-info -->
                          <div class="mailbox-read-message">
                            <p>Hello <?php echo $lname; ?>,</p>
            
                            <p><?php echo $message; ?>.</p>
            
                            <p>Thanks.<br>Admin</p>
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