<?php require_once('joins/header.php'); ?>
<?php require_once('joins/nav.php'); ?>
<?php
// if(isset($_GET['activate'])){
//   $user_id = $_GET['activate'];
//   $query=User::find_sql("UPDATE agent_pay SET status=1 WHERE id='{$user_id}'");
//   if($query){
//       $get_owner = User::find_sql("SELECT *, (SELECT email FROM users WHERE id=user_id) AS main_user_email FROM agent_pay WHERE id='{$user_id}'");
//       if($db_init->num_rows($get_owner)==1){
//           while($rcl=$db_init->fetch_array($get_owner)){
//               $main_user_email = $rcl['main_user_email'];
//           }
//           //send mail message here...

//       }
//   }
// }
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Payment History
        </h1>
        <ol class="breadcrumb">
          <li><a href="../index.html"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Payment history</li>
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
                      <th>Status</th>
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
                          <td><button class="btn btn-warning btn-flat btn-block">Not Paid</button></td>
                        <?php }else{ ?>
                          <td><button class="btn btn-success btn-flat btn-block">Paid</button></td>
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