<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Kepegawaian</title>

    <!-- CSS Bootstrap -->
    <link href="style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <?php
    // Panggil file koneksi_db.php
    include "koneksi_db.php";

    // Query untuk mengambil data dari tabel pegawai, kontrak, dan jabatan dengan join
    $query = "SELECT pegawai.nama_pegawai, pegawai.alamat_pegawai, pegawai.tangga_lahir_pegawai, 
            jabatan.nama_jabatan, kontrak.tgl_mulai, kontrak.tgl_selesai, kontrak.jumlah_gaji
            FROM pegawai
            INNER JOIN kontrak ON pegawai.id_pegawai = kontrak.id_pegawai
            INNER JOIN jabatan ON pegawai.id_jabatan = jabatan.id_jabatan";

    // Eksekusi query
    $result = mysqli_query($koneksi, $query);

    //query untuk menambahkan data : 
    $nama_pegawai = $_POST['nama_pegawai'];
    $alamat_pegawai = $_POST['alamat_pegawai'];
    $tangga_lahir_pegawai = $_POST['tangga_lahir_pegawai'];
    $id_jabatan = $_POST['id_jabatan'];
    $tanggal_mulai = $_POST['tgl_mulai'];
    $tanggal_selesai = $_POST['tgl_selesai'];
    $jumlah_gaji = $_POST['jumlah_gaji'];

    //query insert data
    $queryInsert = "INSERT INTO pegawai (nama_pegawai, alamat_pegawai, tangga_lahir_pegawai, id_jabatan) 
          VALUES ('$nama_pegawai', '$alamat_pegawai', '$tangga_lahir_pegawai', '$id_jabatan');
          INSERT INTO kontrak (id_pegawai, tgl_mulai, tgl_selesai, jumlah_gaji)
          SELECT p.id_pegawai, '$tanggal_mulai', '$tanggal_selesai', '$jumlah_gaji'
          FROM pegawai p
          INNER JOIN jabatan j ON p.id_jabatan = j.id_jabatan
          WHERE p.nama_pegawai = '$nama_pegawai'";

    // Jalankan query
$resultInsert = mysqli_query($koneksi, $query);

// Periksa apakah query berhasil dijalankan
if ($resultInsert) {
    echo "Data pegawai berhasil ditambahkan.";
} else {
    echo "Error: " . $queryInsert . "<br>" . mysqli_error($koneksi);
}

    // Periksa apakah query berhasil dieksekusi
    if (!$result) {
        die("Query failed: " . mysqli_error($koneksi));
    }
    ?>

    <header>
        <div class="container">
            <h6 class="display-6 text-black text-center">Halaman Kepegawaian</h6>
        </div>
    </header>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12 mx-auto">
                    <div class="float-md-end">
                        <button type="button" id="openModalBtn" class="btn btn-success">Tambah Pegawai</button>
                    </div>
                    <!-- The Modal -->
                    <div id="myModal" class="modal">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <b-form method="post" action="tambah.php">
                                <div class="mb-3 row">
                                    <label for="inputNama" class="col-sm-2 col-form-label">Nama Pegawai</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputNama" name="nama_pegawai">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="inputAlamat" class="col-sm-2 col-form-label">Alamat Pegawai</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputAlamat" name="alamat_pegawai">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="inputTglLahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="inputTglLahir" name="tangga_lahir_pegawai">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="inputJabatan" class="col-sm-2 col-form-label">Jabatan</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputJabatan" name="nama_jabatan">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="inputTglMulai" class="col-sm-2 col-form-label">Tanggal Mulai</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="inputTglMulai" name="tgl_mulai">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="inputTglSelesai" class="col-sm-2 col-form-label">Tanggal Selesai</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="inputTglSelesai" name="tgl_selesai">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="inputGaji" class="col-sm-2 col-form-label">Jumlah Gaji</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputGaji" name="jumlah_gaji">
                                    </div>
                                </div>
                                <button type='button' class='btn btn-primary' action="tambah.php">Simpan</button>
                            </b-form>
                        </div>
                    </div>
                    <!-- Tabel untuk menampilkan data pegawai -->
                    <table class="table table-striped-columns">
                        <thead>
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Nama Pegawai</th>
                                <th scope="col">Alamat Pegawai</th>
                                <th scope="col">Tanggal Lahir</th>
                                <th scope="col">Jabatan</th>
                                <th scope="col">Tanggal Mulai</th>
                                <th scope="col">Tanggal Selesai</th>
                                <th scope="col">Jumlah Gaji</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1; // Inisialisasi nomor urut
                            while ($row = mysqli_fetch_array($result)) {
                                // Menampilkan data dalam baris tabel
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . $row['nama_pegawai'] . "</td>";
                                echo "<td>" . $row['alamat_pegawai'] . "</td>";
                                echo "<td>" . $row['tangga_lahir_pegawai'] . "</td>";
                                echo "<td>" . $row['nama_jabatan'] . "</td>";
                                echo "<td>" . $row['tgl_mulai'] . "</td>";
                                echo "<td>" . $row['tgl_selesai'] . "</td>";
                                echo "<td>" . $row['jumlah_gaji'] . "</td>";
                                echo "<td>
                                        <button type='button' class='btn btn-primary'>Edit</button>
                                        <button type='button' class='btn btn-danger'>Hapus</button>
                                      </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- Tombol untuk tambah data pegawai -->

                </div>
            </div>
        </div>
    </section>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JV0+kgOUerFLZJB+8ih41P5Jc5l3HM2Q/biVvXEV4eowWdBQZc5P1UjdaL6Y6zF1" crossorigin="anonymous"></script>
<!-- Bootstrap Bundle with Popper -->
<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("openModalBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>

<script>
    
</script>
</html>