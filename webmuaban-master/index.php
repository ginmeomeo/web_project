<?php
session_start();

if (isset($_SESSION['username']) && $_SESSION['username']){};
include 'module/connect_sql.php';
$count=10;
$query_seach="SELECT * FROM post";
function local($danhmuc,$khuvuc,$loc,$trang,$search){
    return "index.php?danhmuc=$danhmuc&khuvuc=$khuvuc&loc=$loc&trang=$trang&search=$search";
}
if( isset($_GET['search'])){
    $search=(string)$_GET['search'];
}
else{
    $search="";
}
if( isset($_GET['danhmuc'])){
    $danhmuc=(string)$_GET['danhmuc'];
    //$query_seach="SELECT * FROM post WHERE  danhmuc LIKE '%$danhmuc%' ORDER BY id DESC";
    //$query_seach="SELECT * FROM post ORDER BY id DESC";
}
else{
    $danhmuc="tất cả";
    //$query_seach="SELECT * FROM post ORDER BY id DESC";
}
if( isset($_GET['khuvuc'])){
    $khuvuc=(string)$_GET['khuvuc'];
}
else{
    $khuvuc="hà nội";
}
if( isset($_GET['trang'])){
    $trang=(int)$_GET['trang'];
}
else{
    $trang=1;
}
if( isset($_GET['loc'])){
    $loc=(string)$_GET['loc'];
}
else{
    $loc="";
}
if($danhmuc!="tất cả"){
$query_seach="SELECT * FROM post  WHERE danhmuc LIKE '%$danhmuc%'";
if($khuvuc!="hà nội"){
$query_seach=$query_seach." and khuvuc LIKE '%$khuvuc%'";  
}
if($search!=""){
$query_seach=$query_seach." and tieude LIKE '%$search%'";  
}
}
else{
    if($khuvuc!="hà nội"){
    $query_seach="SELECT * FROM post  WHERE khuvuc LIKE '%$khuvuc%'";
    if($search!=""){
    $query_seach=$query_seach." and tieude LIKE '%$search%'";  
    }
    }
    else{
    if($search!=""){
    $query_seach="SELECT * FROM post  WHERE tieude LIKE '%$search%'"; 
    }
    else{
    $query_seach="SELECT * FROM post";    
    }
    }
}

if($res=mysqli_query($link, $query_seach)){
    $num= mysqli_num_rows($res);
    if($num>0){
        $result=$res;
        $num_page= CEIL($num/$count);
    }
    else{
        $num_page=1;
    }
}
 $start_page=($trang-1)*$count;
 if($loc==""){
 $query= $query_seach."  ORDER BY id DESC"." limit $start_page , $count";
 }
 else if($loc=="thapdencao"){
     $query= $query_seach."  ORDER BY gia ASC"." limit $start_page , $count";
 }
 else if($loc=="caodenthap"){
     $query= $query_seach."  ORDER BY gia DESC"." limit $start_page , $count";
 }
 $result=mysqli_query($link, $query);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Chợ đồ cũ</title>
        <link href="css/css_index.css" rel="stylesheet" type="text/css"/>
        <script src="jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script>
          $(document).ready( function(){//load body truoc
          $(".menu-sub").hide();
	  $(".menu").hover( function(){
		$(this).find('div:first').next().slideToggle(200);
	  });
          $('select').on('change', function (e) {
          var optionSelected = $("option:selected", this);
          var valueSelected = this.value;
          window.location=""+valueSelected;
          });
          $("#img_search").click( function(){
		var search=$('#search').val();
                var alt = $(this).attr("alt");
                window.location=""+alt+search;
	  });
          });
        </script>
    </head>
    <body>
        <div class="wrapper">
        <?php
        include 'module/header.php';
        ?>
        <div class="content">
        
        <div class="select">
            <div class="croll">
                <a href="index.php?danhmuc=tất cả">Trang chủ ></a>
                <?php 
                if(isset($danhmuc)){
                echo "<a href=\"index.php?danhmuc=$danhmuc\">$danhmuc></a>";
                echo "<span>trang</span>";
                echo "<a href=\"".local($danhmuc,$khuvuc,$loc,1,$search)."\">1</a>";
                $next_page=$trang+1;
                $back_page=$trang-1;
                if($back_page>0){
                 echo "<a href=\"".local($danhmuc,$khuvuc,$loc,$back_page,$search)."\"><</a>";
                }
                for($i=2;$i<$num_page;$i++){
                     echo "<a href=\"".local($danhmuc,$khuvuc,$loc,$i,$search)."\">$i</a>";
                }
                if($next_page<$num_page){
                 echo "<a href=\"".local($danhmuc,$khuvuc,$loc,$next_page,$search)."\">></a>";
                }
                if($num_page>1){
                 echo "<a href=\"".local($danhmuc,$khuvuc,$loc,$num_page,$search)."\">$num_page</a>";
                }
                }
                ?>
            </div>
            
            <div class="menu-select">
                <select id="select_1">
                <option <?php echo "value=\"".local($danhmuc,$khuvuc,"",$trang,$search)."\""; if(isset($loc)&&$loc==""){echo" selected='selected'";}?>>Lọc/ Bỏ lọc</option>
                <option <?php echo "value=\"".local($danhmuc,$khuvuc,"thapdencao",$trang,$search)."\""; if(isset($loc)&&$loc=="thapdencao"){echo" selected='selected'";}?>>Giá thấp -> cao</option>
                <option <?php echo "value=\"".local($danhmuc,$khuvuc,"caodenthap",$trang,$search)."\""; if(isset($loc)&&$loc=="caodenthap"){echo" selected='selected'";}?>>Giá cao -> thấp</option>
                </select>
            </div>
            <div class="menu-select">
                <select id="select_2">
                <option <?php echo "value=\"".local($danhmuc,"",$loc,1,$search)."\""; if(isset($khuvuc)&&$khuvuc=="hà nội"){echo" selected='selected'";}?>>Hà nội</option>
                <option <?php echo "value=\"".local($danhmuc,"quận hoàn kiếm",$loc,1,$search)."\""; if(isset($khuvuc)&&$khuvuc=="quận hoàn kiếm"){echo" selected='selected'";}?>>quận hoàn kiếm</option>
                <option <?php echo "value=\"".local($danhmuc,"quận ba đình",$loc,1,$search)."\""; if(isset($khuvuc)&&$khuvuc=="quận ba đình"){echo" selected='selected'";}?>>quận ba đình</option>
                <option <?php echo "value=\"".local($danhmuc,"quận đống đa",$loc,1,$search)."\""; if(isset($khuvuc)&&$khuvuc=="quận đống đa"){echo" selected='selected'";}?>>quận đống đa</option>
                <option <?php echo "value=\"".local($danhmuc,"quận hai bà trưng",$loc,1,$search)."\""; if(isset($khuvuc)&&$khuvuc=="quận hai bà trưng"){echo" selected='selected'";}?>>quận hai bà trưng</option>
                <option <?php echo "value=\"".local($danhmuc,"quận thanh xuân",$loc,1,$search)."\"";if(isset($khuvuc)&&$khuvuc=="quận thanh xuân"){echo" selected='selected'";}?>>quận thanh xuân</option>
                <option <?php echo "value=\"".local($danhmuc,"quận cầu giấy",$loc,1,$search)."\""; if(isset($khuvuc)&&$khuvuc=="quận cầu giấy"){echo" selected='selected'";}?>>quận cầu giấy</option>
                <option <?php echo "value=\"".local($danhmuc,"quận hoàng mai",$loc,1,$search)."\""; if(isset($khuvuc)&&$khuvuc=="quận hoàng mai"){echo" selected='selected'";}?>>quận hoàng mai</option>
                <option <?php echo "value=\"".local($danhmuc,"quận long biên",$loc,1,$search)."\""; if(isset($khuvuc)&&$khuvuc=="quận long biên"){echo" selected='selected'";}?>>quận long biên</option>
                <option <?php echo "value=\"".local($danhmuc,"quận tây hồ",$loc,1,$search)."\""; if(isset($khuvuc)&&$khuvuc=="quận tây hồ"){echo" selected='selected'";}?>>quận tây hồ</option>
                <option <?php echo "value=\"".local($danhmuc,"quận hà đông",$loc,1,$search)."\""; if(isset($khuvuc)&&$khuvuc=="quận hà đông"){echo" selected='selected'";}?>>quận hà đông</option>
                </select>
            </div>
            <div class="search_form">
                <img id="img_search" src="images/Search.png" alt="<?php echo local($danhmuc, $khuvuc, $loc, 1,"");?>"/>
                <input type="text" name="search" id="search"  <?php if($search!=""){echo "value=\"$search\"";}?>" placeholder="Tìm kiếm ..." >
            </div>    
            
            
        </div>
         <div class="status" style="width: 100%;height: 20px;font-size: 13px;float: left; background-color: #FFF">tìm thấy <?php echo $num;?> hàng đang được rao bán</div>
        <div class="list-product">
            <?php
            if(mysqli_num_rows($result)>0){
            while($row= mysqli_fetch_assoc($result)){
            ?>
            <a href="detail.php?id=<?php echo $row['id']; ?>">
                    <img src="images-upload/<?php echo $row['anh1'];?> " width="234px" height="234px"/>
                    <div class="title">
                    <?php echo substr($row['tieude'],0,34);?><br/>
                    Giá: <?php echo substr($row['gia'],0,15);?>đ<br/>
                    <?php echo substr($row['diachi'],0,35);?><br/>
                    Từ: <?php echo substr($row['ngaydang'],0,22);?>
                    </div>
            </a>
            <?php
            }
            }
            ?>
        </div>
        </div>
        <div class="clear"></div>
        <div class="footer">
            <span>Coppyright 2017</span>
        </div>
        </div>
    </body>
</html>
