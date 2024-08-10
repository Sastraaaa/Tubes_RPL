<?php
include 'config/koneksi.php';

// Retrieve confirmed orders
$orderQuery = "SELECT * FROM pesanan WHERE status = 'confirmed'";
$orderResult = $conn->query($orderQuery);

// Update order status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pay_order'])) {
    $order_id = $_POST['order_id'];
    $tunai = $_POST['tunai'];
    $total_harga = $_POST['total_harga'];

    if ($tunai < $total_harga) {
        echo "<script>alert('Jumlah tunai tidak boleh kurang dari total harga.'); window.location.href='kasir_dashboard.php';</script>";
    } else {
        $kembalian = $tunai - $total_harga;

        // Update the order status to 'paid'
        $updateOrderQuery = "UPDATE pesanan SET status='paid' WHERE id_pesanan=?";
        $stmt = $conn->prepare($updateOrderQuery);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->close();

        // Update the table status to 'tersedia'
        $updateTableQuery = "UPDATE meja SET status='tersedia' WHERE nomor_meja=(SELECT no_meja FROM pesanan WHERE id_pesanan=?)";
        $stmt = $conn->prepare($updateTableQuery);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $stmt->close();

        echo "<script>alert('Pesanan telah dibayar! Kembalian: Rp $kembalian'); window.location.href='kasir_dashboard.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Kasir Dashboard</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="Kasir Dashboard">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
    <link rel="shortcut icon" href="favicon.ico">
    <!-- FontAwesome JS-->
    <script defer src="assets/plugins/fontawesome/js/all.min.js"></script>

    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="assets/css/portal.css">

</head>

<body class="app">
    <header class="app-header fixed-top">
        <div class="app-header-inner">
            <div class="container-fluid py-2">
                <div class="app-header-content">
                    <div class="row justify-content-between align-items-center">

                        <div class="col-auto">
                            <a id="sidepanel-toggler" class="sidepanel-toggler d-inline-block d-xl-none" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" role="img">
                                    <title>Menu</title>
                                    <path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path>
                                </svg>
                            </a>
                        </div><!--//col-->

                        <div class="app-utilities col-auto">

                        <div class="app-utilities col-auto">
							<div class="app-utility-item app-user-dropdown dropdown">
								<a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
								</a>
								<ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
									<li><a class="dropdown-item" href="#" onclick="confirmLogout()">Log Out</a></li>
								</ul>
							</div><!--//app-user-dropdown-->
						</div><!--//app-utilities-->
                    </div><!--//row-->
                </div><!--//app-header-content-->
            </div><!--//container-fluid-->
        </div><!--//app-header-inner-->
        <div id="app-sidepanel" class="app-sidepanel sidepanel-hidden">
            <div id="sidepanel-drop" class="sidepanel-drop"></div>
            <div class="sidepanel-inner d-flex flex-column">
                <a href="#" id="sidepanel-close" class="sidepanel-close d-xl-none">&times;</a>
                <div class="app-branding">
                    <a class="app-logo" href="pelayan_dashboard.php"><span class="logo-text">Kasir</span></a>

                </div><!--//app-branding-->
                <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
                    <ul class="app-menu list-unstyled accordion" id="menu-accordion">
                        <li class="nav-item">
                            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                            <a class="nav-link active" href="kasir_dashboard.php">
                                <span class="nav-icon">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-card-list" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                                        <path fill-rule="evenodd" d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5z" />
                                        <circle cx="3.5" cy="5.5" r=".5" />
                                        <circle cx="3.5" cy="8" r=".5" />
                                        <circle cx="3.5" cy="10.5" r=".5" />
                                    </svg>
                                </span>
                                <span class="nav-link-text">Order</span>
                            </a><!--//nav-link-->
                        </li><!--//nav-item-->
                        <li class="nav-item">
                            <!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
                            <a class="nav-link " href="detail_pesanan.php">
                                <span class="nav-icon">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-card-list" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                                        <path fill-rule="evenodd" d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5z" />
                                        <circle cx="3.5" cy="5.5" r=".5" />
                                        <circle cx="3.5" cy="8" r=".5" />
                                        <circle cx="3.5" cy="10.5" r=".5" />
                                    </svg>
                                </span>
                                <span class="nav-link-text">Detail Pesanan</span>
                            </a><!--//nav-link-->
                        </li><!--//nav-item-->

                    </ul><!--//app-menu-->
                </nav><!--//app-nav-->
            </div><!--//sidepanel-inner-->
        </div><!--//app-sidepanel-->
    </header><!--//app-header-->

    <div class="app-wrapper">

        <div class="app-content pt-3 p-md-3 p-lg-4">
            <div class="container">
                <h3>Daftar Pesanan</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Pelanggan</th>
                            <th>Nomor Meja</th>
                            <th>Total Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $orderResult->fetch_assoc()) : ?>
                            <tr>
                                <td><?= $row['nama_pelanggan']; ?></td>
                                <td><?= $row['no_meja']; ?></td>
                                <td>Rp <?= $row['total_harga']; ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#payModal" data-id="<?= $row['id_pesanan']; ?>" data-nama="<?= $row['nama_pelanggan']; ?>" data-meja="<?= $row['no_meja']; ?>" data-total="<?= $row['total_harga']; ?>">
                                        Bayar
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Payment Modal -->
            <div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="payModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="payModalLabel">Pembayaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST">
                                <input type="hidden" name="order_id" id="order_id">
                                <input type="hidden" name="total_harga" id="total_harga">
                                <div class="mb-3">
                                    <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                                    <input type="text" class="form-control" id="nama_pelanggan" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="no_meja" class="form-label">Nomor Meja</label>
                                    <input type="text" class="form-control" id="no_meja" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="detail_pesanan" class="form-label">Detail Pesanan</label>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Nama Menu</th>
                                                <th>Qty</th>
                                                <th>Harga</th>
                                                <th>Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody id="detail_pesanan">
                                            <!-- Dynamic content will be loaded here -->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mb-3">
                                    <label for="total_total_harga" class="form-label">Total Harga</label>
                                    <input type="text" class="form-control" id="total_total_harga" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="tunai" class="form-label">Tunai</label>
                                    <input type="number" class="form-control" name="tunai" id="tunai" required>
                                </div>
                                <div class="mb-3">
                                    <label for="kembalian" class="form-label">Kembalian</label>
                                    <input type="text" class="form-control" id="kembalian" readonly>
                                </div>
                                <button type="submit" name="pay_order" class="btn btn-success">Bayar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div><!--//app-content-->
    </div><!--//app-wrapper-->


    <!-- Javascript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script>
        $('#payModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var nama = button.data('nama');
            var meja = button.data('meja');
            var total = button.data('total');

            var modal = $(this);
            modal.find('#order_id').val(id);
            modal.find('#nama_pelanggan').val(nama);
            modal.find('#no_meja').val(meja);
            modal.find('#total_harga').val(total);
            modal.find('#total_total_harga').val('Rp ' + total);

            // Fetch order details and populate the modal
            $.ajax({
                url: 'detail.php',
                type: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    modal.find('#detail_pesanan').html(response);
                }
            });

            // Calculate kembalian
            modal.find('#tunai').on('input', function() {
                var tunai = $(this).val();
                var kembalian = tunai - total;
                modal.find('#kembalian').val(kembalian >= 0 ? 'Rp ' + kembalian : 'Jumlah tunai kurang');
            });

            // Prevent form submission if tunai is less than total
            modal.find('form').on('submit', function(event) {
                var tunai = modal.find('#tunai').val();
                if (tunai < total) {
                    alert('Jumlah tunai tidak boleh kurang dari total harga.');
                    event.preventDefault();
                }
            });
        });
    </script>
    <!-- Page Specific JS -->
    <script src="assets/js/app.js"></script>

</body>

</html>