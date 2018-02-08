<div class="header">
            <div id="logo">
            <a href="index.php?danhmuc=tất cả">
                <img src="images/logo.png" width="200px" height="50px"/>  
            </a>
            </div>
            <div class="menu">
                <div class="menu-item">Điện tử</div>
                <div class="menu-sub">
                <a href="index.php?danhmuc=điện thoại">Điện thoại</a>
                <a href="index.php?danhmuc=máy tính bảng">Máy tính bảng</a>
                <a href="index.php?danhmuc=laptop">Laptop</a>
                <a href="index.php?danhmuc=máy tính bàn">Máy tính để bàn</a>
                <a href="index.php?danhmuc=loa,amply">loa, amply</a>
                <a href="index.php?danhmuc=phụ kiện, linh kiện">phụ kiện, linh kiện</a>
                </div>
            </div>
            <div class="menu">
                <div class="menu-item">Gia dụng</div>
                <div class="menu-sub">
                <a href="index.php?danhmuc=tivi, tủ lạnh">Tivi, tủ lạnh, máy giặt</a>
                <a href="index.php?danhmuc=nội, ngoại thất">Nội ngoại thất</a>
                <a href="index.php?danhmuc=cây cảnh, thú cưng">Cây cảnh, thú cưng</a>
                <a href="index.php?danhmuc=quần áo, giày dép">Quần áo, giày dép</a>
                <a href="index.php?danhmuc=đồ gia dụng khác">Đồ gia dụng khác</a>
                </div>
            </div>
            <div class="menu">
                <div class="menu-item">Xe cộ</div>
                <div class="menu-sub">
                <a href="index.php?danhmuc=ô tô">Ô tô</a>
                <a href="index.php?danhmuc=xe máy">Xe máy</a>
                <a href="index.php?danhmuc=xe tải">Xe tải</a>
                <a href="index.php?danhmuc=xe điện">Xe điện</a>
                <a href="index.php?danhmuc=xe đạp">Xe đạp</a>
                <a href="index.php?danhmuc=phụ tùng xe">Phụ tùng xe</a>
                </div>
            </div>
            <div class="menu">
                <div class="menu-item">Bất động sản</div>
                <div class="menu-sub">
                <a href="index.php?danhmuc=căn hộ, chung cư">Căn hộ, chung cư</a>
                <a href="index.php?danhmuc=đất">Đất</a>
                <a href="index.php?danhmuc=văn phòng, mặt tiền">Văn phòng, mặt tiền</a>
                <a href="index.php?danhmuc=nhà trọ">Nhà trọ</a>
                </div>
            </div>
            <div class="menu" style="float: right;">
                <?php
                if (isset($_SESSION['username']) && $_SESSION['username']){
                ?>
                <div class="menu-item" style=" color: blue; padding: 0px;">
                   
                    <img src="images/user.png" alt="" width="45px" height="45px"/>
                     <?php echo $_SESSION['sdt'];?>
                </div>
                <div class="menu-sub">
                <a href="profile.php">Hồ sơ</a>
                <a href="logout.php">Đăng xuất</a>
                </div>
                <?php
                }
                else{
                ?>
                <a href="login.php"><div class="menu-item">Đăng nhập/Đăng kí</div></a>
                <?php
                }
                ?>
            </div>
            
            <div class="menu-2" style="float: right;margin-right: 10px;">
                <a href="post.php">Đăng tin</a>
            </div>
            
            
         
 </div>
