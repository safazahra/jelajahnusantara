<?php
$username = $_SESSION['username'];
//ambil data user login
$query_user = mysqli_query(
    $conn,
    "SELECT * FROM user WHERE username='$username'"
);
$user = mysqli_fetch_assoc($query_user);

//query untuk mengambil data article
$sql_article = "SELECT * FROM article ORDER BY tanggal DESC";
$hasil_article = $conn->query($sql_article);
//query untuk mengambil data gallery
$sql_gallery = "SELECT * FROM gallery ORDER BY tanggal DESC";
$hasil_gallery = $conn->query($sql_gallery);

//menghitung jumlah baris data article
$jumlah_article = $hasil_article->num_rows; 
$jumlah_gallery = $hasil_gallery->num_rows; 
?>

<div class="row pt-4">
    <div class="col-12 text-center">
        <p class="text-muted mb-1">Selamat Datang,</p>
        <h5 class="fw-bold text-danger"><?= $user['username']; ?></h5>

        <?php if (!empty($user['foto'])): ?>
            <img src="img/<?= $user['foto']; ?>"
                 class="rounded-circle mt-3"
                 width="150"
                 height="150"
                 style="object-fit: cover;">
        <?php else: ?>
            <img src="img/default.png"
                 class="rounded-circle mt-3"
                 width="150"
                 height="150">
        <?php endif; ?>
    </div>
</div>

<div class="row justify-content-center pt-4">

    <div class="col-md-3">
        <div class="card border border-danger mb-3 shadow">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="bi bi-newspaper"></i> Article
                </h5>
                <span class="badge rounded-pill text-bg-danger fs-2">
                    <?= $jumlah_article; ?>
                </span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border border-danger mb-3 shadow">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="bi bi-camera"></i> Gallery
                </h5>
                <span class="badge rounded-pill text-bg-danger fs-2">
                    <?= $jumlah_gallery; ?>
                </span>
            </div>
        </div>
    </div>

</div>