<?php
if (isset($message)) {
   foreach ($message as $message) {
      echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark" data-bs-theme="dark">
      <div class="container-fluid">
         <a href="index.php" class="logo navbar-brand">Resto</a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
               <li class="nav-item">
                  <form class="d-flex" role="search" method="post" action="search.php">
                     <input class="form-control me-2 box" type="search" aria-label="Search" name="search_box" placeholder="search here...">
                     <button class="btn btn-outline-success" type="submit" name="search_btn">Search</button>
                  </form>
               </li>
               <li class="nav-item">
                  <a href="index.php" class="nav-link active" aria-current="page">home</a>
               </li>
               <li class="nav-item">
                  <a href="about.php" class="nav-link">about</a>
               </li>
               <li class="nav-item">
                  <a href="menu.php" class="nav-link">menu</a>
               </li>
               <li class="nav-item">
                  <a href="orders.php" class="nav-link">orders</a>
               </li>
               <li class="nav-item">
                  <a href="contact.php" class="nav-link">contact</a>
               </li>
               <li class="nav-item">
                  <?php
                  $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                  $count_cart_items->execute([$user_id]);
                  $total_cart_items = $count_cart_items->rowCount();
                  ?>
                  <a href="cart.php" class="nav-link"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_items; ?>)</span></a>
               </li>
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                     <div id="user-btn" class="fas fa-user"></div>
                  </a>
                  <?php
                  $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                  $select_profile->execute([$user_id]);
                  if ($select_profile->rowCount() > 0) {
                     $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                  ?>
                     <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                           <p class="name dropdown-header"><?= $fetch_profile['name']; ?></p>
                        </li>
                        <li>
                           <hr class="dropdown-divider">
                        </li>
                        <li><a href="profile.php" class="btn dropdown-item">profile</a></li>
                        <li><a href="components/user_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn dropdown-item">logout</a></li>
                     </ul>
                  <?php
                  } else {
                  ?>
                     <ul class="dropdown-menu dropdown-menu-end">
                        <li><a href="login.php" class="btn dropdown-item">login</a></li>
                     </ul>
                  <?php
                  }
                  ?>
               </li>
         </div>
   </nav>
   <script>
      window.addEventListener('scroll', function() {
         const navbar = document.querySelector('.navbar');
         const headerHeight = document.querySelector('.header').offsetHeight;

         if (window.scrollY > headerHeight) {
            navbar.classList.add('fixed-top');
         } else {
            navbar.classList.remove('fixed-top');
         }
      });
   </script>

</header>