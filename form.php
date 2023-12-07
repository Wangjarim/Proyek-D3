<?php include "header.php" ?>

<hr>
<div class="card-body">
<form action="tambahaksi.php" method="POST">
    <div class="card-body">
        <div class="form-group">
            <label>nama_lengkap</label>
                <input type="int" class="form-control" placeholder="Masukkan Kode Buku" name="kode">
        </div>
        <div class="form-group">
            <label>nik</label> 
                <input type="text" class="form-control" placeholder="Masukkan Judul Buku" name="judul">
        </div>
        <div class="form-group">
            <label>Jenis Kelamin</label> 
                <input type="text" class="form-control" placeholder="Masukkan Nama Pengarang" name="pengarang">
        </div>
        <div class="form-group">
            <label>Tempat Lahir</label> 
                <input type="text" class="form-control" placeholder="Masukkan Nama Pengarang" name="pengarang">
        </div>
        <div class="form-group">
            <label>Tanggal Lahir</label> 
                <input type="text" class="form-control" placeholder="Masukkan Nama Pengarang" name="pengarang">
        </div>
        <div class="form-group">
            <label>Alamat</label> 
                <input type="text" class="form-control" placeholder="Masukkan Nama Pengarang" name="pengarang">
        </div>
        <div class="form-group">
            <label>No Hp</label> 
                <input type="text" class="form-control" placeholder="Masukkan Nama Pengarang" name="pengarang">
        </div>
        <div class="form-group">
            <label>Id Jadwal</label> 
                <input type="text" class="form-control" placeholder="Masukkan Nama Pengarang" name="pengarang">
        </div>
        <div class="form-group">
            <label>tgl reservasi</label> 
                <input type="text" class="form-control" placeholder="Masukkan Nama Pengarang" name="pengarang">
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary" value="Simpan">Submit</button>
        </div>
    </div>
</form>
</div>

<?php include "footer.php" ?>