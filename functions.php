<?php

$conn = mysqli_connect("localhost", "root", "", "tiketing");

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function cari($bandara_keberangkatan, $bandara_tujuan, $waktu_keberangkatan)
{

    $query = "SELECT p.id_penerbangan, p.nomor_penerbangan, p.harga, p.waktu_keberangkatan, b1.nama_bandara AS bandara_keberangkatan, b2.nama_bandara AS bandara_tujuan
          FROM penerbangan p
          JOIN bandara b1 ON p.id_bandara_keberangkatan = b1.id_bandara
          JOIN bandara b2 ON p.id_bandara_tujuan = b2.id_bandara
          WHERE b1.nama_bandara LIKE '%$bandara_keberangkatan%'
          AND b2.nama_bandara LIKE '%$bandara_tujuan%'
          AND p.waktu_keberangkatan LIKE '%$waktu_keberangkatan%'";

    return query($query);
}

function penumpang($data)
{
    global $conn;
    $id_penumpang = [];

    for ($i = 0; $i < count($data['nama_lengkap']); $i++) {
        // Sanitize input data
        $nama_lengkap =  htmlspecialchars($data['nama_lengkap'][$i]);
        $tanggal_lahir =  htmlspecialchars($data['tanggal_lahir'][$i]);
        $jenis_kelamin =  htmlspecialchars($data['jenis_kelamin'][$i]);
        $nomor_telepon =  htmlspecialchars($data['nomor_telepon'][$i]);
        $email =  htmlspecialchars($data['email'][$i]);

        $query = "INSERT INTO penumpang (nama_lengkap, tanggal_lahir, jenis_kelamin, nomor_telepon, email) VALUES ('$nama_lengkap', '$tanggal_lahir', '$jenis_kelamin', '$nomor_telepon', '$email')";

        $result = mysqli_query($conn, $query);
        if ($result) {

            $id_penumpang[] = mysqli_insert_id($conn);
        }
    }

    // Mengembalikan array ID penumpang
    return $id_penumpang;
}

function pemesanan($id_penerbangan, $id_penumpang, $jumlah_penumpang, $total_harga)
{
    global $conn;
    $id_pemesanan = [];
    $id_penerbangan = htmlspecialchars($id_penerbangan);
    $jumlah_penumpang = htmlspecialchars($jumlah_penumpang);
    $total_harga = htmlspecialchars($total_harga);


    for ($i = 0; $i < count($id_penumpang); $i++) {
        $current_id_penumpang = htmlspecialchars($id_penumpang[$i]);


        $query = "INSERT INTO pemesanan (id_penerbangan, id_penumpang, tanggal_pemesanan, jumlah_penumpang, total_harga) 
                  VALUES ('$id_penerbangan', '$current_id_penumpang', NOW(), '$jumlah_penumpang', '$total_harga')";


        $result = mysqli_query($conn, $query);

        if ($result) {
            $id_pemesanan[] = mysqli_insert_id($conn);
        }
    }


    return $id_pemesanan;
}

// Fungsi untuk menambahkan pembayaran
function pembayaran($data)
{
    global $conn; // Pastikan koneksi database sudah terhubung

    // Mengambil data dari parameter
    $id_pemesanan = htmlspecialchars($data['id_pemesanan']);
    $metode_pembayaran = htmlspecialchars($data['metode_pembayaran']);
    $jumlah_pembayaran = htmlspecialchars($data['jumlah_pembayaran']);

    // Mendapatkan tanggal dan waktu saat ini
    $tanggal_pembayaran = date('Y-m-d H:i:s');

    // Menyiapkan query untuk memasukkan data pembayaran
    $sql = "INSERT INTO pembayaran (id_pemesanan, metode_pembayaran, tanggal_pembayaran, jumlah_pembayaran) 
            VALUES ('$id_pemesanan', '$metode_pembayaran', '$tanggal_pembayaran', '$jumlah_pembayaran')";

    mysqli_query($conn, $sql);

    return mysqli_affected_rows($conn);
}

function registrasi($data)
{
    global $conn;
    // Mengambil data dari parameter
    $username = strtolower(stripslashes($data["username"]));
    $email = strtolower(stripslashes($data["email"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    $result = mysqli_query($conn, "SELECT email FROM pengguna WHERE email = '$email'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
    alert('email sudah terdaftar');
    </script>";
    } else {
        //cek konfirmasi password
        if ($password !== $password2) {
            echo "<script>
        alert('konfirmasi password tidak sesuai');
        </script>";
            //memberhentikan program berhenti
            return false;
        } else {
            //enkripsi password
            $password = password_hash($password, PASSWORD_DEFAULT);
            //tambahkan user baru ke database
            mysqli_query($conn, "INSERT INTO pengguna VALUES('', '$username', '$password','$email')");
            return mysqli_affected_rows($conn);
        }
    }
}
