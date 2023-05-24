<div class="footer">
    <div class="container">
        <div class="row">
            <div class="footer-col1">
                <h3>Theo Dõi Tại</h3>
                <ul style="color: black">
                    <li><a href="https://www.facebook.com/LED-MD-STORE-108323298749688">Facebook </a></li>
                    <li><a href="https://www.tiktok.com/@trinhcheng?lang=vi-VN">TikTok </a>
                    <li>
                    <li><a href="https://shopee.vn/dendeco247?categoryId=100636&entryPoint=ShopByPDP&itemId=4617140799&upstream=search">Shopee </a></li>
                </ul>
            </div>
            <div class="footer-col2">
                <img src="images/logo.png">
            </div>
            <div class="footer-col3">
                <h3>Địa Chỉ</h3>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3722.6697171747246!2d105.75336237517803!3d21.085849780577828!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3134556fc91b488b%3A0xf98d7822045d5d0e!2zxJDDqG4gc8OhbmcgbmjDoCB4aW5o!5e0!3m2!1svi!2s!4v1683849893177!5m2!1svi!2s" width="200" height="240
                    " style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
        <hr>
        <p class="copyright">Copyright <? echo date("Y"); ?> By ChiKo</p>
        <!-- Messenger Plugin chat Code -->
        <div id="fb-root"></div>

        <!-- Your Plugin chat code -->
        <div id="fb-customer-chat" class="fb-customerchat">
        </div>

        <script>
            var chatbox = document.getElementById('fb-customer-chat');
            chatbox.setAttribute("page_id", "108323298749688");
            chatbox.setAttribute("attribution", "biz_inbox");
        </script>

        <!-- Your SDK code -->
        <script>
            window.fbAsyncInit = function() {
                FB.init({
                    xfbml: true,
                    version: 'v16.0'
                });
            };

            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s);
                js.id = id;
                js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        <script>
        window.fbAsyncInit = function() {
            FB.init({
            appId      : '{your-app-id}',
            cookie     : true,
            xfbml      : true,
            version    : '{api-version}'
            });
            
            FB.AppEvents.logPageView();   
            
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
</script>
    </div>

</div>




</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="app.js"></script>
<script src="64tinhthanh.js"></script>

</html>