<?php
require "functions.php";

if (isset($_POST["register"])) {
    if (registrasi($_POST) > 0) {
        echo "<script>
        alert('Registrasi Berhasil');
        document.location.href='login.php';
        </script>";
    } else {
        echo mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="register.css">
</head>

<body>
    <div class="container">
        <h1>Register</h1>
        <form action="" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <label for="password2">Confirm Password:</label>
            <input type="password" name="password2" id="password2" required>

            <button type="submit" name="register">Register</button>
        </form>
        <br>
        <a href="login.php">Already have an account? Login</a>
    </div>
</body>

</html>