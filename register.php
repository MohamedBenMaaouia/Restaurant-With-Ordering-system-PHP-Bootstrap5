<?php

include 'components/connect.php';

session_start();

$current_page = basename(__FILE__, '.php');

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_UNSAFE_RAW);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_UNSAFE_RAW);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_UNSAFE_RAW);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_UNSAFE_RAW);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_UNSAFE_RAW);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? OR number = ?");
   $select_user->execute([$email, $number]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $message[] = 'email or number already exists!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         $insert_user = $conn->prepare("INSERT INTO `users`(name, email, number, password) VALUES(?,?,?,?)");
         $insert_user->execute([$name, $email, $number, $cpass]);
         $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
         $select_user->execute([$email, $pass]);
         $row = $select_user->fetch(PDO::FETCH_ASSOC);
         if($select_user->rowCount() > 0){
            $_SESSION['user_id'] = $row['id'];
            header('location:index.php');
         }
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

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

<section class="form-container card container-sm 0" style="width: 500px;">
      <div class="card-body ">
         <h3 class="card-title" style="text-align: center;">Login</h3>
         <form action="" method="post">
            <div class="form-floating mb-3">
               <input type="text" name="name" class="form-control" id="floatingInput" placeholder="enter your name" required>
               <label for="floatingInput">Name</label>
            </div>
            <div class="form-floating mb-3">
               <input type="email" name="email" class="form-control" id="floatingInput" placeholder="enter your name" oninput="this.value = this.value.replace(/\s/g, '')" required>
               <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating mb-3">
               <input type="number" name="number" class="form-control" id="floatingInput" placeholder="enter your name" oninput="this.value = this.value.replace(/\s/g, '')" required>
               <label for="floatingInput">Number</label>
            </div>
            <div class="form-floating">
               <input type="password" name="pass" class="form-control mb-3" id="floatingPassword" placeholder="Password" required>
               <label for="floatingPassword">Password</label>
            </div>
            <div class="form-floating">
               <input type="password" name="cpass" class="form-control mb-3" id="floatingPassword" placeholder="Password" required>
               <label for="floatingPassword">Confirm Password</label>
            </div>
            <div class="d-grid gap-2 col-6 mx-auto mb-3">
               <input type="submit" value="Register" name="submit" class="btn btn-primary">
            </div>
            <p style="text-align: center;">already have an account? <a href="login.php">login now</a></p>
         </form>
      </div>
   </section>












<?php include 'components/footer.php'; ?>







<!-- custom js file link  -->
<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>