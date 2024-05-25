<?php

include 'components/connect.php';

session_start();

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
   <title>Becha</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- bootstrap  -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

   <!-- custom css file link  -->
   <style>
     
      body{
         background-image: url("Login-background.jpg");
      }

      .hero .slide {
         display: flex;
         align-items: center;
         flex-wrap: wrap-reverse;
         gap: 2rem;
         margin-bottom: 4rem;
      }

      .hero .slide .image {
         flex: 1 1 40rem;
      }

      .hero .slide .image img {
         width: 50%;
         margin-left: 150px;
      }

      .hero .slide .content {
         flex: 1 1 40rem;
         text-align: center;
         margin-left: 150px;
      }

      .hero .slide .content span {
         font-size: 2.5rem;
         color: var(--light-color);
      }

      .hero .slide .content h3 {
         margin: 1rem 0;
         font-size: 6rem;
         color: var(--black);
         text-transform: capitalize;
      }
   </style>


</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <section class="hero ">

      <div class="swiper hero-slider ">

         <div class="swiper-wrapper">

            <div class="swiper-slide slide">
               <div class="content">
                  <span>order online</span>
                  <h3>delicious pizza</h3>
                  <a class="btn btn-outline-primary" href="menu.php" role="button">See Menu</a>
               </div>
               <div class="image ">
                  <img src="images/home-img-1.png" alt="">
               </div>
            </div>

            <div class="swiper-slide slide">
               <div class="content">
                  <span>order online</span>
                  <h3>chezzy hamburger</h3>
                  <a class="btn btn-outline-primary" href="menu.php" role="button">See Menu</a>
               </div>
               <div class="image">
                  <img src="images/home-img-2.png" alt="">
               </div>
            </div>

            <div class="swiper-slide slide">
               <div class="content">
                  <span>order online</span>
                  <h3>rosted chicken</h3>
                  <a class="btn btn-outline-primary" href="menu.php" role="button">See Menu</a>
               </div>
               <div class="image">
                  <img src="images/home-img-3.png" alt="">
               </div>
            </div>

         </div>

         <div class="swiper-pagination"></div>

      </div>

   </section>
   <section class="category">
      </br></br>
      <h1 class="title" style="text-align: center;">food category</h1>
      </br></br>
      <div class="container text-center">
         <div class="row">
            <div class="col">
               <img src="images/cat-1.png" class="w-50" alt=""></br></br>
               <a href="category.php?category=fast food" class="box btn btn-primary" role="button">
                  Fast food
               </a>
            </div>
            <div class="col">
               <img src="images/cat-2.png" class="w-50" alt=""></br></br>
               <a href="category.php?category=main dish" class="box btn btn-primary" role="button">
                  main dishes
               </a>
            </div>
            <div class="col">
               <img src="images/cat-3.png" class="w-50" alt=""></br></br>
               <a href="category.php?category=drinks" class="box btn btn-primary" role="button">
                  Drinks
               </a>
            </div>
            <div class="col">
               <img src="images/cat-4.png" class="w-50" alt=""></br></br>
               <a href="category.php?category=desserts" class="box btn btn-primary" role="button">
                  Desserts
               </a>
            </div>

         </div>
         </br></br></br>
   </section>

   </br></br>
   <section class="products container-sm " style="max-width:1000px ">

      <h1 class="title" style="text-align: center;">latest dishes</h1></br>


      <div class="box-container">

         <?php
         $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
         $select_products->execute(); ?>
         <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            if ($select_products->rowCount() > 0) {
               while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
                  <div class="col ">
                     <div class="card text-bg-dark mb-3 h-100 ">
                        <form action="" method="post" class="box ">
                           <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                           <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                           <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                           <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
                           <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
                           <img src="uploaded_img/<?= $fetch_products['image']; ?>" class="card-img-top "style="width:307px; height: 270px; " alt="">
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
            ?>
         </div>

      </div>
      </br>
      <div class="more-btn" style="text-align: center;">
         <a href="menu.php" class="box btn btn-primary" role="button">view all</a>

      </div>
      </br>

      
   </section>
   
   
   
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


   <?php include 'components/footer.php'; ?>


   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

   <script>
      var swiper = new Swiper(".hero-slider", {
         loop: true,
         grabCursor: true,
         effect: "flip",
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
         },
      });
   </script>

</body>

</html>