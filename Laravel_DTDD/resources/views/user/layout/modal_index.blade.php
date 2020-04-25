<div id="myModal" class="modal sign_in_up">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="row">
            <div class="col-5">
                <h2 class="title" id="title_sign_form">ĐĂNG NHẬP</h2>
                <p id="content_sign">Đăng nhập để lưu lại giỏ hàng, mua sản phẩm, bình luận và nhiều hơn thế,...</p>
                <img src="DiDongZin/assets/img/undraw_press_play_bx2d.svg">
            </div>
            <div class="col-7">
                <div class="g-btn">
                    <button class="sd-btn tablinks active" onclick="openTab(event, 'login')">Đăng nhập</button>
                    <button class="sd-btn tablinks" onclick="openTab(event, 'register')">Đăng kí</button>
                </div>

                {{----- ĐĂNG NHẬP ------------------------------------------------------}}
                <div id="login" class="tabcontent">
                    <form action="dangnhap" method="POST">
                        {{ csrf_field() }}
                        
                        @if (session('thongBaoDangNhap'))
                            <?php  
                                echo '<script>alert("'. session('thongBaoDangNhap') .'")</script>';
                            ?>
                        @endif

                        <label for="username"><img src="DiDongZin/assets/img/male_user_30px.png"></label>
                        <input type="text" id="username" name="username" placeholder="Tên đăng nhập">
                        <label for="password"><img src="DiDongZin/assets/img/secure_30px.png"></label>
                        <input type="password" id="password" name="password" placeholder="Mật khẩu">
                        <input class="thr-btn" type="submit" value="Đăng Nhập">
                        <a href="#">Quên mật khẩu ?</a>
                    </form>
                </div>

                {{----- ĐĂNG KÝ ------------------------------------------------------}}
                <div id="register" class="tabcontent">
                    <form action="#" method="POST">
                        <label for="username2"><img src="DiDongZin/assets/img/male_user_30px.png"></label>
                        <input type="text" id="username2" placeholder="Tên đăng nhập">
                        <label for="password2"><img src="DiDongZin/assets/img/secure_30px.png"></label>
                        <input type="password" id="password2" placeholder="Mật khẩu">
                        <label for="re_password"><img src="DiDongZin/assets/img/secure_30px.png"></label>
                        <input type="password" id="re_password" placeholder="Nhập lại mật khẩu">
                        <input class="thr-btn" type="submit" value="Đăng Kí">   
                    </form>
                </div>
                
                @if (session('dangXuat'))
                    <?php  
                        echo '<script>alert("'. session('dangXuat') .'")</script>';
                    ?>
                @endif
                
            </div>
        </div>
    </div>

</div>