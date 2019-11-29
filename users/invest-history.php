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
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Transaction History
      </h1>
      <ol class="breadcrumb">
        <li><a href="../index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Investment History</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <div class="box" style="overflow:auto;">
<?php
$query = User::find_sql("SELECT * FROM invested WHERE user_id='{$session->user_id}' ORDER BY id DESC");
$count=1;
if($db_init->num_rows($query)>0){
?>
                <div class="box-header">
                  <h3 class="box-title">Transactions History</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                      <!-- History headings-->
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Amount</th>
                      <th>TimeStamp</th>
                      <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                        <!-- Loop the row-->
                        <!-- First row-->                
<?php
  while($row=$db_init->fetch_array($query)){
    $amount = $row['amount'];
    $status = $row['status'];
    $created = $row['created'];
?>
                    <tr>
                      <td><?php echo $count; ?></td>
                      <td><i class="fa fa-usd"></i><?php if(empty($amount)){ echo "<i>pending</i>"; }else{ echo $amount; } ?></td>
                      
                      <td><?php echo $created; ?></td>
                      <td> <i class="<?php if($row['status']==0){ echo 'fa fa-close text-warning'; }else{ echo 'fa fa-check text-success'; } ?>"></i></td>
                    </tr>
<?php
    $count++;
  }
?>
                    <!-- End of first row-->
                    </tbody>
                    
                  </table>
                </div>
                <!-- /.box-body -->
<?php 
  }else{
    echo "No Investment made yet!";
  }
?>
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