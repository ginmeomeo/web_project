<?php
//thêm dữ liệu//
function insert_post($name,$sdt,$khuvuc,$danhmuc,$tieude,$diachhi,$gia,$chitiet,$ngaydang,$img1,$img2,$img3,$img4){
    global $link;
    $insert="INSERT INTO post(ten,sdt,khuvuc,danhmuc,tieude,diachi,gia,chitiet,ngaydang,anh1,anh2,anh3,anh4)"
            . " VALUES('$name','$sdt','$khuvuc','$danhmuc','$tieude','$diachhi','$gia','$chitiet','$ngaydang','$img1','$img2','$img3','$img4')";
    if(!mysqli_query($link, $insert)){
      die('lỗi truy cập sql<br/>'. mysqli_error($link));
      return FALSE;
    }
    else{
      return TRUE;
    }
}
function form_error($label_field) {
    global $error;
    if (isset($error[$label_field])) {
        echo "<span style=\"color: #FFF;\">{$error[$label_field]}</span><br/>";
    }
}
?>
