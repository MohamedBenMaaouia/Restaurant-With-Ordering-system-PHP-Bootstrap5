<?php

include 'components/connect.php';

session_start();

$current_page = "update address";

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:index.php');
};

if (isset($_POST['submit'])) {

   $address = $_POST['flat'] . ', ' . $_POST['building'] . ', ' . $_POST['area'] . ', ' . $_POST['town'] . ', ' . $_POST['city'] . ', ' . $_POST['state'] . ', ' . $_POST['country'] . ' - ' . $_POST['pin_code'];
   $address = filter_var($address, FILTER_UNSAFE_RAW);

   $update_address = $conn->prepare("UPDATE `users` set address = ? WHERE id = ?");
   $update_address->execute([$address, $user_id]);

   $message[] = 'address saved!';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update address</title>

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

   <?php include 'components/user_header.php' ?>
   <?php include 'components/breadcrumb.php'; ?>

   <section class="form-container card container-sm 0 bg-transparent" style="width: 500px;">
      <div class="card-body">
         <h3 class="card-title" style="text-align: center;">your address</h3>

         <form action="" method="post">
            <input type="text" class="box form-control mb-3" placeholder="flat no." required maxlength="50" name="flat">
            <input type="text" class="box form-control mb-3" placeholder="building no." required maxlength="50" name="building">
            <input type="text" class="box form-control mb-3" placeholder="area name" required maxlength="50" name="area">
            <input type="text" class="box form-control mb-3" placeholder="town name" required maxlength="50" name="town">
            <input type="text" class="box form-control mb-3" placeholder="city name" required maxlength="50" name="city">
            <input type="text" class="box form-control mb-3" placeholder="state name" required maxlength="50" name="state">
            <input type="text" class="box form-control mb-3" placeholder="country name" required maxlength="50" name="country">
            <input type="number" class="box form-control mb-3" placeholder="pin code" required max="999999" min="0" maxlength="6" name="pin_code">
            <div class="d-grid gap-2 col-6 mx-auto">
               <input type="submit" value="save address" name="submit" class="btn btn-primary">
            </div>
         </form>
      </div>
   </section>
   </br>
   </br>










   <?php include 'components/footer.php' ?>







   <!-- custom js file link  -->
   <script src="js/script.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>