<?php
	include_once("../is_logged_in.php");
	include_once("../config.php");

	// error_reporting(0);

	if(isset($_POST['submit'])){
		try{
			if(isset($_POST['username'])){
				$member = mysqli_query($conn, "SELECT * FROM member WHERE username = '$_POST[username]'");
				$data = mysqli_fetch_array($member);
			}

			$id_user = 0;
			$id_diskon = 1;

			if($data){
				$id_user = $data['id_member'];
				$id_diskon = $data['id_promo'];
			}

			if($id_user == 0){
				echo "<script>alert('Username not found!')</script>";
				return;
			}

			if($_POST['waktu'] <= 0){
				echo "<script>alert('Pilih total waktu!')</script>";
				return;
			}

			$promo = mysqli_query($conn, "SELECT * FROM promo WHERE id_promo = '$id_diskon'");
			$data_diskon = mysqli_fetch_array($promo);

			$diskon = 0;
			$tier = '';

			if($data_diskon){
				$diskon = $data_diskon['diskon'];
				$tier = $data_diskon['tier'];
			}

			$current_date = date("Y/m/d");

			$save = mysqli_query($conn, 
				"INSERT INTO billing (id_operator, id_user, waktu, tanggal, diskon, status_billing)
					VALUES(
						'$_SESSION[id_operator]', 
						'$id_user',
						'$_POST[waktu]', 
						'$current_date',
						'$diskon',
						0
					)
				"
			);

			if($save){
				header("Location: /billing/konfirmasiBilling.php?bill_id=".mysqli_insert_id($conn));
			} else {
				echo
				"<script>
					alert('Failed!');
				</script>";
				return;
			}
		} catch (Exception $e) {
			echo $e->getMessage();
			die();
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<title>Tambah Billing</title>
</head>
<body>
	<?php include('../navbar.php') ?>
	<main class="mx-5">
		<section>
			<div class="card mt-5">
				<div class="card-header bg-primary text-white">Buat billing baru</div>
				<div class="card-body">
					<form method="post" action="">
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" name="username" class="form-control" id="username" required placeholder="Username member">
						</div>
						<label for="name">Waktu</label><br>
						<select class="form-select mb-2" name="waktu" aria-label="Default select example">
							<option selected>Pilih waktu</option>
							<option value="1">1 jam</option>
							<option value="2">2 jam</option>
							<option value="3">3 jam</option>
							<option value="4">4 jam</option>
							<option value="5">5 jam</option>
							<option value="6">6 jam</option>
							<option value="7">7 jam</option>
							<option value="8">8 jam</option>
						</select>
						<div class="form-group">
							<label for="operator">Operator</label>
							<input type="text" name="operator" class="form-control" value="<?= $_SESSION['nama']?>" id="operator" disabled placeholder="Operator">
						</div>
						<div class="form-group">
							<label for="tanggal">Tanggal</label>
							<input type="text" name="tanggal" class="form-control" value="<?= date("Y/m/d") ?>" id="tanggal" disabled placeholder="Tanggal">
						</div>
						<button type="submit" class="btn btn-primary" name="submit">Konfirmasi</button>
						<button type="reset" class="btn btn-danger text-white" name="reset">Reset</button>
					</form>
				</div>
			</div>
		</section>
	<script type="text/javascript" src="../js/bootstrap.min.js"></script>
</body>
</html>