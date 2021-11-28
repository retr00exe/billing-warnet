<?php
	include_once("../is_logged_in.php");
	include_once("../config.php");

	// error_reporting(0);

	if(isset($_POST['submit'])){
		try{
			$save = mysqli_query($conn, 
				"INSERT INTO pc (nomor, spesifikasi, status, id_operator)
					VALUES(
						'$_POST[nomor]', 
						'$_POST[spesifikasi]',
						'$_POST[status]', 
						'$_POST[id_operator]'
					)
				"
			);
			if($save){
				echo
				"<script>
					alert('Successfully add new PC!');
					document.location = '/pc/listKompi.php'
				</script>";
			} else {
				echo
				"<script>
					alert('Add new PC failed!');
					document.location = '/pc/listKompi.php'
				</script>";
			}
		} catch (Exception $e) {
			echo $e->getMessage();
			die();
		}
	}

	$operator = mysqli_query($conn, "SELECT * FROM operator");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<title>Tambah PC Baru</title>
</head>
<body>
	<?php include('../navbar.php') ?>
	<main class="mx-5">
		<section>
			<div class="card mt-5">
				<div class="card-header bg-primary text-white">Tambah PC baru</div>
				<div class="card-body">
					<form method="post" action="">
						<div class="form-group">
							<label for="nomor">Nomor Seri</label>
							<input type="text" name="nomor" class="form-control" id="nomor" required placeholder="Nomor seri">
						</div>
						<div class="form-group">
							<label for="spesifikasi">Spesifikasi</label>
							<input type="text" name="spesifikasi" class="form-control" id="spesifikasi" placeholder="Spesifikasi">
						</div>
						<select class="form-select mb-3" name="status" aria-label="Default select example">
							<option selected>Status</option>
							<option value="1">Aktif</option>
							<option value="0">Rusak</option>
						</select>
						<br>
						<select class="form-select mb-3" name="id_operator" aria-label="Default select example">
							<option selected>Operator</option>
							<?php
								while($op = mysqli_fetch_array($operator)) :
							?>
								<option value="<?= $op['id_operator'] ?>"><?= $op['nama'] ?></option>
							<?php endwhile; ?>
						</select>
						<br>
						<button type="submit" class="btn btn-primary" name="submit">Konfirmasi</button>
						<button type="reset" class="btn btn-danger text-white" name="reset">Reset</button>
					</form>
				</div>
			</div>
		</section>
	<script type="text/javascript" src="../js/bootstrap.min.js"></script>
</body>
</html>