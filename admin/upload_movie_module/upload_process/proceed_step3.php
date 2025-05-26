<?php
session_start();
$_SESSION['upload_movie_step']="step4.php";
header("location:../../dashboard_module/add_movie.php");
?>