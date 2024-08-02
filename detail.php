<?php
require "functions.php";

$jumlah_penumpang = $_GET["jumlah_penumpang"];
$id_penerbangan = $_GET["id_penerbangan"];

$penerbangan_detail = query("SELECT p.id_penerbangan, p.nomor_penerbangan, p.harga, p.waktu_keberangkatan,p.waktu_kedatangan ,b1.nama_bandara AS bandara_keberangkatan, b2.nama_bandara AS bandara_tujuan
FROM penerbangan p
JOIN bandara b1 ON p.id_bandara_keberangkatan = b1.id_bandara
JOIN bandara b2 ON p.id_bandara_tujuan = b2.id_bandara
WHERE p.id_penerbangan = '$id_penerbangan'")[0];

$total_harga = $penerbangan_detail["harga"] * $jumlah_penumpang;


if (isset($_POST["submit"])) {
    $id_penumpang = penumpang($_POST);

    // Debugging output
    var_dump($id_penumpang);

    if ($id_penumpang !== false) {
        $id_pemesanan = pemesanan($id_penerbangan, $id_penumpang, $jumlah_penumpang, $total_harga);

        if ($id_pemesanan !== false) {
            // Simpan id_pemesanan di sesi
            session_start();
            $_SESSION['id_pemesanan'] = $id_pemesanan;

            // Redirect ke halaman pembayaran
            header("Location: pembayaran.php");
            exit();
        }
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penerbangan</title>
    <link rel="stylesheet" href="detail.css">
</head>

<body>
    <div class="container">
        <h1>Detail Penerbangan</h1>

        <form action="" method="post">
            <input type="hidden" name="id_penerbangan" value="<?= htmlspecialchars($penerbangan_detail["id_penerbangan"]) ?>" readonly>
            <div class="form-group">
                <label for="bandara_keberangkatan">Asal Bandara</label>
                <input type="text" name="bandara_keberangkatan" id="bandara_keberangkatan" class="form-control" value="<?= htmlspecialchars($penerbangan_detail["bandara_keberangkatan"]) ?>" readonly>
            </div>
            <div class="form-group">
                <label for="bandara_tujuan">Tujuan Bandara</label>
                <input type="text" name="bandara_tujuan" id="bandara_tujuan" class="form-control" value="<?= htmlspecialchars($penerbangan_detail["bandara_tujuan"]) ?>" readonly>
            </div>
            <div class="form-group">
                <label for="waktu_keberangkatan">Waktu Keberangkatan</label>
                <input type="text" name="waktu_keberangkatan" id="waktu_keberangkatan" class="form-control" value="<?= htmlspecialchars($penerbangan_detail["waktu_keberangkatan"]) ?>" readonly>
            </div>
            <div class="form-group">
                <label for="waktu_kedatangan">Waktu Kedatangan</label>
                <input type="text" name="waktu_kedatangan" id="waktu_kedatangan" class="form-control" value="<?= htmlspecialchars($penerbangan_detail["waktu_kedatangan"]) ?>" readonly>
            </div>
            <div class="form-group">
                <label for="total_harga">Total Harga (<?= htmlspecialchars($jumlah_penumpang) ?> Penumpang)</label>
                <input type="text" name="total_harga" id="total_harga" class="form-control" value="<?= htmlspecialchars($total_harga) ?>" readonly>
            </div>
        </form>

        <div class="form-container">
            <h2>Data Penumpang</h2>
            <form action="" method="post">
                <?php for ($i = 1; $i <= $jumlah_penumpang; $i++) : ?>
                    <fieldset>
                        <legend>Penumpang <?= $i ?></legend>
                        <div class="form-group">
                            <label for="nama_lengkap_<?= $i ?>">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap[]" id="nama_lengkap_<?= $i ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir_<?= $i ?>">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir[]" id="tanggal_lahir_<?= $i ?>" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin_<?= $i ?>">Jenis Kelamin</label>
                            <select name="jenis_kelamin[]" id="jenis_kelamin_<?= $i ?>" class="form-control" required>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nomor_telepon_<?= $i ?>">Nomor Telepon</label>
                            <input type="text" name="nomor_telepon[]" id="nomor_telepon_<?= $i ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email_<?= $i ?>">Email</label>
                            <input type="email" name="email[]" id="email_<?= $i ?>" class="form-control">
                        </div>
                    </fieldset>
                <?php endfor; ?>
                <button type="submit" name="submit">Lanjut</button>
            </form>
        </div>
    </div>
</body>

</html>