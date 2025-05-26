<?php
session_start();

if(isset($_SESSION['admin_data'])){
    header("location:dashboard_module/index.php");
}else if(!isset($_SESSION['admin_data'])){
    header("location:login_module/index.php");
}
?>