<?php
session_start();
if (!isset($_SESSION["pasien"])) {
    header("Location: index.php");
    exit;
}



require 'function.php';

$id_pasien = $_GET['id_pasien'];
$pesan_berhasil = urldecode($_GET['pesan']);

$struk = query("SELECT p.*,u.*,a.*,d.nama,d.spesialis,d.no_hp AS no_hp_dokter,j.* FROM pasien p INNER JOIN users u ON p.id_user = u.id_user INNER JOIN antrian a ON a.id_pasien = p.id INNER JOIN dokter d ON p.id_dokter = d.id INNER JOIN jadwal_dokter j ON j.id_dokter = d.id WHERE p.id = $id_pasien")[0];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="assets/dist/css/adminlte.min.css?v=3.2.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="daftar_dokter.php">Klinik Sukajadi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="daftar_dokter.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="content mt-5">
        <div class="d-flex justify-content-center ">
            <?php if (!empty($pesan_berhasil)) : ?>
                <div class="alert alert-success">
                    <?= $pesan_berhasil; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="container-fluid" id="pdfContent">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-header" style="font-size: 24px;">
                            <h3 class="card-title">Struk Reservasi</h3>
                        </div>

                        <div class="card-body">
                            <div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Lengkap</label>
                                                <input type="text" class="form-control" value="<?= $struk['nama_lengkap']; ?>" name="nama_lengkap" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label>NIK</label>
                                                <input type="number" class="form-control" placeholder="Masukkan NIK" name="nik" disabled value="<?= $struk['nik']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Jenis Kelamin</label>
                                                <input type="text" class="form-control" placeholder="Masukkan NIK" name="jk" disabled value="<?= $struk['jenis_kelamin']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Tempat Lahir</label>
                                                <input type="text" class="form-control" placeholder="Masukkan Tempat Lahir" name="tempat_lahir" disabled value="<?= $struk['tempat_lahir']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal Lahir</label>
                                                <input type="date" class="form-control" placeholder="Masukkan Tanggal Lahir" name="tanggal_lahir" disabled value="<?= $struk['tanggal_lahir']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Tujuan</label>
                                                <input type="text" class="form-control" placeholder="Masukkan tanggal reservasi" name="tujuan" disabled value="<?= $struk['tujuan']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>No Hp</label>
                                                <input type="number" class="form-control" placeholder="Masukkan Nomor HP" name="no_hp" disabled value="<?= $struk['no_hp']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Dokter</label>
                                                <input type="text" class="form-control" disabled value="<?= $struk['nama']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Spesialis</label>
                                                <input type="text" class="form-control" disabled value="<?= $struk['spesialis']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Hari</label>
                                                <input type="text" class="form-control" disabled value="<?= $struk['hari']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Ruangan</label>
                                                <input type="text" class="form-control" disabled value="<?= $struk['ruangan']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>No Hp Dokter</label>
                                                <input type="number" class="form-control" disabled value="<?= $struk['no_hp']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Tanggal Reservasi</label>
                                                <input type="date" class="form-control" placeholder="Masukkan tanggal reservasi" name="tgl_reservasi" disabled value="<?= $struk['tanggal_reservasi']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Antrian</label>
                                                <input type="number" class="form-control" placeholder="Masukkan tanggal reservasi" name="antrian" disabled value="<?= $struk['id_antrian']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6 w-100">
                                            <div class="form-group">
                                                <label>Alamat</label>
                                                <input type="text" class="form-control" placeholder="Masukkan Alamat" name="alamat" disabled value="<?= $struk['alamat']; ?>">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-primary" id="downloadBtn">Unduh sebagai PDF</button>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-right">
                                <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- Include html2pdf.js from CDN -->
    <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>

    <script>
        document.getElementById('downloadBtn').addEventListener('click', function() {
            // Call the function to generate and download the PDF
            generatePDF();
        });

        function generatePDF() {
            // Use html2pdf to convert the HTML content to PDF
            var element = document.getElementById('pdfContent'); // 'pdfContent' is the id of the container holding your HTML content
            var tes = html2pdf(element);
            console.log(tes);
        }
    </script>

    <!-- Skrip FPDF (sesuaikan dengan path yang sesuai) -->
    <!-- <script src="fpdf/fpdf.js"></script> -->

    <!-- Skrip JavaScript untuk menangani pengunduhan PDF -->


</body>

</html>


<hr>
<div class="card-body">

</div>