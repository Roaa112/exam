<?php
session_start();
require_once '../inc/conn.php';
//start the session 
if(isset($_POST['signup'])){
  // catch
  $user_name = trim(htmlspecialchars($_POST['name']));
  $email = trim(htmlspecialchars($_POST['email']));
  $password = trim(htmlspecialchars($_POST['password']));
  $phone = trim(htmlspecialchars($_POST['phone']));
  $address = trim(htmlspecialchars($_POST['address']));
  //validation 
  $errors=[];
  // user name
  if (empty($_POST['name'])) {
    $errors[] = "username is required";
  } elseif (!is_string($_POST['name'])) {
    $errors[] = "username must be a string";
  } elseif (strlen($user_name) >= 100) {
    $errors[] = "username must be less than 100";
  }
  // email
  // 1) $email_column=array($_SESSION['data'],$email);
  if (empty($_POST['email'])) {
    $errors[] = "email is required";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "you must write email form";
  } elseif (strlen($email) >= 100) {
    $errors[] = "email must be less than 100";
}
//make sure that email is uniqe
$query="select email as email from users ";
$result=mysqli_query($conn,$query);

if(mysqli_num_rows($result)>0){
    $emailUniq=mysqli_fetch_all($result,MYSQLI_ASSOC);
    foreach ($emailUniq as $E) {
      if ($email == $E['email']) {
          $errors[] = "Email already exists";
          break;
      }
  }
}
// password
if (empty($_POST['password'])) {
  $errors[] = "password is required";
} elseif (!is_string($_POST['password'])) {
  $errors[] = "you must write pass form";
} elseif (strlen($password) < 6) {
  $errors[] = "password must be at least 6 characters";
}
// phone
if (empty($_POST['phone'])) {
  $errors[] = "phone is required";
} elseif (!ctype_digit($_POST['phone'])) {
  $errors[] = "phone must be numeric";
} elseif (!preg_match('/^\d{8,15}$/', $phone)) {
  $errors[] = "phone must be between 8 and 15 digits";
}
// address
if (empty($_POST['address'])) {
  $errors[] = "address is required";
} elseif (!is_string($_POST['address'])) {
  $errors[] = "address must be a string";
} elseif (strlen($address) >= 200) {
  $errors[] = "address must be less than 200";
}
//password hashed
$passwordHashed=password_hash($password,PASSWORD_DEFAULT);

//if empty errors then store data in session 
if(empty($errors)){
    $query="insert into users (`name`, `email`, `password`,`phone`,`address`,`field`) 
    VALUES ('$user_name', '$email', '$passwordHashed','$phone','$address','user')";
    $result=mysqli_query($conn,$query);
    if($result){
        header("location:../login.php");
    }else{
        $errors[] = "error while insert"; 
        header("location:../signup.php");
    }

}else{
    $_SESSION['errors'] = $errors;
    header("location:../signup.php");
    exit(); 
}


}else{
    header("location:../signup.php");
}





?>



