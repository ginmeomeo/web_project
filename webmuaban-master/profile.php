<?php
   session_start();
   include 'module/connect_sql.php';
   function update_user($new_ten,$new_sdt,$new_matkhau,$id_user){
       global $link;
       global $error;
       
       $query_update="UPDATE user SET ten='$new_ten',sdt='$new_sdt', matkhau='$new_matkhau' WHERE id=$id_user";
       if(!mysqli_query($link, $query_update)){
       $error['update']="lỗi cập nhật";
       return FALSE;
       }
       else{
       return TRUE;
       }    
   }
   function form_error($label_field) {
    global $error;
    if (isset($error[$label_field])) {
        echo "<label style=\"color: red; \">{$error[$label_field]}</label><br/>";
    }
   } 
   
   if (isset($_SESSION['sdt']) && $_SESSION['sdt']){
       $sdt=$_SESSION['sdt'];
       $ten=$_SESSION['username'];
       $query="SELECT * FROM user  WHERE sdt LIKE '%$sdt%'";
       $res=mysqli_query($link, $query);
       $row= mysqli_fetch_assoc($res);
       $matkhau=$row['matkhau'];
       $id_user=$row['id'];
       $query_seach="SELECT * FROM post  WHERE sdt LIKE '%$sdt%'"; 
       $result=mysqli_query($link, $query_seach);
       
   }
   else{
       header("Location:logout.php");
   }
   if($_SERVER['REQUEST_METHOD']=="POST"){
	
	$error=array();
        
            if(empty($_POST['name'])){
		$error['name_reg']="bạn cần nhập username";
	    }
	    else{
            $new_name=$_POST['name'];
	    }
        
            if(empty($_POST['sdt'])){
               $error['sdt']="bạn cần nhập số điện thoại";
	    }
	    else{
            
            if($sdt!=$_POST['sdt']){
            $temp=$_POST['sdt'];
            $query_seach="SELECT * FROM user WHERE sdt LIKE '%$temp%'";
            if($res=mysqli_query($link, $query_seach)){
            $num= mysqli_num_rows($res);
             if($num>0){
               $error['sdt']="số điện thoại đã có người đăng kí";
             }
             else{
                 $new_sdt=$_POST['sdt'];
             }
             }
             }
             else{
                $new_sdt=$_POST['sdt']; 
             }
            }
        
	    if(empty($_POST['pass'])){
		$error['pass']="bạn cần nhập password";
	    }
	    else{
               $new_pass=$_POST['pass'];
            }
            
	    if(empty($error)){
		if(update_user($new_name, $new_sdt, $new_pass, $id_user)==true){
                    header("Location:logout.php");
                };
                
	    }
	    else{
            //xử lý lỗi 	
	    }
   }
   if( isset($_GET['id'])&&isset($_GET['delete'])){
       if($_GET['id']==$id_user){
           $post_id=$_GET['delete'];
           $query_delete = "DELETE FROM post WHERE id='$post_id' and sdt=$sdt" ;
           if(!mysqli_query($link, $query_delete)){
            die('lỗi truy cập sql<br/>'. mysqli_error($link));
           }
           else{
               header("Location:profile.php");
           }
           
       }
   }
   
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Hồ sơ</title>
        <link href="css/css_index.css" rel="stylesheet" type="text/css"/>
        <link href="css/css_profile.css" rel="stylesheet" type="text/css"/>
        <script src="jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script>
          $(document).ready( function(){//load body truoc
          $(".menu-sub").hide();
	  $(".menu").hover( function(){
		$(this).find('div:first').next().slideToggle(200);
	  });
          });
        </script>
    </head>
    <body>
        <div class="wrapper">
            <?php
            include 'module/header.php';
            ?>
            <div class="select">
            <div class="croll">
                <a href="index.php?danhmuc=tất cả">Trang chủ ></a>
                <a href="profile.php">hồ sơ</a>
            </div>
            </div>
            <div class='profile'>
                <form id="sign_up" action="profile.php" method="post">
                    <h5>Thông tin tài khoản</h5>
                    <label>Tên</label><br>
                    <input type="text" name="name" class="txt" size="32" value="<?php echo $ten;?>"/><br />
                    <?php form_error('name');?>
                    <label>số điện thoại</label><br>
                    <input type="text" name="sdt" class="txt" size="32" value="<?php echo $sdt;?>"/><br />
                    <?php form_error('sdt');?>
                    <label>mật khẩu</label><br>
                    <input type="password" name="pass" class="txt" size="32" value="<?php echo $matkhau;?>"/><br />
                    <?php form_error('pass');?>
                    <input  class="submit" type="submit" name="update" value="cập nhập" /><br />
                    <?php form_error('update'); 
                    if(!empty($flag)){
                        if($flag==TRUE){
                             echo "<label style=\"color: blue; \">bạn đã cập nhật thành công</label><br/>";
                        }
                    }
                    ?>
            </form>   
            <h5>Hàng đã đăng bán</h5>
            <div class="list">
            <?php
            if(mysqli_num_rows($result)>0){
            while($row= mysqli_fetch_assoc($result)){
            ?>
            <div class="product">
            <a href="detail.php?id=<?php echo $row['id']; ?>">
                    <img src="images-upload/<?php echo $row['anh1'];?> " width="200px" height="200px"/>
                    <div class="title">
                    <?php echo substr($row['tieude'],0,34);?><br/>
                    Giá: <?php echo substr($row['gia'],0,15);?>đ<br/>
                    <?php echo substr($row['diachi'],0,35);?><br/>
                    Từ: <?php echo substr($row['ngaydang'],0,22);?>
                    </div>
            </a>
                <a class='xoa' href="profile.php?id=<?php echo $id_user; ?>&delete=<?php echo $row['id'];?>"> Xóa</a>
            </div>
            <?php
            }
            }
            ?>
            </div>
                
            </div>
        </div>
    </body>
</html>
