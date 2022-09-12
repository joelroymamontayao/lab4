<?php
require_once 'connection.php';

session_start();

if(isset($_SESSION["admin_login"]))
{
  header("location: admin_home.php");
}
if(isset($_SESSION["seller_login"]))
{
  header("location: seller_home.php");
}
if(isset($_SESSION["buyer_login"]))
{
  header("location: buyer_home.php");
}

if(isset($_REQUEST['btn_login']))
{
  $email =$_REQUEST["txt_email"];
  $password =$_REQUEST["txt_password"];
  $role =$_REQUEST["txt_role"];

  if(empty($email)){
    $errorMsg[]="please enter email";
  }
  else if(empty($password)){
    $errorMsg[]="please enter password";
  }
  else if(empty($role)){
    $errorMsg[]="please select role";
  }
  else if($email AND $password AND $role)
  {
    try
    {
      $select_stmt=$db->prepare("SELECT email, password, role FROM masterlogin
        WHERE email=:uemail AND password=:upassword AND role=:urole");
      $select_stmt->bindParam(":uemail", $email);
      $select_stmt->bindParam(":upassword", $password);
      $select_stmt->bindParam(":urole", $role);
      $select_stmt->execute();

      while($row=$select_stmt->fetch(PDO::FETCH_ASSOC))
      {
        $dbemail=$row["email"];
        $dbpassword=$row["password"];
        $dbrole=$row["role"];
      }
      if($email!=null AND $password!=null AND $role!=null)
      {
        if($select_stmt->rowCount()>0)
        {
          if($email==$dbemail AND $password==$dbpassword AND $role==$dbrole)
          {
            switch($dbrole)
            {
              case "admin":
              $_SESSION["admin_login"]=$email;
              $loginMsg="Admin...Successfully Login...";
              header("refresh:3;admin_home.php");
              break;

              case "seller":
              $_SESSION["seller_login"]=$email;
              $loginMsg="Seller...Successfully Login...";
              header("refresh:3;seller_home.php");
              break;

              case "buyer":
              $_SESSION["buyer_login"]=$email;
              $loginMsg="Buyer...Successfully Login...";
              header("refresh:3;buyer_home.php");
              break;

              default:
              $errorMsg[]="wrong email or password or role";
            }
          }
          else
          {
            $errorMsg[]="wrong email or password or role";
          }
        }
        else
        {
          $errorMsg[]="wrong email or password or role";
        }
      }
      else
      {
        $errorMsg[]="wrong email or password or role";
      }
    }
    catch(PDOException $e)
    {
      $e->getMessage();
    }
  }
  else
  {
    $errorMsg[]="wrong email or password or role";
  }
}

 ?>

 <?php
 if(isset($errorMsg))
 {
   foreach($errorMsg as $error);
 {
 echo $error;
 }
 }
 if(isset($loginMsg))
 {
   echo $loginMsg;
 }
 ?>

<form method="post" class="form-horizontal">
  <div class="form-group">
    <label class="col-sm-3 control-label">Email</label>
    <div class="col-sm-6">
      <input type="text" name="txt_email" class="form-control" placeholder="enter email" />
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label">Password</label>
    <div class="col-sm-6">
      <input type="password" name="txt_password" class="form-control" placeholder="enter password" />
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label">Select Type</label>
    <div class="col-sm-6">
    <select class="form-control" name="txt_role">
      <option value="" selected="selected"> - select role - </option>
      <option value="admin">Admin</option>
      <option value="seller">Seller</option>
      <option value="buyer">Buyer</option>
    </select>
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-9 m-t-15">
      <input type="submit" name="btn_login" class="btn btn-success" value="Login">
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-9 m-t-15">
      You don't have an account register here? <a href="register.php"><p class="text-info">Register Account</p></a>
    </div>
  </div>

</form>
