<?php
include "koneksi.php";

$username = $_SESSION['username'];

$query = mysqli_query(
    $conn,
    "SELECT * FROM user WHERE username='$username'"
);

$user = mysqli_fetch_assoc($query);
?>

<form action="profile_update.php" method="POST" enctype="multipart/form-data">

    <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text"
               class="form-control"
               value="<?= $user['username']; ?>"
               readonly>
    </div>

    <div class="mb-3">
        <label class="form-label">Password Baru</label>
        <input type="password"
               class="form-control"
               name="password"
               placeholder="Kosongkan jika tidak ingin mengganti password">
    </div>

    <div class="mb-3">
        <label class="form-label">Foto Profil</label>
        <input type="file"
               class="form-control"
               name="foto">
    </div>

    <div class="mb-3">
        <label class="form-label">Foto Profil Saat Ini</label><br>
        <img src="img/<?= $user['foto']; ?>"
             width="120"
             class="img-thumbnail">
             
    </div>

    <button class="btn btn-danger" type="submit">
        Simpan
    </button>

</form>
