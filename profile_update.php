<?php
session_start();
include "koneksi.php";

$username = $_SESSION['username'];
$password = $_POST['password'];

// ambil data lama
$data = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT foto FROM user WHERE username='$username'")
);

// UPDATE PASSWORD
if (!empty($password)) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    mysqli_query(
        $conn,
        "UPDATE user SET password='$hash' WHERE username='$username'"
    );
}

// UPDATE FOTO
if (!empty($_FILES['foto']['name'])) {
    $namaFoto = time() . "_" . $_FILES['foto']['name'];
    move_uploaded_file($_FILES['foto']['tmp_name'], "img/" . $namaFoto);

    // hapus foto lama
    if ($data['foto'] && file_exists("img/" . $data['foto'])) {
    unlink("img/" . $data['foto']);
    }

    mysqli_query(
        $conn,
        "UPDATE user SET foto='$namaFoto' WHERE username='$username'"
    );
}

header("Location: admin.php?page=profile");
