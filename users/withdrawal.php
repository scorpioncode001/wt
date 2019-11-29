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
###AAA###
if(isset($_POST['cash_main_a'])){
  $tr_id = $db_init->escape(htmlentities($_POST['inv_id']));
  $mode = $db_init->escape(htmlentities($_POST['mode']));
  $b_id = $db_init->escape(htmlentities($_POST['b_id']));
  if(!empty($tr_id) && !empty($mode)){
    if($mode=='Account'){
      $_SESSION['tr_id']=$tr_id;
      $_SESSION['bonus_id']=$b_id;
      $_SESSION['inv_mode']='Paystack';
      $_SESSION['tbl_mode']='invested';
      $_SESSION['cash_mode']='main';
      echo "<script> window.location='cash_out_account.php'; </script>";
    }elseif($mode=='Wallet'){
      $_SESSION['tr_id']=$tr_id;
      $_SESSION['bonus_id']=$b_id;
      $_SESSION['inv_mode']='Paystack';
      $_SESSION['tbl_mode']='invested';
      $_SESSION['cash_mode']='main';
      echo "<script> window.location='cash_out_wallet.php'; </script>";
    }
  }else{
    //error fill in... 
    echo "<script> alert_func('warning', 'Incorrect Submission, choose correctly!', 'withdrawal.php'); </script>";
  }
}
if(isset($_POST['cash_bonus_a'])){
  $tr_id = $db_init->escape(htmlentities($_POST['inv_id']));
  $mode = $db_init->escape(htmlentities($_POST['mode']));
  $b_id = $db_init->escape(htmlentities($_POST['b_id']));
  if(!empty($tr_id) && !empty($mode)){
    if($mode=='Account'){
      $_SESSION['tr_id']=$tr_id;
      $_SESSION['bonus_id']=$b_id;
      $_SESSION['inv_mode']='Paystack';
      $_SESSION['tbl_mode']='invested';
      $_SESSION['cash_mode']='bonus';
      echo "<script> window.location='cash_out_account.php'; </script>";
    }elseif($mode=='Wallet'){
      $_SESSION['tr_id']=$tr_id;
      $_SESSION['bonus_id']=$b_id;
      $_SESSION['inv_mode']='Paystack';
      $_SESSION['tbl_mode']='invested';
      $_SESSION['cash_mode']='bonus';
      echo "<script> window.location='cash_out_wallet.php'; </script>";
    }
  }else{
    //error fill in... 
    echo "<script> alert_func('warning', 'Incorrect Submission, choose correctly!', 'withdrawal.php'); </script>";
  }
}


###BBB###
// if(isset($_POST['cash_main_b'])){
//   $tr_id = $db_init->escape(htmlentities($_POST['inv_id']));
//   $mode = $db_init->escape(htmlentities($_POST['mode']));
//   $b_id = $db_init->escape(htmlentities($_POST['b_id']));
//   if(!empty($tr_id) && !empty($mode)){
//     if($mode=='Account'){
//       $_SESSION['tr_id']=$tr_id;
//       $_SESSION['bonus_id']=$b_id;
//       $_SESSION['inv_mode']='Bitcoin';
//       $_SESSION['tbl_mode']='investments';
//       $_SESSION['cash_mode']='main';
//       echo "<script> window.location='cash_out_account.php'; </script>";
//     }elseif($mode=='Wallet'){
//       $_SESSION['tr_id']=$tr_id;
//       $_SESSION['bonus_id']=$b_id;
//       $_SESSION['inv_mode']='Bitcoin';
//       $_SESSION['tbl_mode']='investments';
//       $_SESSION['cash_mode']='main';
//       echo "<script> window.location='cash_out_wallet.php'; </script>";
//     }
//   }else{
//     //error fill in... 
//     echo "<script> alert('Incorrect Submission, choose correctly!'); window.location='withdrawal.php'; </script>";
//   }
// }
// if(isset($_POST['cash_bonus_b'])){
//   $tr_id = $db_init->escape(htmlentities($_POST['inv_id']));
//   $mode = $db_init->escape(htmlentities($_POST['mode']));
//   $b_id = $db_init->escape(htmlentities($_POST['b_id']));
//   if(!empty($tr_id) && !empty($mode)){
//     if($mode=='Account'){
//       $_SESSION['tr_id']=$tr_id;
//       $_SESSION['bonus_id']=$b_id;
//       $_SESSION['inv_mode']='Bitcoin';
//       $_SESSION['tbl_mode']='investments';
//       $_SESSION['cash_mode']='bonus';
//       echo "<script> window.location='cash_out_account.php'; </script>";
//     }elseif($mode=='Wallet'){
//       $_SESSION['tr_id']=$tr_id;
//       $_SESSION['bonus_id']=$b_id;
//       $_SESSION['inv_mode']='Bitcoin';
//       $_SESSION['tbl_mode']='investments';
//       $_SESSION['cash_mode']='bonus';
//       echo "<script> window.location='cash_out_wallet.php'; </script>";
//     }
//   }else{
//     //error fill in... 
//     echo "<script> alert('Incorrect Submission, choose correctly!'); window.location='withdrawal.php'; </script>";
//   }
// }
?> 

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Active Cash Logs
      </h1>
      <ol class="breadcrumb">
        <li><a href="../index.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Active cash logs</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <div class="box" style="overflow:auto;">
<?php
$query = User::find_sql("SELECT * FROM invested WHERE user_id='{$session->user_id}' AND status=1 AND w_status=0 ORDER BY id DESC");
$count=1;
if($db_init->num_rows($query)>0){
?>
                <div class="box-header">
                  <h3 class="box-title">User Active Transactions</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped table-responsive">
                      <!-- History headings-->
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Amount</th>
                      <th>Bonus</th>
                      <th>Withdrawal Mode</th>
                      <th>ALL BALANCE</th>
                      <th>BONUS</th>
                    </tr>
                    </thead>
                    <tbody>
                        <!-- Loop the row-->
                        <!-- First row-->                
<?php
  while($row=$db_init->fetch_array($query)){
    $amount = $row['amount'];
    $invest_id = $row['id'];
    $bonus_q = User::find_sql("SELECT * FROM bonus WHERE user_id='{$session->user_id}' AND inv_id='{$invest_id}'");
    if($db_init->num_rows($bonus_q)==1){
      while($col=$db_init->fetch_array($bonus_q)){
        $b_id = $col['id'];
        $bonus_amount = $col['main_bonus'];
        $w_status=$col['w_status'];
      }
    }else{
      $bonus_amount = 0;
    }

    $created = $row['created'];
?>
                    <tr>
                    <form role="form" method="POST" action="">
                      <td><?php echo $count; ?></td>
                      <td><i class="fa fa-usd"></i><?php echo $amount; ?></td>
                      <td><i class="fa fa-usd"></i><?php echo $bonus_amount; ?></td>
                      <td>
                      <div class="row">
                      <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6"><input type="radio" name="mode" value="Account" > Provide Account Details</div>
                      <div class="col-md-6 col-lg-6 col-xs-6 col-sm-6"><input type="radio" name="mode" value="Wallet" > Provide Wallet Id</div>
                      </div>
                      </td>
                      
                         
                      
                        <input type="hidden" name="inv_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="b_id" value="<?php echo $b_id; ?>">
                        <td style="text-align:center"><button type="submit" name="cash_main_a" class="btn btn-warning btn-block"><i class="fa fa-check"></i> Cash Out</button></td>
                        <?php if($w_status==1 || $bonus_amount==0){ ?>
                          <td style="text-align:center"><button type="" name="" class="btn btn-danger btn-block" disabled><i class="fa fa-close"></i> Not Available</button></td>
                        <?php }else{ ?>
                          <td style="text-align:center"><button type="submit" name="cash_bonus_a" class="btn btn-success btn-block"><i class="fa fa-check"></i> Bonus Cash-Out</button></td>
                        <?php } ?>
                    </form>
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
    echo "No Logs!";
  }
?>
              </div>

        </div>
        <!--/.col (left) -->

      </div>
     
    </section>
    <!-- /.content -->
    
  </div>
  <!-- /.content-wrapper -->
  <?php require_once('joins/footer.php'); ?>