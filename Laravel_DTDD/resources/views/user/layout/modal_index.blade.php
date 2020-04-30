<div id="myModal" class="modal sign_in_up"
    @if ( session('loiDangKy') || (count($errors) > 0))
        style="display:block"
    @endif
>
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
                    <form action="dangky" method="POST">
                        {{ csrf_field() }}
                        
                        <?php $loi = ""; ?>
                        @if (count($errors) > 0)
                            <?php
                                foreach ($errors->all() as $err) {
                                    if($loi == ""){
                                        $loi .= $err;
                                    }else{
                                        $loi .= '\\n'. $err;
                                    }
                                }
                                echo '<script>alert("'. $loi .'");</script>'
                            ?>
                        @endif
                                
                        @if (session('loiDangKy'))
                            <?php
                                echo '<script>alert("'. session('loiDangKy') .'")</script>'
                            ?>
                        @endif

                        @if (session('thongBaoDangKy'))
                            <?php  
                                echo '<script>alert("'. session('thongBaoDangKy') .'")</script>';
                            ?>
                        @endif

                        <label for="hoVaTenLot"><img src="DiDongZin/assets/img/male_user_30px.png"></label>
                        <input type="text" name="hoVaTenLot" id="hoVaTenLot" placeholder="Điền họ và tên lót...">

                        <label for="ten"><img src="DiDongZin/assets/img/male_user_30px.png"></label>
                        <input type="text" name="ten" id="ten" placeholder="Điền tên của bạn...">

                        <label for="username2"><img src="DiDongZin/assets/img/male_user_30px.png"></label>
                        <input type="text" name="username2" id="username2" placeholder="Tên đăng nhập">

                        <label for="password2"><img src="DiDongZin/assets/img/secure_30px.png"></label>
                        <input type="password" name="password2" id="password2" placeholder="Mật khẩu">

                        <label for="re_password2"><img src="DiDongZin/assets/img/secure_30px.png"></label>
                        <input type="password" name="re_password2" id="re_password2" placeholder="Nhập lại mật khẩu">

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