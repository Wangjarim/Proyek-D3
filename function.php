<?php
$connect = mysqli_connect("localhost", "root", "", "klinik");

require 'vendor/autoload.php';

use Carbon\Carbon;

function query($query)
{
    global $connect;
    $result = mysqli_query($connect, $query);
    $row = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function register($data)
{
    global $connect;


    $fullname = mysqli_real_escape_string($connect, $data['name']);
    $username = stripslashes($data["username"]);
    $password = mysqli_real_escape_string($connect, $data["password"]);
    $confirm = mysqli_real_escape_string($connect, $data["confirm"]);
    $username_sama = mysqli_query($connect, "SELECT username FROM users WHERE username = '$username'");


    if (mysqli_fetch_assoc($username_sama)) {
        echo "<script>
                    alert('Username yang dipilih sudah terdaftar')
                </script>";
        return false;
    }



    if ($confirm !== $password) {
        echo "<script>
                    alert('Password tidak sama')
                </script>";
        return false;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($connect, "INSERT INTO users VALUES('','$fullname' ,'$username', '$hash', 'pasien')");

    return mysqli_affected_rows($connect);
}

function tambahDokter($data)
{

    global $connect;

    $nama_dokter = mysqli_real_escape_string($connect, $data['nama_dokter']);
    $spesialis = stripslashes($data["spesialis"]);
    $no_hp = mysqli_real_escape_string($connect, $data["no_hp"]);

    $query = "INSERT INTO dokter (`nama`,`spesialis`,`no_hp`) VALUES ('$nama_dokter','$spesialis','$no_hp')";
    mysqli_query($connect, $query);

    return mysqli_affected_rows($connect);
}

function editDokter($data)
{

    global $connect;

    $id = $data['id'];
    $nama_dokter = mysqli_real_escape_string($connect, $data['nama_dokter']);
    $spesialis = stripslashes($data["spesialis"]);
    $no_hp = mysqli_real_escape_string($connect, $data["no_hp"]);

    $query = "UPDATE dokter SET 
                nama = '$nama_dokter',
                spesialis = '$spesialis',
                no_hp = '$no_hp'

                WHERE id = $id
            ";
    mysqli_query($connect, $query);

    return mysqli_affected_rows($connect);
}

function jadwalDokter($data)
{
    global $connect;

    $id = $data['id'];
    $hari = mysqli_real_escape_string($connect, $data['hari']);
    $jam = stripslashes($data["jam"]);
    $ruangan = mysqli_real_escape_string($connect, $data["ruangan"]);

    $query = "INSERT INTO jadwal_dokter (`id_dokter`,`hari`,`jam`,`ruangan`) VALUES ('$id','$hari','$jam','$ruangan')";
    mysqli_query($connect, $query);

    return mysqli_affected_rows($connect);
}

function editJadwal($data)
{

    global $connect;

    $id = $data['id'];
    $hari = mysqli_real_escape_string($connect, $data['hari']);
    $jam = stripslashes($data["jam"]);
    $ruangan = mysqli_real_escape_string($connect, $data["ruangan"]);

    $query = "UPDATE jadwal_dokter SET 
                hari = '$hari',
                jam = '$jam',
                ruangan = '$ruangan'

                WHERE id = $id
            ";
    mysqli_query($connect, $query);

    return mysqli_affected_rows($connect);
}

function dataDiri($data)
{
    global $connect;

    $id_dokter = $data['id_dokter'];
    $id_user = $data['id_user'];
    $nik = mysqli_real_escape_string($connect, $data['nik']);
    $tujuan = mysqli_real_escape_string($connect, $data['tujuan']);
    $jenis_kelamin = mysqli_real_escape_string($connect, $data['jenis_kelamin']);
    $tempat_lahir = mysqli_real_escape_string($connect, $data['tempat_lahir']);
    $tanggal_lahir = mysqli_real_escape_string($connect, $data['tanggal_lahir']);
    $alamat = mysqli_real_escape_string($connect, $data['alamat']);
    $tgl_reservasi = mysqli_real_escape_string($connect, $data['tgl_reservasi']);

    Carbon::setLocale('id');
    $carbonDate = Carbon::parse($tgl_reservasi);
    $nama_hari_input = $carbonDate->translatedFormat('l');

    // Pemeriksaan apakah pasien sudah melakukan reservasi pada hari yang sama
    $query_check_reservasi = "SELECT COUNT(*) AS jumlah_reservasi FROM pasien WHERE id_user = '$id_user' AND tanggal_reservasi = '$tgl_reservasi'";
    $result_check_reservasi = mysqli_query($connect, $query_check_reservasi);
    $row_check_reservasi = mysqli_fetch_assoc($result_check_reservasi);

    $jumlah_reservasi = $row_check_reservasi['jumlah_reservasi'];

    if ($jumlah_reservasi > 0) {
        // Pasien sudah melakukan reservasi pada hari yang sama
        echo "<script>
            alert('Maaf, Anda sudah melakukan reservasi pada tanggal $tgl_reservasi.');
        </script>";
        return false;
    }

    // Cek apakah dokter memiliki jadwal pada hari tersebut
    $query_jadwal_hari = "SELECT COUNT(*) AS jumlah_jadwal FROM jadwal_dokter WHERE id_dokter = '$id_dokter' AND hari = '$nama_hari_input'";
    $result_jadwal_hari = mysqli_query($connect, $query_jadwal_hari);
    $row_jadwal_hari = mysqli_fetch_assoc($result_jadwal_hari);

    $jumlah_jadwal_hari = $row_jadwal_hari['jumlah_jadwal'];

    // Cek apakah jumlah pasien pada hari tersebut sudah mencapai batas maksimal (3 pasien)
    if ($jumlah_jadwal_hari > 0) {
        $query_jumlah_pasien = "SELECT COUNT(*) AS jumlah_pasien FROM pasien WHERE id_dokter = '$id_dokter' AND tanggal_reservasi = '$tgl_reservasi'";
        $result_jumlah_pasien = mysqli_query($connect, $query_jumlah_pasien);
        $row_jumlah_pasien = mysqli_fetch_assoc($result_jumlah_pasien);

        $jumlah_pasien = $row_jumlah_pasien['jumlah_pasien'];

        if ($jumlah_pasien < 3) {
            // Jika jumlah pasien masih kurang dari 3, tambahkan data pasien ke dalam tabel
            $query_insert_pasien = "INSERT INTO pasien (id_user,id_dokter, nik, jenis_kelamin, tempat_lahir,tanggal_lahir,alamat,tanggal_reservasi) VALUES ('$id_user','$id_dokter', '$nik', '$jenis_kelamin', '$tempat_lahir','$tanggal_lahir','$alamat','$tgl_reservasi')";

            mysqli_query($connect, $query_insert_pasien);

            $id_pasien = mysqli_insert_id($connect);
            $pesan_berhasil = urlencode("Reservasi berhasil. Terima kasih!");
            header("Location: struk.php?id_pasien=$id_pasien&pesan=$pesan_berhasil");

            $antrian = "INSERT INTO antrian (id_pasien,tujuan) VALUES ('$id_pasien','$tujuan')";

            mysqli_query($connect, $antrian);

            return mysqli_affected_rows($connect);
        } else {
            // Jumlah pasien sudah mencapai batas maksimal
            echo "<script>
                alert('Maaf, jumlah pasien pada hari $nama_hari_input pada tanggal $tgl_reservasi sudah mencapai batas maksimal.');
            </script>";
            return false;
        }
    } else {
        // Dokter tidak memiliki jadwal pada hari tersebut
        echo "<script>
            alert('Maaf, dokter tidak memiliki jadwal pada hari $nama_hari_input pada tanggal $tgl_reservasi.');
        </script>";
        return false;
    }
}
