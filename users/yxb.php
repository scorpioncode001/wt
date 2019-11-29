<?php require_once('joins/header.php'); ?>
<?php require_once('joins/nav.php'); ?>
<?php
if(isset($_POST['wallet_submit'])){
  $wallet_id=$db_init->escape(htmlentities($_POST['wallet_id']));

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
      if($currency[$i]=='NGN'){
        $from_key=$i;
      }
  }
  for($i=0;$i<count($rate);$i++){
      if($currency[$i]=='USD'){
        $to_key=$i;
      }
  }
  $amount = $db_init->escape(htmlentities($_POST['amount']));
  $from=$from_key;
  $to= $to_key;
  $combine=array_combine($currency, $rate);
  $from_currency=$rate[$from];
  $to_currency=$rate[$to];
  $result=$to_currency/$from_currency;
  $resultrev=$from_currency/$to_currency;

  $output = $result*$amount;
  $reverse= $resultrev*$amount;

  $equivalent_value_dollar = $output;

  $i=0;
  foreach ($json['rates'] as $key => $value) {
      $currency[$i]=$key;
      $rate[$i]=$value;
      $i=$i+1;
  }
  for($i=0;$i<count($rate);$i++){
      if($currency[$i]=='NGN'){
        $from_key=$i;
      }
  }
  for($i=0;$i<count($rate);$i++){
      if($currency[$i]=='BTC'){
        $to_key=$i;
      }
  }
  $amount = $db_init->escape(htmlentities($_POST['amount']));
  $from=$from_key;
  $to= $to_key;
  $combine=array_combine($currency, $rate);
  $from_currency=$rate[$from];
  $to_currency=$rate[$to];
  $result=$to_currency/$from_currency;
  $resultrev=$from_currency/$to_currency;

  $output = $result*$amount;
  $reverse= $resultrev*$amount;

  $equivalent_value_btc = $output;


  if(!empty($wallet_id) && !empty($amount)){
    $confirm_balance_q = User::find_sql("SELECT ecnalab FROM ecnalab WHERE user_id='{$session->user_id}' LIMIT 1");
    if($db_init->num_rows($confirm_balance_q)==1){
      while($row=$db_init->fetch_array($confirm_balance_q)){
        $user_current_balance=$row['ecnalab'];
      }
      if($user_current_balance<$amount){
        //MAKE PUP UP
        echo "<script> alert('Insufficient fund!'); window.location='index.php'; </script>";
        die();
      }else{
        $query = User::find_sql("INSERT INTO payments SET amount_usd='{$equivalent_value_dollar}', amount_btc='{$equivalent_value_btc}', wallet_id='{$wallet_id}', user_id='{$session->user_id}', payment_type='Bitcoin',  amount='{$amount}', requested=NOW()");
        if($query){
          echo "<script> alert('Your withdrawal request has been created, an email will be sent to you shortly once the payment is confirmed and made withing 24 hours!'); window.location='index.php'; </script>";
        }
      }
    }else{
      echo "<script> alert('Insufficient fund!'); window.location='index.php'; </script>";
      die();
    }
  }else{
    echo "<script> alert('All fields must be filled out!'); window.location='cash-out.php'; </script>";
  }
}

if(isset($_POST['local_submit'])){
  $bank_name=$db_init->escape(htmlentities($_POST['bank_name']));
  $acc_name = $db_init->escape(htmlentities($_POST['acc_name']));
  $acc_no=$db_init->escape(htmlentities($_POST['acc_no']));
  $amount = $db_init->escape(htmlentities($_POST['amount']));

  if(!empty($bank_name) && !empty($acc_no) && !empty($amount) && !empty($acc_name)){
    $confirm_balance_q = User::find_sql("SELECT ecnalab FROM ecnalab WHERE user_id='{$session->user_id}' LIMIT 1");
    if($db_init->num_rows($confirm_balance_q)==1){
      while($row=$db_init->fetch_array($confirm_balance_q)){
        $user_current_balance=$row['ecnalab'];
      }
      if($user_current_balance<$amount){
        //MAKE PUP UP
        echo "<script> alert('You do not have sufficient fund!'); window.location='index.php'; </script>";
        die();
      }else{
        $query = User::find_sql("INSERT INTO payments SET user_id='{$session->user_id}', payment_type='Local Account',  amount='{$amount}', requested=NOW(), bank='{$bank_name}', acc_name='{$acc_name}', acc_number='{$acc_no}'");
        if($query){
          echo "<script> window.location='confirm-withdraw.php'; </script>";
        }
      }
    }else{
      echo "<script> alert('You do not have sufficient fund!'); window.location='index.php'; </script>";
      die();
    }
  }else{
    echo "<script> alert('All fields must be filled out!'); window.location='cash-out.php'; </script>";
  }
}
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
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Wallet ID</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="">
              <div class="box-body">
                <div class="form-group">
                  <label>Wallet ID &nbsp;<i class="fa fa-id-badge"></i></label>
                  <input name="wallet_id" type="text" class="form-control" placeholder="Enter ID">
                </div>
                <div class="form-group">
                        <label>Amount (₦) </label>
                        <input name="amount" type="number" class="form-control"placeholder="Enter amount">
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
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Local Account</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="POST" action="">
                  <div class="box-body">
                      <div class="form-group">
                        <label>Bank Name&nbsp;<i class="fa fa-bank"></i></label>
                        <input name="bank_name" type="text" class="form-control" placeholder="Bank name">
                      </div>
                      <div class="form-group">
                        <label>Account Name&nbsp;<i class="fa fa-bank"></i></label>
                        <input name="acc_name" type="text" class="form-control" placeholder="Account name">
                      </div>
                      <div class="form-group">
                        <label>Account Number &nbsp;<i class="fa fa-money"></i></label>
                        <input name="acc_no" type="text" class="form-control" placeholder="Account number">
                      </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Amount (₦) </label>
                      <input name="amount" type="number" class="form-control" placeholder="Enter amount">
                    </div>
                  </div>
                  <!-- /.box-body -->
    
                  <div class="box-footer">
                    <button type="submit" name="local_submit" class="btn btn-primary">Proceed</button>
                  </div>
                </form>
              </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php require_once('joins/footer.php'); ?>