<?php
	include_once("../is_logged_in.php");
	include_once("../config.php");

	$promo = mysqli_query($conn, "SELECT * FROM promo");

	if(isset($_GET['id'])){
		if(isset($_GET['method'])){
			if($_GET['method'] == 'delete'){
				$hard_delete = mysqli_query($conn, "DELETE FROM promo WHERE id_promo = '$_GET[id]'");
				if($hard_delete){
					echo
						"<script>
							alert('Promo deleted!');
							document.location = '/promo/daftarPromo.php'
						</script>";
				}
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
	<title>Dashboard</title>
</head>
<body>
	<?php include('../navbar.php') ?>
	<main class="mx-5">
	<h1 class="text-center mt-5">Tier Member Warnet</h1>
		<section>
			<h3 class="my-5">Member</h3>
			<table width='80%' class="table mt-5">
				<tr>
					<th scope="col">No.</th>
					<th scope="col">Tier</th>
					<th scope="col">Diskon</th>
					<th scope="col">Aksi</th>
				</tr>
				<?php
					$no = 1;
					while($item = mysqli_fetch_array($promo)) :
				?>
					<tr>
						<td><?=$no++?></td>
						<td><?=$item['tier']?></td>
						<td><?=$item['diskon']?>%</td>
						<td>
							<a href="/promo/editPromo.php?id=<?=@$item['id_promo']?>" class="btn btn-warning">Edit</a>
							<a href="/promo/daftarPromo.php?method=delete&id=<?=@$item['id_promo']?>" onclick="return confirm('Are you sure you want to delete this promo?')"class="btn btn-danger">Delete</a>
						</td>
					<tr>
				<?php endwhile; ?>
			</table>
		</section>
		<section class="mt-5">
			<a href="addPromo.php" class="btn btn-success">Tambah Promo Baru</a>
		</section>
	</main>
	<script type="text/javascript"> src="../js/bootstrap.min.js"></script>
</body>
</html>