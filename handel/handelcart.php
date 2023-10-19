 <?php
//  session_start();
//  require_once '../inc/conn.php';
 
//  if(isset($_SESSION['user_id'])){
 
 
 
//  if (empty($_GET['id']) || !isset($_POST['cart'])) {
//      header("location:shop.php");
//      exit();
//  }
 
//  $product_id = $_GET['id'];
//  $query = "SELECT * FROM products WHERE product_id = $product_id";
//  $result = mysqli_query($conn, $query);
//  if (mysqli_num_rows($result) == 1) {
//     $product = mysqli_fetch_assoc($result);
//     $quantity = intval($_POST['quantity']);
//     $subtotal = $product['price'] * $quantity;
//     $price = $product['price'];
//     $user_id = $_SESSION['user_id'];
//     $insertOrder = "INSERT INTO orders (user_id) VALUES ('$user_id')";
//         $insertOrderResult = mysqli_query($conn, $insertOrder);
//         if ($insertOrderResult) {
//             $query = "SELECT order_id FROM orders where user_id=$user_id";
//             $result=mysqli_query($conn, $query);
//             $orders=mysqli_fetch_all($result,MYSQLI_ASSOC);
//             foreach($orders as $order){
//             $order_id=$order;
//             $insertOrderItemsQuery = "INSERT INTO orderitems (price, quantity, subtotal, product_id, order_id) 
//             VALUES ('$price', '$quantity', '$subtotal', '$product_id', '$order_id')";
//             $insertOrderItemsResult = mysqli_query($conn, $insertOrderItemsQuery);
//             if ($insertOrderItemsResult) {
                
//                 header("location:../cart.php");
//                 exit();
//             } else {
//                 $_SESSION['errors'] = ['error while inserting into orderitems'];
//                 header("location:../shop.php");
//                 exit();
//             }
//         }
//         }else {
//             $_SESSION['errors'] = ['error while inserting order id'];
//             header("location:../shop.php");
//             exit();
//         }
//  }else {
//     $_SESSION['errors'] = ['product id not found'];
//     header("location:../shop.php");
//     exit();
//  }
   
// }else{
//     header("location:../login.php");
// }




?>
<?php
session_start();
require_once '../inc/conn.php';

if (isset($_SESSION['user_id'])) {
    if (empty($_GET['id']) || !isset($_POST['cart'])) {
        header("Location: shop.php");
        exit();
    }

    $product_id = $_GET['id'];
    $query = "SELECT * FROM products WHERE product_id = $product_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $product = mysqli_fetch_assoc($result);
        $quantity = intval($_POST['quantity']);
        $subtotal = $product['price'] * $quantity;
        $price = $product['price'];
        $user_id = $_SESSION['user_id'];

        $insertOrder = "INSERT INTO orders (user_id) VALUES ('$user_id')";
        $insertOrderResult = mysqli_query($conn, $insertOrder);

        if ($insertOrderResult) {
            $order_id = mysqli_insert_id($conn);

            $insertOrderItemsQuery = "INSERT INTO orderitems (price, quantity, subtotal, product_id, order_id) 
                                      VALUES ('$price', '$quantity', '$subtotal', '$product_id', '$order_id')";
            $insertOrderItemsResult = mysqli_query($conn, $insertOrderItemsQuery);

            if ($insertOrderItemsResult) {
                header("Location: ../cart.php");
                exit();
            } else {
                $_SESSION['errors'] = ['Error while inserting into orderitems.'];
                header("Location: ../shop.php");
                exit();
            }
        } else {
            $_SESSION['errors'] = ['Error while inserting order ID.'];
            header("Location: ../shop.php");
            exit();
        }
    } else {
        $_SESSION['errors'] = ['Product ID not found.'];
        header("Location: ../shop.php");
        exit();
    }
} else {
    header("Location: ../login.php");
}
?>