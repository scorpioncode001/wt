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
if(isset($_POST['activete_inv'])){
    $inv_id=$db_init->escape(htmlentities($_POST['inv_id']));
    $user_id=$db_init->escape(htmlentities($_POST['user_id']));
    $amount=$db_init->escape(htmlentities($_POST['amount']));
    if(!empty($inv_id) && !empty($user_id) && !empty($amount)){
        $update_q=User::find_sql("UPDATE invested SET status=1 WHERE id='{$inv_id}'");
        if($update_q){
          $percent = User::get_percent();
          $tr_bonus = $percent*$amount;
          //$insert_id = $db_init->insert_id();
          $insert_q= User::find_sql("INSERT INTO bonus SET user_id='{$session->user_id}', inv_id='{$inv_id}', inv_type='Bitcoin', bonus='0', default_bonus='{$tr_bonus}', main_bonus='0', cashed_out='0', date=NOW()");
            $get_user_info_q=User::find_sql("SELECT * FROM ecnalab WHERE user_id='{$user_id}'");
            if($db_init->num_rows($get_user_info_q)==1){
                while($column=$db_init->fetch_array($get_user_info_q)){
                    $user_balance=$column['ecnalab']+$amount;
                    $credit_q=User::find_sql("UPDATE ecnalab SET ecnalab='{$user_balance}' WHERE user_id='{$user_id}'");
                }
            }elseif($db_init->num_rows($get_user_info_q)==0){
              $user_balance = $amount;
                $credit_q=User::find_sql("INSERT INTO ecnalab SET user_id='{$user_id}', ecnalab='{$amount}', updated=NOW()");
                $get_agent_ref = find_sql("SELECT id, referal_id FROM users WHERE id='{$user_id}'");
                if($db_init->num_rows($get_agent_ref)==1){
                  while($rcl=$db_init->fetch_array($get_agent_ref)){
                    $referal_id = $rcl['referal_id'];
                  }
                  if($referal_id != 0){
                    $agent_pay = User::get_agent_pay(); 
                    $pay_ref = User::find_sql("UPDATE agents SET bonus=bonus+$agent_pay WHERE user_id='{$referal_id}'");
                    $get_agt = User::find_sql("SELECT * FROM agents WHERE user_id='{$referal_id}' LIMIT 1");
                    if($db_init->num_rows($get_agt)==1){
                      while($rcll=$db_init->fetch_array($get_agt)){
                        $get_bonus = $rcll['bonus'];
                      }
                      //send mail message here...
                      $message = "
                      Account Credit from Agent transaction <br>
                      Amount: $$agent_pay <br>
                      Agent Balance: $$get_bonus
                      ";
                      $insert_mail = User::find_sql("INSERT INTO contact_response SET user_id='$referal_id', message='$message', created=NOW()");
                    }
                  }
                }
            }
            if($credit_q){
              //send mail message here...
              $message2 = "
              Account Credit from Bitcoin transaction <br>
              Amount: $$amount <br>
              Balance: $$user_balance
              ";
              $insert_mail = User::find_sql("INSERT INTO contact_response SET user_id='$user_id', message='$message2', created=NOW()");
              if($insert_mail){
                echo "<script> alert_func('success', 'Updated and Credited Successfully!', ''); </script>";
              }
            }
        }
    }else{
        echo "<script> alert_func('warning', 'Session timeout!', ''); </script>";
    }
}
?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Confirm Wallet Payment
        </h1>
        <ol class="breadcrumb">
          <li><a href="./index.php"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Confirm wallet payment</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <div class="box">
<?php
$query=User::find_sql("SELECT * FROM invested WHERE invest_type='Bitcoin' AND status=0 AND reference!='' ORDER BY id DESC");
if($db_init->num_rows($query)>0){
?>
              <div class="box-header">
                <h3 class="box-title">Logs</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                  <!-- History headings-->
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>User</th>
                      <th>Amount(<i class="fa fa-usd"></i>)</th>
                      <th>Amount(<i class="fa fa-btc"></i>)</th>
                      <th>Wallet ID</th>
                      <th>TimeStamp</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Loop the row-->
    <?php
    $counter=1;
      while($row=$db_init->fetch_array($query)){
        $inv_id = $row['id'];
        $user_id = $row['user_id'];
        $get_user_name_q=User::find_sql("SELECT fname, lname FROM users WHERE id='{$user_id}' LIMIT 1");
          while($col=$db_init->fetch_array($get_user_name_q)){
            $user_full_name=$col['fname']." ".$col['lname'];
          }
        $amount = $row['amount'];
        $wallet_id = $row['reference'];
        $created = $row['paidAt'];
    ?>
                    <!-- First row-->

                    <tr>
                        <td><?php echo $counter; ?></td>
                        <td>
                          <?php echo $user_full_name; ?>
                        </td>
                        <td><?php echo $amount; ?></td>
                        <td><?php echo $row['equivalent_btc']; ?></td>
                        <td><?php echo $wallet_id; ?></td>
                        <td><?php echo $created; ?></td>
                        <form role="form" method="POST" action="">
                        <input type="hidden" name="inv_id" value="<?php echo $inv_id; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <input type="hidden" name="amount" value="<?php echo $amount; ?>">
                        <td style="text-align:center"><button type="submit" name="activete_inv" class="btn btn-warning btn-block"><i class="fa fa-check"></i> Confirm</button></td>
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