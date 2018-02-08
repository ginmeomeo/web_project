<?php
function resize_img($src,$width,$height){
    $new_width=$width;
    $new_height=$height;
    list($w,$h)=getimagesize($src);
    if($w>=$h){
        $raito=$w/$width;
        $new_height=$h/$raito;
    }
    else{
        $raito=$h/$height;
        $new_width=$w/$raito;
    }
    $mg_top=FLOOR(($height-$new_height)/2);
    $mg_left=FLOOR(($width-$new_width)/2);
    return $size_img= "width=\"$new_width px\" height=\"$new_height px\" style=\" margin-top:$mg_top"."px; margin-left: $mg_left"."px; \" ";
}
?>
