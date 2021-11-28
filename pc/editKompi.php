<?php
	include_once("../is_logged_in.php");
	include_once("../config.php");

	if(isset($_POST['submit'])){
		try{
			if($_POST['status'] === 'Pilih'){
				echo "<script>alert('Masukkan status PC!')</script>";
				return;
			}

			if($_POST['id_operator'] === 'Pilih'){
				echo "<script>alert('Masukkan nama operator!')</script>";
				return;
			}

			$edit = mysqli_query($conn, 
				"UPDATE pc SET
						nomor = '$_POST[nomor]', 
						spesifikasi = '$_POST[spesifikasi]',
						status = '$_POST[status]', 
						id_operator = '$_POST[id_operator]'
					WHERE id_pc = '$_GET[id]'
				"
			);
			if($edit){
				echo
				"<script>
					alert('Edit PC success!');
					document.location = '/pc/listKompi.php'
				</script>";
			} else {
				echo
				"<script>
					alert('Edit PC failed!');
					document.location = '/pc/listKompi.php'
				</script>";
			}
		} catch (Exception $e) {
			echo $e->getMessage();
			die();
		}
	}

	if(isset($_GET['id'])){
		$pc = mysqli_query($conn, "SELECT * FROM pc WHERE id_pc = '$_GET[id]'");
		$data = mysqli_fetch_array($pc);
		if($data){
			$nomor = $data['nomor'];
			$spesifikasi = $data['spesifikasi'];
			$status = $data['status'];
			$id_operator = $data['id_operator'];
		}
		$operator = mysqli_query($conn, "SELECT * FROM operator");
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<title>Edit PC</title>
</head>
<body>
	<?php include('../navbar.php') ?>
	<main class="mx-5">
		<section>
			<div class="card mt-5">
				<div class="card-header bg-primary text-white">Edit PC</div>
				<div class="card-body">
					<form method="post" action="">
						<div class="form-group">
							<label for="nomor">Nomor Seri</label>
							<input type="text" name="nomor" value="<?=@$nomor?>" class="form-control" id="nomor" required placeholder="Nomor seri">
						</div>
						<div class="form-group">
							<label for="spesifikasi">Spesifikasi</label>
							<input type="text" name="spesifikasi" value="<?=@$spesifikasi?>" class="form-control" id="spesifikasi" required placeholder="Spesifikasi">
						</div>
						<label for="status">Status PC</label>
						<br>
						<select class="form-select mb-3" name="status" aria-label="Default select example">
							<option selected>Pilih</option>
							<option value="1">Aktif</option>
							<option value="0">Rusak</option>
						</select>
						<br>
						<label for="status">Operator</label>
						<br>
						<select class="form-select mb-3" name="id_operator" aria-label="Default select example">
							<option selected>Pilih</option>
							<?php
								while($op = mysqli_fetch_array($operator)) :
							?>
								<option value="<?= $op['id_operator'] ?>"><?= $op['nama'] ?></option>
							<?php endwhile; ?>
						</select>
						<br>
						<button type="submit" class="btn btn-success" name="submit">Simpan</button>
						<button type="reset" class="btn btn-warning text-white" name="reset">Reset</button>
					</form>
				</div>
			</div>
		</section>
	<script type="text/javascript"> src="js/bootstrap.min.js"></script>
</body>
</html>