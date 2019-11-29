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
if(isset($_POST['add_link'])){
  $title = $db_init->escape(htmlentities($_POST['title']));
  $link = $db_init->escape(htmlentities($_POST['link']));
  if(!empty($title) && !empty($link)){
    $query = User::find_sql("INSERT INTO links SET link='{$link}', title='{$title}', status=0, date=NOW()");
    if($query){
        echo "<script> alert_func('success', 'Link Created successfully!', ''); </script>";
    }
  }else{
    echo "<script> alert_func('warning', 'Fill in correctly!', ''); </script>";
  }
}

?>
<div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Add Account Links
          <small>Western Trade | Admin</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="../index.php"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Links</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Upload</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Title</label>
                  <input type="text" name="title" class="form-control" id="news-head" placeholder="Enter link title">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Link</label>
                  <input type="text" name="link" class="form-control" id="news-head" placeholder="Enter link url">
                </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="add_link" class="btn btn-danger">Upload <i class="fa fa-upload"></i></button>
              </div>
            </form>
          </div>
          </div>

          <!-- fix for small devices only -->
          <div class="clearfix visible-sm-block"></div>

        </div>
        <!-- /.row -->

        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->



<?php require_once('joins/footer.php'); ?>