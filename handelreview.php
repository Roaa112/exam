<?php session_start();?>
<?php require_once 'inc/conn.php';?>
<?php  if(isset($_SESSION['user_id'])){
  if( !empty($_GET['id'])){ $id=$_GET['id'];?>
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

    <?php if(isset($_POST['button'])){
       $rating=$_POST['rate'];
       $comment=$_POST['text'];
       $user_id=$_SESSION['user_id'];
       $product_id=$_GET['id'];

       $query="INSERT INTO reviews (product_id,user_id,rating,comment) VALUES ('$product_id','$user_id','$rating','$comment'); ";
       $result=mysqli_query($conn,$query);
       if($result){
        $_SESSION['success'] =" comment inserted successfuly";
        header("Location:handelreview.php?id= $id");

       }else{
        $_SESSION['errors'] = ['Error while inserting into orderitems.'];
        header("Location:handelreview.php?id= $id");
       }

      }?>
    <?php
   $product_id=$_GET['id'];
    $query="select * from products where product_id=$product_id ";
    $result=mysqli_query($conn,$query);
    if(mysqli_num_rows($result)==1){
      $product=mysqli_fetch_assoc($result);
    }else{
     $msg="post not found";
    }
    ?>
    
        <h2>Featured Products</h2>
        <p>Summer Collection New Modren Desgin</p>
        <div class="pro-container">
        <?php if(!empty($product)):?>
            <div class="pro">
            <!-- <form> -->
           
            <img src="admin/uplode/<?php echo $product['image'];?>" alt="p1" />
                <div class="des">
                <h2><?php echo $product['title'];?></h2>
                    <h5><?php echo $product['description'];?></h5>
                    <!-- <div class="star ">
                        <i class="fas fa-star "></i>
                        <i class="fas fa-star "></i>
                        <i class="fas fa-star "></i>
                        <i class="fas fa-star "></i>
                        <i class="fas fa-star "></i>
                    </div> -->
                    <h4><?php echo $product['price'];?></h4>

                </div>
            </div>
            <?php 
       
          else:
            echo $msg;
          endif;
          ?>
           
        </div>
    </section>
    
    <div class="row d-flex justify-content-center">
  <div class="col-md-8 col-lg-6">
    <div class="card shadow-0 border" style="background-color: #f0f2f5;">
    <form action="handelreview.php?id=<?php echo $id?>" method="post">
      <div class="card-body p-4">
        1<input type="radio" name="rate" value="1">
        2<input type="radio" name="rate" value="2">
        3<input type="radio" name="rate" value="3">
        4<input type="radio" name="rate" value="4">
        5<input type="radio" name="rate" value="5">
        <div class="form-outline mb-4">
          <input type="text"  name="text" id="addANote" class="form-control" placeholder="Type comment..." />
          <br>
          <button class="form-label btn btn-primary" name="button" for="addANote">+ Add a note</button>
          </form>
        </div>
        <?php
    $query = "select reviews.comment as comment,reviews.rating as rate,users.name as name from reviews join users on reviews.user_id=users.user_id where product_id=$product_id;";
    $result=mysqli_query($conn,$query);
     if(mysqli_num_rows($result)>0):
         $comments=mysqli_fetch_all($result,MYSQLI_ASSOC);
         if(!empty($comments)):
         foreach ($comments as  $comment) :
          # code...

    ?>
        <div class="card mb-4">
          <div class="card-body">
            <p><?php echo $comment['comment'];?></p>

            <div class="d-flex justify-content-between">
              <div class="d-flex flex-row align-items-center">
                <!-- <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(4).webp" alt="avatar" width="25"
                  height="25" /> -->
                 
   
                <p class="small mb-0 ms-2"><?php echo $comment['name'];?></p>
                 
              </div>
              <div class="d-flex flex-row align-items-center">
                <!-- <p class="small text-muted mb-0">Upvote?</p> -->
                <!-- <p class="small mb-0 ms-2"><?php //echo $comment['rate'];?></p> -->
              </div class="star">
             <div> <?php for($i=0;$i<$comment['rate'];$i++):?>
                <i class="fas fa-star "></i>
                <?php endfor;?></div>
            </div>
          </div>
          <?php
        endforeach;
      endif;
       endif;?>
        </div>
      </div>
    </div>
  </div>
</div>
  

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
      header("location:shop.php");
   
}
}else{
  header("location:login.php");
}
?>