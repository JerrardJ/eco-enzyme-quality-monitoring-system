<?php 
include("app/controllers/posts.php"); 
include("app/database/config.php"); 
include("app/database/fetchData.php"); 
include("app/database/fetchChartData.php"); 

if(empty($_SESSION['username'])){
    header('location: login.php');
}
if(!empty($_SESSION['username'])){
    $usernames = $_SESSION['username'];
}

// Ambil tanggal dari input GET atau pakai default
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-7 days'));
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

// Pagination setup
$limit = 10; // jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query data dengan filter tanggal dan urut berdasarkan ID ASC
$sql = "SELECT * FROM sensor_data
        WHERE DATE(waktu) BETWEEN :start_date AND :end_date 
        ORDER BY id ASC 
        LIMIT :limit OFFSET :offset";

$stmt = $conn_db->prepare($sql);
$stmt->bindParam(':start_date', $start_date);
$stmt->bindParam(':end_date', $end_date);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$data_result = $stmt;

// Hitung total data untuk pagination
$count_sql = "SELECT COUNT(*) FROM sensor_data WHERE DATE(waktu) BETWEEN :start_date AND :end_date";
$count_stmt = $conn_db->prepare($count_sql);
$count_stmt->execute([':start_date' => $start_date, ':end_date' => $end_date]);
$total_rows = $count_stmt->fetchColumn();
$total_pages = ceil($total_rows / $limit);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Candal|Lora" rel="stylesheet">

    <!-- Icons Installation -->
    <script src="https://kit.fontawesome.com/8bab192097.js" crossorigin="anonymous"></script>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="asset/css/styles.css?v=2.8" type ="text/css">
    <link rel="stylesheet" href="asset/css/styles2.css?v=2.9" type ="text/css">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="asset/css/admin.css?v=7.5" type="text/css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>

    <title>Dashboard</title>
</head>

<body>
<?php include("app/include/adminHeader.php"); ?>

    <!-- DASHBOARD START -->
    <div class="admin-wrapper">
        <div class="admin-content">
            <!-- DASHBOARD CONTENT START -->
            <h2 class="page-title">Dashboard</h2>
            <div class="content-dashboard">
                
                <!-- DISPLAY SUCCESS ONLY START -->
                <?php include("app/include/messages.php"); ?>
                <!-- DISPLAY SUCCESS ONLY END -->
                <div class="box-top">
                    <canvas id="suhuChart"></canvas>
                    <canvas id="kelembapanChart"></canvas>
                </div>
                <div class="box-center">
                    <canvas id="gasChart"></canvas>
                    <canvas id="phChart"></canvas>
                </div>
                <div class="box-bottom">
                    <canvas id="turbidityChart"></canvas>
                    <canvas id="salinitasChart"></canvas>
                </div>

                <script>
                    const labels = <?php echo json_encode($labels); ?>;

                    const chartData = {
                        suhu: <?php echo json_encode($suhu); ?>,
                        kelembapan: <?php echo json_encode($kelembapan); ?>,
                        mq7: <?php echo json_encode($mq7); ?>,
                        pH: <?php echo json_encode($ph); ?>,
                        turbiditas: <?php echo json_encode($turbiditas); ?>,
                        salinitas: <?php echo json_encode($salinitas); ?>
                    };

                    function createChart(ctxId, label, data) {
                    new Chart(document.getElementById(ctxId), {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [
                            {
                                label: label,
                                data: data,
                                borderColor: 'blue',
                                backgroundColor: 'rgba(255, 0, 0, 0.1)',
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            devicePixelRatio: window.devicePixelRatio,
                            plugins: {
                                legend: {
                                    labels: {
                                        font: {
                                            size: 19
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: { beginAtZero: false }
                            }
                        }
                    });
                    }

                    createChart("suhuChart", "Suhu (°C)", chartData.suhu);
                    createChart("kelembapanChart", "Kelembapan (%)", chartData.kelembapan);
                    createChart("gasChart", "Gas (Karbon Monoksida)", chartData.mq7);
                    createChart("phChart", "pH", chartData.pH);
                    createChart("turbidityChart", "Kekeruhan (NTU)", chartData.turbiditas);
                    createChart("salinitasChart", "Salinitas (ppt)", chartData.salinitas);
                </script>

                <div class="data-section">
                    <h2 class="page-title">Data Table</h2>

                    <!-- Filters & Export -->
                    <div class="filter-actions">
                        <form method="get" class="date-form">
                            Start Date: <input type="date" name="start_date" value="<?php echo $start_date; ?>">
                            End Date: <input type="date" name="end_date" value="<?php echo $end_date; ?>">
                            <button type="submit">Search</button>
                        </form>

                        <form method="get" action="export_csv.php" class="csv-form">
                            <input type="hidden" name="start_date" value="<?php echo $start_date; ?>">
                            <input type="hidden" name="end_date" value="<?php echo $end_date; ?>">
                            <button type="submit">Download CSV</button>
                        </form>
                    </div>

                    <!-- Data Table -->
                    <div id="dataTable" style="overflow-x: auto;">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th class="custom-th">ID</th>
                                    <th class="custom-th">Suhu (°C)</th>
                                    <th class="custom-th">Kelembapan (%)</th>
                                    <th class="custom-th">Gas (ppm)</th>
                                    <th class="custom-th">pH</th>
                                    <th class="custom-th">Turbidity (NTU)</th>
                                    <th class="custom-th">Salinity (ppt)</th>
                                    <th class="custom-th">Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $data_result->fetch()): ?>
                                <tr>
                                    <td class="custom-td"><?php echo $row['id']; ?></td>
                                    <td class="custom-td"><?php echo $row['suhu']; ?></td>
                                    <td class="custom-td"><?php echo $row['kelembapan']; ?></td>
                                    <td class="custom-td"><?php echo $row['mq7']; ?></td>
                                    <td class="custom-td"><?php echo $row['ph']; ?></td>
                                    <td class="custom-td"><?php echo $row['turbiditas']; ?></td>
                                    <td class="custom-td"><?php echo $row['salinitas']; ?></td>
                                    <td class="custom-td"><?php echo $row['waktu']; ?></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>

                        <!-- Pagination -->
                        <div class="custom-pagination">
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <a href="?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            <!-- DASHBOARD CONTENT END -->
        </div>
    </div>
    <!-- DASHBOARD END -->

    <!-- Custom JS -->
    <script src="asset\js\scripts.js"></script>
    <script src="asset/js/scripts2admin.js"></script>


</body>

</html>