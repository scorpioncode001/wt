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
if(isset($_POST['wallet_submit'])){
    $wallet_id=$db_init->escape(htmlentities($_POST['wallet_id']));
    if(!empty($wallet_id)){
        $api="1624e51bd2836c627954b292c79eee92";
        $string = file_get_contents("http://data.fixer.io/api/latest?access_key=$api&format=1");
        $json = json_decode($string, true);
      
        $i=0;
        foreach ($json['rates'] as $key => $value) {
            $currency[$i]=$key;
            $rate[$i]=$value;
            $i=$i+1;
        }
        for($i=0;$i<count($rate);$i++){
            if($currency[$i]=='USD'){
              $from_key=$i;
            }
        }
        for($i=0;$i<count($rate);$i++){
            if($currency[$i]=='BTC'){
              $to_key=$i;
            }
        }
        $amount = $_SESSION['tr_amount'];
        $from=$from_key;
        $to= $to_key;
        $combine=array_combine($currency, $rate);
        $from_currency=$rate[$from];
        $to_currency=$rate[$to];
        $result=$to_currency/$from_currency;
        $resultrev=$from_currency/$to_currency;
      
        $output = $result*$amount;
        $reverse= $resultrev*$amount;
      
        $equivalent_value_btc = round($output, 10, PHP_ROUND_HALF_UP);
      
      
        if(!empty($wallet_id) && !empty($amount)){
          if(!isset($_SESSION['tr_id']) || !isset($_SESSION['tbl_mode']) || !isset($_SESSION['cash_mode']) || !isset($_SESSION['inv_mode'])){
              echo "<script> window.location='index.php'; </script>";
          }else{
              $amount = $_SESSION['tr_amount'];
              $tr_id = $_SESSION['tr_id'];    //investments or invested id
              $inv_mode = $_SESSION['inv_mode'];  //Paystack or Bitcoin
              $cash_mode = $_SESSION['cash_mode']; //main or bonus
              $tbl_mode = $_SESSION['tbl_mode'];  //investments or invested
          
              if($cash_mode=='main'){
                  $confirm_balance_q = User::find_sql("SELECT ecnalab FROM ecnalab WHERE user_id='{$session->user_id}' LIMIT 1");
                  if($db_init->num_rows($confirm_balance_q)==1){
                      while($row=$db_init->fetch_array($confirm_balance_q)){
                          $user_current_balance=$row['ecnalab'];  //getbonus and add up
      
                          $bonus_id = $_SESSION['bonus_id'];
                          $bonus_q = User::find_sql("SELECT * FROM bonus WHERE id='{$bonus_id}' AND user_id='{$session->user_id}' AND inv_id='{$tr_id}' AND inv_type='{$inv_mode}' AND w_status=0");
                          if($db_init->num_rows($bonus_q)==1){
                              while($col=$db_init->fetch_array($bonus_q)){
                                  $tr_balance = $col['main_bonus']+$user_current_balance;
                              }
                          }else{
                              $tr_balance = $user_current_balance;
                          }
                      }
                      
                      if($tr_balance<$amount){
                          //MAKE PUP UP
                          echo "<script> alert_func('warning', 'You do not have sufficient fund!', 'index.php'); </script>";
                        //   die();
                      }else{
                          $query = User::find_sql("INSERT INTO payments SET bonus_id='{$bonus_id}', tbl_mode='{$tbl_mode}', tbl_id='{$tr_id}', w_type='main', user_id='{$session->user_id}', payment_type='Bitcoin',  amount='{$amount}', requested=NOW(), wallet_id='{$wallet_id}', amount_usd='{$amount}', amount_btc='{$equivalent_value_btc}'");
                          if($query){
                              $update_q=User::find_sql("UPDATE $tbl_mode SET w_status=1 WHERE id='{$tr_id}'");
                              $update_q=User::find_sql("UPDATE bonus SET w_status=1 WHERE id='{$bonus_id}'");
                              unset($_SESSION['tr_amount']);
                              unset($_SESSION['tr_id']);
                              unset($_SESSION['inv_mode']);
                              unset($_SESSION['cash_mode']);
                              unset($_SESSION['tbl_mode']);
                              echo "<script> window.location='confirm-withdraw.php'; </script>";
                          }
                      }
                  }else{
                    echo "<script> alert_func('warning', 'You do not have sufficient fund!', 'index.php'); </script>";
                    // die();
                  }
              }elseif($cash_mode=='bonus'){
                  $bonus_id = $_SESSION['bonus_id'];  //bonus tbl id
      
                  $bonus_q = User::find_sql("SELECT * FROM bonus WHERE id='{$bonus_id}' AND user_id='{$session->user_id}' AND inv_id='{$tr_id}' AND inv_type='{$inv_mode}'");
                  if($db_init->num_rows($bonus_q)==1){
                      while($col=$db_init->fetch_array($bonus_q)){
                          if($col['status']==0){
                              $tr_amount = $col['main_bonus'];
                          }else{
                              echo "<script> alert_func('warning', 'You do not have any bonus left on this transaction!', 'withdrawal.php'); </script>";
                            //   die();
                          }
                      }
                      if($tr_amount<$amount){
                        echo "<script> alert_func('warning', 'You do not have sufficient fund!', 'withdrawal.php'); </script>";
                        // die();
                      }else{
                          $query = User::find_sql("INSERT INTO payments SET bonus_id='{$bonus_id}', tbl_mode='{$tbl_mode}', tbl_id='{$tr_id}', w_type='bonus', user_id='{$session->user_id}', payment_type='Local Account',  amount='{$amount}', requested=NOW(), bank='{$bank_name}', acc_name='{$acc_name}', acc_number='{$acc_no}'");
                          if($query){
                              $update_q=User::find_sql("UPDATE bonus SET w_status=1 WHERE id='{$bonus_id}'");
                              unset($_SESSION['tr_amount']);
                              unset($_SESSION['tr_id']);
                              unset($_SESSION['inv_mode']);
                              unset($_SESSION['cash_mode']);
                              unset($_SESSION['tbl_mode']);
                              echo "<script> window.location='confirm-withdraw.php'; </script>";
                          }
                      }
                  }else{
                      echo "<script> window.location='withdrawal.php'; </script>";
                  }
              }
          }
        }
      
          
      }else{
        echo "<script> alert_func('warning', 'all fields must be filled out correctly!', 'cash_out_wallet.php'); </script>";
      }
    }



if(!isset($_SESSION['tr_id']) || !isset($_SESSION['tbl_mode']) || !isset($_SESSION['cash_mode']) || !isset($_SESSION['inv_mode'])){
    echo "<script> window.location='index.php'; </script>";
}else{
    $tr_id = $_SESSION['tr_id'];    //investments or invested id
    $inv_mode = $_SESSION['inv_mode'];  //Paystack or Bitcoin
    $cash_mode = $_SESSION['cash_mode']; //main or bonus
    $tbl_mode = $_SESSION['tbl_mode'];  //investments or invested

    if($cash_mode=='main'){
        $query=User::find_sql("SELECT * FROM $tbl_mode WHERE user_id='{$session->user_id}' AND id='{$tr_id}'");
        if($db_init->num_rows($query)==1){
            while($row=$db_init->fetch_array($query)){
                $tr_amount = $row['amount'];
            }
        }else{
            //error
            echo "<script> window.location='withdrawal.php'; </script>";
        }
        $bonus_id = $_SESSION['bonus_id'];  //bonus tbl id
        $bonus_q = User::find_sql("SELECT * FROM bonus WHERE id='{$bonus_id}' AND user_id='{$session->user_id}' AND inv_id='{$tr_id}' AND inv_type='{$inv_mode}' AND w_status=0");
        if($db_init->num_rows($bonus_q)==1){
            while($col=$db_init->fetch_array($bonus_q)){
                $tr_amount += $col['bonus'];
            }
        }else{
            $tr_balance = $user_current_balance;
        }
    }elseif($cash_mode=='bonus'){
        $bonus_id = $_SESSION['bonus_id'];  //bonus tbl id
        $bonus_q = User::find_sql("SELECT * FROM bonus WHERE id='{$bonus_id}' AND user_id='{$session->user_id}' AND inv_id='{$tr_id}' AND inv_type='{$inv_mode}'");
        if($db_init->num_rows($bonus_q)==1){
            while($col=$db_init->fetch_array($bonus_q)){
                $tr_amount = $col['bonus'];
            }
        }else{
            echo "<script> window.location='withdrawal.php'; </script>";
        }
    }
    // unset();
    // unset();
}
$_SESSION['tr_amount'] = $tr_amount;
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Withdraw Cash
    </h1>
    <ol class="breadcrumb">
      <li><a href="../index.html"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Withdraw</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <!-- left column -->
      <div class="col-md-6">
        <!-- Horizontal Form -->
        <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Enter Wallet Details</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <!-- form start -->
            <form role="form" method="POST" action="">
              <div class="box-body">
                <div class="form-group">
                  <label>Wallet ID &nbsp;<i class="fa fa-id-badge"></i></label>
                  <input name="wallet_id" type="text" class="form-control" placeholder="Enter ID">
                </div>
                <div class="form-group">
                        <label>Amount:  </label>
                        <h5><i class="fa fa-usd"></i><?php echo $tr_amount; ?></h5>
                      </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="wallet_submit">Proceed</button>
              </div>
            </form>
        </div>
        
        <!-- /.box -->
      </div>
      <div class="col-md-6">

          <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Bitcoin Converter</h3>
                </div>

                <form class="form-horizontal">
                  <div class="box-body">
                    <coingecko-coin-converter-widget  coin-id="bitcoin" currency="usd" background-color="#ffffff" font-color="#4c4c4c" locale="en"></coingecko-coin-converter-widget>
                  </div>
                </form>

          </div>

        </div>
      <!--/.col (right) -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php require_once('joins/footer.php'); ?>