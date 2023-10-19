<?php
session_start();
require_once '../inc/conn.php';
if(isset($_SESSION['user_id'])){
if(isset($_POST['delete'])){
    if(isset($_POST['id'])){
        $product_id=$_POST['id'];
        $query="SELECT order_id FROM orderitems WHERE product_id=$product_id";
        $result=mysqli_query($conn,$query);
        if(mysqli_num_rows($result)>0){
            $order_id=mysqli_fetch_assoc($result,)['order_id'];
            $_SESSION['order_id']=$order_id;
            $deleteOrderItemsQuery="DELETE  FROM orderitems WHERE product_id=$product_id";
            $deleteOrderItemsResult=mysqli_query($conn,$deleteOrderItemsQuery);
            if($deleteOrderItemsResult){
            $order_id=$_SESSION['order_id'];
              $deleteOrderQuery="DELETE  FROM orders WHERE order_id=$order_id ";
            $deleteOrderResult=mysqli_query($conn,$deleteOrderQuery);
            unset($_SESSION['order_id']);
                if($deleteOrderResult){
                    
                 
                    $_SESSION['success']="Product deleted successfully";
                    header("location:../cart.php");
                    exit();
                }
            }
        }
    }
}
}else{
    header("location:../login.php");
}
?>
