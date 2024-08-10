<?php
include 'config/koneksi.php';

// Fetch makanan
$makananQuery = "SELECT * FROM menu WHERE kategori='makanan' ORDER BY nama_menu ASC";
$makananResult = $conn->query($makananQuery);

// Fetch minuman
$minumanQuery = "SELECT * FROM menu WHERE kategori='minuman' ORDER BY nama_menu ASC";
$minumanResult = $conn->query($minumanQuery);

// Fetch available tables
$mejaQuery = "SELECT * FROM meja WHERE status='tersedia'";
$mejaResult = $conn->query($mejaQuery);
// Handling form submission for order confirmation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['konfirm'])) {
	$nama_pelanggan = $_POST['nama_pelanggan'];
	$nomor_meja = $_POST['nomor_meja'];
	$total_harga = $_POST['totalbelanja'];
	$status = 'pending';

	// Decode cart JSON to array
	$cart = json_decode($_POST['cart'], true);

	$errors = [];
	// Check stock for each item
	if (is_array($cart)) {
		foreach ($cart as $item) {
			$id_menu = $item['id'];
			$qty = $item['qty'];

			$stockQuery = "SELECT stok FROM menu WHERE id_menu = ?";
			$stmt = $conn->prepare($stockQuery);
			$stmt->bind_param("i", $id_menu);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			$stmt->close();

			if ($row['stok'] < $qty) {
				$errors[] = "Stok untuk item {$item['name']} tidak mencukupi. Stok tersedia: {$row['stok']}.";
			}
		}
	}

	if (count($errors) == 0) {
		// Insert into pesanan table
		$insertPesananQuery = "INSERT INTO pesanan (nama_pelanggan, no_meja, tanggal, total_harga, status) VALUES (?, ?, NOW(), ?, ?)";
		$stmt = $conn->prepare($insertPesananQuery);
		$stmt->bind_param("sids", $nama_pelanggan, $nomor_meja, $total_harga, $status);
		$stmt->execute();
		$last_id = $stmt->insert_id;
		$stmt->close();

		// Insert into detail_pesanan table and update stock
		if (is_array($cart)) {
			foreach ($cart as $item) {
				$id_menu = $item['id'];
				$nama_menu = $item['name'];
				$qty = $item['qty'];
				$harga = $item['price'];
				$sub_total = $item['total'];

				$insertDetailPesananQuery = "INSERT INTO detail_pesanan (id_pesanan, id_menu, nama_menu, qty, harga, sub_total) VALUES (?, ?, ?, ?, ?, ?)";
				$stmt = $conn->prepare($insertDetailPesananQuery);
				$stmt->bind_param("iisiii", $last_id, $id_menu, $nama_menu, $qty, $harga, $sub_total);
				$stmt->execute();
				$stmt->close();

				$updateStockQuery = "UPDATE menu SET stok = stok - ? WHERE id_menu = ?";
				$stmt = $conn->prepare($updateStockQuery);
				$stmt->bind_param("ii", $qty, $id_menu);
				$stmt->execute();
				$stmt->close();
			}
		}

		// Update meja status
		$updateMejaQuery = "UPDATE meja SET status='tidak tersedia' WHERE nomor_meja=?";
		$stmt = $conn->prepare($updateMejaQuery);
		$stmt->bind_param("i", $nomor_meja);
		$stmt->execute();
		$stmt->close();

		echo "<script>alert('Pesanan telah dikonfirmasi!');</script>";
	} else {
		foreach ($errors as $error) {
			echo "<script>alert('$error');</script>";
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Portal - Bootstrap 5 Admin Dashboard Template For Developers</title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
	<meta name="author" content="Xiaoying Riley at 3rd Wave Media">
	<link rel="shortcut icon" href="favicon.ico">
	<style>
		.card-body {
			display: flex;
			flex-direction: column;
			justify-content: flex-start;
			padding: 0.75rem;
		}

		.card img {
			width: 100%;
			/* Ensure the image takes full width of the card */
			height: 150px;
			/* Set a fixed height for the images */
			object-fit: contain;
			/* Ensure the entire image is visible without being cut off */
		}

		.card-title {
			margin-bottom: 0.25rem;
			font-size: 1.1rem;
		}

		.card-text {
			margin-bottom: 0.25rem;
			font-size: 0.9rem;
		}

		.btn {
			margin-top: 0.5rem;
		}

		.cart-section {
			border-left: 10px solid #ddd;
			padding-left: 1rem;
		}

		@media (max-width: 767.98px) {
			.cart-section {
				border-left: none;
				padding-left: 0;
				margin-top: 2rem;
			}
		}
	</style>


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
					<a class="app-logo" href="pelayan_dashboard.php"><span class="logo-text">Orders</span></a>

				</div><!--//app-branding-->
				<nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
					<ul class="app-menu list-unstyled accordion" id="menu-accordion">
						<li class="nav-item">
							<!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
							<a class="nav-link" href="pelayan_dashboard.php">
								<span class="nav-icon">
									<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-house-door" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" d="M7.646 1.146a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 .146.354v7a.5.5 0 0 1-.5.5H9.5a.5.5 0 0 1-.5-.5v-4H7v4a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .146-.354l6-6zM2.5 7.707V14H6v-4a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v4h3.5V7.707L8 2.207l-5.5 5.5z" />
										<path fill-rule="evenodd" d="M13 2.5V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
									</svg>
								</span>
								<span class="nav-link-text">Meja</span>
							</a><!--//nav-link-->
						</li><!--//nav-item-->
						<li class="nav-item">
							<!--//Bootstrap Icons: https://icons.getbootstrap.com/ -->
							<a class="nav-link active" href="orders.php">
								<span class="nav-icon">
									<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-card-list" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
										<path fill-rule="evenodd" d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5z" />
										<circle cx="3.5" cy="5.5" r=".5" />
										<circle cx="3.5" cy="8" r=".5" />
										<circle cx="3.5" cy="10.5" r=".5" />
									</svg>
								</span>
								<span class="nav-link-text">Orders</span>
							</a><!--//nav-link-->
						</li><!--//nav-item-->

					</ul><!--//app-menu-->
				</nav><!--//app-nav-->
			</div><!--//sidepanel-inner-->
		</div><!--//app-sidepanel-->
	</header><!--//app-header-->

	<div class="app-wrapper">

		<div class="app-content pt-1 p-md-2 p-lg-4">
			<div class="container">
				<div class="row">
					<div class="col-lg-8">
						<div class="menu-section">
							<div class="row mb-2">
								<div class="col">
									<button class="btn btn-primary filter-menu" data-category="makanan">Makanan</button>
									<button class="btn btn-secondary filter-menu" data-category="minuman">Minuman</button>
								</div>
							</div>
							<div class="row" id="menu-container">
								<!-- Makanan Items -->
								<div class="menu-items makanan row row-cols-1 row-cols-md-2 row-cols-lg-5 g-4">
									<?php while ($row = $makananResult->fetch_assoc()) : ?>
										<div class="col">
											<div class="card h-100">
												<img src="<?= $row['image']; ?>" class="card-img-top" alt="<?= $row['nama_menu']; ?>">
												<div class="card-body">
													<h5 class="card-title"><?= $row['nama_menu']; ?></h5>
													<p class="card-text"><?= $row['deskripsi']; ?></p>
													<p class="card-text">Rp <?= $row['harga']; ?></p>
													<button class="btn btn-primary add-to-cart" data-id="<?= $row['id_menu']; ?>" data-name="<?= $row['nama_menu']; ?>" data-price="<?= $row['harga']; ?>" data-stok="<?= $row['stok']; ?>">Tambah ke Keranjang</button>
												</div>
											</div>
										</div>
									<?php endwhile; ?>
								</div>

								<!-- Minuman Items -->
								<div class="menu-items minuman row row-cols-1 row-cols-md-2 row-cols-lg-5 g-4" style="display: none;">
									<?php while ($row = $minumanResult->fetch_assoc()) : ?>
										<div class="col">
											<div class="card h-100">
												<img src="<?= $row['image']; ?>" class="card-img-top" alt="<?= $row['nama_menu']; ?>">
												<div class="card-body">
													<h5 class="card-title"><?= $row['nama_menu']; ?></h5>
													<p class="card-text"><?= $row['deskripsi']; ?></p>
													<p class="card-text">Rp <?= $row['harga']; ?></p>
													<button class="btn btn-primary add-to-cart" data-id="<?= $row['id_menu']; ?>" data-name="<?= $row['nama_menu']; ?>" data-price="<?= $row['harga']; ?>" data-stok="<?= $row['stok']; ?>">Tambah ke Keranjang</button>
												</div>
											</div>
										</div>
									<?php endwhile; ?>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="cart-section">
							<h3>Keranjang</h3>
							<form method="POST">
								<div class="mb-3">
									<label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
									<input type="text" class="form-control" id="nama_pelanggan" name="nama_pelanggan" required>
								</div>
								<div class="mb-3">
									<label for="nomor_meja" class="form-label">Nomor Meja</label>
									<select class="form-control" id="nomor_meja" name="nomor_meja" required>
										<?php while ($row = $mejaResult->fetch_assoc()) : ?>
											<option value="<?= $row['nomor_meja']; ?>"><?= $row['nomor_meja']; ?></option>
										<?php endwhile; ?>
									</select>
								</div>
								<input type="hidden" name="totalbelanja" id="hidden-totalbelanja" value="0">
								<input type="hidden" name="cart" id="hidden-cart" value="">

								<table class="table">
									<thead>
										<tr>
											<th>No</th>
											<th>Nama Menu</th>
											<th>Harga</th>
											<th>Jumlah</th>
											<th>Total</th>
											<th>Aksi</th>
										</tr>
									</thead>
									<tbody id="cart-items">
										<tr>
											<td colspan="6" class="text-center">Keranjang kosong</td>
										</tr>
									</tbody>
								</table>

								<button type="submit" name="konfirm" class="btn btn-success">Konfirmasi Pesanan</button>
								<div class="text-end">
									<h4>Total Belanja: Rp <span id="total-price">0</span></h4>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div><!--//app-content-->


	</div><!--//app-wrapper-->


	<!-- Javascript -->
	<script>
		function confirmLogout() {
			if (confirm("Apakah Anda yakin ingin keluar?")) {
				window.location.href = 'index.php';
			}
		}
	</script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="assets/js/orders.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
	<script src="assets/plugins/popper.min.js"></script>
	<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

	<!-- Page Specific JS -->
	<script src="assets/js/app.js"></script>

</body>

</html>