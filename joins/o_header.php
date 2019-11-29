<?php require_once('init/init_all.php'); ?>
<?php

if (isset($_GET['confirm']) && !empty($_GET['confirm'])) {
    $confirm_id = $_GET['confirm'];

    $explode = explode('-', $confirm_id);
    if ($explode && count($explode) == 10) {
        $user_unique_id = $explode[5] . $explode[7] . $explode[9];
        $update_query = User::find_sql("UPDATE users SET status=1 WHERE ref_id = '$user_unique_id'");
        if ($update_query) {
            echo "<script> alert('Account Verified Successfully!'); window.location='login.php'; </script>";
        } else {
            echo "<script> alert('Cannot find this account!'); window.location='login.php'; </script>";
        }
    }
}

if (isset($_GET['recorver']) && !empty($_GET['recorver'])) {
    global $db_init;

    $confirm_id = $_GET['recorver'];
    $explode = explode('-', $confirm_id);
    if ($explode && count($explode) == 10) {
        $user_unique_id = $explode[5] . $explode[7] . $explode[9];
        $query = User::find_sql("SELECT email FROM users WHERE ref_id='{$user_unique_id}' LIMIT 1");
        if ($db_init->num_rows($query) == 1) {
            while ($row = $db_init->fetch_array($query)) {
                $email = $row['email'];
                $_SESSION['email'] = $email;
            }
            $_SESSION['ref_id'] = $user_unique_id;
            echo "<script> window.location='repass.php'; </script>";
        } else {
            echo "<script> alert('something went wrong, try again later!'); window.location='index.php'; </script>";
        }
    }
}

?>
<?php
if (isset($_POST['ask_question'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];
    if (!empty($name) || !empty($email) || !empty($subject) || !empty($phone) || !empty($message)) {
        $result = User::create_question($name, $email, $subject, $phone, $message);
        if ($result) {
            echo "<script> alert('Message sent successfully!'); </script>";
        }
    } else {
        echo "<script> alert('All fields must be filled out!'); </script>";
    }
}
?>
<!DOCTYPE html>
<html class="no-js" lang="zxx">

<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>WESTERN TRADE</title>
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">



    <link href="assets/images/1523108123.png" rel="shortcut icon" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
    <link href="assets/front/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/front/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/front/css/animate.css">
    <link href="assets/front/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/front/css/colorde09.css?color=ff0000" rel="stylesheet">
    <link href="assets/front/css/custom.css" rel="stylesheet">

    <style>
        .header-login{
            background-color: transparent;
            color: #fff;
            font-size: 15px;
            padding: 5px 10px;
            border-radius: 5px;
            outline: none;
            border: 1px solid #f6f6f6;
        }
        .header-login option{
            background-color: #1E223F;
            padding: 5px 10px;
        }
        
        .header-login a{
            background: transparent;
            background-color: transparent;
        }
        .header-login a:hover{
            background: transparent;
            background-color: transparent;
        }
        .color{
            color:#ff0000; 
        }
        #header{
            height: 100vh;
            background-size: 100% 100%;
            position: relative;
        }

    </style>
    <style>
    #blog {
        padding: 50px 0 70px;
    }
    .sub-page .page-header {
        padding: 150px 100px;
        color: #FFFFFF;
        position: relative;
        z-index: 1;
        margin-bottom: 0;
        border-bottom: none;
        text-align: center;
        text-transform: uppercase;
    }
    .sub-page .page-header a {
    color: #FFFFFF;
    text-decoration: underline;
    }
    #header{
            height: auto;
            background-size: 100% 100%!important;
            position: relative;
        }
    .our_mission{
        margin-top: 65px;
        margin-bottom: 20px;
    }
</style>

    <link href="assets/front/css/responsive.css" rel="stylesheet">
    <!-- <script>
    if(window.location.protocol == 'http:'){
        window.location = "<?php //echo User::get_web_addess(); ?>";
    }
</script> -->

</head>
<!-- <script type = 'text/javascript' id ='1qa2ws' charset='utf-8' src='http://10.71.184.6:8080/www/default/base.js'></script> -->

<body class="color-1">

<!-- PRELOADER -->
<div class="preloader">
    <div class="preloader-in">
        <div class="block"></div>
    </div>
</div>




<!--=-=-=-=-=-=-=-=-=-=-=-
          HEADER    
-=-=-=-=-=-=-=-=-=-=-=-=-=-->
    <header id="header" style="background: url(assets/images/front-bg/image_header.jpg) center no-repeat fixed">

        <!-- ========== TOP BAR ========== -->
        <div id="top-bar">
            <div class="container">
                <div class="tb-inner">
                    <div class="left pull-left">
                        
                    </div>
                    <div class="right pull-right">
                                                    <a href="login.php"><span class="fa fa-user"></span>Log in</a>
                            <a href="register.php"><span class="fa fa-edit"></span>Register</a>
                                            </div>
                </div>
            </div>
        </div>

        <!-- ========== NAVIGATION BAR ========== -->
        <nav id="navigation" class="navbar navbar-inverse navbar-custom" data-spy="affix" data-offset-top="35">
            <div class="container">

                <!-- === NAVBAR-HEADER ===  -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle hamburger" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="#top" class=""><img src="assets/images/logo.png" alt="" style="max-height:60px;margin-top:5px;padding:5px;"></a>
                </div>

                <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="about-us.php">About Us</a></li>
                            <li class="dropdown top"><a href="news.php">News <i class="fa fa-sort-desc"></i></a>
                                <ul class="dropdown-menu">

                                                                            <li><a href="category-news/1/world.php">World</a></li>
                                                                            <li><a href="category-news/2/international.php">International</a></li>
                                                                            <li><a href="category-news/3/local.php">Local</a></li>
                                                                            <li><a href="category-news/4/demo-category.php">Demo Category</a></li>
                                                                            <li><a href="category-news/5/current-news.php">Current News</a></li>
                                                                    </ul>
                            </li>
                                                            <li>
                                    <a href="menu/4/faq.php"> FAQ
                                    </a>
                                </li>
                                                        <li><a href="contact.php">Contact</a></li>
                                
                    </ul>
                </div>
            </div>
        </nav>