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

if (isset($_POST['delete'])) {
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
   $message[] = 'cart item deleted!';
}

if (isset($_POST['delete_all'])) {
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   // header('location:cart.php');
   $message[] = 'deleted all from cart!';
}

if (isset($_POST['update_qty'])) {
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_UNSAFE_RAW);
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $message[] = 'cart quantity updated';
}

$grand_total = 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>cart</title>

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

   <!-- shopping cart section starts  -->

   <section class="products container-sm" style="max-width:1000px ">

      <h1 class="title">your cart</h1>

      <div class="box-container">

         <?php
         $grand_total = 0;
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]); ?>
         <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            if ($select_cart->rowCount() > 0) {
               while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
            ?>
                  <div class="col ">
                     <div class="card text-bg-dark mb-3 h-100 ">
                        <form action="" method="post" class="box">
                           <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                           <button type="submit" class="fas fa-times" name="delete" onclick="return confirm('delete this item?');"></button>
                           <img src="uploaded_img/<?= $fetch_cart['image']; ?>" class="card-img-top "style="width:307px; height: 270px; " alt="">
                           <div class="card-body">
                              <div class="name"><?= $fetch_cart['name']; ?></div>
                              <div class="flex">
                                 <div class="price"><span>$</span><?= $fetch_cart['price']; ?></div>
                                 <input type="number" name="qty" class="qty" min="1" max="99" value="<?= $fetch_cart['quantity']; ?>" maxlength="2">
                                 <button type="submit" class="fas fa-edit" name="update_qty"></button>
                              </div>
                              <div class="sub-total"> sub total : <span>$<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span> </div>
                           </div>
                        </form>
                     </div>
                  </div>
            <?php
                  $grand_total += $sub_total;
               }
            } else {
               echo '<p class="empty">your cart is empty</p>';
            }
            ?>

         </div>
         </br>
         <div class="card bg-dark text-white">
            <div class="card-body">
               <h5 class="card-title">cart total : <span>$<?= $grand_total; ?></span></h5>
               <form action="" method="post">
                  <button type="submit" class="delete-btn btn btn-danger <?= ($grand_total > 1) ? '' : 'disabled'; ?>" name="delete_all" onclick="return confirm('delete all from cart?');">delete all</button>
               </form>
            </div>
         </div>



         </br>
         <div class="btn-group" role="group" aria-label="Basic mixed styles example">
            <button type="button" class="btn btn-warning"><a href="checkout.php" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">proceed to checkout</a></button>
            <button type="button" class="btn btn-success"><a href="menu.php" class="btn">continue shopping</a></button>
         </div>

      </div>
   </section>

   <!-- shopping cart section ends -->



   </br>






   <!-- footer section starts  -->
   <?php include 'components/footer.php'; ?>
   <!-- footer section ends -->








   <!-- custom js file link  -->
   <script src="js/script.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>