    <!--Footer Copyrights-->
    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <p>&copy;&nbsp;<?php echo date('Y') ?> Western Trade</p>
                </div>
            </div>
        </div>
    </footer>

    <!--All Script-->
    <script src="js/jquery-1.12.4.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/appear.js"></script>
    <script src="js/smoothscroll.js" type="text/javascript"></script>
    <script src="js/odometer.min.js" type="text/javascript"></script>
    <script src="js/script.js" type="text/javascript"></script>
    <script>
        $(window).load(function() {
            // Animate loader off screen
            $(".se-pre-con").fadeOut("slow");;
        });
    </script>
    <script>
        // Control about navigation fixed scrolling mechanism
        window.onscroll = function () { navfixedScroll() };
        // Get the navbar
        var navbar = document.getElementById("breadcrumb");
        // Get the offset position of the navbar
        var sticky = navbar.offsetTop;
        // Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
        function navfixedScroll() {
            if (window.pageYOffset >= sticky) {
                navbar.classList.add("sticky")
            } else {
                navbar.classList.remove("sticky");
            }
        }
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
</html>