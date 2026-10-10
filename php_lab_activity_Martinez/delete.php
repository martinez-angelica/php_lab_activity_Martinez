<?php
include 'dbcon.php';
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
} elseif (isset($_GET['id'])) {
    $id = intval($_GET['id']);
} else {
    header("Location: index.php");
    exit();
}
$sql = "DELETE FROM users WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    if ($conn->affected_rows > 0) {
        header("Location: index.php?msg=deleted");
        exit();
    } else {
        echo "Error: No user found with ID: " . $id;
    }
} else {
    echo "Database Error: " . $conn->error;
}
?>