<?php require_once('joins/header.php'); ?>
<?php require_once('joins/nav.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Make Your Payment
      </h1>
      <ol class="breadcrumb">
        <li><a href="../index.html"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Create Payment</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <!-- <h3 class="box-title">Enter desired amount</h3> -->
            </div>
            <!-- /.box-header -->
            <?php if($continent == 'Africa'){ ?>
            <!-- form start -->
            <form id="paymentForm">
            <script src="https://js.paystack.co/v1/inline.js"></script>
              <div class="box-body">
                <div class="box-body">
                <div class="form-group">
                  <button type="submit" class="btn btn-default"><img src="../images/paystack.png" alt="" srcset=""></button>
                </div>
                
              </div>
              </div>
            </form>
                
            <?php }else{ ?>
                <script src="https://www.paypal.com/sdk/js?client-id=ARtf1SDeczaiIXFdFaFtXipQoObF9pdCBqEEZgxisjLFNt5bWNhD38omxxBZovsbgxBsx3ahTxsBmWJu"></script>
                <div id="paypal-button-container"></div>
            <?php } ?>
          </div>
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <?php if($continent == 'Africa'){ ?>
    <script>
  var paymentForm = document.getElementById('paymentForm');
  paymentForm.addEventListener("submit", payWithPaystack, false);

  function payWithPaystack(e) {
    e.preventDefault();
    var setings = "<?php require_once('../ProcessPage/initialise.php') ?>";
    var handler = PaystackPop.setup({
      key: '<?php echo User::get_paystack_key(); ?>', // Replace with your public key
      email: '<?php echo $email; ?>',
      amount: '<?php echo $_SESSION["payer_amount"]; ?>' * 100,
      firstname: '<?php echo $fname; ?>',
      lastname: '<?php echo $lname; ?>',
      // ref: ''+Math.floor((Math.random() * 1000000000) + 1), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
      // label: "Optional string that replaces customer email"
      onClose: function(){
        alert('Transaction Terminated!');
      },
      callback: function(response){
        window.location = "<?php echo User::get_payment_redirect(); ?>?reference=" + response.reference;
      }
    });
    
    handler.openIframe();
  }
  </script>
    <?php }else{ ?>
      <script>
  paypal.Buttons({
    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: '<?php echo $_SESSION["payer_amount"]; ?>'
          }
        }]
      });
    },
    onApprove: function(data, actions) {
      return actions.order.capture().then(function(details) {
        window.location = "<?php echo User::get_payment_redirect(); ?>?orderID=" + data.orderID;
      });
    }
  }).render('#paypal-button-container');
</script>
      <?php } ?>
  
  
  <!-- /.content-wrapper //4JY48216GN723225D-->
  <?php require_once('joins/footer.php'); ?>