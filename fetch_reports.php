<?php
include 'config/koneksi.php';

function fetchMonthlyReport($conn) {
    $sql = "SELECT MONTH(tanggal) as month, SUM(total_harga) as total FROM pesanan GROUP BY MONTH(tanggal)";
    $result = $conn->query($sql);
    $data = [];
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

function fetchWeeklyReport($conn) {
    $sql = "SELECT WEEK(tanggal) as week, SUM(total_harga) as total FROM pesanan GROUP BY WEEK(tanggal)";
    $result = $conn->query($sql);
    $data = [];
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

function fetchTopMenuItems($conn) {
    $sql = "SELECT nama_menu, SUM(qty) as total_qty FROM detail_pesanan GROUP BY id_menu ORDER BY total_qty DESC LIMIT 5";
    $result = $conn->query($sql);
    $data = [];
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

if(isset($_GET['type'])) {
    if($_GET['type'] == 'monthly') {
        echo json_encode(fetchMonthlyReport($conn));
    } else if($_GET['type'] == 'weekly') {
        echo json_encode(fetchWeeklyReport($conn));
    } else if($_GET['type'] == 'top_menu') {
        echo json_encode(fetchTopMenuItems($conn));
    }
}
?>
