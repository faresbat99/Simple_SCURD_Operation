<?php
// connect to database 
session_start();
$conn = mysqli_connect("localhost", "root", "", "fares");
if ($conn) {
    echo mysqli_connect_error();
}
//query statement for list all users
$query = "SELECT * FROM `users`";
$result = mysqli_query($conn, $query);

// sending to DB to get the data

if (isset($_GET["search"])) {
    // escaping to avoid sql injection
    $search = mysqli_escape_string($conn, $_GET["search"]);
    // append to the query
    // $query.=" WHERE `users`.`name` like '%$search%' OR `users`.`email` like '%$search%' ";
    $query .= " WHERE `name` like '%$search%' OR `email` like '%$search%' ";
    // exec
    $result = mysqli_query($conn, $query);
}
if ($_SESSION['id']==null) {
    header("Location: login.php");
}
//table
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        a:hover#add {
            color: black;
        }

        img {
            height: 11em;
            width: auto;
            border-radius: 20%;

        }

        td {
            text-align: center;
        }

        * {
            padding: 5px;
        }

    </style>
    <title>List of users</title>
</head>

<body>
    <?= "Hi ".$_SESSION['name']?>
    <a href="logout.php">Logout</a><br>
    <form action="list.php" method="get">
        <input type="search" name="search" placeholder="Search for name or email">
        <input type="submit" value="Search">

    </form>
    <table>
        <thead>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Photo</th>
            <th>Admin</th>
            <th>Action</th>
        </thead>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tbody>
                <tr>
                    <td><?= $row["id"] ?></td>
                    <td><?= $row["name"] ?></td>
                    <td><?= $row["email"] ?></td>
                    <td>
                        <?php 
                        if ($row["avatar"]) { ?>
                            <img src="../../uploads/<?= $row["name"] . "." . $row["avatar"] ?>">
                        <?php } 
                        else { ?> <img src="../../uploads/emptyImage.jpg">
                        <?php } ?>
                    </td>
                    <td><?= $row["admin"] ? "Yes" : "No" ?></td>
                    <td>
                        <a href="edit.php?id=<?= $row["id"] ?>">Edit </a>|
                        <a href="delete.php?id=<?= $row["id"] ?>&name=<?= $row["name"]?>&avatar=<?= $row["avatar"]?>"> Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="text-align:center;color:#fff; background-color:#000;"><?= mysqli_num_rows($result) ?> User</td>
                    <td colspan="4" style="text-align:center; background-color:rgb(0, 1, 1);"><a id="add" style="color:#fff; text-decoration: none; " href="add.php">Add User</a> </td>
                </tr>
            </tfoot>
    </table>
</body>

</html>
<?php
mysqli_free_result($result);
mysqli_close($conn);
?>