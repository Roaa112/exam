<?php session_start();?>

<?php if(isset($_SESSION['user_id'])){?>
<?php include 'header.php' ?>
<?php include 'navbar.php' ?>
<?php require_once 'inc/conn.php'?>
<?php

$user_id=$_SESSION['user_id'];
$query = "SELECT orderitems.price AS price, orderitems.quantity AS quantity,orderitems.product_id AS product_id,
  orderitems.subtotal AS subtotal, products.image AS image,
  products.title AS title, products.description AS description, products.product_id AS product_id FROM orderitems JOIN products join orders
  ON orderitems.product_id = products.product_id and orderitems.order_id=orders.order_id where user_id=$user_id";
$result=mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
  $posts=mysqli_fetch_all($result,MYSQLI_ASSOC);
}else{
  $msg="post not found";
}
  
?>

<section id="page-header" class="about-header"> 
  <h2>#Cart</h2>
  <p>Let's see what you have.</p>

</section>
<section id="cart" class="section-p1">
  <table width="100%">
  <?php

if(isset($_SESSION['success'])){
      ?>
     <div class="alert alert-success"><?php echo $_SESSION['success'];?></div>
     <?php
      
      unset($_SESSION['success']);
}
?>
    <thead>
      <tr>
        <td>Image </td>
        <td>Name</td>
        <td>Desc</td>
        <td>Quantity</td>
        <td>Price</td>
        <td>Subtotal</td>
        <td>Remove</td>
      </tr>
    </thead>
    <?php if(!empty($posts)){
      foreach ($posts as $post) {
    ?>
    <tbody>
      <tr>
        <td><img src="admin/uplode/<?php echo $post['image'];?>" alt="product1"></td>
        <td><?php echo $post['title'];?></td>
        <td><?php echo $post['description'];?></td>
        <td><?php echo $post['quantity'] ?></td>
        <td><?php echo $post['price'];?></td>
        <td><?php echo ($post['subtotal'])?></td>
        <td>
          <form action="handel/handelDeletePost.php" method="post">
            <input type="hidden" name="id" value="<?php echo $post['product_id'];?>">
            <button type="submit" name="delete" class="btn btn-danger">Remove</button>
          </form>
        </td>
      </tr>
    </tbody>
    <?php }}?>
   <td>
          <form action="cart.php" method="POST">
            <button type="submit" name="confirm_order" class="btn btn-success">Confirm</button>
          </form>

      </td>
  </table>
</section>
<?php if(isset($_POST['confirm_order'])){
    $user_id=$_SESSION['user_id'];
       $query="select sum(subtotal) as subtotal from orderitems join orders on orderitems.order_id=orders.order_id where user_id=$user_id ";
       $result=mysqli_query($conn,$query);
       if(mysqli_num_rows($result)==1){
      $subtotal=mysqli_fetch_assoc($result)['subtotal'];
    
    
    ?>
<section id="cart-add" class="section-p1">
    <div id="coupon">
        <h3>Coupon</h3>
        <input type="text" placeholder="Enter coupon code">
        <button class="normal">Apply</button>
    </div>
    <div id="subTotal">
        <h3>Cart totals</h3>
        <table>
            <tr>
                <td>Subtotal</td>
                <td><?php echo $subtotal;?></td>
            </tr>
            <tr>
                <td>Shipping</td>
                <td>$50.00</td>
            </tr>
            <tr>
                <td>Tax</td>
                <td>$0.00</td>
            </tr>
            <tr>
                <td><strong>Total</strong></td>
                <td><strong><?php echo $subtotal+50;?></strong></td>
            </tr>
        </table>
        <form action="confirmOrder.php" method="post">
        <button class="normal" name="confirmOrder">proceed to checkout</button>
    </form>
    </div>
    </section>
<?php }
}
?>
<?php include "footer.php" ?>

<?php
}else{
    header("location:login.php");
}
?>