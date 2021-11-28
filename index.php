<?php
	include_once("is_logged_in.php");
	include_once("config.php");

	$member = mysqli_query($conn, "SELECT
		m.id_member, m.nama, m.username, m.email, m.waktu, m.alamat, m.telepon, m.created_at, m.is_deleted, p.tier, p.diskon
		FROM member AS m 
		INNER JOIN promo AS p 
		ON 
		m.id_promo = p.id_promo
	");
	$operator = mysqli_query($conn, "SELECT * FROM operator");

	if(isset($_GET['id'])){
		if(isset($_GET['method'])){
			if($_GET['method'] == 'ban'){
				$soft_delete = mysqli_query($conn, "UPDATE member SET is_deleted=1 WHERE id_member = '$_GET[id]'");
				if($soft_delete){
					echo
						"<script>
							alert('User banned!');
							document.location = 'index.php'
						</script>";
				}
			}else if($_GET['method'] == 'activate'){
				$soft_delete = mysqli_query($conn, "UPDATE member SET is_deleted=0 WHERE id_member = '$_GET[id]'");
				if($soft_delete){
					echo
						"<script>
							alert('User recovered!');
							document.location = 'index.php'
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
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<title>Dashboard</title>
</head>
<body>
	<?php include('navbar.php') ?>
	<main class="mx-5">
	<h1 class="text-center mt-5">Warnet Liyue</h1>
		<section>
			<h3 class="my-5">Member</h3>
			<table width='80%' class="table mt-5">
				<tr>
					<th scope="col">No.</th>
					<th scope="col">Nama</th>
					<th scope="col">Username</th>
					<th scope="col">Email</th>
					<th scope="col">Sisa waktu</th>
					<th scope="col">Alamat</th>
					<th scope="col">Telepon</th>
					<th scope="col">Tanggal bergabung</th>
					<th scope="col">Member</th>
					<th scope="col">Diskon</th>
					<th scope="col">Status</th>
					<th scope="col">Aksi</th>
				</tr>
				<?php
					$no = 1;
					while($item = mysqli_fetch_array($member)) :
				?>
					<tr>
						<td><?=$no++?></td>
						<td><?=$item['nama']?></td>
						<td><?=$item['username']?></td>
						<td><?=$item['email']?></td>
						<td><?=$item['waktu']?> jam</td>
						<td><?=$item['alamat']?></td>
						<td><?=$item['telepon']?></td>
						<td><?=$item['created_at']?></td>
						<td><?=$item['tier']?></td>
						<td><?=$item['diskon']?>%</td>
						<td class="<?=$item['is_deleted'] == 1 ? 'text-danger' : 'text-success' ?>"><?=$item['is_deleted'] == 0 ? 'Active' : 'Banned' ?></td>
						<td>
							<a href="member/editMember.php?id=<?=@$item['id_member']?>" class="btn btn-warning">Edit</a>
							<a href="index.php?method=<?=$item['is_deleted'] == 0 ? 'ban' : 'activate' ?>&id=<?=@$item['id_member']?>" onclick="return confirm('Are you sure you want to <?=$item['is_deleted'] == 0 ? 'banned' : 'activate' ?> this?')"class="btn btn-<?=$item['is_deleted'] == 0 ? 'danger' : 'primary' ?>"><?=$item['is_deleted'] == 0 ? 'Ban' : 'Activate' ?></a>
						</td>
					<tr>
				<?php endwhile; ?>
			</table>
		</section>
		<section class="mt-5">
			<a href="member/tambahMember.php" class="btn btn-success">Tambah Member</a>
		</section>
		<section class="mb-5">
			<h3 class="my-5">OP</h3>
			<table width='80%' class="table mt-5">
				<tr>
					<th scope="col">No.</th>
					<th scope="col">Nama</th>
					<th scope="col">Email</th>
				</tr>
				<?php
					$no = 1;
					while($item = mysqli_fetch_array($operator)) :
				?>
					<tr>
						<td><?=$no++?></td>
						<td><?=$item['nama']?></td>
						<td><?=$item['email']?></td>
					<tr>
				<?php endwhile; ?>
			</table>
		</section>
		<section class="mt-5">
			<a href="billing/tambahBilling.php" class="btn btn-primary mb-5">Tambah Billing</a>
		</section>
	</main>
	<script type="text/javascript"> src="js/bootstrap.min.js"></script>
</body>
</html>