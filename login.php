<?php
session_start();
require "functions.php";

if (isset($_COOKIE['id']) && isset($_COOKIE["key"])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];
    //ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT email FROM pengguna WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
    //cek cookie dan username
    if ($key === hash('sha256', $row['email'])) {
        $_SESSION['login'] = true;
    }
}

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];


    $result = mysqli_query($conn, "SELECT * FROM pengguna WHERE email = '$email'");

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            //set session
            $_SESSION["login"] = true;

            //cek remember me
            if (isset($_POST['remember'])) {

                setcookie('id', $row["id"], time() + 60);
                setcookie('key', hash('sha256', $row["email"]), time() + 60);
            }

            header("Location:index.php");
            exit;
        }
    }
    $error = true;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <div class="container">
        <h1>Login</h1>
        <?php if (isset($error)) : ?>
            <p>Email atau password salah</p>
        <?php endif; ?>
        <form action="" method="post">
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember Me</label>
            </div>

            <button type="submit" name="login">Login</button>
        </form>

        <div class="register">Don't have an account? <a href="register.php">Register</a></div>
    </div>
</body>

</html>