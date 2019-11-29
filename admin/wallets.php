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
if(isset($_POST['add_wallet'])){
  $bearer = $db_init->escape(htmlentities($_POST['bearer']));
  $wallet = $db_init->escape(htmlentities($_POST['wallet']));
  if(!empty($bearer) && !empty($wallet)){
    $query = User::find_sql("INSERT INTO wallets SET name='{$bearer}', wallet_id='{$wallet}', status=0, date=NOW()");
    if($query){
        echo "<script> alert_func('success', 'Wallet Added successfully!', ''); </script>";
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
          Add Account Wallets
          <small>Western Thread | Admin</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="../index.php"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Wallets</li>
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
                  <label for="exampleInputEmail1">Account Bearer</label>
                  <input type="text" name="bearer" class="form-control" id="news-head" placeholder="Enter account name">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Wallet Id</label>
                  <input type="text" name="wallet" class="form-control" id="news-head" placeholder="Enter wallet id">
                </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="add_wallet" class="btn btn-danger">Upload <i class="fa fa-upload"></i></button>
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