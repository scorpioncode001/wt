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
if(isset($_SESSION['payer_amount'])){
  // $type = $_SESSION['type'];
  if($continent=='Africa' && !isset($_SESSION['btc_value'])){
    // $insert_q=User::find_sql("INSERT INTO invested SET user_id='{$session->user_id}', full_name='{$full_name}', invest_type='Paystack', created=NOW()");
    // if($insert_q){
    //   unset($_SESSION['type']);
    // }
    $result = array();
    //The parameter after verify/ is the transaction reference to be verified
    if(isset($_GET['reference'])){
      $type = "Paystack";
      $redirected_reference = $_GET['reference'];
      $url = "https://api.paystack.co/transaction/verify/$redirected_reference";
      $get_key = User::get_paystack_secret_key();
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt(
        $ch, CURLOPT_HTTPHEADER, [
          "Authorization: Bearer $get_key"]
      );
      $request = curl_exec($ch);
      if(curl_error($ch)){
      echo 'error:' . curl_error($ch);
      }
      curl_close($ch);

      if ($request) {
        $result = json_decode($request, true);
        // if($result){
        //   if($result['data']){
        //     if($result['data']['status']=='success'){
        //       // echo "<script> alert('Transaction was successful'); </script>";
        //     }else{
        //       echo "Transaction was not successful: Last gateway response was: ".$result['data']['gateway_response'];
        //     }
        //   }else{
        //     echo $result['message'];
        //   }
        // }
      }

      if (array_key_exists('data', $result) && array_key_exists('status', $result['data']) && ($result['data']['status'] === 'success')) {
        $transaction = $result['data'];
        //$reference = $result['reference'];
        $tr_fname = $transaction['customer']['first_name'];
        $tr_lname = $transaction['customer']['last_name'];
        if(empty($tr_fname) || empty($tr_lname)){
          $tr_full_name = $fname." ".$lname;
        }else{
          $tr_full_name = $tr_fname." ".$tr_lname;
        }
        $tr_email = $transaction['customer']['email'];
        $tr_amount = $_SESSION['payer_usd']; //$transaction['amount']/100;
        $tr_reference = $transaction['reference'];
        $tr_paidAt = $transaction['paidAt'];

        $check_db = User::find_sql("SELECT * FROM invested WHERE reference='{$tr_reference}' LIMIT 1");
        if($db_init->num_rows($check_db)==1){
          //scammer
          echo "<script> window.location='index.php'; </script>";
          // exit();
        }else{
        #store details, confirm and credit;
          $store_db = User::find_sql("INSERT into invested SET user_id='{$session->user_id}', full_name='{$tr_full_name}', email='{$email}', amount='{$tr_amount}', invest_type='Paystack', reference='{$tr_reference}', paidAt='{$tr_paidAt}', status=1, created=NOW()");
          if($store_db){
            $percent = User::get_percent();
            $tr_bonus = $percent*$tr_amount;
            $insert_id = $db_init->insert_id();
            $insert_q= User::find_sql("INSERT INTO bonus SET user_id='{$session->user_id}', inv_id='{$insert_id}', inv_type='Paystack', bonus='0', default_bonus='{$tr_bonus}', main_bonus='0', cashed_out='0', date=NOW()");
            $get_user_info_q=User::find_sql("SELECT * FROM ecnalab WHERE user_id='{$user_id}'");
            if($db_init->num_rows($get_user_info_q)==1){
                while($column=$db_init->fetch_array($get_user_info_q)){
                    $user_balance=$column['ecnalab']+$tr_amount;
                    $credit_q=User::find_sql("UPDATE ecnalab SET ecnalab='{$user_balance}' WHERE user_id='{$user_id}'");
                }
            }elseif($db_init->num_rows($get_user_info_q)==0){
              $user_balance = $tr_amount;
                $credit_q=User::find_sql("INSERT INTO ecnalab SET user_id='{$user_id}', ecnalab='{$tr_amount}', updated=NOW()");
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
            if($credit_q){
                //send mail message here...
                $message2 = "
                Account Credit from Paystack transaction <br>
                Amount: $$tr_amount <br>
                Balance: $$user_balance
                ";
                $insert_mail = User::find_sql("INSERT INTO contact_response SET user_id='$session->user_id', message='$message2', created=NOW()");
                if($insert_mail){
                  unset($_SESSION['payer_amount']);
                  unset($_SESSION['payer_usd']);
                  echo "<script> alert_func('success', 'Transaction was successful!', 'index.php'); </script>";
                }
            }
          }
        }
        
      }else{
        echo "<script> alert_func('success', 'Transaction was unsuccessful', 'index.php'); </script>";
      }
    }
  }elseif(isset($_GET['orderID'])){
      $uri = 'https://api.sandbox.paypal.com/v1/oauth2/token';
      //for live production use $uri = 'https://api.paypal.com/v1/oauth2/token';

      $clientId = User::get_paypal_key();
      $secret = User::get_paypal_secret_key();
      $redirected_orderID = $_GET['orderID'];

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, $uri);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_SSLVERSION , 6); //NEW ADDITION
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
      curl_setopt($ch, CURLOPT_USERPWD, $clientId.":".$secret);
      curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

      $result = curl_exec($ch);
      $access_token = '';
      if(empty($result))die("Error: No response.");
      else
      {
          $json = json_decode($result);
          $access_token = $json->access_token;
      }

      curl_close($ch);


      $url = "https://api.sandbox.paypal.com/v2/checkout/orders/$redirected_orderID";
      $accessToken=$access_token;
      $curl = curl_init($url);
      curl_setopt($curl, CURLOPT_POST, false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curl, CURLOPT_HEADER, false);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'Authorization: Bearer ' . $accessToken,
          'Accept: application/json',
          'Content-Type: application/json'
      ));
      $response = curl_exec($curl);
      if ($response) {
        $transaction = json_decode($response, true);
        if(array_key_exists('payer', $transaction) && array_key_exists('status', $transaction) && ($transaction['status'] === 'COMPLETED')){
          $tr_fname = $transaction['payer']['name']['given_name'];
          $tr_lname = $transaction['payer']['name']['surname'];
          $tr_full_name = $tr_fname." ".$tr_lname;
          $tr_email = $transaction['payer']['email_address'];
          $tr_amount = $transaction['purchase_units'][0]['amount']['value']; //$transaction['amount']/100;
          $tr_reference = $transaction['id'];
          $tr_paidAt = date('Y-m-d h:i:s', strtotime($transaction['create_time']));
          //echo $tr_fname."<br>".$tr_lname."<br>".$tr_full_name."<br>".$tr_email."<br>".$tr_amount."<br>".$tr_reference."<br>".$tr_paidAt;
      
          $check_db = User::find_sql("SELECT * FROM invested WHERE reference='{$tr_reference}' LIMIT 1");
              if($db_init->num_rows($check_db)==1){
                //scammer
                echo "<script> window.location='index.php'; </script>";
                // exit();
              }else{
              #store details, confirm and credit;
                $store_db = User::find_sql("INSERT into invested SET user_id='{$session->user_id}', full_name='{$tr_full_name}', email='{$email}', amount='{$tr_amount}', invest_type='Paypal', reference='{$tr_reference}', paidAt='{$tr_paidAt}', status=1, created=NOW()");
                if($store_db){
                  $percent = User::get_percent();
                  $tr_bonus = $percent*$tr_amount;
                  $insert_id = $db_init->insert_id();
                  $insert_q= User::find_sql("INSERT INTO bonus SET user_id='{$session->user_id}', inv_id='{$insert_id}', inv_type='Paypal', bonus='0', default_bonus='{$tr_bonus}', main_bonus='0', cashed_out='0', date=NOW()");
                  $get_user_info_q=User::find_sql("SELECT * FROM ecnalab WHERE user_id='{$user_id}'");
                  if($db_init->num_rows($get_user_info_q)==1){
                      while($column=$db_init->fetch_array($get_user_info_q)){
                          $user_balance=$column['ecnalab']+$tr_amount;
                          $credit_q=User::find_sql("UPDATE ecnalab SET ecnalab='{$user_balance}' WHERE user_id='{$user_id}'");
                      }
                  }elseif($db_init->num_rows($get_user_info_q)==0){
                      $credit_q=User::find_sql("INSERT INTO ecnalab SET user_id='{$user_id}', ecnalab='{$tr_amount}', updated=NOW()");
                      $user_balance = $tr_amount;
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
                  if($credit_q){
                      //send mail message here...
                      $message2 = "
                      Account Credit from PayPal transaction <br>
                      Amount: $$tr_amount <br>
                      Balance: $$user_balance
                      ";
                      $insert_mail = User::find_sql("INSERT INTO contact_response SET user_id='$session->user_id', message='$message2', created=NOW()");
                      if($insert_mail){
                        unset($_SESSION['payer_amount']);
                        echo "<script> alert_func('success', 'Transaction was successful!', 'index.php'); </script>";
                      }
                  }
                }
              }
        
        }
      
      }
  }elseif(isset($_SESSION['btc_value'])){
    $type = $_SESSION['type'];
    $dollar = $_SESSION['payer_amount'];
    $btc = $_SESSION['btc_value'];
    $wallet = $_SESSION['wallet_id'];
  }
}else{
  echo "<script> window.location='index.php'; </script>";
}
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="../index.php"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-8 col-md-offset-2">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">IMPORTANT</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                    <div class="callout callout-warning" >
                    <?php if($type=='Bitcoin'){ ?>
                      <h3>Your payments details are...</h3>
                      <h4 style="color:#111111">
                          Wallet Id: <?php echo $wallet; ?><br>
                          Amount In Dollar: <?php echo $dollar; ?><br>
                          Amount In Bitcoin: <?php echo $btc; ?>,<br><br><br>
                          Also an email has been sent to your mail containing the above mentioned<br> 
                          informations for you to complete your payments.
                        </h4>
                      <?php 
                          unset($_SESSION['payer_amount']);
                          unset($_SESSION['btc_value']);
                          unset($_SESSION['wallet_id']);
                          unset($_SESSION['type']);
                          }
                      ?>
                            <p style="color:#111111">Please Take Note !</p>
                          </div>
            </div>
          </div>
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php require_once('joins/footer.php'); ?>