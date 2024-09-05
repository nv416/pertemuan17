<?php

session_start();

require 'functions.php'; 

if (isset($_COKIE['id']) && isset($_COOKIE['key']) ) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    // ambil username berdasarkan id 
    $result = mysqli_query($conn, "SELECT username FROM username WHERE id =$id" );

    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username
    if($key == hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
    }
}

if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST["login"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    if (mysqli_num_rows($result) > 0) {

        // cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {

            // set session
            $_SESSION["login"] = true;

            // cek remember me
            if(isset($_POST["remember"])) {
                // buat cookie
                setcookie('id', $eow['id'], time() + 60);
                setcookie('key', hash('sha256', $row['username']), time() + 60);
            }

            header("Location: index.php");
            exit;
        }
    }

    $error = true;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman login</title>
    <style>
        label {
            display: block;
        }

        input {
            display: block;
        }
    </style>
</head>

<body>
    <h1>halaman login</h1>

    <?php if (isset($error)): ?>
        <p style="color: red; font-style: italic;">username/password salah</p>
    <?php endif; ?>


    <form action="" method="post">
        <ul>
            <li>
                <label for="username">username</label>
                <input type="text" name="username" id="username">
            </li>
            <li>
                <label for="password">password :</label>
                <input type="password" name="password" id="password">
            </li>
            
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">remember me </label>
                </li>

                <li>
                    <button type="submit" name="login">login</button>
                </li>
        </ul>
    </form>
</body>

</html>