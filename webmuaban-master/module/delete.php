<?php
//xóa dữ liệu//
require 'connect_sql.php';
$name='dinhnam';
$sql_delete = "DELETE FROM post WHERE ten='$name'" ;
if(!mysqli_query($link, $sql_delete)){
 die('lỗi truy cập sql<br/>'. mysqli_error($link));
}
else{
    echo 'xóa dữ liệu thành công';
}

?>
