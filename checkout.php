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

if (isset($_POST['submit'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_UNSAFE_RAW);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_UNSAFE_RAW);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_UNSAFE_RAW);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_UNSAFE_RAW);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_UNSAFE_RAW);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if ($check_cart->rowCount() > 0) {

      if ($address == '') {
         $message[] = 'please add your address!';
      } else {

         $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
         $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

         $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
         $delete_cart->execute([$user_id]);

         $message[] = 'order placed successfully!';
      }
   } else {
      $message[] = 'your cart is empty';
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

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

   <section class="checkout card text-center mx-auto bg-transparent" style="align-items: center; width: 500px; margin-left:500px">

      <h1 class="title">order summary</h1>

      <form action="" method="post">

         <div class="cart-items card bg-transparent text-white" style="width: 400px;">
            <div class="card-body">
               <h3 class="card-title">cart items</h3>

               <?php
               $grand_total = 0;
               $cart_items[] = '';
               $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
               $select_cart->execute([$user_id]);
               if ($select_cart->rowCount() > 0) {
                  while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                     $cart_items[] = $fetch_cart['name'] . ' (' . $fetch_cart['price'] . ' x ' . $fetch_cart['quantity'] . ') - ';
                     $total_products = implode($cart_items);
                     $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
               ?>
                     <p><span class="name"><?= $fetch_cart['name']; ?></span><span class="price">$<?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?></span></p>
               <?php
                  }
               } else {
                  echo '<p class="empty">your cart is empty!</p>';
               }
               ?>
               <p class="grand-total"><span class="name">grand total :</span><span class="price">$<?= $grand_total; ?></span></p>
               <a href="cart.php" class="btn btn-primary">view cart</a>
            </div>
         </div>

         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
         <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
         <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
         <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
         <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">
         </br>
         <div class="user-info card bg-transparent text-white" style="width: 400px;">
            <div class="card-body">
               <h3 class="card-title">your info</h3>
               <p><i class="fas fa-user"></i><span><?= $fetch_profile['name'] ?></span></p>
               <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number'] ?></span></p>
               <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
               <a href="update_profile.php" class="btn btn-primary">update info</a>
               <h3 class="card-title">delivery address</h3>
               <p><i class="fas fa-map-marker-alt"></i><span><?php if ($fetch_profile['address'] == '') {
                                                                  echo 'please enter your address';
                                                               } else {
                                                                  echo $fetch_profile['address'];
                                                               } ?></span></p>
               <a href="update_address.php" class="btn btn-primary mb-3">update address</a>
               </br>

               <select name="method" class="box" required>
                  <option value="" disabled selected>select payment method --</option>
                  <option value="cash on delivery">cash on delivery</option>
                  <option value="credit card">credit card</option>
                  <option value="paytm">paytm</option>
                  <option value="paypal">paypal</option>
               </select>
               </br>
               </br>
               <input type="submit" value="place order" class="btn btn-danger <?php if ($fetch_profile['address'] == '') {
                                                                                 echo 'disabled';
                                                                              } ?>" name="submit">
            </div>
         </div>
         </br>

      </form>

   </section>

   </br>







   <!-- footer section starts  -->
   <?php include 'components/footer.php'; ?>
   <!-- footer section ends -->






   <!-- custom js file link  -->
   <script src="js/script.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>