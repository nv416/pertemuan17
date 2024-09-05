<?php

session_start();

require 'functions.php';

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$laptop = query("SELECT * FROM laptop");

if (isset($_POST["cari"])) {
    $laptop = cari($_POST["keyword"]);
}

?>

<!-- // ambil data dari tabel db_laptop //
// $result = mysqli_query($conn, "SELECT * FROM laptop"); // -->


<!-- ambil data (fetch) laptop dari $result
    mysqli_fetch_row() mengembalikan array numerik
    mysqli_fetch_assoc() mengembalikan array assosiative
    mysqli_fetch_array mengembalikan array keduannya
    mysqli_fetch_object memanggil object dengan cara ->merek -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman admin</title>
</head>

<body>

    <a href="logout.php">logout</a>

    <h1><a href="index.php " style="text-decoration: none;color: black;">daftar laptop</a></h1>

    <a href="tambah.php">tambah data laptop</a>
    <br>

    <form action="" method="post">
        <input type="text" name="keyword" size="40" autofocus placeholder="masukan keyword pencarian" autocomplete="off>">
        <button type="submit" name="cari">cari!</button>
    </form>

    <table border=1 cellpadding=10 cellspacing=0>

        <tr>
            <th>id</th>
            <th>aksi</th>
            <th>gambar</th>
            <th>merek</th>
            <th>model</th>
            <th>procesor</th>
            <th>ram</th>
            <th>penyimpanan</th>
        </tr>
        <?php $i = 1; ?>
        <?php foreach ($laptop as $lpt) : ?>
            <tr>
                <td><?= $i; ?></td>
                <td>
                    <a href="ubah.php?id=<?= $lpt["id"]; ?>">ubah</a> |
                    <a href="hapus.php?id=<?= $lpt["id"]; ?>" onclick="return confirm('yakin');">hapus</a>
                </td>
                <td><img src="gambar/<?= $lpt["gambar"]; ?>" width="70" alt=""></td>
                <td><?= $lpt["merek"]; ?></td>
                <td><?= $lpt["model"]; ?></td>
                <td><?= $lpt["procesor"]; ?></td>
                <td><?= $lpt["ram"]; ?></td>
                <td><?= $lpt["penyimpanan"]; ?></td>
            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>
    </table>
</body>

</html>