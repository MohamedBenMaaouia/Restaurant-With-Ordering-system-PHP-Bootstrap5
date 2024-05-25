<?php

include 'components/connect.php';

session_start();

$current_page = basename(__FILE__, '.php');

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- bootstrap  -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

   <!-- custom css file link  -->
   <!-- <link rel="stylesheet" href="css/style.css"> -->
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
   <section class="about1" >
      <div class="card mb-3 mx-auto bg-transparent " style="max-width: 1100px; margin-top:60px;">
         <div class="row g-0 ">
            <div class="col-md-5">
               <img src="images/about-img.svg" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-7">
               <div class="card-body">
                  <h5 class="card-title">Why choose us?</h5>
                  <p class="card-text">Welcome to Resto, where culinary excellence meets unparalleled hospitality. Choose us for an unforgettable dining experience crafted with passion and precision. Our diverse menu, inspired by global flavors and local ingredients, promises to tantalize your taste buds with every bite. Step into our inviting ambiance and be greeted with warmth and personalized service, ensuring your visit is nothing short of extraordinary. With a commitment to sustainability and a dedication to creating lasting memories, Resto invites you to indulge in a culinary journey like no other. Join us and discover why we're not just a restaurant, but your ultimate dining destination.</p>
                  
                  <a href="menu.php" class="btn btn-primary">Our menu</a>
               </div>
            </div>
         </div>
      </div>
   </section>
   <section class="steps">
      <div class="card-group w-75 mx-auto bg-transparent" style="margin-top: 50px; max-width: 1100px; ">
         <div class="card bg-transparent">
            <img src="images/step-1.png" class="card-img-top" style="padding:50px;" alt="...">
            <div class="card-body">
               <h5 class="card-title">Order</h5>
               <p class="card-text">Choose your favorite food and pass your order. Dont forget to add your address</p>
               
            </div>
         </div>
         <div class="card bg-transparent">
            <img src="images/step-2.png" class="card-img-top " style="padding:50px;" alt="...">
            <div class="card-body">
               <h5 class="card-title">Delivery</h5>
               <p class="card-text">We will deliver your food right to your door.</p>
               
            </div>
         </div>
         <div class="card bg-transparent">
            <img src="images/step-3.png" class="card-img-top" style="padding:50px;" alt="...">
            <div class="card-body">
               <h5 class="card-title">The Best Part</h5>
               <p class="card-text">Enjoy the best meal you ever had.</p>
               
            </div>
         </div>
      </div>
   </section>
   </br>
   </br>
   


   <!-- footer section starts  -->
   <?php include 'components/footer.php'; ?>
   <!-- footer section ends -->=




   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


   <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>


   <script src="js/script.js"></script>


</body>

</html>