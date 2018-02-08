<?php 
session_start(); 
if (isset($_SESSION['username'])){
    unset($_SESSION['username']);
    unset($_SESSION['sdt']);
}
header("Location:index.php");
?>

