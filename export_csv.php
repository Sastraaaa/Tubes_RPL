<?php
include 'config/koneksi.php';

if(isset($_GET['type'])) {
    if($_GET['type'] == 'monthly') {
        $data = fetchMonthlyReport($conn);
        $filename = "monthly_report.csv";
    } else if($_GET['type'] == 'weekly') {
        $data = fetchWeeklyReport($conn);
        $filename = "weekly_report.csv";
    } else if($_GET['type'] == 'top_menu') {
        $data = fetchTopMenuItems($conn);
        $filename = "top_menu_report.csv";
    }

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=' . $filename);
    $fp = fopen('php://output', 'w');
    if ($data) {
        fputcsv($fp, array_keys($data[0]));
        foreach ($data as $row) {
            fputcsv($fp, $row);
        }
    }
    fclose($fp);
    exit;
}
?>
