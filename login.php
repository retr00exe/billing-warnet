<?php
	// Create database connection using config file
	include_once("config.php");
	error_reporting(0);
 	session_start();

	 if (isset($_SESSION['nama'])) {
		header("Location:/");
	}

	// Check If form submitted, insert form data into users table.
	if(isset($_POST['submit'])) {
		try {
			$email = $_POST['email'];
			$password = $_POST['password'];

			// include database connection file
			include_once("../config.php");
			// Insert user data into table

			$result = mysqli_query($mysqli, "SELECT * FROM operator WHERE email='$email'");
			if ($result->num_rows > 0){
				$row = mysqli_fetch_array($result);
				if (password_verify($password, $row['password'])){
					$_SESSION['nama'] = $row['nama'];
					echo 'Berhasil Login!';
					header("Location:/");
				} else {
					echo 'Password salah!';
				}
			} else {
				echo 'Email tidak valid!';
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

<meta name="viewport" content="width=device-width, initial-
scale=1.0">

<title>Login</title>

</head>
<body>
	<main>
	<div>
			<form action="" method="post" name="form">
				<h3>Login Warnet</h3>
				<table width="25%" border="0">
					<tr>
						<td>Email</td>
						<td><input type="text" name="email" required></td>
					</tr>
					<tr>
						<td>Password</td>
						<td><input type="password" name="password" required></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" name="submit" value="Login"></td>
					</tr>
				</table>
			</form>
		</div>
	</main>
</html>