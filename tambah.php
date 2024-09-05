<?php

session_start();

if (!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}

require 'functions.php';

// cek apakah tombol suubmit suda di pencet
if (isset($_POST["submit"])) {
    // cek apakah data berhasil di tambah atau tidak
    if (tambah($_POST) > 0) {
        echo "
            <script>
                alert('data berhasil ditambahkan!');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('data gagal ditambahkan!');
                document.location.href = 'index.php';
            </script>
        ";
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tambah data laptop</title>
</head>

<body>
    <h1>tambah data laptop</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="merek">Merek :</label>
                <input type="text" name="merek" id="merek" required autocomplete="off">
            </li>
            <li>
                <label for="model">Model :</label>
                <input type="text" name="model" id="model" autocomplete="off">
            </li>
            <li>
                <label for="procesor">Procesor :</label>
                <input type="text" name="procesor" id="procesor" autocomplete="off">
            </li>
            <li>
                <label for="ram">Ram :</label>
                <input type="text" name="ram" id="ram" autocomplete="off">
            </li>
            <li>
                <label for="penyimpanan">Penyimpanan :</label>
                <input type="text" name="penyimpanan" id="penyimpanan" autocomplete="off">
            </li>
            <li>
                <label for="gambar">gambar :</label>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">submit!</button>
            </li>
        </ul>

    </form>
</body>

</html>