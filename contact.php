<?php

include 'components/connect.php';

session_start();

$current_page = basename(__FILE__, '.php');

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
};

if (isset($_POST['send'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_UNSAFE_RAW);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_UNSAFE_RAW);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_UNSAFE_RAW);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_UNSAFE_RAW);

   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   if ($select_message->rowCount() > 0) {
      $message[] = 'already sent message!';
   } else {

      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);

      $message[] = 'sent message successfully!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- bootstrap  -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/css">

   <style>
      input::-webkit-outer-spin-button,
      input::-webkit-inner-spin-button {
         -webkit-appearance: none;
         margin: 0;
      }
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

   <!-- contact section starts  -->
   <div class="container text-center">
      <div class="row">
         <div class="col">
            <div class="image">
               <img src="images/contact-img.svg" alt="">
            </div>
         </div>
         <div class="col">
            <div class="w-100 h-100 " style="margin-top: 110px;">
               <form action="" method="post">
                  <div class="form-floating mb-3">
                     <input type="text" name="name" class="form-control" id="name" required>
                     <label for="name">Enter your name</label>
                  </div>
                  <div class="form-floating mb-3">
                     <input type="email" name="email" class="form-control" id="email" required>
                     <label for="email">Enter your email</label>
                  </div>
                  <div class="form-floating mb-3">
                     <input type="number" name="number" class="form-control" id="number" required maxlength="10">
                     <label for="number">Enter your number</label>
                  </div>
                  <div class="form-floating mb-3">
                     <textarea class="form-control" name="msg" placeholder="Leave a comment here" id="floatingTextarea" rows="6" required></textarea>
                     <label for="floatingTextarea">Enter your message</label>
                  </div>
                  <button type="submit" value="send message" name="send" class="btn btn-primary">Send message</button>
               </form>
            </div>
         </div>
      </div>
   </div>


   <!-- footer section starts  -->
   <?php include 'components/footer.php'; ?>
   <!-- footer section ends -->








   <!-- custom js file link  -->
   <script src="js/script.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>