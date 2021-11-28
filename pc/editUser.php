<?php
	include_once("../is_logged_in.php");
	include_once("../config.php");

	if(isset($_POST['submit'])){
		try{
			if(isset($_POST['newuser'])){
				$member = mysqli_query($conn, "SELECT * FROM member WHERE username = '$_POST[newuser]'");
				$data = mysqli_fetch_array($member);
			}

			$id_user = 0;

			if($data){
				$id_user = $data['id_member'];
			}

			if($id_user == 0){
				echo "<script>alert('Username not found!')</script>";
				return;
			}

			$edit = mysqli_query($conn, 
				"UPDATE pc SET
						user_id = '$id_user'
					WHERE id_pc = '$_GET[id]'
				"
			);

			if($edit){
				echo
				"<script>
					alert('Edit PC user success!');
					document.location = '/pc/listKompi.php'
				</script>";
			} else {
				echo
				"<script>
					alert('Edit PC user failed!');
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
			$user_id = $data['user_id'];
			if($user_id){
				$member = mysqli_query($conn, "SELECT * FROM member WHERE id_member = '$user_id'");
				$data_member = mysqli_fetch_array($member);
				$user_now = $data_member['nama'];
			}
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
	<title>Edit User</title>
</head>
<body>
	<?php include('../navbar.php') ?>
	<main class="mx-5">
		<section>
			<div class="card mt-5">
				<div class="card-header bg-primary text-white">Ubah pengguna PC</div>
				<div class="card-body">
					<form method="post" action="">
						<div class="form-group">
							<label for="user">User saat ini</label>
							<input type="text" name="user" disabled value="<?=@$user_now?>" class="form-control" id="user" required placeholder="Kosong">
						</div>
						<div class="form-group">
							<label for="newuser">User baru</label>
							<input type="text" name="newuser" value="<?=@$nomor?>" class="form-control" id="newuser" required placeholder="Masukkan user baru">
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