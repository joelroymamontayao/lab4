<center>
  <h1>Seller Page</h1>

  <h3>
  <?php

  session_start();

  if(!isset($_SESSION['seller_login']))
  {
    header("location: ../index.php");
  }
  if(isset($_SESSION['admin_login']))
  {
    header("location: ../admin/admin_home.php");
  }
  if(isset($_SESSION['buyer_login']))
  {
    header("location: ../buyer/buyer_home.php");
  }
  if(isset($_SESSION['seller_login']))
  {
    ?>
    Welcome,
    <?php
    echo $_SESSION['seller_login'];
  }
  ?>

</h3>
  <a href="../logout.php">Logout</a>
</center>
