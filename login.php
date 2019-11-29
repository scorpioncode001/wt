<?php require_once('includes/header.php') ?>
<?php require_once('set_signin.php') ?>

    <!--Breadcrumb-->

    <section id="breadcrumb" class="space nav-bar">

        <div class="container">

            <div class="row">

                <div class="col-sm-6 breadcrumb-block">

                    <h2>Western Trade | Login</h2>

                </div>

                <div class="col-sm-6 breadcrumb-block text-right">

                    <ol class="breadcrumb">

                        <li><a href="index.php">Home</a></li>

                        <li class="active">Login</li>

                    </ol>

                </div>

            </div>

        </div>

    </section>

    <!--Contact Us-->

    <section id="contact" class="space">

        <div class="container">

            <div class="row">


                <div class="col-sm-5 col-sm-offset-4 contact-block" style="box-shadow:1px 1px 2px  #000;padding:10px">

                    <div class="col-sm-12 main-heading">

                        <h3>Login !</h3>

                    </div>
                    <div class="col-sm-12" style="padding:20px;text-align: center">
                        <img src="./images/user.png" alt="hench_login image" class="img-responsive img-rounded"
                            style="width:100px;height:100px;margin-left:40%">
                    </div>

                    <form action="#" id="contact-form" role="form" method="POST">

                        <div class="form-group col-sm-12 padding-left">

                            <input type="email" class="form-control" name="email" id="mail" required placeholder="Email">

                        </div>

                        <div class="form-group col-sm-12 padding-left">

                            <input type="password" class="form-control" name="pass" id="pass" required
                                placeholder="Password">

                        </div>


                        <div class="col-sm-12  no-padding">

                            <input type="submit" name="signin" class="btn btn-default" value="Login">
                            <span class="pull-right"><a href="fpass.php">forgot password ?</a></span>

                        </div>

                    </form>

                </div>



            </div>

        </div>

    </section>


    <?php require_once('includes/footer.php'); ?>