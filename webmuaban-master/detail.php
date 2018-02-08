<?php
session_start();
include 'module/connect_sql.php';
include 'module/resize_image.php';

if( isset($_GET['id'])){
    $id_post=(int)$_GET['id'];
    $query_select="SELECT * FROM post WHERE  id LIKE '%$id_post%'";
    if($result=mysqli_query($link, $query_select)){
    if(mysqli_num_rows($result)>0){
    $row= mysqli_fetch_assoc($result);
    $img=array();
    $name=$row['ten'];
    $sdt=$row['sdt'];
    $khuvuc=$row['khuvuc'];
    $danhmuc=$row['danhmuc'];
    $tieude=$row['tieude'];
    $diachi=$row['diachi'];
    $gia=$row['gia'];
    $chitiet=$row['chitiet'];
    $ngaydang=$row['ngaydang'];
    $img[0]=$row['anh1'];
    $img[1]=$row['anh2'];
    $img[2]=$row['anh3'];
    $img[3]=$row['anh4'];
    }
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Chợ đồ cũ</title>
        <link href="css/css_index.css" rel="stylesheet" type="text/css"/>
        <link href="css/css_detail.css" rel="stylesheet" type="text/css"/>
        <script src="jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script>
        $(document).ready( function(){
          $(".menu-sub").hide();
	  $(".menu").hover( function(){
		$(this).find('div:first').next().slideToggle(200);
	  });
          $k=0;
          $temp=0;
          $('#id0').show();
          $("#next").click( function(){
               $temp=$k+1;
               if($('#id'+$temp).length){
                   $('.img_product').hide();
                   $k=$k+1;
                   if($k>3){
                   $k=0;
                   }
                   $('#id'+$k).show();
               }   
	  });
          $("#back").click( function(){
               $temp=$k-1;
               if($('#id'+$temp).length){
                   $('.img_product').hide();
                   $k=$k-1;
                   if($k<0){
                   $k=3;
                   }
                   $('#id'+$k).show();
               }
               
	  });
          $(window).scroll(function(){
		if($(window).scrollTop() - $(".image").position().top < 0){
		$('.image').css({'position':'relative'});
		}else{
		$('.image').css({'position':'fixed'});
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
        <div class="detail">
            <div class="select">
            <div class="croll">
                <a href="index.php?danhmuc=tất cả">Trang chủ ></a>
                <a href="index.php?danhmuc=<?php echo $danhmuc?>">
                    <?php
                    if( isset($row)){
                        echo "$danhmuc>";
                    }
                    ?>
                </a>
                <span>
                    <?php
                    if( isset($row)){
                        echo $tieude;
                    }
                    ?>
                </span>
                
            </div>
            </div>
            <div class="image">
                
                <?php
                if( isset($img)){
                for($i=0;$i<4;$i++){
                    if(strcmp($img[$i],'')){
                    echo "<img class=\"img_product\" id=\"id".$i."\"src=\"images-upload/$img[$i]\"".resize_img("images-upload/$img[$i]",500,500)."/>"; 
                    }
                }
                }
                ?>
                <img  id='back' src="images/back.png" alt=""/>
                <img  id='next' src="images/next.png" alt=""/>
              
            </div>
            
            <div class="details" >
                <?php if( isset($row)){
                ?>
                <ul>
                    <li style="font-size: 22px; ">
                        <?php echo $tieude; ?>
                    </li>
                    <li style="color: #9c3328;">
                        <span>Giá bán: </span> <?php echo $gia." vnđ"; ?>
                    </li>
                    <li>
                        <span>Tên người bán: </span><?php echo $name; ?>
                    </li>
                    <li>
                       <span> SĐT liên hệ: </span><?php echo $sdt; ?>
                    </li>
                    <li>
                        <span>Địa chỉ giao dịch: </span><?php echo $diachi; ?>
                    </li>
                    <li>
                       <span> Ngày đăng: </span><?php echo $ngaydang; ?>
                    </li>
                    <li>
                       ---------------------------------------------------
                    </li>
                    <li style="font-size: 14px;">
                        <?php 
                        $comment= nl2br($chitiet,FALSE);
                        echo $comment; 
                        ?>
                    </li>
                    
                </ul>
                <?php
                }
                ?>
            </div>
        </div>
        
        </div>
    </body>
</html>
