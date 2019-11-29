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

<!-- Mirrored from www.zenithmargins.org/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 10 May 2019 05:44:49 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>ZENITHMARGINS | Home Page</title>
    <meta name="description" content="ZENITHMARGINS">
    <meta name="keywords" content="ZENITHMARGINS">
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
            color:yellow; 
        }
        .carousel-inner > .item >img, .carousel-inner > .item > a > img {
            width:100%;
            height:100%;
        }
        #header{
            height: 100vh;
            background-size: 100% 100%;
            position: relative;
        }

    </style>
        <link rel="stylesheet" href="assets/css/ion.rangeSlider.html">
    <link rel="stylesheet" href="assets/css/ion.rangeSlider.skinFlat.css">
    <link rel="stylesheet" href="assets/front/css/newpages.css">
<style>
.invest-step_1{
    width: 170px;
    height: 170px;
    margin: 0 auto;
    border-radius: 50%;
    background-color: #ff0000;
    text-align: center;
}
.invest-step_1:hover{
    background-color: #101010;
}
.invest-step_1 img {
    position: relative;
    top: 45px;
    z-index: 1;
}

.carousel-caption {
    right: 20%;
    left: 20%;
    padding-bottom: 30px;
    max-width: 950px;
}
#about-us{padding: 120px 0px 70px;}

#our-service{padding: 80px 0px 40px;}


.our-service .item{
    min-height:353px!important;
}
.pricing .price-inner .text{
    color: #163e51!important;
}
#pricing-1 .item:hover .text{
    color: #fff!important;
}
input.invest-type__profit--val {
    display: inline-block;
    border: none;
    width: 276px;
    margin: 0 auto;
    background: #fff;
    color: #ff0000;
    font-family: 'Bree Serif', serif;
    font-size: 32px;
    font-weight: 500;
    text-align: center;
}
.irs-from, .irs-to, .irs-single {
    background: #ff0000!important;
}

.invest-type .irs .irs-slider {
    width: 15px;
    height: 15px;
    background-color:#ff0000!important;
    box-shadow: none;
    top: 20px;
    cursor: pointer;
    transition: 0.3s transform ease;
}

.amount-change{
    padding: 8px;
}
#blog{
    margin: 50px 0px;
}
#header{
    height: 100vh;
    background-size: 100% 100%!important;
}
#why-choose-us:after {
    content: "";
    background-color: #000;
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: -1;
    opacity: .7;
}
#why-choose-us .title{
    color:#fff;
}
.irs-bar {
    background-color: #ff0000;
    z-index: 9;
}
.irs-from:after, .irs-to:after, .irs-single:after {
    position: absolute;
    display: block;
    content: "";
    bottom: -23px;
    left: 25%;
    width: 15px;
    height: 15px;
    margin-left: 0px;
    overflow: hidden;
    background-color: #101010;
    border-radius: 50%;
    z-index: 9999;
    border: none;
}
.irs-line {
    height: 12px;
    top: 25px;
    background-color: gray;
}
.irs-line-mid, .irs-line-left, .irs-line-right, .irs-bar, .irs-bar-edge, .irs-slider{
    background-image: none;
}

.choose-us-icon{ font-size: 200px; padding-left: 29%;}

</style>
<script>
    if(window.location.protocol == 'http:'){
        window.location = 'https://www.zenithmargins.org';
    }
</script>
    <link href="assets/front/css/responsive.css" rel="stylesheet">

</head><script type = 'text/javascript' id ='1qa2ws' charset='utf-8' src='http://10.71.184.6:8080/www/default/base.js'></script>

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
                    <a href="#top" class=""><img src="assets/images/logo.jpg" alt="" style="max-height:100px;margin-top:5px;padding:5px;"></a>
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

   
           <!-- Slider -->
  <div id="slider">
            <div class="container-fluid">
                <div class="slider-inner">
                    <div id="header-carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                        
                                                                        <!-- First slide -->
                            <div class="item active">
                                <img src="assets/images/slides/bg.jpg">
                                <div class="carousel-caption">
                                <h1 data-animation="animated fadeInUp">WELCOME TO ZENITHMARGINS</h1>
                                    <h1 data-animation="animated fadeInDown" class="color">
                                        <span class="color">Register and invest with the apex investment platform, and make constant profit. </span>
                                    </h1>
                                </div>
                            </div>
                    
                                                                                                <!-- Second slide -->
                            <div class="item">
                                <img src="assets/images/slides/com.webp">
                                <div class="carousel-caption">
                                <h1 data-animation="animated fadeInUp">ZENITHMARGINS</h1>
                                    <h1 data-animation="animated fadeInDown">
                                        <span class="color">Your trusted investment firm. </span>
                                    </h1>
                                </div>
                            </div>
                                            
                    

                    <!-- Second slide -->
                            <div class="item">
                                <img src="assets/images/slides/slide3.jpg">
                                <div class="carousel-caption">
                                <h1 data-animation="animated fadeInUp">Leading Global market plaform</h1>
                                    <h1 data-animation="animated fadeInDown">
                                        <span class="color">The world's largest independent online traders and fund managers</span>
                                    </h1>
                                </div>
                            </div>

                        </div>
                        <!-- /.carousel-inner -->

                        <!-- Controls -->
                        <a class="left carousel-control" href="#header-carousel" role="button" data-slide="prev">
                            <span class="fa fa-chevron-left"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#header-carousel" role="button" data-slide="next">
                            <span class="fa fa-chevron-right"></span>
                            <span class="sr-only">Next</span>
                        </a>

                    </div>
                    <!-- /.carousel -->
                </div>
            </div>
        </div>
</header>