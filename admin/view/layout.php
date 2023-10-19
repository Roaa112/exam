<?php
session_start();
if(isset($_SESSION['user_id'])){
include "../view/header.php";
include "../view/sidebar.php";
include "../view/body.php";
include "../view/navbar.php";
include "../view/footer.php";
}else{
    header("location:../../login.php");
}
