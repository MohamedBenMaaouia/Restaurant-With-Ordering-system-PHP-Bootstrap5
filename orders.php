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
   <title>orders</title>

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


   <section class="orders ">
      <h1 class="title" style="text-align: center;">your orders</h1>
      </br>
      <div class="box-container ">
         <?php
         if ($user_id == '') {
            echo '<p class="empty">please login to see your orders</p>';
         } else {
            $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
            $select_orders->execute([$user_id]);
            $i = 1;
            if ($select_orders->rowCount() > 0) {
               while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                  // Start a new row for every third order
                  if (($i - 1) % 3 == 0) {
                     echo '<div class="row">';
                  }
         ?>
                  <div class="col-md-4 ">
                     <p class="d-inline-flex gap-1">
                        <a class="btn btn-primary " style="margin-left: 190px;" data-bs-toggle="collapse" href="#collapseExample<?php echo $i; ?>" role="button" aria-expanded="false" aria-controls="collapseExample">
                           Order n°<?php echo $i; ?>
                        </a>
                     </p>
                     <div class="collapse" id="collapseExample<?php echo $i; ?>">
                        <div class="card col">
                           
                           <p>name : <span><?= $fetch_orders['name']; ?></span></p>
                           <p>email : <span><?= $fetch_orders['email']; ?></span></p>
                           <p>number : <span><?= $fetch_orders['number']; ?></span></p>
                           <p>address : <span><?= $fetch_orders['address']; ?></span></p>
                           <p>payment method : <span><?= $fetch_orders['method']; ?></span></p>
                           <p>your orders : <span><?= $fetch_orders['total_products']; ?></span></p>
                           <p>total price : <span>$<?= $fetch_orders['total_price']; ?>/-</span></p>
                           <p> payment status : <span style="color:<?php if ($fetch_orders['payment_status'] == 'pending') {
                                                                        echo 'red';
                                                                     } else {
                                                                        echo 'green';
                                                                     }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
                        </div>
                     </div>
                     <br>
                  </div>
         <?php
                  // Close the row after every third order
                  if ($i % 3 == 0 || $i == $select_orders->rowCount()) {
                     echo '</div>'; // Close the row div
                  }
                  $i = $i + 1;
               }
            } else {
               echo '<p class="empty">no orders placed yet!</p>';
            }
         }
         ?>
      </div>
   </section>
   
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>










   <!-- footer section starts  -->
   <?php include 'components/footer.php'; ?>
   <!-- footer section ends -->






   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>