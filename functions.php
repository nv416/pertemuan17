<?php
$conn = mysqli_connect("localhost", "root", "", "db_laptop");

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $lpts = [];
    while ($lpt = mysqli_fetch_assoc($result)) {
        $lpts[] = $lpt;
    }
    return $lpts;
}

function tambah($data)
{
    // ambil data dari tiap elemen form
    global $conn;
    $merek = htmlspecialchars($data["merek"]);
    $model = htmlspecialchars($data["model"]);
    $procesor = htmlspecialchars($data["procesor"]);
    $ram = htmlspecialchars($data["ram"]);
    $penyimpanan = htmlspecialchars($data["penyimpanan"]);

    // upload gambar
    $gambar = upload();

    if (!$gambar) {
        return false;
    }


    // query insert data mysql

    $query = "INSERT INTO laptop VALUES
    ('','$gambar','$merek','$model','$procesor','$ram','$penyimpanan')
    ";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function upload()
{
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFIle = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];


    // cek apakah tidak ada gambar yang di upload 
    if ($error === 4) {
        echo "<script>
            alert('pilih gambar terlebih dahulu!');
            </script>";
        return false;
    }

    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
        alert('yang anda upload bukan gambar!');
        </script>";
        return false;
    }
    if ($ukuranFIle > 1000000) {
        echo "<script>
        alert('ukuran gambar terlalu besar!');
        </script>";
        return false;
    }

    // lolos pengecekan gambar berhasil di upload
    // generate nama gambar baru agar tidak tertimpa

    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'gambar/' . $namaFileBaru);
    return $namaFileBaru;
}

function hapus($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM laptop WHERE id = $id");

    return mysqli_affected_rows($conn);
}

function ubah($data)
{
    global $conn;

    $id = $data["id"];
    $gambarLama = htmlspecialchars($data["gambarLama"]);
    $merek = htmlspecialchars($data["merek"]);
    $model = htmlspecialchars($data["model"]);
    $procesor = htmlspecialchars($data["procesor"]);
    $ram = htmlspecialchars($data["ram"]);
    $penyimpanan = htmlspecialchars($data["penyimpanan"]);

    // Periksa apakah ada gambar baru yang diupload
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
        // Jika upload gagal, langsung kembali
        if (!$gambar) {
            return false;
        }
    }

    // Query update
    $query = "UPDATE laptop SET 
                gambar = '$gambar',
                merek = '$merek',
                model = '$model',
                procesor = '$procesor',
                ram = '$ram',
                penyimpanan = '$penyimpanan'
              WHERE id = $id";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function cari($keyword)
{
    $query = "SELECT * FROM laptop WHERE 
                merek LIKE '%$keyword%' OR
                model LIKE '%$keyword%' OR
                procesor LIKE '%$keyword%' OR
                ram LIKE '%$keyword%' OR
                penyimpanan LIKE '%$keyword%'
                ";
    return query($query);
}

function registrasi($data){
    global $conn;

    $username = strtolower(stripslashes($data["username"])); 
    $password = mysqli_real_escape_string($conn,$data["password"]);
    $password2 = mysqli_real_escape_string($conn,$data["password2"]);

    // cek username ada atau belum
    $result = mysqli_query($conn, "SELECT * FROM user WHERE username ='$username'");
    if(mysqli_fetch_assoc($result)){
        echo "<script>
                alert('username sudah ada')
                </script>";
                return false;
    }

    // cek konfirmasi password
    if($password !== $password2){
        echo "<script>
                alert('konfirmasi password tidak sesuai!');
                </script>";
                return false;
    } 

    // enskripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    mysqli_query($conn,"INSERT INTO user VALUES('','$username','$password')" );
    
    return mysqli_affected_rows($conn);

}
