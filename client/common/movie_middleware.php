<?php
session_start();

if(!isset($_SESSION['user']))
{
    $_SESSION['logInRedirect']['id'] = $_GET['id'];
    $_SESSION['logInRedirect']['type']= $_GET['type'];
    header("location: ../log-in.php");
}
if($_GET['type'] == "movie")
{

    header("location: ../player/movie_player.php?id=".md5($_GET['id']));
}
else if($_GET['type'] == "trailler")
{
    header("location: ../player/trailler_player.php?id=".md5($_GET['id']));

}
else if($_GET['type'] == "Teaser")
{
    header("location: ../player/teaser_player.php?id=".md5($_GET['id']));

}
?>