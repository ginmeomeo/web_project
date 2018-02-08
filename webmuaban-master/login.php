<?php
session_start();
include 'module/connect_sql.php';
function insert_user($ten,$sdt,$matkhau){
       global $link;
       global $error;
       $query_seach="SELECT * FROM user WHERE sdt LIKE '%$sdt%'";
       if($res=mysqli_query($link, $query_seach)){
       $num= mysqli_num_rows($res);
       if($num>0){
        $error['sdt_reg']="số điện thoại đã có người đăng kí";
        return FALSE;
       }
       else{
       $insert="INSERT INTO user(ten,sdt,matkhau) VALUE ('$ten','$sdt','$matkhau')";
       if(!mysqli_query($link, $insert)){
          $error['dangki']="lỗi đăng kí, vui lòng thử lại";
       return FALSE;
       }
       else{
       return TRUE;
       }
       }
       }
       
}
function form_error($label_field) {
    global $error;
    if (isset($error[$label_field])) {
        echo "<label style=\"color: red; \">{$error[$label_field]}</label><br/>";
    }
}

if($_SERVER['REQUEST_METHOD']=="POST"){
	// phất cờ
	$error=array();
        
        if(isset($_POST['submit_login']) ){
            if(empty($_POST['sdt'])){
             $error['sdt']="bạn cần nhập số điện thoại";
	    }
	    else{
            $sdt=$_POST['sdt'];
            $query_seach="SELECT * FROM user WHERE sdt LIKE '%$sdt%'";
            if($res=mysqli_query($link, $query_seach)){
            $num= mysqli_num_rows($res);
            if($num==0){
             $error['sdt']="tài khoản không tồn tại";
            }
            }
	    }
        
	    if(empty($_POST['password'])){
            $error['password']="bạn cần nhập password";
	    }
	    else{
            $password=$_POST['password'];    
            }
            
            if(empty($error)){
		$row= mysqli_fetch_assoc($res);
                if($password!=$row['matkhau']){
                    $error['password']="mật khẩu không đúng";
                }
                else{
                    $_SESSION['username']=$row['ten'];
                    $_SESSION['sdt']=$row['sdt'];
                    header("Location:index.php");
                }
	    }
	    else{
             	
	    }
        }
        
       
        if(isset($_POST['submit_reg']) ){ 
            if(empty($_POST['name_reg'])){
		$error['name_reg']="bạn cần nhập username";
	    }
	    else{
            $name_reg=$_POST['name_reg'];
	    }
        
            if(empty($_POST['sdt_reg'])){
               $error['sdt_reg']="bạn cần nhập số điện thoại";
	    }
	    else{
            $sdt_reg=$_POST['sdt_reg'];
	    }
        
	    if(empty($_POST['pass_reg'])){
		$error['pass_reg']="bạn cần nhập password";
	    }
	    else{
               $pass_reg=$_POST['pass_reg'];
            }
            
	    if(empty($error)){
		$flag=insert_user($name_reg, $sdt_reg, $pass_reg);
	    }
	    else{
            //xử lý lỗi 	
	    }
        }
        
	
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>login</title>
        <link href="css/css_index.css" rel="stylesheet" type="text/css"/>
        <link href="css/css_login.css" rel="stylesheet" type="text/css"/>
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
                <a href="login.php">Đăng nhập/ Đăng kí</a>
                </span>
                
            </div>
            </div>
            <div class="dangnhap">
                <form id="login" action="login.php" method="post">
                    <label style="font-size: 12px; color: red;">bạn cần đăng nhập để có thể đăng tin</label>
                    <h4 >ĐĂNG NHẬP</h4>
                    <label>số điện thoại</label><br>
                    <input type="text" name="sdt" class="txt" size="32" value=""/><br />
                    <?php form_error('sdt');?>
                    <label>mật khẩu</label><br>
                    <input type="password" name="password" class="txt" size="32" value=""/><br />
                    <?php form_error('password');?>
                    <input class="submit" type="submit" name="submit_login" value="Đăng nhập" /><br/>
                    <?php form_error('dangnhap');?>
                </form>
                
                <form id="sign_up" action="login.php" method="post">
                    <label style="font-size: 12px; color: red;">nếu bạn chưa có tài khoản hãy đăng kí</label>
                    <h4>ĐĂNG KÍ</h4>
                    <?php
                    if(!empty($flag)){
                        if($flag==TRUE){
                             echo "<label style=\"color: blue; \">bạn đã đăng kí thành công</label><br/>";
                        }
                    }
                    ?>
                    <label>Tên</label><br>
                    <input type="text" name="name_reg" class="txt" size="32" value=""/><br />
                    <?php form_error('name_reg');?>
                    <label>số điện thoại</label><br>
                    <input type="text" name="sdt_reg" class="txt" size="32" value=""/><br />
                    <?php form_error('sdt_reg');?>
                    <label>mật khẩu</label><br>
                    <input type="password" name="pass_reg" class="txt" size="32" value=""/><br />
                    <?php form_error('pass_reg');?>
                    <input  class="submit" type="submit" name="submit_reg" value="Đăng kí" /><br />
                    <?php form_error('dangki'); ?>
                </form>
            </div>
        </div>
    </body>
</html>
