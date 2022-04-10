<?php
include "database.php";
session_start();
if (!isset($_SESSION["user_email"])) {
    header("Location: index.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/todos.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php getHead();?>

</head>

<body>
    <?php getHeader(); ?>
    <div class="container">
        <div class="your-todo">
            <h1>Your Todos:</h1>
        </div>
        
        <div class="no-todo">
            <?php 
            // Get User Id based on user email
            $sql = "SELECT id FROM users WHERE email='{$_SESSION["user_email"]}'";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            if ($count > 0) {
                $row = mysqli_fetch_assoc($res);
                $user_id = $row["id"];
            } else {
                $user_id = 0;
            }
            $sql1 = "SELECT * FROM todos WHERE user_id='{$user_id}' ORDER BY id DESC";
            $res1 = mysqli_query($conn, $sql1);
            if (mysqli_num_rows($res1) > 0) {
                foreach ($res1 as $todo) {
            ?>
            <div class="get-todo">
                <?php getTodo($todo); ?>
            </div>
            <?php }
             } 
            
             else { echo "<h1>Todos are not available!</h1>"; } ?>
        </div>
    </div>


</body>

</html>