<?php
session_start(); // Start session for storing login information

include 'config.php'; // Include the connection file

// If login form is submitted
if(isset($_POST['submit'])) {
    $conn = connectToDatabase();
    
    $namauser = $conn->real_escape_string($_POST['namauser']);
    $password = $conn->real_escape_string($_POST['password']);

    $query = "SELECT * FROM user WHERE namauser='$namauser' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user'] = $user;

        // Redirect to the appropriate page based on user's level
        $level = $_SESSION['user']['level'];
        switch ($level) {
            case 1:
                header("Location: admin/menu/index.php");
                break;
            case 2:
                header("Location: waiter/index.php");
                break;
            case 3:
                header("Location: kasir/pesanan.php");
                break;
            case 4:
                header("Location: owner/index.php");
                break;
            default:
                // Redirect to login page if level is not recognized
                header("Location: login.php");
                break;
        }
        exit(); // Stop further execution
    } else {
        $error = true;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Login</h3>
                    </div>
                    <div class="card-body">
                        <?php if(isset($error) && $error): ?>
                            <div class="alert alert-danger" role="alert">
                                Invalid username or password!
                            </div>
                        <?php endif; ?>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="namauser">Username:</label>
                                <input type="text" name="namauser" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="submit" class="btn btn-primary btn-block">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
