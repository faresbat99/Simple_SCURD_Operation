<?php
session_start();
if ($_SESSION["id"]==null) {
    header("Location: login.php");
}
// connection
$conn = mysqli_connect("localhost", "root", "", "fares");
if (!$conn) {
    echo mysqli_connect_error($conn);
}
//receiving id 
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

$query = "DELETE  FROM `users` WHERE `id`=$id";
if (mysqli_query($conn, $query)) {
    // we want to delete the photo that is store in db 
    $name = $_GET["name"];
    $avatar = $_GET["avatar"];
    unlink("../../uploads/" . "$name" . "." . "$avatar");
    header("Location: list.php");
    exit;
} else
    echo mysqli_error($conn);
mysqli_close($conn);
