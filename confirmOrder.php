<?php
session_start();
if(isset($_POST['submit'])){
    //catch
    $name = trim(htmlspecialchars($_POST['name']));
    $city = trim(htmlspecialchars($_POST['city']));
    $email = trim(htmlspecialchars($_POST['email']));
    $phone = trim(htmlspecialchars($_POST['phone']));
    $address = trim(htmlspecialchars($_POST['address']));
    //validation
    $errors = [];
    //name
    if (empty($_POST['name'])) {
        $errors[] = "username is required";
      } elseif (!is_string($_POST['name'])) {
        $errors[] = "username must be a string";
      } elseif (strlen($name) >= 100) {
        $errors[] = "username must be less than 100";
      }
    //city
    if (empty($_POST['city'])) {
        $errors[] = "city name is required";
      } elseif (!is_string($_POST['city'])) {
        $errors[] = "city name must be a string";
      } elseif (strlen($city) >= 100) {
        $errors[] = "city name must be less than 100";
      }
      // email
      if (empty($_POST['email'])) {
        $errors[] = "email is required";
      } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "you must write email form";
      } elseif (strlen($email) >= 100) {
        $errors[] = "email must be less than 100";
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
    //massage
     if (empty($errors)) {
      $_SESSION['success']="Congratulations, your order has been placed!";
      header("locaton:confirmOrder.php");

     }else {
        $_SESSION['errors']=$errors;
        header("locaton:confirmOrder.php");
     }
}else{
    header("locaton:confirmOrder.php");
}




?>
<?php

if(isset($_SESSION['user_id'])){
include "header.php";
include "navbar.php";

?>


<section id="cart-add" class="section-p1">
    <form>
    
        <div id="coupon">
            <h3>Coupon</h3>
            <input type="text" name="coupon" placeholder="Enter coupon code">
            <button class="normal" type="submit" >Apply</button>
        </div>
        </form>
        <div id="subTotal">
            <h3>Cart totals</h3>
            <?php 
            
                 if(isset($_SESSION['errors'])){
                  foreach($_SESSION['errors'] as $error){?>
                 <div class="alert alert-danger"><?php echo $error;?></div>
                 <?php
                  }
                  unset($_SESSION['errors']);
                   
                }
                ?>
               
            <!-- <form class=" col-4" > -->
            <form class=" col-4" method="post" action="confirmOrder.php">
            <?php

if(isset($_SESSION['success'])){
      ?>
     <div class="alert alert-success"><?php echo $_SESSION['success'];?></div>
     <?php
      
      unset($_SESSION['success']);
}
?>
                name<input type="text" name="name" >
               email <input type="email"name="email"  >
                address<input type="text"  name="address" >
                city<input type="text" name="city" >
                postalCode<input type="number"  >
                phone<input type="text" name="phone">
                paymentType<select >
                <option value="Cash_on_Delivery">Cash on Delivery</option>
                    <option value="Credit_Card">Credit Card</option>
                    <option value="Fawry">Fawry</option>
                </select>
                
                <button class="normal" type="submit" name="submit" >proceed to checkout</button>
            </form>
            </form>
           
        </div>
    </section>


    <?php include "footer.php" ?>
    <?php
    }else{
    header("location:login.php");
}
?>