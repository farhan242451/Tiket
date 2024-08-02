<?php
require "functions.php";

session_start();

// Mengambil ID pemesanan dari sesi
$id_pemesanan = $_SESSION['id_pemesanan'][0];

// Mengambil detail pemesanan
$pemesanan_detail = query("SELECT p.id_pemesanan, p.id_penerbangan, p.id_penumpang, p.tanggal_pemesanan, p.jumlah_penumpang, p.total_harga,b1.nama_bandara AS bandara_keberangkatan, b2.nama_bandara AS bandara_tujuan, pe.nomor_penerbangan, pe.harga, pe.waktu_keberangkatan, pe.waktu_kedatangan
    FROM pemesanan p
    JOIN penerbangan pe ON p.id_penerbangan = pe.id_penerbangan
    JOIN bandara b1 ON pe.id_bandara_keberangkatan = b1.id_bandara
    JOIN bandara b2 ON pe.id_bandara_tujuan = b2.id_bandara
    WHERE p.id_pemesanan = '$id_pemesanan'")[0];

$jumlah_pembayaran = $pemesanan_detail["total_harga"];

// Mengambil daftar metode pembayaran (atau bisa diambil dari tabel jika perlu)
$pembayaran = query("SELECT DISTINCT metode_pembayaran FROM pembayaran");

// Memproses pembayaran jika form disubmit
if (isset($_POST["bayar"])) {
    $metode_pembayaran = htmlspecialchars($_POST['metode_pembayaran']);
    $jumlah_pembayaran = htmlspecialchars($_POST['jumlah_pembayaran']);

    // Menambahkan pembayaran ke database
    if (pembayaran($_POST)) {
        echo "<script>alert('Pembayaran Berhasil'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Pembayaran Gagal');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <link rel="stylesheet" href="pembayaran.css"> <!-- Link ke file CSS Anda -->
</head>

<body>
    <div class="container">
        <h1>Detail Pemesanan</h1>

        <p><strong>Nomor Penerbangan:</strong> <?= htmlspecialchars($pemesanan_detail["nomor_penerbangan"]) ?></p>
        <p><strong>Asal Bandara:</strong> <?= htmlspecialchars($pemesanan_detail["bandara_keberangkatan"]) ?></p>
        <p><strong>Tujuan Bandara:</strong> <?= htmlspecialchars($pemesanan_detail["bandara_tujuan"]) ?></p>
        <p><strong>Waktu Keberangkatan:</strong> <?= htmlspecialchars($pemesanan_detail["waktu_keberangkatan"]) ?></p>
        <p><strong>Waktu Kedatangan:</strong> <?= htmlspecialchars($pemesanan_detail["waktu_kedatangan"]) ?></p>
        <p><strong>Jumlah Penumpang:</strong> <?= htmlspecialchars($pemesanan_detail["jumlah_penumpang"]) ?></p>

        <form action="" method="post">
            <input type="hidden" name="id_pemesanan" value="<?= htmlspecialchars($pemesanan_detail['id_pemesanan']) ?>">

            <label for="metode_pembayaran">Metode Pembayaran:</label>
            <select name="metode_pembayaran" id="metode_pembayaran" required>
                <option value="" disabled selected>Pilih Metode Pembayaran</option>
                <?php foreach ($pembayaran as $row) : ?>
                    <option value="<?= htmlspecialchars($row['metode_pembayaran']) ?>">
                        <?= htmlspecialchars($row['metode_pembayaran']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="jumlah_pembayaran">Jumlah Pembayaran:</label>
            <input type="text" name="jumlah_pembayaran" id="jumlah_pembayaran" value="<?= htmlspecialchars($jumlah_pembayaran) ?>" readonly>

            <button type="submit" name="bayar">Bayar</button>
        </form>

        <br>
        <a href="index.php">Kembali ke Beranda</a>
    </div>
</body>

</html>