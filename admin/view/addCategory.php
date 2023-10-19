<?php
session_start();
if(isset($_SESSION['user_id'])){
include "../view/header.php";
include "../view/sidebar.php";
include "../view/navbar.php";
?>

      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">

              <div class="card-body px-5 py-5">
                <h3 class="card-title text-left mb-3">Add Category</h3>
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

                <form method="POST" action="../handel/handeladdCategory.php">
                  <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control p_input">
                  </div>
                  <div class="text-center">
                    <button type="submit" name="addCategory" class="btn btn-primary btn-block enter-btn">Add</button>
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