<?php
session_start();
if(isset($_SESSION['user_id'])){
require_once '../../inc/conn.php';
if(isset($_POST['addProduct'])){
    $category=trim(htmlspecialchars($_POST['cat']));
    $title=trim(htmlspecialchars($_POST['title']));
    $description=trim(htmlspecialchars($_POST['desc']));
    $price=trim(htmlspecialchars($_POST['price']));
    $quantity=trim(htmlspecialchars($_POST['quantity']));
    //image
    $images=$_FILES['img'];
    $image_name=$images['name'];
    $tmp_name=$images['tmp_name'];
    $ext = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
    $size= $images['size']/(1024*1024);
    //validaton 
    $errors=[];
    $array=["png","jpeg","jpg"];
    //cat desc 
  if (empty(($_POST['cat']))||empty($_POST['desc'])) {
    $errors[] = "category and title and description is required";
  } elseif (( is_numeric($_POST['desc']))  ||(!is_string($_POST['cat']))) {
    $errors[] = "username must be a string";
  } 

  //title
  if(empty($_POST['title'])){
    $errors[]="title is requerd";
  }elseif( ! is_string($title)){
    $errors[]="title must be string";
  }elseif(strlen($title)>100){
    $errors[]="title must be less tha 100";
  }
  // quantity
  if(empty($_POST['quantity'])){
    $errors[]="quantity is requerd";
  }elseif(! is_numeric($quantity)){
    $errors[]="quantity must be numeric";
  }
//price
  if(empty($_POST['price'])){
    $errors[]="price is requerd";
  }elseif(! is_numeric($price)){
    $errors[]="price must be numeric";
  }
  //image validation 
  if(!is_string($image_name)){
   $errors[]="image name must be string";
  }elseif(!in_array($ext,$array)){
   $errors[]="image name must be string";
  }elseif($size>1){
   $errors[]="image is too large";}
  if(empty($errors)){
    $query="select category_id from categories where `category_name`='$category'";
    $result=mysqli_query($conn,$query);
    if(mysqli_num_rows($result)==1){
        $category_id=mysqli_fetch_assoc($result)['category_id'];
        $_SESSION['category_id']=$category_id;
    }else{
        $errors[] = "category not exisit"; 
        header("location:../view/addProduct.php"); 
    }
    $query = "INSERT INTO products (`title`,`description`,`image`,`price`,`quantity`,`category_id`)
    VALUES ('$title','$description','$image_name','$price','$quantity','$category_id')";
    $result=mysqli_query($conn,$query);
    if($result){
        $_SESSION['success']="product inserted successfuly";
        move_uploaded_file($tmp_name,"../uplode/$image_name");
        header("location:../view/addProduct.php");
    }else{
        $errors[] = "error while insert"; 
        header("location:../view/addProduct.php");
    }


  }else{
    $_SESSION['errors']=$errors;
    header("location:../view/addProduct.php");
  }

}else{
    header("location:../view/addProduct.php");
}
}else{
  header("location:../../login.php");
}