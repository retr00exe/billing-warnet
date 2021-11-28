<?php
	include_once("config.php");
	// error_reporting(0);
 	session_start();

	 if (isset($_SESSION['login'])) {
		header("Location:/");
	}

	if (isset($_SESSION['nama'])) {
		header("Location:/");
	}

	if(isset($_POST['login'])) {
		try {
			$email = $_POST['email'];
			$password = $_POST['password'];

			$result = mysqli_query($conn, "SELECT * FROM operator WHERE email='$email'");
			if (mysqli_num_rows($result) === 1){
				$row = mysqli_fetch_assoc($result);
				if (password_verify($password, $row['password'])){
					$_SESSION['login'] = true;
					$_SESSION['nama'] = $row['nama'];
					$_SESSION['id_operator'] = $row['id_operator'];
					echo "<script>alert('Login success!')</script>";
					header("Location:/");
					exit;
				}
			} 

			$error = true;

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
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<title>Login</title>
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
			<h1 class="mb-5">Login</h1>
			<form method="post" action="">
				<div class="form-group">
					<label for="name">Email</label>
					<input type="text" name="email" value="<?=@$vnama?>" class="form-control" id="email" required placeholder="Email">
				</div>
				<div class="form-group">
					<label for="username">Password</label>
					<input type="password" name="password" value="<?=@$vusername?>" class="form-control" id="password" required placeholder="Password">
				</div>
				<button type="submit" class="btn btn-primary text-white" name="login">Submit</button>
				<?php if(isset($error)) : ?>
					<p class="text-danger">Email/password salah</p>
				<?php endif; ?>
				<p class="mt-5">Belum punya akun? <a href="/register.php">register</a></p>
			</form>
		</div>
	</main>
</html>