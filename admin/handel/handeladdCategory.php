<?php
session_start();
if(isset($_SESSION['user_id'])){
require_once '../../inc/conn.php';
if(isset($_POST['addCategory'])){
    $title=$_POST['title'];
    //validate
    $errors=[];
  //name
  if (empty($_POST['title'])) {
    $errors[] = "category name is required";
  } elseif ( is_numeric($_POST['title'])) {
    $errors[] = "category name must be a string";
  } elseif (strlen($title) >= 100) {
    $errors[] = "category name must be less than 100";
  }
  if(empty($errors)){
    $query="insert into categories (`category_name`) VALUES ('$title')";
    $result=mysqli_query($conn,$query);
    if($result){
        $_SESSION['success']="category inserted successfuly";
        header("location:../view/addCategory.php");
    }else{
        $errors[] = "error while insert"; 
        header("location:../view/addCategory.php");
    }

}else{
    $_SESSION['errors'] = $errors;
    header("location:../view/addCategory.php");
}

}else{
header("location:../view/addCategory.php");
}
}else{
  header("location:../../login.php");
}