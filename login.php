<?php
//memulai session atau melanjutkan session yang sudah ada
session_start();

//menyertakan code dari file koneksi
include "koneksi.php";

//check jika sudah ada user yang login arahkan ke halaman admin
if (isset($_SESSION['username'])) {
    header("location:admin.php");
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Zona Jelajah Nusantara</title>
    <meta
        name="description"
        content="Temukan pengalaman tak terlupakan dari Sabang sampai Merauke bersama kami."
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="icon" href="img/logo.png"/>
    <link 
        rel="stylesheet"  
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    />
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
        rel="stylesheet" 
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" 
        crossorigin="anonymous"
    />
    <style>
      .accordion-button:not(.collapsed) {
        background-color: #7fb1e7ff;
        color: white;
      }
    </style>
  </head>
  <body class="bg-primary-subtle">
        <div class="cotainer mt-5 pt-5">
            <div class="row">
                <div class="col-12 col-sm-8 col-md-6 m-auto">
                    <div class="card border-0 shadow rounded-5">
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <i class="bi bi-person-circle h1 display-4"></i>
                                <p>Welcome Zona Jelajah Nusantara</p>
                                <hr/>
                            </div>
                            <form action="" method="post" id="loginForm">
                                <input
                                type="text"
                                name="user"
                                id="user"
                                class="form-control my-4 py-2 rounded-4"
                                placeholder="Username"
                                />
                                <input
                                type="password"
                                name="pass"
                                id="pass"
                                class="form-control my-4 py-2 rounded-4"
                                placeholder="Password"
                                />
                                <div class="text-center my-3 d-grid">
                                <button class="btn btn-danger rounded-4">Login</button>
                                </div>
                                <p id="errorMsg" class="text-danger"></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    //CHECK APAKAH ADA REQUEST DENGAN METHOD POST YANG DILAKUKAN
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // AMBIL NILAI INPUT 
        $userInput = $_POST['user'];
        $passInput = $_POST['pass'];

        // --- VALIDASI EMPTY FIELD ---
        if ($userInput == "") {
            echo "Username tidak boleh kosong!";
            exit; // hentikan proses
        }

        if ($passInput == "") {
            echo "Password tidak boleh kosong!";
            exit; // hentikan proses
        }

        //JIKA LOLOS SEMUA VALIDASI
        $username = $userInput; 
        $password = md5($passInput); //menggunakan fungsi enkripsi md5 supaya sama dengan password  yang tersimpan di database

        //PREPARED STATEMENT
        $stmt = $conn->prepare("SELECT * 
                                FROM user 
                                WHERE username=? AND password=?");

        //PARAMETER BINDING
        $stmt->bind_param("ss", $username, $password);//username string dan password string
        
        //DATABASE EXECUTES THE STATEMENT
        $stmt->execute();
        
        //MENAMPUNG HASIL EKSEKUSI
        $hasil = $stmt->get_result();
        
        //MENGAMBIL BARIS DARI HASIL SEBAGAI ARRAY ASOSIATIF
        $row = $hasil->fetch_array(MYSQLI_ASSOC);

        //JIKA LOLOS SEMUA VALIDASI 

        //CHECK APAKAH ADA BARIS HASIL DATA USER YANG COCOK
        if (!empty($row)) { 
            //JIKA DATA (BERHASIL), ALIHKAN KE HALAMAN ADMIN
             $_SESSION['username'] = $username; //SIMPAN VARIABEL USERNAME PADA SESSION
            header("location:admin.php");
        } else {
            //JIKA DATA TIDAK ADA (GAGAL), TETAP DIHALAMAN LOGIN
            header("location:login.php");
        }
    };
    ?>
    <script>
        document.getElementById("loginForm").addEventListener("submit", function(event) {
            const user = document.getElementById("user").value.trim();
            const pass = document.getElementById("pass").value.trim();
            const errorMsg = document.getElementById("errorMsg");

            // RESET PESAN ERROR
            errorMsg.textContent = "";

            // CEK USERNAME KOSONG
            if (user === "") {
                errorMsg.textContent = "Username tidak boleh kosong!";
                event.preventDefault(); // stop submit (stop kirim data dari form ke server)
                return;
            }

            // CEK PASSWORD KOSONG
            if (pass === "") {
                errorMsg.textContent = "Password tidak boleh kosong!";
                event.preventDefault(); // stop submit (stop kirim data dari form ke server)
                return;
            }

            // JIKA LOLOS SEMUA VALIDASI, FORM AKAN SUBMIT (KIRIM DATA DARI FORM KE SERVER)
  });
</script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
