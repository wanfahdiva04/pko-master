<?php
session_start();
if ($_SESSION['status'] != "login" || $_SESSION['level'] != "admin") {
	header("location:../login?pesan=belum_login");
}

include "../../conn.php";
$id = mysqli_real_escape_string($conn, $_GET['id']);
$data = mysqli_query($conn, "SELECT * from sesi where id='$id'");
if (isset($_POST['simpan'])) {
	$id = mysqli_real_escape_string($conn, $_POST['id']);
	$nama_sesi = mysqli_real_escape_string($conn, $_POST['nama_sesi']);
	$mulai = mysqli_real_escape_string($conn, $_POST['mulai']);
	$akhir = mysqli_real_escape_string($conn, $_POST['akhir']);
	$hari = mysqli_real_escape_string($conn, ucfirst($_POST['hari']));

	$ubah = mysqli_query($conn, "UPDATE sesi set nama_sesi='$nama_sesi', mulai='$mulai', akhir='$akhir', hari='$hari' where id='$id'");
	if ($ubah) {
		echo '<script>alert("Berhasil Mengubah data."); document.location="../data_sesi";</script>';
	} else {
		echo '<script>alert("Gagal Mengubah data.");</script>';
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="../../vendor/images/ifsu.png" />

	<title>PKO Admin - Edit Sesi</title>

	<!-- Custom fonts for this template-->
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="../vendor/css/sb-admin-2.min.css" rel="stylesheet">
	<!-- Custom styles for this page -->
	<link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
	<div id="wrapper">

		<!-- Sidebar -->
		<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

			<!-- Sidebar - Brand -->
			<a class="sidebar-brand d-flex align-items-center justify-content-center" href="../dashboard">
				<div class="sidebar-brand-icon">
					<i class="fab fa-product-hunt mt-2"> PKO</i>
				</div>
			</a>

			<!-- Divider -->
			<hr class="sidebar-divider my-0">

			<!-- Nav Item - Dashboard -->
			<li class="nav-item">
				<a class="nav-link" href="../dashboard">
					<i class="fas fa-fw fa-tachometer-alt"></i>
					<span>Dashboard</span></a>
			</li>

			<!-- Nav Item - Sesi -->
			<li class="nav-item active">
				<a class="nav-link" href="../data_sesi">
					<i class="fas fa-fw fa-clock"></i>
					<span>Sesi</span></a>
			</li>

			<!-- Nav Item - Siswa -->
			<li class="nav-item">
				<a class="nav-link" href="../data_siswa">
					<i class="fas fa-fw fa-user-injured"></i>
					<span>Siswa</span></a>
			</li>

			<!-- Nav Item - Guru -->
			<li class="nav-item">
				<a class="nav-link" href="../data_guru">
					<i class="fas fa-fw fa-user-graduate"></i>
					<span>Guru</span></a>
			</li>

			<!-- Nav Item - Paslon -->
			<li class="nav-item">
				<a class="nav-link" href="../data_paslon">
					<i class="fas fa-fw fa-user"></i>
					<span>Paslon</span></a>
			</li>

			<!-- Nav Item - Hasil -->
			<li class="nav-item">
				<a class="nav-link" href="../hasil">
					<i class="fas fa-fw fa-poll"></i>
					<span>Hasil</span></a>
			</li>

			<!-- Nav Item - Laporan -->
			<li class="nav-item">
				<a class="nav-link" href="../laporan">
					<i class="fas fa-fw fa-print"></i>
					<span>Laporan</span></a>
			</li>

			<!-- Nav Item - Log out -->
			<li class="nav-item">
				<a class="nav-link" href="../logout.php">
					<i class="fas fa-fw fa-sign-out-alt"></i>
					<span>Log out</span></a>
			</li>
			<!-- Divider -->
			<hr class="sidebar-divider d-none d-md-block">

			<!-- Sidebar Toggler (Sidebar) -->
			<div class="text-center d-none d-md-inline">
				<button class="rounded-circle border-0" id="sidebarToggle"></button>
			</div>

		</ul>
		<!-- End of Sidebar -->

		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">
			<!-- Main Content -->
			<div id="content">
				<!-- Topbar -->
				<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
					<!-- Topbar Navbar -->
					<ul class="navbar-nav ml-auto">
						<!-- Nav Item - User Information -->
						<li class="nav-item dropdown no-arrow">
							<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-user-circle mr-2 mt-1"></i>
								<span class="mt-2 mr-2 mb-1 d-none d-lg-inline text-gray-600"><?= ucfirst($_SESSION['nama']); ?></span>
							</a>
							<!-- Dropdown - User Information -->
							<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
								<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
									<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
									Logout
								</a>
							</div>
						</li>
					</ul>
				</nav>
				<!-- End of Topbar -->

				<!-- Begin Page Content -->
				<div class="container-fluid">
					<!-- Page Heading -->
					<div class="d-sm-flex align-items-center justify-content-center mb-4">
						<h4 class="m-0 font-weight-bold text-primary align-items-center">Edit Data Sesi</h4>
					</div>
					<!-- DataTales String Pass -->
					<div class="card shadow mb-4" id="stringpass">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary align-items-center">Data</h6>
						</div>
						<div class="card-body">
							<?php while ($d = mysqli_fetch_assoc($data)) { ?>
								<form action="" method="POST">
									<div class="form-group row" hidden>
										<label for="id" class="col-sm-2 col-form-label">Id</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" required id="id" name="id" value="<?php echo mysqli_real_escape_string($conn, $d['id']); ?>">
										</div>
									</div>
									<div class="form-group row">
										<label for="nama_sesi" class="col-sm-2 col-form-label">Nama</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" required id="nama_sesi" name="nama_sesi" value="<?php echo mysqli_real_escape_string($conn, $d['nama_sesi']); ?>">
										</div>
									</div>
									<div class="form-group row">
										<label for="mulai" class="col-sm-2 col-form-label">Jam Mulai</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" required id="mulai" name="mulai" value="<?php echo mysqli_real_escape_string($conn, $d['mulai']); ?>">
										</div>
									</div>
									<div class="form-group row">
										<label for="akhir" class="col-sm-2 col-form-label">Jam akhir</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" required id="akhir" name="akhir" value="<?php echo mysqli_real_escape_string($conn, $d['akhir']); ?>">
										</div>
									</div>
									<div class="form-group row">
										<label for="hari" class="col-sm-2 col-form-label">Hari</label>
										<div class="col-sm-4">
											<?php
											if ($d['hari'] == 'Sunday') {
												$hari = "Minggu";
											} elseif ($d['hari'] == 'Monday') {
												$hari = "Senin";
											} elseif ($d['hari'] == 'Tuesday') {
												$hari = "Selasa";
											} elseif ($d['hari'] == 'Wednesday') {
												$hari = "Rabu";
											} elseif ($d['hari'] == 'Thursday') {
												$hari = "Kamis";
											} elseif ($d['hari'] == 'Friday') {
												$hari = "Jum`at";
											} elseif ($d['hari'] == 'Saturday') {
												$hari = "Sabtu";
											}
											?>
											<input type="text" class="form-control" disabled id="hari" name="" value="<?php echo mysqli_real_escape_string($conn, $hari); ?>">
										</div>
										<label for="kehari" class="col-sm-2 col-form-label">Ubah Ke hari</label>
										<div class="col-sm-4">
											<select class="custom-select" name="hari" id="kehari" required>
												<option value="">-pilih hari-</option>
												<option value="Sunday">Minggu</option>
												<option value="Monday">Senin</option>
												<option value="Tuesday">Selasa</option>
												<option value="Wednesday">Rabu</option>
												<option value="Thursday">Kamis</option>
												<option value="Friday">Jum'at</option>
												<option value="Saturday">Sabtu</option>
											</select>
										</div>
									</div>
									<div class="form-group row float-right">
										<div class="col-sm-12 mt-2">
											<button type="submit" class="btn btn-primary mx-1" name="simpan">Ubah</button>
											<a href="../data_sesi" class="btn btn-secondary mx-1">Kembali</a>
										</div>
									</div>
								</form>
							<?php
							}
							?>
						</div>
					</div>

					<!-- /.container-fluid -->
				</div>

				<!-- End of Main Content -->
			</div>
			<!-- Footer -->
			<footer class="sticky-footer bg-white">
				<div class="container my-auto">
					<div class="copyright text-center my-auto">
						<span>Copyright &copy; pemiluIfsu <?= date('Y'); ?></span>
					</div>
				</div>
			</footer>
			<!-- End of Footer -->

		</div>
		<!-- End of Content Wrapper -->

		<!-- End of Page Wrapper -->
	</div>

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>


	<!-- Logout Modal-->
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Bener Yeuh?</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">Pencet Logout Mun Bener Ek Kaluar</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
					<a class="btn btn-primary" href="../logout.php">Logout</a>
				</div>
			</div>
		</div>
	</div>

	<!-- Bootstrap core JavaScript-->
	<script src="../vendor/jquery/jquery.min.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- Core plugin JavaScript-->
	<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

	<!-- Custom scripts for all pages-->
	<script src="../vendor/js/sb-admin-2.min.js"></script>

	<!-- Page level plugins -->
	<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
	<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

	<!-- Page level custom scripts -->
	<script src="../vendor/js/demo/datatables-demo.js"></script>

</body>

</html>


<div class="row" hidden>
	<h1 align="center">edit data sesi</h1>
	<a href="../data_sesi">kembali</a><br>
	<?php while ($d = mysqli_fetch_assoc($data)) { ?>
		<form action="" method="post">
			<input type="hidden" name="id" value="<?php echo mysqli_real_escape_string($conn, $d['id']); ?>">
			<label for="nama_sesi">nama_sesi</label>
			<input type="text" name="nama_sesi" id="nama_sesi" value="<?php echo mysqli_real_escape_string($conn, $d['nama_sesi']); ?>">
			<br>
			<label for="mulai">jam mulai</label>
			<input type="text" name="mulai" id="mulai" value="<?php echo mysqli_real_escape_string($conn, $d['mulai']); ?>">
			<br>
			<label for="akhir">jam akhir</label>
			<input type="text" name="akhir" id="akhir" value="<?php echo mysqli_real_escape_string($conn, $d['akhir']); ?>">
			<br>
			<table>
				<td><label for="hari">hari</label>
					<?php
					if ($d['hari'] == 'Sunday') {
						$hari = "Minggu";
					} elseif ($d['hari'] == 'Monday') {
						$hari = "Senin";
					} elseif ($d['hari'] == 'Tuesday') {
						$hari = "Selasa";
					} elseif ($d['hari'] == 'Wednesday') {
						$hari = "Rabu";
					} elseif ($d['hari'] == 'Thursday') {
						$hari = "Kamis";
					} elseif ($d['hari'] == 'Friday') {
						$hari = "Jum'at";
					} elseif ($d['hari'] == 'Saturday') {
						$hari = "Sabtu";
					}
					?>
					<input type="text" readonly disabled value="<?php echo $hari; ?>">
					<label for="">ubah ke hari</label>
					<select name="hari" id="hari">
						<option value="Sunday">Minggu</option>
						<option value="Monday">Senin</option>
						<option value="Tuesday">Selasa</option>
						<option value="Wednesday">Rabu</option>
						<option value="Thursday">Kamis</option>
						<option value="Friday">Jumat</option>
						<option value="Saturday">Sabtu</option>
					</select></td>
			</table>
			<br>
			<button name="simpan">simpan</button>
		</form>
	<?php
	}
	?>
</div>