<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Owner Dashboard</h1>

        <div class="row mt-5">
            <div class="col-md-6">
                <h3>Monthly Financial Report</h3>
                <canvas id="monthlyReportChart"></canvas>
                <a href="export_csv.php?type=monthly" class="btn btn-primary mt-2">Download CSV</a>
            </div>
            <div class="col-md-6">
                <h3>Weekly Financial Report</h3>
                <canvas id="weeklyReportChart"></canvas>
                <a href="export_csv.php?type=weekly" class="btn btn-primary mt-2">Download CSV</a>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12">
                <h3>Top 5 Menu Items</h3>
                <canvas id="topMenuChart"></canvas>
                <a href="export_csv.php?type=top_menu" class="btn btn-primary mt-2">Download CSV</a>
            </div>
        </div>
    </div>

    <script>
        function fetchReportData(type, callback) {
            fetch(`fetch_reports.php?type=${type}`)
                .then(response => response.json())
                .then(data => callback(data));
        }

        function renderChart(canvasId, labels, data, label) {
            new Chart(document.getElementById(canvasId), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: label,
                        data: data,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
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

        fetchReportData('monthly', data => {
            const labels = data.map(item => `Month ${item.month}`);
            const chartData = data.map(item => item.total);
            renderChart('monthlyReportChart', labels, chartData, 'Total Income');
        });

        fetchReportData('weekly', data => {
            const labels = data.map(item => `Week ${item.week}`);
            const chartData = data.map(item => item.total);
            renderChart('weeklyReportChart', labels, chartData, 'Total Income');
        });

        fetchReportData('top_menu', data => {
            const labels = data.map(item => item.nama_menu);
            const chartData = data.map(item => item.total_qty);
            renderChart('topMenuChart', labels, chartData, 'Total Quantity');
        });
    </script>
</body>
</html>
