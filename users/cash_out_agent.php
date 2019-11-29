
<?php require_once('joins/header.php'); ?>
<?php require_once('joins/nav.php'); ?>
<!-- content Wrapper. Contains page content -->
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
      <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Enter Account Details</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <?php if($_SESSION['mode']=='Account') {?>
              <form role="form" method="POST" action="">
                <div class="box-body">
                    <div class="form-group">
                      <label>Bank Name&nbsp;<i class="fa fa-bank"></i></label>
                      <input name="bank_name" type="text" class="form-control" placeholder="Bank name" required>
                    </div>
                    <div class="form-group">
                      <label>Account Name&nbsp;<i class="fa fa-bank"></i></label>
                      <input name="acc_name" type="text" class="form-control" placeholder="Account name" required>
                    </div>
                    <div class="form-group">
                      <label>Account Number &nbsp;<i class="fa fa-money"></i></label>
                      <input name="acc_no" type="text" class="form-control" placeholder="Account number" required>
                    </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Amount: </label>
                    <h5><i class="fa fa-usd"></i><?php echo $agent_balance; ?></h5>
                  </div>
                </div>
                <!-- /.box-body -->
  
                <div class="box-footer">
                  <button type="submit" name="local_submit" class="btn btn-primary">Proceed</button>
                </div>
              </form>
              <?php }elseif($_SESSION['mode']=='Wallet'){ ?>
                <form role="form" method="POST" action="">
              <div class="box-body">
                <div class="form-group">
                  <label>Wallet ID &nbsp;<i class="fa fa-id-badge"></i></label>
                  <input name="wallet_id" type="text" class="form-control" placeholder="Enter ID">
                </div>
                <div class="form-group">
                        <label>Amount:  </label>
                        <h5><i class="fa fa-usd"></i><?php echo $agent_balance; ?></h5>
                      </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="wallet_submit">Proceed</button>
              </div>
            </form>
              <?php }else{
                  echo "<script> window.location='apply_agent.php'; </script>";
              } ?>
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
<?php 
if(!isset($_SESSION['mode'])){
    echo "<script> window.location='apply_agent.php'; </script>";
}

if(isset($_POST['local_submit'])){
    $bank_name=$db_init->escape(htmlentities($_POST['bank_name']));
    $acc_name = $db_init->escape(htmlentities($_POST['acc_name']));
    $acc_no=$db_init->escape(htmlentities($_POST['acc_no']));
    $details = "
        Bank Name: $bank_name
        Account Name: $acc_name
        Account Number: $acc_no
        ";
    // echo $bank_name;
    if(!empty($bank_name) && !empty($acc_name) && !empty($acc_no) && $agent_balance != 0){
        if($_SESSION['mode']=='Account'){
            $query = User::find_sql("INSERT INTO agent_pay SET user_id='{$session->user_id}', payment_type='Bank Payment', amount='{$agent_balance}', requested=NOW(), details='{$details}'");
            if($query){
                $update = User::find_sql("UPDATE agents SET bonus=bonus-$agent_balance WHERE user_id='{$session->user_id}'");
                echo "<script> alert_func('success', 'Details submitted successfully for payment!', 'confirm-withdraw.php'); </script>";
                unset($_SESSION['mode']);
            }
        }else{
            echo "<script> alert_func('warning', 'Network Timeout!', 'apply_agent.php'); </script>";
        }
    }else{
        echo "<script> alert_func('warning', 'Network Timeout!', 'apply_agent.php'); </script>";
    }
}
if(isset($_POST['wallet_submit'])){
    $wallet_id=$db_init->escape(htmlentities($_POST['wallet_id']));
    $details = "
        Wallet Id: $wallet_id
        ";

    if(!empty($wallet_id) && $agent_balance != 0){
        if($_SESSION['mode']=='Wallet'){
            $query = User::find_sql("INSERT INTO agent_pay SET user_id='{$session->user_id}', payment_type='Bitcoin', amount='{$amount}', requested=NOW(), details='{$details}'");
            if($query){
                unset($_SESSION['mode']);
                echo "<script> alert_func('success', 'Details submitted successfully for payment!', 'confirm-withdraw.php'); </script>";
            }
        }else{
            echo "<script> alert_func('warning', 'Network Timeout!', 'apply_agent.php'); </script>";
        }
    }else{
        echo "<script> alert_func('warning', 'Network Timeout!', 'apply_agent.php'); </script>";
    }
}

?>