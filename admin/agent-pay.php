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
if(isset($_GET['activate'])){
  $user_id = $_GET['activate'];
  $get_owner = User::find_sql("SELECT * FROM agent_pay WHERE id='{$user_id}'");
  if($db_init->num_rows($get_owner)==1){
      while($rcl=$db_init->fetch_array($get_owner)){
          $main_user_amount = $rcl['amount'];
          $user_id2 = $rcl['user_id'];
      }
      $query=User::find_sql("UPDATE agent_pay SET status=1, amount=0 WHERE id='{$user_id}'");
      if($query){
        //send mail message here...
        $message2 = "
        Agent Bonus Payment Completed<br>
        Amount: $$main_user_amount <br>
        Agent Balance: $0
        ";
        $insert_mail = User::find_sql("INSERT INTO contact_response SET user_id='$user_id2', message='$message2', created=NOW()");
        if($insert_mail){
          echo "<script> alert_func('success', 'Transaction successful!', 'withdraw-history.php'); </script>";
        }
      }
  }
}
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Payment Requests
        </h1>
        <ol class="breadcrumb">
          <li><a href="../index.html"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Payment requests</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <div class="box">
<?php
$query=User::find_sql("SELECT *, (SELECT CONCAT(fname, ' ',lname) FROM users WHERE id=(user_id) LIMIT 1) AS full_name FROM agent_pay ORDER BY id DESC");
if($db_init->num_rows($query)>0){
?>
              <div class="box-header">
                <h3 class="box-title">Payment Logs</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <!-- History headings-->
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>User</th>
                      <th>Payment Type</th>
                      <th>Acc. Details</th>
                      <th>Amount</th>
                      <th>Date</th>
                      <th>Control</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Loop the row-->
    <?php
    $counter=1;
      while($row=$db_init->fetch_array($query)){
    ?>
                    <!-- First row-->

                    <tr>
                        <td><?php echo $counter; ?></td>
                        <td>
                        <?php echo $row['full_name']; ?>
                        </td>
                        <td><?php echo $row['payment_type']; ?></td>
                        <td><?php echo $row['details']; ?></td>
                        <td><i class="fa fa-usd"></i><?php echo $row['amount']; ?></td>
                        <td><?php echo $row['requested']; ?></td>
                        <?php if($row['status']==0){ ?>
                          <td><a href="?activate=<?php echo $row['id']; ?>" class="btn btn-warning btn-flat btn-block">Confirm</a></td>
                        <?php }else{ ?>
                          <td><a href="" class="btn btn-success btn-flat btn-block">Confirmed</a></td>
                        <?php } ?>
                        
                    </tr>

                    <!-- End of first row-->
    <?php 
    $counter++;
    } 
    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.box-body -->
            </div>
  <?php 
    }else{
      echo "No investment logs!";
    } 
  ?>

          </div>
          <!--/.col (left) -->

        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    
  <?php require_once('joins/footer.php'); ?>