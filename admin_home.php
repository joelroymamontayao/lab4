<center>
  <h1>Admin Page</p>

  <h3>
    <?php
      session_start()

      if(!isset($_SESSION['admin_login']))
      {
        header("location: ../index.php");
      }
      if(isset($_SESSION['seller_login']))
      {
        header("location: ../seller/seller_home.php");
      }
      if(isset($_SESSION['buyer_login']))
      {
        header("location: ../buyer/buyer_home.php");
      }
      if(isset($_SESSION['admin_login']))
      {
        ?>
        Welcome,
        <?php
          echo $_SESSION['admin_login'];
      }
      ?>
    </h3>
      <a href="../logout.php">Logout</a>
</center>
