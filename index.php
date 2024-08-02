<?php


session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require "functions.php";


$penerbangan = query("SELECT p.id_penerbangan, p.nomor_penerbangan, p.harga, p.waktu_keberangkatan, b1.nama_bandara AS bandara_keberangkatan, b2.nama_bandara AS bandara_tujuan
FROM penerbangan p
JOIN bandara b1 ON p.id_bandara_keberangkatan = b1.id_bandara
JOIN bandara b2 ON p.id_bandara_tujuan = b2.id_bandara;
");



if (isset($_POST["submit"])) {
    $bandara_keberangkatan = $_POST["bandara_keberangkatan"];
    $bandara_tujuan = $_POST["bandara_tujuan"];
    $waktu_keberangkatan = $_POST["waktu_keberangkatan"];


    $terbang = cari($bandara_keberangkatan, $bandara_tujuan, $waktu_keberangkatan);
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Search</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <form action="" method="post">
        <h1>Cari Penerbangan Anda</h1>

        <label for="bandara_keberangkatan">Bandara Asal:</label>
        <select name="bandara_keberangkatan" id="bandara_keberangkatan" required>
            <option value="" disabled selected>Pilih Bandara Asal</option>
            <?php foreach ($penerbangan as $row) : ?>
                <option value="<?php echo htmlspecialchars($row['bandara_keberangkatan']); ?>">
                    <?php echo htmlspecialchars($row['bandara_keberangkatan']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="bandara_tujuan">Bandara Tujuan:</label>
        <select name="bandara_tujuan" id="bandara_tujuan" required>
            <option value="" disabled selected>Pilih Bandara Tujuan</option>
            <?php foreach ($penerbangan as $row) : ?>
                <option value="<?php echo htmlspecialchars($row['bandara_tujuan']); ?>">
                    <?php echo htmlspecialchars($row['bandara_tujuan']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="waktu_keberangkatan">Tanggal Keberangkatan:</label>
        <input type="date" name="waktu_keberangkatan" id="waktu_keberangkatan" required>

        <label for="jumlah_penumpang">Jumlah Penumpang:</label>
        <input type="number" name="jumlah_penumpang" id="jumlah_penumpang" min="1" required>

        <button name="submit" type="submit">Cari</button>
    </form>

    <?php if (isset($terbang)) : ?>
        <h2>Hasil Pencarian</h2>
        <table>
            <thead>
                <tr>
                    <th>Nomor Penerbangan</th>
                    <th>Harga</th>
                    <th>Waktu Keberangkatan</th>
                    <th>Bandara Keberangkatan</th>
                    <th>Bandara Tujuan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($terbang as $penerbangan) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($penerbangan['nomor_penerbangan']); ?></td>
                        <td><?php echo htmlspecialchars($penerbangan['harga']); ?></td>
                        <td><?php echo htmlspecialchars($penerbangan['waktu_keberangkatan']); ?></td>
                        <td><?php echo htmlspecialchars($penerbangan['bandara_keberangkatan']); ?></td>
                        <td><?php echo htmlspecialchars($penerbangan['bandara_tujuan']); ?></td>
                        <td class="form-container">
                            <form action="detail.php" method="get">
                                <input type="hidden" name="id_penerbangan" value="<?= htmlspecialchars($penerbangan["id_penerbangan"]); ?>">
                                <input type="hidden" name="jumlah_penumpang" value="<?= htmlspecialchars($_POST['jumlah_penumpang']); ?>">
                                <button type="submit">Pesan</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>

</html>