<?php
	include_once("../is_logged_in.php");
	include_once("../config.php");

	if(isset($_POST['submit'])){
		try{
			$edit = mysqli_query($conn, 
				"UPDATE promo SET
						tier = '$_POST[tier]', 
						diskon = '$_POST[diskon]'
					WHERE id_promo = '$_GET[id]'
				"
			);
			if($edit){
				echo
				"<script>
					alert('Edit promo data success!');
					document.location = '/promo/daftarPromo.php'
				</script>";
			} else {
				echo
				"<script>
					alert('Edit promo data failed!');
					document.location = '/promo/daftarPromo.php'
				</script>";
			}
		} catch (Exception $e) {
			echo $e->getMessage();
			die();
		}
	}

	if(isset($_GET['id'])){
		$member = mysqli_query($conn, "SELECT * FROM promo WHERE id_promo = '$_GET[id]'");
		$data = mysqli_fetch_array($member);
		if($data){
			$tier = $data['tier'];
			$diskon = $data['diskon'];
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
				<div class="card-header bg-primary text-white">Edit promo</div>
				<div class="card-body">
					<form method="post" action="">
						<div class="form-group">
							<label for="tier">Tier promo</label>
							<input type="text" name="tier" value="<?=@$tier?>" class="form-control" id="tier" required placeholder="Nama tier">
						</div>
						<div class="form-group">
							<label for="diskon">Diskon</label>
							<input type="text" name="diskon" value="<?=@$diskon?>" class="form-control" id="diskon" placeholder="Diskon">
						</div>
						<button type="submit" class="btn btn-primary" name="submit">Ubah</button>
						<button type="reset" class="btn btn-danger text-white" name="reset">Reset</button>
					</form>
				</div>
			</div>
		</section>
	<script type="text/javascript" src="../js/bootstrap.min.js"></script>
</body>
</html>