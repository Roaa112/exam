<?php
session_start();
require_once '../inc/conn.php';

//start the session 
if(isset($_POST['login'])){
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));
    //validation 
    $errors=[];
    if (empty($_POST['email'])) {
        $errors[] = "email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "you must write email form";
    } elseif (strlen($email) >= 100) {
        $errors[] = "email must be less than 100";
    }
    // password
    if (empty($_POST['password'])) {
       $errors[] = "password is required";
    } elseif (!is_string($_POST['password'])) {
       $errors[] = "you must write pass form";
    } elseif (strlen($password) < 6) {
       $errors[] = "password must be at least 6 characters";
    }

    if(empty($errors)){
//user
        $query="select * from users where `email`='$email'";
        $result= mysqli_query($conn,$query);
        if(mysqli_num_rows($result)==1){
            //كدا اتاكدت ان في شخص عندة الايميل دة ناقص اتاكد من ال باسورد

            $row = mysqli_fetch_assoc($result);
            $user_id = $row['user_id'];
            $_SESSION['user_id']=$row['user_id'];
        if($row['field']=="user"){
            $oldpassword = $row['password'];
            $name =$row['name'];
            
            if( password_verify($password,$oldpassword)){
                $_SESSION['success']="welcome ".$name;
               
                header("location:../shop.php");
            }else{
                $_SESSION['errors']=["email or pass not currect"];
                header("location:../Login.php");
            }
        }else{
            $oldpassword = $row['password'];
           
            if( password_verify($password,$oldpassword)){
                $_SESSION['user_id']=$user_id;
                header("location:../admin/view/layout.php");
            }else{
                $_SESSION['errors']=["email or pass not currect"];
                header("location:../login.php");
            }
        }
        }else{
                $_SESSION['errors']=["this account not exist"];
                header("location:../login.php");
            
        }
    }else{
        $_SESSION['errors'] = $errors;
        header("location:../login.php");
    }

}else{
    header("location:../login.php");
}







?>