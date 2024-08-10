<?php
include 'koneksi.php';
// Get username and password from POST
$username = $_POST['username'];
$password = $_POST['password'];

// Query to check user credentials
$sql = "SELECT * FROM karyawan WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['username'] = $row['username'];
    $_SESSION['id_jabatan'] = $row['id_jabatan'];

    // Redirect based on id_jabatan
    switch ($row['id_jabatan']) {
        case 1:
            header("Location: ../admin_dashboard.php");
            break;
        case 2:
            header("Location: ../owner_dashboard.php");
            break;
        case 3:
            header("Location: ../koki_dashboard.php");
            break;
        case 4:
            header("Location: ../kasir_dashboard.php");
            break;
        case 5:
            header("Location: ../pelayan_dashboard.php");
            break;
        default:
            echo "Invalid role.";
            break;
    }
} else {
    echo "username atau password salah.";
}

mysqli_close($conn);
