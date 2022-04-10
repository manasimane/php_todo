<?php
include "database.php";
session_start();
if (!isset($_SESSION["user_email"])) {
    header("Location: index.php");
    die();
}

if (isset($_GET["id"])) {
    $todoId = mysqli_real_escape_string($conn, $_GET["id"]);
} else {
    header("Location: todos.php");
}

$msg = "";

if (isset($_POST["updateTodo"])) {
    $title = mysqli_real_escape_string($conn, $_POST["title"]);
    $desc = mysqli_real_escape_string($conn, $_POST["desc"]);

    // Updating todo
    $sql = "UPDATE todos SET title='{$title}', description='{$desc}' WHERE id='{$todoId}'";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        $_POST["title"] = "";
        $_POST["desc"] = "";
        $msg = 
        "<div class='alert'>
            <div class='msg'>
                <p><i class='fa-solid fa-circle-info'></i> Todo is updated.</p>
            </div>
        </div>";
    } else {
        $msg =
         "<div class='alert'>
            <div class='msg'>
                <p><i class='fa-solid fa-circle-info'></i> Todo is not updated.</p>
            </div>
        </div>";
    }
}

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
$sql = "SELECT * FROM todos WHERE id='{$todoId}' AND user_id='{$user_id}'";
$res = mysqli_query($conn, $sql);
if (mysqli_num_rows($res) > 0) {
    $todoData = mysqli_fetch_assoc($res);
} else {
    header("Location: todos.php");
}

?>


<!doctype html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/todos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <?php getHead(); ?>
</head>

<body class="bg-light">
    <?php getHeader(); ?>
    <div class="container">
        <div class="your-todo">
            <h1> ✍🏻 Edit Todo</h1>
        </div>
        <div class="addTodoFrm">
            <?php echo $msg; ?>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" placeholder="e.g. I want to do study" value="<?php echo $todoData['title']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="desc">Description</label>
                    <textarea name="desc" rows="3" required><?php echo $todoData['description']; ?></textarea>
                </div>
                <div class="form-group form-btn">
                    <button type="submit" name="updateTodo" class="btn btn-primary me-2">Update</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>