<?php
session_start();
if(isset($_SESSION['user_id'])){
include "../view/header.php";

include "../view/sidebar.php";
include "../view/navbar.php";

?>
<?php
require_once '../../inc/conn.php';
$query="select category_name from categories ";
$result=mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
  $categories=mysqli_fetch_all($result,MYSQLI_ASSOC);

}
?>
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">

              <div class="card-body px-5 py-5">
                <h3 class="card-title text-left mb-3">Add Product</h3>
                <form method="POST" action="../handel/handeladdproduct.php" enctype="multipart/form-data">
                <?php  if(isset($_SESSION['errors'])){
      foreach($_SESSION['errors'] as $error){?>
     <div class="alert alert-danger"><?php echo $error;?></div>
     <?php
      }
      unset($_SESSION['errors']);
       
    }?>
                <?php
    if(isset($_SESSION['success'])){
          ?>
         <div class="alert alert-success"><?php echo $_SESSION['success'];?></div>
         <?php
          
          unset($_SESSION['success']);
    }
    ?>
                  <div class="form-group">
                    <label>Category</label>
                    <select name="cat" class="form-control p_input">
                    <?php  if(!empty($categories)):
                   foreach($categories as $categorie):?> 
                    <option> <?=  $categorie['category_name']?> </option>  
                    <?php 
                    endforeach; 
                  endif;
                    ?>
                </select>
                  </div>
                  <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control p_input">
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                    <input type="text" name="desc" class="form-control p_input">
                  </div>
                  <div class="form-group">
                    <label>Price</label>
                    <input type="number" name="price" class="form-control p_input">
                  </div>
                  <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" name="quantity" class="form-control p_input">
                  </div>
                  <div class="form-group">
                    <label>Image</label>
                    <input type="file" name="img" class="form-control p_input">
                  </div>
                  <div class="text-center">
                    <button type="submit" name="addProduct" class="btn btn-primary btn-block enter-btn">Add</button>
                  </div>
                
                </form>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>

<?php 
include "../view/footer.php";
 ?>
 <?php }else{
    header("location:../../login.php");
}?>