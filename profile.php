<?php

include 'components/connect.php';

session_start();

$current_page = basename(__FILE__, '.php');

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:index.php');
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>profile</title>

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

   <section class="user-details">

      <div class="user card container-sm 0 text-center bg-transparent text-white " style="width: 500px;">
         <?php

         ?>
         <img src="images/user-icon.png" alt="" class="w-50 mx-auto card-img-top">
         <div class="card-body">
            <p><i class="fas fa-user"></i><span><span><?= $fetch_profile['name']; ?></span></span></p>
            <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number']; ?></span></p>
            <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email']; ?></span></p>
            <div class="d-grid gap-2 col-6 mx-auto">
               <a href="update_profile.php" class="btn btn-primary">update info</a>
            </div>
            <p class="address"><i class="fas fa-map-marker-alt"></i><span><?php if ($fetch_profile['address'] == '') {
                                                                              echo 'please enter your address';
                                                                           } else {
                                                                              echo $fetch_profile['address'];
                                                                           } ?></span></p>
            <div class="d-grid gap-2 col-6 mx-auto">
               <a href="update_address.php" class="btn btn-primary">update address</a>
            </div>
         </div>
      </div>

   </section>
   </br>
   </br>









   <?php include 'components/footer.php'; ?>







   <!-- custom js file link  -->
   <script src="js/script.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>