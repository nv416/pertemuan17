<?php

session_start();

if (!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}

require 'functions.php';

// ambil data di url
$id = $_GET["id"];

// query data laptop berdasarkan id
$lpt = query("SELECT * FROM laptop WHERE id=$id")[0];

// cek apakah tombol suubmit suda di pencet
if (isset($_POST["submit"])) {

    // cek apakah data berhasil di ubah
    if (ubah($_POST) > 0) {
        echo "
            <script>
                alert('data berhasil diubah!');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('data berhasil diubah!');
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
    <title>ubah data laptop</title>
</head>

<body>
    <h1>ubah data laptop</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $lpt["id"]; ?>">
        <input type="hidden" name="gambarLama" value="<?= $lpt["gambar"]; ?>">

        <ul>
            <li>
                <label for="merek">Merek :</label>
                <input type="text" name="merek" id="merek" required
                    value="<?= $lpt["merek"]; ?> ">
            </li>
            <li>
                <label for="model">Model :</label>
                <input type="text" name="model" id="model" value="<?= $lpt["model"]; ?>">
            </li>
            <li>
                <label for="procesor">Procesor :</label>
                <input type="text" name="procesor" id="procesor" value="<?= $lpt["procesor"]; ?>">
            </li>
            <li>
                <label for="ram">Ram :</label>
                <input type="text" name="ram" id="ram" value="<?= $lpt["ram"]; ?>">
            </li>
            <li>
                <label for="penyimpanan">Penyimpanan :</label>
                <input type="text" name="penyimpanan" id="penyimpanan" value="<?= $lpt["penyimpanan"]; ?>">
            </li>
            <li>
                <label for="gambar">gambar :</label><br>
                <img src="gambar/<?= $lpt["gambar"]; ?>" width="80" alt=""><br>
                <input type="file" name="gambar" id="gambar" >
            </li>
            <li>
                <button type="submit" name="submit">ubah!</button>
            </li>
        </ul>
    </form>
</body>

</html>