<?php

function dbConnect()
{ 
$hostname = "localhost";
$username = "root";
$password = "Manasi@123";
$database = "todo_list";

$conn = mysqli_connect($hostname, $username, $password, $database) or die("Database connection failed.");
return $conn;
}

$conn = dbConnect();

function emailIsValid($email)
{
    $conn = dbConnect();
    $sql = "SELECT email FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        return true;
    } else {
        return false;
    }
}

function checkLoginDetails($email, $password)
{
    $conn = dbConnect();
    $sql = "SELECT email FROM users WHERE email='$email' AND password='$password' ";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        return true;
    } else {
        return false;
    }
}

function createUser($email, $password)
{
    $conn = dbConnect();
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
    $result = mysqli_query($conn, $sql);
    return $result;
}

 function getHead()
 {
     $pageTitle = dynamicTitle();
     $output = '<title>'. $pageTitle .'</title>';  
     echo $output;
 }

function getHeader()
{
    $output =
    '<nav>
        <div class="home">
            <a href="todos.php" >
                Todo List
            </a>
        </div>
        <div class="bar">
            <label for="id-show-menu" class="show-menu">
                <div class="nav-icon">
                    <i class="fa-solid fa-bars"></i>
                </div>
            </label>
        <input type="checkbox" id="id-show-menu" class="checkbox-menu" role="button">
            <div class="menu-block">
                <ul class="navUL">
                <li><a href="todos.php">Home</a></li>
                <li><a href="add-todo.php">Add Todo</a></li>
                <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>';

    echo $output;
}

function textLimit($string, $limit)
{
    if (strlen($string) > $limit) {
        return substr($string, 0, $limit) . "...";
    } else {
        return $string;
    }
}

function getTodo($todo)
{
    $output = 
    '<div class="todo-view">
            <p class="viewdef">Title: </p>  <h3>'. textLimit($todo['title'], 28) .'</h3> <br>
             <p class="viewdef">Description:</p>  <p>'. textLimit($todo['description'], 75) .'</p><br>
            <div>
                <div class="link-view">
                    <i class="fa-solid fa-eye"></i> <a href="view-todo.php?id='. $todo['id'] .'" >View</a>
                    <i class="fa-solid fa-pen-fancy"></i> <a href="edit-todo.php?id='. $todo['id'] .'" >Edit</a>
                </div>
            </div>
        </div>';

    echo $output;
}

function dynamicTitle()
{
    global $conn;
    $filename = basename($_SERVER["PHP_SELF"]);
    $pageTitle = "";
    switch ($filename) {
        case 'index.php':
            $pageTitle = "Home";
            break;

        case 'todos.php':
            $pageTitle = "Todo List";
            break;

        case 'add-todo.php':
            $pageTitle = "Add Todo";
            break;

        case 'edit-todo.php':
            $pageTitle = "Edit Todo";
            break;

        case 'view-todo.php':
            $todoId = mysqli_real_escape_string($conn, $_GET["id"]);
            $sql1 = "SELECT * FROM todos WHERE id='{$todoId}'";
            $res1 = mysqli_query($conn, $sql1);
            if (mysqli_num_rows($res1) > 0) {
                foreach ($res1 as $todo) {
                    $pageTitle = $todo["title"];
                }
            }
            break;

        default:
            $pageTitle = "Todo List";
            break;
    }

    return $pageTitle;
}