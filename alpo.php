<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Monthly Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Monthly Report</h1>
        <div class="text-center mb-3">
            <button id="bar-chart-btn" class="btn btn-primary">Bar Chart</button>
            <button id="line-chart-btn" class="btn btn-secondary">Line Chart</button>
        </div>
        <canvas id="myChart" width="400" height="200"></canvas>
    </div>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_rasaunikom";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT MONTH(tanggal) AS month, COUNT(id_pesanan) AS order_count, SUM(total_harga) AS total_revenue 
        FROM pesanan 
        GROUP BY MONTH(tanggal)";
    $result = $conn->query($sql);

    $months = [];
    $order_counts = [];
    $total_revenues = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $months[] = $row['month'];
            $order_counts[] = $row['order_count'];
            $total_revenues[] = $row['total_revenue'];
        }
    }

    $conn->close();
    ?>

    <script>
        const months = <?php echo json_encode($months); ?>;
        const orderCounts = <?php echo json_encode($order_counts); ?>;
        const totalRevenues = <?php echo json_encode($total_revenues); ?>;

        let chartType = 'bar';
        let chart;

        function renderChart(type) {
            const ctx = document.getElementById('myChart').getContext('2d');
            if (chart) chart.destroy();
            chart = new Chart(ctx, {
                type: type,
                data: {
                    labels: months,
                    datasets: [{
                            label: 'Number of Orders',
                            data: orderCounts,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Total Revenue',
                            data: totalRevenues,
                            backgroundColor: 'rgba(153, 102, 255, 0.2)',
                            borderColor: 'rgba(153, 102, 255, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        document.getElementById('bar-chart-btn').addEventListener('click', () => renderChart('bar'));
        document.getElementById('line-chart-btn').addEventListener('click', () => renderChart('line'));

        renderChart(chartType);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>