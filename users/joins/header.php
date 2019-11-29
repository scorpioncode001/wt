<?php require_once('../init/init_all.php'); ?>
<?php
if(!isset($session->user_id)){
    header('Location: ..');
}
if($_SESSION['location'] != "users"){
  $loc=$_SESSION['location'];
  header("location: ../$loc");
}
?>
<?php
if(isset($_GET['logout'])){
  $session->logout();
}
?>
<?php require_once('../ProcessPage/initialise.php'); ?>
<?php
    
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Western Trade | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link href="favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <link href="../vendor/sweetalert2/sweetalert2.min.css" rel="stylesheet">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- PAYSTACK INLINE -->
  <!-- <script src='../js/paystack_inline.js'></script> -->
  <script src='https://js.paystack.co/v1/inline.js'></script>

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <style>
        .no-js #loader {
            display: none;
        }

        .js #loader {
            display: block;
            position: absolute;
            left: 100px;
            top: 0;
        }

        .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('../preloader.gif') center no-repeat #fff;
        }
    </style>
    <!-- <script>
    if(window.location.protocol == 'http:'){
        window.location = 'https://www.westerntrade.com/users';
    }
</script> -->
</head>
<body class="hold-transition sidebar-mini skin-blue">
<div class="se-pre-con"></div>
<div class="wrapper">
  <header class="main-header">

    <!-- Logo -->
    <a href="index.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>W</b> T</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Western</b> Trade</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success"><?php echo $total_msg_counter; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header"><?php if($total_msg_counter==1){ echo "You have 1 message"; }else{ echo "You have $total_msg_counter messages"; } ?></li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
<?php   for($a=0; $a<count($admin_ids); $a++){ ?>
                  <li><!-- start message -->
                    <a href="./read-messages.php?msg_id=<?php echo $msgs_ids[$a] ?>">
                      <div class="pull-left">
                        <img src="../images/wt_logo.png" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Admin
                        <small><i class="fa fa-clock-o"></i> <?php echo $message_validity_array[$a]; ?></small>
                      </h4>
                      <p><?php echo $user_unred_msgs_array[$a]; ?></p>
                    </a>
                  </li>
<?php } ?>
                  <!-- end message -->
                </ul>
              </li>
              <li class="footer"><a href="./messages.php">See All Messages</a></li>
            </ul>
          </li>
          
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle">
              <i class="fa fa-usd"></i> <?php echo $user_balance; ?>
            </a>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo $picture; ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $full_name; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo $picture; ?>" class="img-circle" alt="User Image">

                <p>
                <?php echo $full_name; ?>
                  <small>last logged: <?php echo $last_logged; ?></small>
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="col-md-12">
                  <a href="./profile.php" class="btn btn-default btn-flat form-control"><i class="fa fa-user"></i> Profile</a>
                </div>
                <div class="col-md-12">
                  <a href="./change-pass.php" class="btn btn-default btn-flat form-control">
                    <i class="fa fa-key"></i>
                    Change Password</a>
                </div>
                <div class="col-md-12">
                  <a href="?logout" class="btn btn-default btn-flat form-control">
                    <i class="fa fa-sign-out"></i>
                    Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>

    </nav>
  </header>