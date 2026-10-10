<?php
include 'dbcon.php';
if (isset($_POST['submit'])) {
    $name  = $_POST['name'];
    $email = $_POST['email'];
    if (!empty($name) && !empty($email)) {
        $sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
        if ($conn->query($sql) === TRUE) {
            header("Location: index.php?msg=added");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #e9ecef; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .main-container { margin-top: 50px; }
        .card { border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .table thead th { border-bottom: 2px solid #dee2e6; font-weight: 600; }
        .inline-form { display: inline; }
    </style>
</head>
<body>
<div class="container main-container">
    <h1 class="text-center mb-5" style="color: #2c3e50; font-weight: 600;">User Management System</h1>
    <?php if ($msg == 'added'): ?>
        <div class="alert alert-success" role="alert">User added successfully!</div>
    <?php elseif ($msg == 'updated'): ?>
        <div class="alert alert-info" role="alert">User updated successfully!</div>
    <?php elseif ($msg == 'deleted'): ?>
        <div class="alert alert-danger" role="alert">User deleted successfully!</div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-4">
            <div class="card p-4">
                <h4 class="mb-4" style="color: #2c3e50;">Add New User</h4>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Full Name" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Address" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary w-100 py-2" style="background-color: #0d6efd;">Submit</button>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card p-4">
                <h4 class="mb-4" style="color: #2c3e50;">Registered Users</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Joined</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM users ORDER BY id DESC";
                            $result = $conn->query($sql);
                            $count = 1;
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?php echo $count++; ?></td>
                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                        <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                        <td>
                                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success">Edit</a>
                                            <form action="delete.php" method="POST" class="inline-form">
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" name="delete" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center text-muted py-4'>No data found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>