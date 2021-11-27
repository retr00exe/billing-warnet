<?php
	// include_once("is_logged_in.php");
	include_once("../config.php");

	$pc = mysqli_query($mysqli, "SELECT
		p.nomor, p.spesifikasi, p.status, o.nama, p.user_id
		FROM pc AS p
		INNER JOIN operator AS o
		ON 
		p.id_operator = o.id_operator
	");
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
	<h1 class="text-center mt-5">List PC</h1>
		<section>
			<table width='80%' class="table mt-5">
				<tr>
					<th scope="col">No.</th>
					<th scope="col">Kode Seri</th>
					<th scope="col">Spesifikasi</th>
					<th scope="col">Status</th>
					<th scope="col">Operator</th>
					<th scope="col">User</th>
				</tr>
				<?php
					$no = 1;
					while($item = mysqli_fetch_array($pc)) :
				?>
					<tr>
						<td><?=$no++?></td>
						<td><?=$item['nomor']?></td>
						<td><?=$item['spesifikasi']?></td>
						<td class=<?=$item['status'] == 1 ? 'text-success' : 'text-danger' ?>><?=$item['status'] == 1 ? 'Aktif' : 'Rusak' ?></td>
						<td><?=$item['nama']?></td>
						<td><?=isset($item['user_id'])? $item['user_id'] : 'Kosong'?></td>
						<!-- <td>
							<a href="member/editMember.php?id=<?=@$item['id_member']?>" class="btn btn-warning">Edit</a>
							<a href="index.php?method=<?=$item['is_deleted'] == 0 ? 'ban' : 'activate' ?>&id=<?=@$item['id_member']?>" onclick="return confirm('Are you sure you want to <?=$item['is_deleted'] == 0 ? 'banned' : 'activate' ?> this?')"class="btn btn-<?=$item['is_deleted'] == 0 ? 'danger' : 'primary' ?>"><?=$item['is_deleted'] == 0 ? 'Ban' : 'Activate' ?></a>
						</td> -->
					<tr>
				<?php endwhile; ?>
			</table>
		</section>
		<section class="mt-5">
			<a href="member/tambahMember.php" class="btn btn-success">Tambah Member</a>
		</section>
	</main>
	<script type="text/javascript"> src="../js/bootstrap.min.js"></script>
</body>
</html>