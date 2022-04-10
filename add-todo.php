<?php
include "database.php";
session_start();
if (!isset($_SESSION["user_email"])) {
    header("Location: index.php");
    die();
}

$msg = "";

if (isset($_POST["addTodo"])) {
    $title = mysqli_real_escape_string($conn, $_POST["title"]);
    $desc = mysqli_real_escape_string($conn, $_POST["desc"]);

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
    $sql = null;

    // Inserting todo
    $sql = "INSERT INTO todos (title, description, user_id) VALUES ('$title', '$desc', '$user_id')";
    $res = mysqli_query($conn, $sql);
    if ($res) {
        $_POST["title"] = "";
        $_POST["desc"] = "";
        $msg = 
        "<div class='alert'>
            <div class='msg'>
                <p><i class='fa-solid fa-circle-info'></i> Todo is created.</p>
            </div>
        </div>";
    } else {
        $msg = "<div class='alert alert-2'>
            <div class='msg'>
                <p><i class='fa-solid fa-circle-info'></i> Todo is not created.</p>
            </div>
        </div>";
    }
}

?>


<!doctype html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/todos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <?php getHead(); ?>

</head>

<body>
    <?php getHeader(); ?>
    <div class="container">
        <div class="your-todo">
            <h1> ✍🏻 Add Todo</h1>
        </div>

        <div class="addTodoFrm">
            <?php echo $msg; ?>
                <form action="" method="POST">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" placeholder="Demo title"
                        value="<?php if (isset($_POST["addTodo"])) {
                                            echo $_POST["title"];
                                        } ?>" required>
                </div>
                <div class="form-group">
                    <label for="desc">Description</label>
                    <textarea name="desc" rows="3" required>
                        <?php if (isset($_POST["addTodo"])) {
                            echo $_POST["title"];
                            
                        } ?></textarea>
                </div>
                <div class="form-group form-btn">
                    <button type="submit" name="addTodo"> <i class="fa-solid fa-plus"></i> Add Todo</button>
                    <button type="reset"> <i class="fa-solid fa-arrows-rotate"></i> Reset</button>
                </div>
            </form>
        </div>
    </div>


</body>

</html>