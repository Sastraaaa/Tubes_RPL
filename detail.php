<?php
include 'config/koneksi.php';

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    $query = "SELECT dp.nama_menu, dp.qty, dp.harga, dp.sub_total 
              FROM detail_pesanan dp 
              JOIN pesanan p ON dp.id_pesanan = p.id_pesanan 
              WHERE p.id_pesanan = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $output = '';
    while ($row = $result->fetch_assoc()) {
        $output .= '<tr>
                        <td>' . $row['nama_menu'] . '</td>
                        <td>' . $row['qty'] . '</td>
                        <td>' . $row['harga'] . '</td>
                        <td>' . $row['sub_total'] . '</td>
                    </tr>';
    }
    echo $output;
}
?>
