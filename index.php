<?php
include "database.php";
session_start();

if (isset($_SESSION["user_email"])) {
     header("Location: todos.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en" >

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Todo list</title>
    <link rel="stylesheet" href="css/index.css">

    <?php getHead();?>
</head>

<body>

    <div class="loginBox">
        <img class="user" src="https://i.ibb.co/yVGxFPR/2.png" height="100px" width="100px">
        <h3>Sign in here</h3><br>
        <form class="form-inline" action="login.php" method="POST" id="frm_login">

            <label for="email">Email address:</label>
            <input type="email" class="form-control" name="email" placeholder="Enter here.." id="email" required>

            <label for="pwd">Password:</label>
            <input type="password" class="form-control" name="password" placeholder="Enter here.." id="btnlogin"
                required>
            <button name="submit" type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

</body>

</html>