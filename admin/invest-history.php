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
if(isset($_POST['assign_wallet_id'])){
  $wallet_id=$db_init->escape(htmlentities($_POST['wallet_id']));
  $inv_id= $db_init->escape(htmlentities($_POST['inv_id']));
  $user_email=$db_init->escape(htmlentities($_POST['user_email']));
  $bitcoin_amount= $db_init->escape(htmlentities($_POST['bitcoin_amount']));
  $dollar_amount= $db_init->escape(htmlentities($_POST['dollar_amount']));
  if(!empty($wallet_id) && !empty($inv_id) && !empty($user_email) && !empty($bitcoin_amount)){
    $assign_id_q=User::find_sql("UPDATE invested SET reference='{$wallet_id}' WHERE id='{$inv_id}'");
    if($assign_id_q){
      //mail
      require '../phpmailer/PHPMailerAutoload.php';

          $mail = new PHPMailer();

            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPSecure = "ssl";
            $mail->Port = 465;
            $mail->SMTPAuth = true;
          $username= User::get_email_address(); 
            $pass2=User::get_email_password();
          $mail->Username = $username; 
            $mail->Password = $pass2;
      
          $mail->setFrom(User::get_email_address(), User::get_company_name());
          $mail->addAddress($user_email);
          $mail->Subject = 'WESTERN THREAD WALLET ID';
          $mail ->AddEmbeddedImage('../images/wt_logo.jpeg', 'logoimg');
          $mail->MsgHTML(User::send_wallet_id($dollar_amount, $bitcoin_amount, $wallet_id));
          if ($mail->send())
              echo "<script> alert_func('success', 'Wallet Id Re-assigned and email sent successfully!', 'invest-history.php'); </script>";
    }
  }else{
    echo "<script> alert_func('warning', 'Fill in correctly!', ''); </script>";
  }
}
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Investment Requests
        </h1>
        <ol class="breadcrumb">
          <li><a href="./index.php"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Investment Requests</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <div class="box">
<?php
$query=User::find_sql("SELECT * FROM invested WHERE invest_type='Bitcoin' AND status=0 ORDER BY id DESC");
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
                      <th>Message</th>
                      <th>Amount($)</th>
                      <th>Wallet Status</th>
                      <th>TimeStamp</th>
                      <th>Wallet ID</th>
                      <th>Send Wallet ID</th>
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
            $user_fullname=$column['fname']." ".$column['lname'];
          }
        }
        $inv_id = $row['id'];
        $dollar_amount = $row['amount'];
        $wallet_id = $row['reference'];
        $created = $row['paidAt'];
    ?>
                    <!-- First row-->

                    <tr>
                      <form role="form" method="POST" action="">
                        <td><?php echo $counter; ?></td>
                        <td>
                         <?php echo $user_fullname; ?> has requested for a wallet ID
                        </td>
                        <td><?php echo $dollar_amount; ?></td>
                        <?php if($row['reference']==""){ ?>
                        <td><span class="label label-warning">not assigned</span></td>
                        <?php }else{ ?>
                        <td><span class="label label-success fa fa-check"> assigned</span></td>
                        <?php } ?>
                          
                        <td><?php echo $created; ?></td>
                        <td><input name="wallet_id" value="<?php echo $wallet_id; ?>" class="form-control" type="text" placeholder="assign wallet id"></td>
                        <?php if($row['reference']==""){ ?>
                          <td style="text-align:center">
                          <input name="inv_id" type="hidden" value="<?php echo $inv_id; ?>">
                          <input name="user_email" type="hidden" value="<?php echo $user_email; ?>">
                          <input name="bitcoin_amount" type="hidden" value="<?php echo $row['equivalent_value']; ?>">
                          <input name="dollar_amount" type="hidden" value="<?php echo $dollar_amount; ?>">
                          <button name="assign_wallet_id" type="submit" class="btn btn-info btn-flat btn-block">Assign</button>
                        </td>
                        <?php }else{ ?>
                          <td style="text-align:center">
                          <input name="inv_id" type="hidden" value="<?php echo $inv_id; ?>">
                          <input name="user_email" type="hidden" value="<?php echo $user_email; ?>">
                          <input name="bitcoin_amount" type="hidden" value="<?php echo $row['equivalent_value']; ?>">
                          <input name="dollar_amount" type="hidden" value="<?php echo $dollar_amount; ?>">
                          <button name="assign_wallet_id" type="submit" class="btn btn-facebook btn-flat btn-block">Re-Assign</button>
                        </td>
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
      echo "<div class='col-md-12'>NO INVESTMENTS MADE YET</div>";
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