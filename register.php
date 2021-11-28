<?php
	include_once("config.php");
	// error_reporting(0);
 	// session_start();

	function register($data){
		global $conn;
		$nama = $data['name'];
		$email = strtolower($data['email']);
		$alamat = $data['address'];
		$telepon = $data['telepon'];
		$password = mysqli_real_escape_string($conn, $data['password']);
		$confirm = mysqli_real_escape_string($conn, $data['confirm']);

		$check = mysqli_query($conn, "SELECT email FROM operator WHERE email = '$email'");

		if(mysqli_fetch_assoc($check)){
			echo "<script>alert('Email sudah terdaftar!')</script>";
			return false;
		}

		if($password !== $confirm) {
			echo "<script>alert('Konfirmasi password tidak sesuai!')</script>";
			return false;
		}

		$password = password_hash($password, PASSWORD_DEFAULT);
		
		mysqli_query($conn, "INSERT INTO operator VALUES('', '$nama', '$alamat', '$telepon', '$email', 0, '$password')");

		return mysqli_affected_rows($conn);
	}

	if(isset($_POST['register'])){
		try {
			global $conn;
			if(register($_POST) > 0){
				echo "<script>alert('User successfully registered!')</script>";
				header("Location:/login.php");
			} else {
				echo mysqli_error($conn);
			}
		}	catch (Exception $e) {
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
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<title>Register</title>
	<style>
		.login-box {
			width: 25rem;
			margin-top: 25rem;
		}
	</style>
</head>
<body>
	<main>
		<div class="container login-box">
			<h1 class="mb-5">Register</h1>
			<form method="post" action="">
				<div class="form-group">
					<label for="name">Nama</label>
					<input type="text" name="name" value="<?=@$vnama?>" class="form-control" id="name" required placeholder="Nama">
				</div>
				<div class="form-group">
					<label for="email">Email</label>
					<input type="text" name="email" value="<?=@$vemail?>" class="form-control" id="email" required placeholder="Email">
				</div>
				<div class="form-group">
					<label for="address">Alamat</label>
					<input type="text" name="address" value="<?=@$vaddress?>" class="form-control" id="address" required placeholder="Address">
				</div>
				<div class="form-group">
					<label for="telepon">Telepon</label>
					<input type="tel" name="telepon" value="<?=@$vtelepon?>" class="form-control" id="telepon" required placeholder="Telepon">
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" name="password" value="<?=@$vpassword?>" class="form-control" id="password" required placeholder="Password">
				</div>
				<div class="form-group">
					<label for="confirm">Confirm Password</label>
					<input type="password" name="confirm" value="<?=@$vconfirm?>" class="form-control" id="confirm" required placeholder="Confirm Password">
				</div>
				<button type="submit" class="btn btn-primary text-white" name="register">Submit</button>
			</form>
		</div>
	</main>
</html>