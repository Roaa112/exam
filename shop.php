<?php session_start();?>
<?php require_once 'inc/conn.php';?>
<?php if(isset($_SESSION['user_id'])){?>
<?php include 'header.php' ?>
<?php include 'navbar.php' ?>




    <section id="product1" class="section-p1">
    <?php

    if(isset($_SESSION['success'])){
          ?>
         <div class="alert alert-success"><?php echo $_SESSION['success'];?></div>
         <?php
          
          unset($_SESSION['success']);
    }
    ?>
    <?php 
                 if(isset($_SESSION['errors'])){
                  foreach($_SESSION['errors'] as $error){?>
                 <div class="alert alert-danger"><?php echo $error;?></div>
                 <?php
                  }
                  unset($_SESSION['errors']);
                   
                }
                ?>

    <?php
    $query="select * from products ";
    $result=mysqli_query($conn,$query);
    if(mysqli_num_rows($result)>0){
      $products=mysqli_fetch_all($result,MYSQLI_ASSOC);
    }else{
     $msg="post not found";
    }
    ?>
    
        <h2>Featured Products</h2>
        <p>Summer Collection New Modren Desgin</p>
        <div class="pro-container">
        <?php if(!empty($products)):
                    foreach($products as $product):
                       $product_id= $product['product_id']
                    ?>
            <div class="pro">
            <!-- <form> -->
           
            <form action="handel/handelcart.php?id=<?php echo $product['product_id'];?>" method="post"> 
            <a href="handelreview.php?id=<?php echo $product_id?>">
            <img src="admin/uplode/<?php echo $product['image'];?>" alt="p1" />
             </a>
                <div class="des">
                <h2><?php echo $product['title'];?></h2>
                    <h5><?php echo $product['description'];?></h5>
                    <div class="star ">
                    <?php
                     $query = "select avg(reviews.rating) as rate from reviews where product_id=$product_id;";
                     $result=mysqli_query($conn,$query);
                      if(mysqli_num_rows($result)==1):
                        $rate=floor(mysqli_fetch_assoc($result)['rate']);
                        for($i=0;$i<$rate;$i++):
                    ?>
                    
                        <i class="fas fa-star "></i>
                  
                    <?php 
                    endfor;
                  endif;
                  ?>
                  </div>
                    <h4><?php echo $product['price'];?></h4>
                    <input type="number" name="quantity" value="1">
                    <button type="submit" name="cart"><a class="cart "><i class="fas fa-shopping-cart "></i></a></button>
                     
                </div>
            </form>  
                <!-- <div class="pro">
            <img src="" alt="p1" />
                <div class="des">
                <h2></h2>
                    <h5></h5>
                    <div class="star ">
                        <i class="fas fa-star "></i>
                        <i class="fas fa-star "></i>
                        <i class="fas fa-star "></i>
                        <i class="fas fa-star "></i>
                        <i class="fas fa-star "></i>
                    </div>
                    <h4></h4>
                    <input type="number" name="quantity">
                    <button type="submit"><a class="cart "><i class="fas fa-shopping-cart "></i></a></button>
                     
                </div>
                <div class="pro">
           
            <img src="" alt="p1" />
                <div class="des">
                <h2></h2>
                    <h5></h5>
                    <div class="star ">
                        <i class="fas fa-star "></i>
                        <i class="fas fa-star "></i>
                        <i class="fas fa-star "></i>
                        <i class="fas fa-star "></i>
                        <i class="fas fa-star "></i>
                    </div>
                    <h4></h4>
                    <input type="number" name="quantity">
                    <button type="submit"><a class="cart "><i class="fas fa-shopping-cart "></i></a></button>
                     
                </div>
                <div class="pro">
          
            <img src="" alt="p1" />
                <div class="des">
                <h2></h2>
                    <h5></h5>
                    <div class="star ">
                        <i class="fas fa-star "></i>
                        <i class="fas fa-star "></i>
                        <i class="fas fa-star "></i>
                        <i class="fas fa-star "></i>
                        <i class="fas fa-star "></i>
                    </div>
                    <h4></h4>
                    <input type="number" name="quantity">
                    <button type="submit"><a class="cart "><i class="fas fa-shopping-cart "></i></a></button>
                     
                </div> -->
              
            </div>
            <?php 
          endforeach;
          else:
            echo $msg;
          endif;
          ?>
           
        </div>
    </section>
    


    <section id="pagenation" class="section-p1">
    <nav aria-label="Page navigation example" >
  <ul class="pagination">
    <li class="page-item">
      <a class="page-link" href="shop.php" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Previous</span>
      </a>
    </li>
    <li class="page-item"><a class="page-link" href="#">1 of 2 </a></li>
 
    <li class="page-item">
      <a class="page-link" href="shop.php?" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>
  </ul>
</nav>

    </section>

    <section id="newsletter" class="section-p1 section-m1">
        <div class="newstext ">
            <h4>Sign Up For Newletters</h4>
            <p>Get E-mail Updates about our latest shop and <span class="text-warning ">Special Offers.</span></p>
        </div>
        <div class="form ">
            <input type="text " placeholder="Enter Your E-mail... ">
            <button class="normal ">Sign Up</button>
        </div>
    </section>


    <?php include 'footer.php' ?>
    <?php
    }else{
    header("location:login.php");
}
?>