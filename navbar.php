
<?php

 require_once 'inc/conn.php';?>
<section id="header">
<a href="index.html">
    <img src="img/logo.png" alt="homeLogo">
</a>

<div>
    <ul id="navbar">
        <li class="link">
            <a class="active " href="index.html"></a>
        </li>
        <li class="link">
            <a href="shop.php"></a>
        </li>
        <li class="link">
            <a href="blog.php">Blog</a>
        </li>
        <li class="link">
            <a href="about.php">About</a>
        </li>
        <li class="link">
            <a href="contact.php">Contact</a>
        </li>
        <li class="link">
            <a href="signup.php">Signup</a>
        </li>
        <li class="link">
            <a href="lang.php?lang=en">English</a>
        </li>
        <li class="link">
            <a href="lang.php?lang=ar">Arabic</a>
        </li>
    <?php 
    if(!isset($_SESSION['user_id'])){?>
    <li class="link">
            <a href="login.php">Login</a>
        </li>
        <?php }else{?>
    <li class="link">
            <a href="logout.php">Logout</a>
        </li>
        <?php 
        
        if(isset($_SESSION['user_id'])){
        $user_id=$_SESSION['user_id'];
        $query="select name from users where user_id=$user_id";
        $result=mysqli_query($conn,$query);
        if($result){
            $name=mysqli_fetch_assoc($result)['name'];
        }
        }
    }
        ?>
        


        <li class="link">
            <a id="lg-cart" href="cart.php">
                <i class="fas fa-shopping-cart"></i> 
            </a>
        </li>
        <a href="#" id="close"><i class="fas fa-times"></i> </a>
        <li><?php if(isset($_SESSION['user_id'])) echo $name;?></li>
    </ul>


</div>

<div id="mobile">
    <a href="cart.php">
        <i class="fas fa-shopping-cart"></i>
    </a>
    <a href="#" id="bar"> <i class="fas fa-outdent"></i> </a>
</div>
</section>