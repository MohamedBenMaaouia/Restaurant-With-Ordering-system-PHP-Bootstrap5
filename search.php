<?php

include 'components/connect.php';

session_start();

$current_page = basename(__FILE__, '.php');

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>search page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- bootstrap  -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/css">
   <style>
      body{
         background-image: url("Login-background.jpg");
      }
   </style>
</head>

<body>

   <!-- header section starts  -->
   <?php include 'components/user_header.php'; ?>
   <?php include 'components/breadcrumb.php'; ?>
   <!-- header section ends -->


   <section class="products container-sm" style="max-width:1000px ;min-height: 100vh; margin-top:20px;">

      <div class="box-container">

         <?php
         if (isset($_POST['search_box']) or isset($_POST['search_btn'])) {
            $search_box = $_POST['search_box'];
            $select_products = $conn->prepare("SELECT * FROM `products` WHERE name LIKE '%{$search_box}%'");
            $select_products->execute(); ?>
            <div class="row row-cols-1 row-cols-md-3 g-4">
               <?php
               if ($select_products->rowCount() > 0) {
                  while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
               ?>
                     <div class="col ">
                        <div class="card text-bg-dark mb-3 h-100 ">
                           <form action="" method="post" class="box">
                              <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                              <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                              <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                              <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
                              <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
                              <img src="uploaded_img/<?= $fetch_products['image']; ?>" class="card-img-top " style="width:307px; height: 270px; " alt="">
                              <div class="card-body">
                                 <span><?= $fetch_products['category']; ?></span>
                                 <div class="name card-title"><?= $fetch_products['name']; ?></div>
                                 <div class="flex">
                                    <div class="price"><span>$</span><?= $fetch_products['price']; ?></div>
                                    <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
               <?php
                  }  
               } else {
                  echo '<p class="empty">no products added yet!</p>';
               }
               }
               ?>
            </div>

      </div>

   </section>











   <!-- footer section starts  -->
   <?php include 'components/footer.php'; ?>
   <!-- footer section ends -->







   <!-- custom js file link  -->
   <script src="js/script.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>