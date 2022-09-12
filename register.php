<?php

require_once "connection.php";

if(isset($_REQUEST['btn_register']))
{
  $username = $_REQUEST['txt_username'];
  $email = $_REQUEST['txt_email'];
  $password = $_REQUEST['txt_password'];
  $role = $_REQUEST['txt_role'];

  if(empty($username)){
    $errorMsg[]="Please enter username";
  }
  else if(empty($email)){
    $errorMsg[]="Please enter email";
  }
  else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errorMsg[]="Please enter a valid email address";
  }
  else if (empty($password)){
    $errorMsg[]="Please enter password";
  }
  else if(strlen($password) < 6){
    $errorMsg[]="Password must be atleast 6 characters";
  }
  else if(empty($role)){
    $errorMsg[]="Please select role";
  }
  else
  {
    try
    {
      $select_stmt=$db->prepare("SELECT username, email FROM masterlogin
        WHERE username=:uname OR email=:uemail");
      $select_stmt->bindParam(":uname", $username);
      $select_stmt->bindParam(":uemail", $email);
      $select_stmt->execute();
      $row=$select_stmt->fetch(PDO::FETCH_ASSOC);

      if($row["username"]==$username){
        $errorMsg[]="Sorry username already exists";
      }
      else if($row["email"]==$email){
        $errorMsg[]="Sorry email already exists";
      }

      else if(!isset($errorMsg))
      {
        $insert_stmt=$db->prepare("INSERT INTO masterlogin(username,email,password,role) VALUES(:uname,:uemail,:upassword,:urole)");
        $insert_stmt->bindParam(":uname", $username);
        $insert_stmt->bindParam(":uemail", $email);
        $insert_stmt->bindParam(":upassword", $password);
        $insert_stmt->bindParam(":urole", $role);

        if($insert_stmt->execute())
        {
          $registerMsg="Register Successfully...Wait Login Page";
          header("refresh:4;index.php");
        }
      }
    }
    catch(PDOException $e)
    {
      echo $e->getMessage();
    }
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
if(isset($registerMsg))
{
  echo $registerMsg;
}
?>

<form method="post" class="form-horizontal">

  <div class="form-group">
    <label class="col-sm-3 control-label">Username</label>
    <div class="col-sm-6">
      <input type="text" name="txt_username" class="form-control" placeholder="enter username" />
    </div>
  </div>

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
        <option value="seller">Seller</option>
        <option value="buyer">Buyer</option>
      </select>
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-9 m-t-15">
      <input type="submit" name="btn_register" class="btn btn-primary" value="Register">
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-9 m-t-15">
      You have an account register here? <a href="index.php"><p class="text-info">Login Account</p></a>
    </div>
  </div>

</form>
