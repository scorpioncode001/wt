<?php require_once('joins/header.php'); ?>
<?php require_once('joins/nav.php'); ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Withdrawal History
        </h1>
        <ol class="breadcrumb">
          <li><a href="./index.php"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Withdrawal history</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <div class="box">
<?php
$query=User::find_sql("SELECT * FROM payments ORDER BY id DESC");
if($db_init->num_rows($query)>0){
?>
              <div class="box-header">
                <h3 class="box-title">Logs</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <!-- History headings-->
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>User</th>
                      <th>Details</th>
                      <th>Type</th>
                      <th>Amount (<i class="fa fa-usd"></i>)</th>
                      <th>TimeStamp</th>
                      <th>Withdrawal Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Loop the row-->
    <?php
    $counter=1;
      while($row=$db_init->fetch_array($query)){
        $user_id= $row['user_id'];
        $get_user_email_q=User::find_sql("SELECT email, fname, lname FROM users WHERE id='{$user_id}' LIMIT 1");
        if($db_init->num_rows($get_user_email_q)==1){
          while($column=$db_init->fetch_array($get_user_email_q)){
            $user_email=$column['email'];
            $user_full_name=$column['fname']." ".$column['lname'];
          }
        }
        $withdrawal_id = $row['id'];
        $dollar_amount = $row['amount'];
        $bank=$row['bank'];
        $acc_name=$row['acc_name'];
        $acc_number=$row['acc_number'];
        $wallet_id=$row['wallet_id'];
        $w_type = $row['w_type'];
        if($row['payment_type']=='Local Account'){
          $details="
          Bank: $bank<br>
          Acc. Name: $acc_name<br>
          Acc. Number: $acc_number
          ";
        }elseif($row['payment_type']=='Bitcoin'){
          $details="
          Wallet Id: $wallet_id
          ";
        }else{
          $details="";
        }
        $amount = $row['amount'];
        $requested = $row['requested'];
    ?>
                    <!-- First row-->

                    <tr>
                      <form role="form" method="POST" action="">
                        <td><?php echo $counter; ?></td>
                        <td>
                        <?php echo $user_full_name; ?>
                        </td>
                        <td>
                            <p><?php echo $details; ?></p>
                        </td>
                        <td><?php echo $row['payment_type']; ?></td>
                        <td><?php echo $row['amount']."($w_type)"; ?></td>
                        <td><?php echo $row['requested']; ?></td>
                        <?php if($row['status']==0){ ?>
                          <td><span class="label label-warning">Pending</span></td>
                        <?php }else{ ?>
                          <td><span class="badge bg-green">paid</span></td>
                        <?php } ?>
                      </form>
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
      echo "No Withdrawal logs!";
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