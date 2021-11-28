<?php
	include_once("../is_logged_in.php");
	include_once("../config.php");

	if(isset($_POST['submit'])){
		try{
			$save = mysqli_query($conn, 
				"INSERT INTO member (nama, username, email, alamat, telepon)
					VALUES(
						'$_POST[nama]', 
						'$_POST[username]',
						'$_POST[email]', 
						'$_POST[alamat]', 
						'$_POST[telepon]'
					)
				"
			);
			if($save){
				echo
				"<script>
					alert('Successfully add new member!');
					document.location = '../index.php'
				</script>";
			} else {
				echo
				"<script>
					alert('Add new member failed!');
					document.location = '../index.php'
				</script>";
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
	<title>Edit member</title>
</head>
<body>
	<?php include('../navbar.php') ?>
	<main class="mx-5">
		<section>
			<div class="card mt-5">
				<div class="card-header bg-primary text-white">Input member baru</div>
				<div class="card-body">
					<form method="post" action="">
						<div class="form-group">
							<label for="name">Nama</label>
							<input type="text" name="nama" class="form-control" id="name" required placeholder="Name">
						</div>
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" name="username" class="form-control" id="username" required placeholder="Username">
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="email" name="email" class="form-control" id="email" required placeholder="Email">
						</div>
						<div class="form-group">
							<label for="alamat">Alamat</label>
							<input type="text" name="alamat" class="form-control" id="alamat" required placeholder="Address">
						</div>
						<div class="form-group">
							<label for="telepon">Telepon</label>
							<input type="tel" name="telepon" class="form-control" id="telepon" required placeholder="Telephone">
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