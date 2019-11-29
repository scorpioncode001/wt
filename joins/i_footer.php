<footer id="footer">
<div class="container">
    <div class="footer-inner">
        <div class="footer-top">
            <div class="social-icons">
                <ul class="no-style">
                    <li><a href="https://www.facebook.com/"><span class="fa fa-facebook"></span></a></li>
                    <li><a href="http://www.twitter/"><span class="fa fa-twitter"></span></a></li>
                    <li><a href="http://linkdin.com/"><span class="fa fa-linkedin"></span></a></li>
                    <li><a href="https://plus.google.com/"><span class="fa fa-google-plus"></span></a></li>
                    <li><a href="https://youtube.com/"><span class="fa fa-youtube"></span></a></li>
                </ul>
            </div>
            <a href="#top" class="back-to-top btn btn-info"><span class="fa fa-chevron-up"></span></a>
        </div>
    </div>
</div>
<div class="footer-bottom">
    <div class="container">
        <div class="footer-b-inner">
            <div class="links">
                <ul class="no-style">
                    <li class="margin-contact">
                        <a class="email margin-contact" href="cdn-cgi/l/email-protection.php#4e2b362f233e222b0e26213d3a602d2123"><span class="fa fa-envelope"></span><span class="__cf_email__" data-cfemail="5625232626392422162c33383f223e3b3724313f382578392431">[email&#160;protected]</span></a>
                    </li>
                    <li>
                        <a class="phone margin-contact" href="tel:+0123456789"><span class="fa fa-phone"></span>+13474507192</a>
                    </li>
                </ul>
            </div>
            <div class="footer-text">
                
            </div>
        </div>
    </div>
    <div class="container">
        <div class="footer-b-inner">
            <div class="links">
                <ul class="no-style">
                    <li><a href="document.php" class="transition3s">Document</a></li>
                    <li><a  href="faq.php" class="transition3s">FAQS</a></li>
                    <li><a href="terms.php" class="transition3s">Terms & Condition</a></li>
                    <li><a href="privacy.php" class="transition3s">Privacy & Security</a></li>
                </ul>
            </div>
            <div class="footer-text">
                <p>Western Trade © <?php echo date('Y'); ?> All copyright Reserved.</p>
            </div>
        </div>
    </div>
</div>
</footer>

    <!-- ======= Body Scripts ======= -->
    <!-- <script type="text/javascript"> //<![CDATA[
  var tlJsHost = ((window.location.protocol == "https:") ? "https://secure.trust-provider.com/" : "http://www.trustlogo.com/");
  document.write(unescape("%3Cscript src='" + tlJsHost + "trustlogo/javascript/trustlogo.js' type='text/javascript'%3E%3C/script%3E"));
//]]></script>
<script language="JavaScript" type="text/javascript">
  TrustLogo("https://www.positivessl.com/images/seals/positivessl_trust_seal_lg_222x54.png", "POSDV", "none");
</script> -->

    <!-- Jquery Library -->
    <script data-cfasync="false" src="cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="assets/front/js/jquery-1.12.4.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="assets/front/js/bootstrap.min.js"></script>
    <!-- Owl Carousel JS -->
    <script src="assets/front/owlcarousel/owl.carousel.min.js"></script>
    <!-- WOW JS -->
    <script src="assets/front/js/wow.min.js"></script>
    <!-- Way Points JS -->
    <script src="assets/front/js/waypoints.min.js"></script>
    <!-- Counter JS -->
    <script src="assets/front/js/jquery.counterup.min.js"></script>
    <!-- Slider JS -->
    <script src="assets/front/js/jquery-ui-slider.min.js"></script>
    <!-- Arctext JS -->
    <script src="assets/front/js/jquery.arctext.js"></script>
    <!-- Custom Js -->
    <script src="assets/front/js/script.js"></script>
    <!-- 
    <script type="text/javascript" src="http://www.zenithmargins.org/assets/js/venobox.min.js"></script> -->
    <script type="text/javascript" src="assets/js/ion.rangeSlider.html"></script>

    <script>
        $.each($('.slider-input'), function() {
            var $t = $(this),

                    from = $t.data('from'),
                    to = $t.data('to'),

                    $dailyProfit = $($t.data('dailyprofit')),
                    $totalProfit = $($t.data('totalprofit')),

                    $val = $($t.data('valuetag')),

                    perDay = $t.data('perday'),
                    perYear = $t.data('peryear');


            $t.ionRangeSlider({
                input_values_separator: ";",
                prefix: '$',
                hide_min_max: true,
                force_edges: true,
                onChange: function(val) {
                    $val.val( '$' + val.from);

                    var profit = (val.from * perDay / 100).toFixed(1);
                    profit  = '$' + profit.replace('.', '.') ;
                    $dailyProfit.text(profit) ;

                    profit = ( (val.from * perDay / 100)* perYear ).toFixed(1);
                    profit  =  '$' + profit.replace('.', '.');
                    $totalProfit.text(profit);

                }
            });
        });
        $('.invest-type__profit--val').on('change', function(e) {

            var slider = $($(this).data('slider')).data("ionRangeSlider");

            slider.update({
                from: $(this).val().replace('$', "")
            });
        })
    </script>

</body>


<!-- Mirrored from www.zenithmargins.org/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 10 May 2019 05:49:29 GMT -->
</html>
