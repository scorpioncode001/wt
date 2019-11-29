    <!--Footer Top-->
    <section id="bottom">
        <div class="container">
            <div class="row">
            <div class="col-sm-3 col-md-3">
                    <h3 class="module-title">About Investment</h3>
                    <p>Western Trade is one of the world's leading multi-asset alternative investment firms. Our global
                        team ...</p>
                    <a href="#" class="btn btn-primary btn-sm">Read More</a>
                </div>
                <div class="col-sm-6 col-md-3">
                    <h3 class="module-title">Address</h3>
                    <ul class="textwidget">
                        <li><i class="fa fa-envelope"></i> <?php echo User::get_email_address(); ?></li>
                        <li><i class="fa fa-clock-o"></i> Mon - Fri: 9:00 AM - 18:00 PM</li>
                    </ul>
                </div>
                <div class="col-sm-6 col-md-3">
                    <h3 class="module-title">Usefull Links</h3>
                    <ul class="textwidget">
                        <li><i class="fa fa-angle-right"></i>
                            <i style="color:blue" class="fa fa-facebook"></i>                                
                            <div class="fb-share-button" 
                                data-href="<?php echo User::get_web_addess(); ?>" 
                                data-layout="button">
                            </div>
                        </li>
                        <li><i class="fa fa-angle-right"></i>
                            <a href="whatsapp://send?text=The text to share!" data-action="share/whatsapp/share"><i style="color:green" class="fa fa-whatsapp"></i> Share to WhatsApp</a>
                        </li>
                        <li><i class="fa fa-angle-right"></i>
                            <a href="https://twitter.com/intent/tweet?url=<?=urlencode(User::get_web_addess())?>"><i style="color:blue" class="fa fa-twitter"></i> Share to Twitter</a>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6 col-md-3">
                    <h3 class="module-title">Tag Cloud</h3>
                    <div class="tagspopular">
                        <ul>
                            <li> <a href="#" target="_parent">Dollar </a></li>
                            <li> <a href="#" target="_parent">Bitcoin</a></li>
                            <li> <a href="#" target="_parent">Euro</a></li>
                            <li> <a href="#" target="_parent">Pounds</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Footer Copyrights-->
    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <p>&copy;&nbsp;<?php echo date('Y'); ?> Western Trade</p>
                </div>
            </div>
        </div>
    </footer>

    <!--All Script-->
    <script src="js/jquery-1.12.4.min.js" type="text/javascript"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/appear.js"></script>
    <script src="js/smoothscroll.js" type="text/javascript"></script>

    <!-- <script src="js/owl.carousel.js" type="text/javascript"></script> -->
    <script src="js/owl.carousel_old.js" type="text/javascript"></script>
    <script src="js/odometer.min.js" type="text/javascript"></script>
    <script src="js/script.js" type="text/javascript"></script>
    <script src="js/custom.js" type="text/javascript"></script>
    <script>
        $(window).load(function() {
            // Animate loader off screen
            $(".se-pre-con").fadeOut("slow");;
        });
    </script>
    <script src="https://widgets.coingecko.com/coingecko-coin-compare-chart-widget.js"></script>
    <script src="https://widgets.coingecko.com/coingecko-coin-converter-widget.js"></script>
    <script>
        (function(b, i, t, C, O, I, N) {
            window.addEventListener('load', function() {
                if (b.getElementById(C)) return;
                I = b.createElement(i), N = b.getElementsByTagName(i)[0];
                I.src = t;
                I.id = C;
                N.parentNode.insertBefore(I, N);
            }, false)
        })(document, 'script', 'https://widgets.bitcoin.com/widget.js', 'btcwdgt');
    </script>
    <!-- Load Facebook SDK for JavaScript -->
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>
    </body>

    <!-- Mirrored from demo.canyonthemes.com/html/investment/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 04 Jun 2019 23:05:17 GMT -->

    </html>