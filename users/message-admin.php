<?php require_once('joins/header.php'); ?>
<?php require_once('joins/nav.php'); ?>
<?php
if(isset($_POST['send_message'])){
  $topic = $db_init->escape(htmlentities($_POST['topic']));
  $msg = $db_init->escape(htmlentities($_POST['msg']));
  if(!empty($topic) && !empty($msg)){
    $contact_admin_q = User::find_sql("INSERT INTO contact_admins SET user_id='{$session->user_id}', message='{$msg}', sender='{$full_name}', created=NOW(), topic='{$topic}'");
    if($contact_admin_q){
      echo "<script> alert('Message delivered!'); window.location=''; </script>";
    }
  }else{
    echo "<script> alert('All fields must be filled out!'); window.location=''; </script>";
  }
}

?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Message Admin
      </h1>
      <ol class="breadcrumb">
        <li><a href="../index.html"><i class="fa fa-dashboard"></i> Home</a></li>
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
                  <label for="exampleInputEmail1">Topic </label>
                  <input name="topic" type="text" class="form-control"placeholder="Enter topic">
                </div>
                <div class="form-group">
                        <label>Message Content </label>
                        <textarea name="msg" class="form-control" style="resize:none" rows="7"></textarea>
                      </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="send_message" class="btn btn-warning">Send</button>
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