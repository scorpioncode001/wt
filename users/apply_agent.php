<?php require_once('joins/header.php'); ?>
<?php require_once('joins/nav.php'); ?>
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
if(isset($_POST['cash_out'])){
    $mode = $db_init->escape(htmlentities($_POST['mode']));
    $get_agent_balance = $agent_balance;
    if(!empty($mode) && !empty($get_agent_balance)){
        if($mode=='Account'){
            $_SESSION['mode']='Account';
        }elseif($mode=='Wallet'){
            $_SESSION['mode']='Wallet';
        }else{
            echo "<script> window.location='apply_agent.php'; </script>";
        }
        echo "<script> window.location='cash_out_agent.php'; </script>";
    }else {
        echo "<script> alert_func('warning', 'Insufficient fund!', ''); </script>";
    }
}

?>
  <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header" style="text-align:center">
                <h1>
                <?php if($agent_confirmed) { echo "Agent Qualified";}else{echo "Agent Qualifications";}?>
                    
                </h1>
                <ol class="breadcrumb">
                    <li><a href="./index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Agent</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-8 col-md-offset-2">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header with-border text-center">
                                <h3 class="box-title"> <h3 class="box-title"><?php if($agent_confirmed) { echo "Congratulations, Your details have been confirmed and we are happy to have you as our agent";}else{echo "To become an agent, you must be qualified with the following prospectus mentioned bellow";}?></h3>
                            </div>
                            <hr>
                            <?php if($agent_confirmed){ ?>
                                <div class="container" style="overflow:auto">
                                <form action="" method="post">
                                
                                <?php 
                                if($agent_confirmed){
                                    echo "<p><b>Number of Referals: $no_of_referals Referals<br>";
                                    if($agent_balance>0){
                                        echo '
                                        <div class="container" style="margin: 20px;">
                                            <input type="radio" name="mode" value="Account" > Provide Account Details <br>
                                            <input type="radio" name="mode" value="Wallet" > Provide Wallet Id <br>
                                            <button type="submit" name="cash_out" class="btn btn-success"><label class="label label-warning">Agent Balance: <i class="fa fa-usd"></i>'.$agent_balance.' </label>&nbsp;&nbsp;Cash Out</button>
                                        </div>
                                        ';
                                    }else{
                                        echo '<label class="label label-warning">Agent Balance: <i class="fa fa-usd"></i>'.$agent_balance.' </label>';
                                    }
                                    // echo '
                                    // <div class="row">
                                    //     <div class="col-md-12 form-group">
                                        
                                    //     </div>
                                    // </div>
                                    // ';
                                    // echo "</p></b>";
                                }
                                ?>
                                </form>
                                

                                    <p>Below is your referal link, <br>
                                     kindly use this link to invite users to our website and enjoy the beneficts per each successful invitation. </p>
                                     
                                            <label for="">Referal link:</label>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <input type="text" class="form-control" value="<?php echo User::get_web_addess(); ?>/signup.php?ref=<?php echo $ref_id; ?>" id="myInput">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <button id="copy" class="btn btn-warning">Copy Link</button>
                                                </div>
                                            </div>
                                            <div class="container">
                                                <ul class="textwidget">
                                                    <li><i class="fa fa-angle-right"></i>
                                                        <i style="color:blue" class="fa fa-facebook"></i>                                
                                                        <div class="fb-share-button" 
                                                            data-href="<?php echo User::get_web_addess(); ?>/signup.php?ref=<?php echo $ref_id; ?>" 
                                                            data-layout="button">
                                                        </div>
                                                    </li>
                                                    <li><i class="fa fa-angle-right"></i>
                                                        <a href="whatsapp://send?text=<?php echo User::get_web_addess(); ?>/signup.php?ref=<?php echo $ref_id; ?>" data-action="share/whatsapp/share"><i style="color:green" class="fa fa-whatsapp"></i> Share to WhatsApp</a>
                                                    </li>
                                                    <li><i class="fa fa-angle-right"></i>
                                                        <a href="https://twitter.com/intent/tweet?url=<?=urlencode(User::get_web_addess())?>/signup.php?ref=<?php echo $ref_id; ?>"><i style="color:blue" class="fa fa-twitter"></i> Share to Twitter</a>
                                                    </li>
                                                </ul>
                                            </div><br>

                                     
                                    <div class="container col-md-12">
                                        <b>(NOTE: SHARE THIS LINK TO YOUR SOCIAL MEDIA AND FRIENDS)</b><br>
                                        <I>Each successful registration from your link warrants $5 credit to your accout. <br>
                                        after your referal's first funding to his / her account. 
                                        </I>
                                    </div>
                                    
                                    <hr>
                                    <div class="row">
                                        <div class="text-center form-group col-md-6">
                                            <button id="idle" class="btn btn-success" style="">Congratulations Agent <?php echo $fname; ?></button>
                                        </div>
                                    </div>
                                </div>
                            <?php }else{ 
                                echo "
                                <link href='../vendor/sweetalert2/sweetalert2.min.css' rel='stylesheet'>
                                <script src='../vendor/sweetalert2/sweetalert2.all.min.js'></script>
                                <script>
                                function alert_func(type, message, loc) {
                                    Swal.fire({
                                        position: 'center',
                                        type: type,
                                        title: message,
                                        showConfirmButton: true
                                    }).then(function(){
                                        if(loc!=''){
                                            window.location=loc;
                                        }
                                    });
                                    
                                }
                                </script>
                                ";
                                echo "<script> alert_func('warning', 'Your agent application is on the process to be confirmed by the admin!', ''); </script>";
                                ?>
                                <div class="container">
                                    <li>1. You must have funded your account for the first time. </li><br>
                                    <li>2. You must have been registered with us for atleast 4 weeks / 1 month. </li><br>
                                    <li>3. You must have a working social media account in Facebook, WhatsApp and Twitter </li><br>
                                    <b>(NOTE: YOUR SOCIAL MEDIA DETAILS MUST BE CONFIRMED BEFORE APPROVAL)</b>
                                    <hr>
                                    <?php if(!$agent_applied){ ?>
                                    <div class="row">
                                        <div class="text-center form-group col-md-6">
                                            <a href="agent_form.php"><button class="btn btn-success">Proceed Application <i class="fa fa-forward"></i></button></a>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                            

                        </div>

                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
  <?php require_once('joins/footer.php'); ?>
  <script>
    function clearSelection() {
        var sel;
        if ( (sel = document.selection) && sel.empty ) {
            sel.empty();
        } else {
            if (window.getSelection) {
                window.getSelection().removeAllRanges();
            }
            var activeEl = document.activeElement;
            if (activeEl) {
                var tagName = activeEl.nodeName.toLowerCase();
                if ( tagName == "textarea" ||
                        (tagName == "input" && activeEl.type == "text") ) {
                    // Collapse the selection to the end
                    activeEl.selectionStart = activeEl.selectionEnd;
                }
            }
        }
    }
  </script>
    <script>
    $(function () {
        $('#copy').click(function (event) {
            event.preventDefault();
            var copyText = document.getElementById("myInput");
            copyText.select();
            copyText.setSelectionRange(0, 99999);

            document.execCommand("copy");
            clearSelection();
            alert_func('success', 'Copied to clipboard', '');
        });
        $('#idle').click(function (event) {
            event.preventDefault();
        });
    })
  </script>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>