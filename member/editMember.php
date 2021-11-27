<?php
	// include_once("is_logged_in.php");
	include_once("../config.php");

	if(isset($_POST['submit'])){
		try{
			$edit = mysqli_query($mysqli, 
				"UPDATE member SET
						nama = '$_POST[nama]', 
						username = '$_POST[username]',
						email = '$_POST[email]', 
						alamat = '$_POST[alamat]', 
						telepon ='$_POST[telepon]'
					WHERE id_member = '$_GET[id]'
				"
			);
			if($edit){
				echo
				"<script>
					alert('Edit data success!');
					document.location = '../index.php'
				</script>";
			} else {
				echo
				"<script>
					alert('Edit data failed!');
					document.location = '../index.php'
				</script>";
			}
		} catch (Exception $e) {
			echo $e->getMessage();
			die();
		}
	}

	if(isset($_GET['id'])){
		$member = mysqli_query($mysqli, "SELECT * FROM member WHERE id_member = '$_GET[id]'");
		$data = mysqli_fetch_array($member);
		if($data){
			$vnama = $data['nama'];
			$vusername = $data['username'];
			$vemail = $data['email'];
			$valamat = $data['alamat'];
			$vtelepon = $data['telepon'];
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
	<title>Edit member</title>
</head>
<body>
	<!-- <?php include('navbar.php') ?> -->
	<main class="mx-5">
		<section>
			<h3 class="my-5">Tabel Member Warnet</h3>
			<div class="card mt-5">
				<div class="card-header bg-primary text-white">Input member baru</div>
				<div class="card-body">
					<form method="post" action="">
						<div class="form-group">
							<label for="name">Nama</label>
							<input type="text" name="nama" value="<?=@$vnama?>" class="form-control" id="name" required placeholder="Name">
						</div>
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" name="username" value="<?=@$vusername?>" class="form-control" id="username" required placeholder="Username">
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" name="email" value="<?=@$vemail?>" class="form-control" id="email" required placeholder="Email">
						</div>
						<div class="form-group">
							<label for="alamat">Alamat</label>
							<input type="text" name="alamat" value="<?=@$valamat?>" class="form-control" id="alamat" required placeholder="Address">
						</div>
						<div class="form-group">
							<label for="telepon">Telepon</label>
							<input type="tel" name="telepon" value="<?=@$vtelepon?>" class="form-control" id="telepon" required placeholder="Telephone">
						</div>
						<button type="submit" class="btn btn-success" name="submit">Simpan</button>
						<button type="reset" class="btn btn-warning text-white" name="reset">Reset</button>
					</form>
				</div>
			</div>
		</section>
	<script type="text/javascript"> src="js/bootstrap.min.js"></script>
</body>
</html>