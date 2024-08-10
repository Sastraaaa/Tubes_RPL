<?php
include 'config/koneksi.php';

if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $orderDetailsQuery = "SELECT * FROM detail_pesanan WHERE id_pesanan=?";
    $stmt = $conn->prepare($orderDetailsQuery);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $details = '';
    while ($row = $result->fetch_assoc()) {
        $details .= '<tr>';
        $details .= '<td>' . htmlspecialchars($row['nama_menu'], ENT_QUOTES, 'UTF-8') . '</td>';
        $details .= '<td>' . htmlspecialchars($row['qty'], ENT_QUOTES, 'UTF-8') . '</td>';
        $details .= '</tr>';
    }
    echo $details;
    $stmt->close();
}
?>
