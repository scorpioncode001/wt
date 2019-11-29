<?php require_once('joins/header.php'); ?>
<?php
if(isset($_POST['invest'])){
    $amount = $db_init->escape(htmlentities($_POST['amount']));
    $btc = $db_init->escape(htmlentities($_POST['btc']));
    if(!empty($amount) && $amount<15){
      echo "<script> alert('Amount can not be less than $15!'); window.location='invest.php'; </script>";
      exit();
    }

    if($btc=='Yes'){
    if(!empty($amount)){
        $get_wallet_id = User::find_sql("SELECT wallet_id FROM wallets WHERE status=1 LIMIT 1");
        if($db_init->num_rows($get_wallet_id)==1){
            while($row=$db_init->fetch_array($get_wallet_id)){
            $wallet = $row['wallet_id'];
            $_SESSION['wallet_id'] = $wallet;
            }
        }
        #conversions...
        $api="1624e51bd2836c627954b292c79eee92";
        $string = file_get_contents("http://data.fixer.io/api/latest?access_key=$api&format=1");
        $json = json_decode($string, true);

        //{.....
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
        //....}

        $invest_q = User::find_sql("INSERT INTO invested SET full_name='{$full_name}', email='{$email}', user_id='{$session->user_id}', invest_type='Bitcoin', amount='{$amount}', paidAt=NOW(), reference='{$wallet}', equivalent_btc='{$equivalent_value_btc}' ");
        if($invest_q){
          #procced to notification page containing the generated wallet id to complete payment
          $amount = $db_init->escape(htmlentities($_POST['amount']));
          $_SESSION['payer_amount'] = $amount;
          $_SESSION['btc_value'] = $equivalent_value_btc;
          $_SESSION['type'] = 'Bitcoin';

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
        $mail->addAddress($email);
        $mail->Subject = 'WESTERN TRADE BTC';
        $mail ->AddEmbeddedImage('../images/wt_logo.png', 'logoimg');
        $mail->MsgHTML(User::send_wallet_id($amount, $equivalent_value_btc, $wallet));
        if ($mail->send())
            echo "<script> window.location='confirm-invest.php'; </script>";
          }

    }else{
        echo "<script> alert('all fields must be filled out correctly!'); window.location='invest.php'; </script>";
    }

    }
    // $query = User::find_sql("SELECT * FROM invested WHERE user_id='$session->user_id' AND email='$email' AND status=1 LIMIT 1");
    // if($db_init->num_rows($query)==1){

    // }
    // if(!is_numeric($amount)){
    //   echo "<script> alert('Must be an Integer Value!'); window.location='invest.php'; </script>";
    //   exit();
    // }
    else{
      if($continent=='Africa'){#conversions...
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
            if($currency[$i]=='NGN'){
              $to_key=$i;
            }
        }
        
        $from=$from_key;
        $to= $to_key;
        $combine=array_combine($currency, $rate);
        $from_currency=$rate[$from];
        $to_currency=$rate[$to];
        $result=$to_currency/$from_currency;
        $resultrev=$from_currency/$to_currency;

        $output = $result*$amount;
        $reverse= $resultrev*$amount;

        $amount_ngn = $output;

        $_SESSION['payer_amount'] = ceil($amount_ngn);
        $_SESSION['payer_usd'] = $amount;
        echo "<script> window.location='new-invest.php';</script>";
      }else{
        $_SESSION['payer_amount'] = $amount;
        echo "<script> window.location='new-invest.php';</script>";
        // sdbox = sb-xktgq415671@business.example.com
        // id = ARtf1SDeczaiIXFdFaFtXipQoObF9pdCBqEEZgxisjLFNt5bWNhD38omxxBZovsbgxBsx3ahTxsBmWJu
        // secret = EEBpp4UhJhTgAqSB1kt8l0lXr1APSFBNm1BBWM2oULymy9w0pXSs8zue1GTQn1S-9CYR4ZI86l35J9Yi
        //paypal mode
        #<!-- PASTE HERE YOUR FORM CODE FROM PAYPAL -->
        // echo "
        //   $('#paypal_button').click();
        // ";

        #redirect to a paypal button page

      }
    }

    
}
?>
<?php

?>
<?php require_once('joins/nav.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Make New Investment
      </h1>
      <ol class="breadcrumb">
        <li><a href="../index.html"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">New investment</li>
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
              <h3 class="box-title">Enter desired amount</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="">
              <div class="box-body">
                <div class="box-body">

                <div class="form-group">
                  <label for="exampleInputEmail1">Amount(<i class="fa fa-usd"></i>)</label>
                  <input name="amount" type="number" class="form-control" placeholder="Enter amount">
                </div>
                <div class="form-group">
                  <label for="exampleInputRadio">Pay Using Bitcoin(<i class="fa fa-btc"></i>)</label>
                  <select name="btc" id="" class="form-control">
                  <option value="No">No</option>
                  <option value="Yes">Yes</option>
                  </select>
                </div>
              </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer text-center">
                <button type="submit" name="invest" class="btn btn-primary ">Proceed</button>
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