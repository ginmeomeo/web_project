<?php
   session_start();
   if (isset($_SESSION['username']) && $_SESSION['username']){
   }
   else{
       header("Location:login.php");
   }
   include 'module/connect_sql.php';
   include 'module/insert.php';
   
   if($_SERVER['REQUEST_METHOD']=='POST'){
    $error = array();
    $name = array();
    $tmp_name = array();
    $type = array();
    $size = array();
    $img = array();
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $time= date("Y-m-d h:i:sa");
    if(!empty($_POST['khuvuc'])){
        $khuvuc=$_POST['khuvuc'];
    }
    if(!empty($_POST['danhmuc'])){
        $danhmuc=$_POST['danhmuc'];
    }
    if(empty($_POST['tieude'])){
	$error['tieude']="bạn cần nhập tiêu đề";    
    }
    else{
        $tieude=$_POST['tieude'];   
    }
    if(empty($_POST['diachi'])){
	$error['diachi']="bạn cần nhập địa chỉ";    
    }
    else{
        $diachi=$_POST['diachi'];   
    }
    if(empty($_POST['gia'])){
	$error['gia']="bạn cần nhập giá bán";    
    }
    else{
        $gia=(int)$_POST['gia'];   
    }
    if (empty($_POST['chitiet'])) {
    $chitiet="";
    }
    else{
    $chitiet="".htmlentities($_POST['chitiet']);
    }
   
    
    if(empty($_FILES['file']['tmp_name'])){
        $error['image']='bạn chưa chọn file ảnh';
    }
    foreach ($_FILES['file']['name']as $file){
        $name[]=$file;
    }
    foreach ($_FILES['file']['tmp_name']as $file){
        $tmp_name[]=$file;
    } 
    foreach ($_FILES['file']['error']as $file){
        $error_file[]=$file;
    } 
    foreach ($_FILES['file']['type']as $file){
        $type[]=$file;
    } 
    foreach ($_FILES['file']['size']as $file){
        $size[]=$file;
    }
    
    //lấy id bài post sau cùng 
    $sql='SELECT * FROM post WHERE id=(SELECT MAX(id) FROM post)';
    $res= mysqli_query($link, $sql);
    $row= mysqli_fetch_assoc($res);
    $id_img=$row['id']+1;
    //lấy thông tin tên ảnh
    if(empty($error)){
    for($i=0;$i<4;$i++){
        if(empty($name[$i])){
            $img[$i]='';
        }
        else{
            $img[$i]="$id_img".basename($name[$i]);
        }
    }
    $flag= insert_post($_SESSION['username'],$_SESSION['sdt'],$khuvuc, $danhmuc, $tieude, $diachi, $gia, $chitiet, $time, $img[0], $img[1], $img[2], $img[3]);
    //nếu gửi lên db thành công thì upload ảnh lên sever
    if($flag==true){
    for($i=0;$i<count($name);$i++){
            $last_id = mysqli_insert_id($link);//lấy id của bài post
            $target_dir="images-upload/";
            //$target_file=$target_dir.basename($name[$i]);
            $target_file=$target_dir.$id_img.basename($name[$i]);
            if(move_uploaded_file($tmp_name[$i], $target_file)){
                $flag=TRUE;
                header("Location:detail.php?id=$last_id");
            }else{
                $flag=FALSE;
                $error['upload']='upload thất bại';
            }  
    }
    }
    }
    
    }
    
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Chợ đồ cũ</title>
        <link href="css/css_post.css" rel="stylesheet" type="text/css"/>
        <link href="css/css_index.css" rel="stylesheet" type="text/css"/>
        <script src="jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script>
        $(document).ready( function(){
          $(".menu-sub").hide();
	  $(".menu").hover( function(){
		$(this).find('div:first').next().slideToggle(200);
	  });
          
          $("#input-image").change(function() {
             $("#image1").hide();
             $("#image2").hide();
             $("#image3").hide();
             $("#image4").hide();
             var img=$("#image1");
             for($i=0;$i<this.files.length;$i++){
             var reader = new FileReader();
             reader.onload = function(e) {
              img.attr('src', e.target.result);
              img.show();
              img=img.next();
             };
             reader.readAsDataURL(this.files[$i]);
             }
          });

        });
        </script>
    </head>
    <body>
        <div class="wrapper">
            <?php
            include 'module/header.php';
            ?>
            <div class="form">
                <div class="select">
            <div class="croll">
                <a href="#">Trang chủ ></a>
                <a href="#">Đăng tin</a>
            </div>
            </div>
                <form  class="form" method="POST" enctype="multipart/form-data">
                    <div class="add-image">
                        <h4>THÊM HÌNH ẢNH (tối đa 4 hình)</h4>
                        <input id="input-image" type="file" name="file[]"  multiple=""><br/>
                        
                        <img id="image1" src="#"/>
                        <img id="image2" src="#"/>
                        <img id="image3" src="#"/>
                        <img id="image4" src="#"/>
                    </div>
                    <div class="add-detail">
                        <h4>THÊM THÔNG TIN</h4>
                        <div class="menu-select">
                        <select name="khuvuc">
                        <option value="hà nội">>>Hà nội<<</option>
                        <option value="quận hoàn kiếm">quận hoàn kiếm</option>
                        <option value="quận ba đình">quận ba đình</option>
                        <option value="quận đống đa">quận đống đa</option>
                        <option value="quận hai bà trưng">quận hai bà trưng</option>
                        <option value="quận thanh xuân">quận thanh xuân</option>
                        <option value="quận cầu giấy">quận cầu giấy</option>
                        <option value="quận hoàng mai">quận hoàng mai</option>
                        <option value="quận long biên">quận long biên</option>
                        <option value="quận tây hồ">quận tây hồ</option>
                        <option value="quận hà đông">quận hà đông</option>
                        </select>
                        </div>
                        <div class="text">Chọn khu vực</div>
                        <div class="menu-select">
                        <select name="danhmuc">
                        <option value="tất cả">Tất cả</option>
                        <option value="" disabled="disabled">---Điện tử---------</option>
                        <option value="điện thoại">điện thoại</option>
                        <option value="máy tính bảng">máy tính bảng</option>
                        <option value="laptop">laptop</option>
                        <option value="máy tính bàn">máy tính để bàn</option>
                        <option value="loa,amply">loa,amply</option>
                        <option value="phụ kiện, linh kiện">phụ kiện,linh kiện</option>
                        <option value="" disabled="disabled">---Xe cộ-----------</option>
                        <option value="ô tô">ô tô</option>
                        <option value="xe máy">xe máy</option>
                        <option value="xe tải">xe tải</option>
                        <option value="xe điện">xe điện</option>
                        <option value="xe đạp">xe đạp</option>
                        <option value="phụ tùng xe">phụ tùng xe</option>
                        <option value="" disabled="disabled">---Gia dụng--------</option>
                        <option value="tivi, tủ lạnh">tivi, tủ lạnh, máy giặt</option>
                        <option value="nội, ngoại thất">nội, ngoại thất</option>
                        <option value="cây cảnh, thú cưng">cây cảnh, thú cưng</option>
                        <option value="quần áo, giày dép">quần áo, giày dép</option>
                        <option value="đồ gia dụng khác">đồ gia dụng khác</option>
                        <option value="" disabled="disabled">---Bất động sản----</option>
                        <option value="căn hộ, chung cư">căn hộ , chung cư</option>
                        <option value="đất">đất</option>
                        <option value="văn phòng, mặt tiền">văn phòng, mặt tiền</option>
                        <option value="nhà trọ">nhà trọ</option>
                        </select>
                        </div>
                        <div class="text">Chọn chuyên mục</div>
                        <input type="text" name="tieude" class="txt" size="32" value="" placeholder="Tiêu đề sản phẩm"/><br />
                        <?php form_error('tieude');?>
                        <input type="text" name="diachi" class="txt" size="32" value="" placeholder="Địa chỉ giao dịch"/><br />
                        <?php form_error('diachi');?>
                        <input type="number" name="gia" class="txt" placeholder="giá sản phẩm ( vnđ )">
                        <?php form_error('gia');?>
                        <textarea name="chitiet" cols="66" rows="15" placeholder="Thêm chi tiết" value=""></textarea><br>
                        <input id="sub" type="submit" name="submit" value="ĐĂNG TIN"><br/>
                        
                        <?php 
                        if(isset($flag)){
                            if($flag==true){
                            echo "<span style=\"color: #FFF; width: 100%; text-align: center;\">Đăng tin thành công</span><br/>";
                            
                            }
                            else{
                            echo "<span style=\"color: #FFF; width: 100%; text-align: center;\">Đăng tin thất bại</span><br/>";
                            }
                        }
                        
                        ?>
                       
                    </div>
                    
                </form>
             
            </div>
            
        </div>
    </body>
</html>
