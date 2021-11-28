<?php
	include_once("../is_logged_in.php");
	include_once("../config.php");

	$pc = mysqli_query($conn, "SELECT
		p.id_pc, p.nomor, p.spesifikasi, p.status, o.nama as operator, m.nama
		FROM pc AS p
		LEFT JOIN operator AS o
		ON 
		p.id_operator = o.id_operator
		LEFT JOIN member AS m
		ON 
		p.user_id = m.id_member
	");

	if(isset($_GET['id'])){
		if(isset($_GET['method'])){
			if($_GET['method'] == 'delete'){
				$hard_delete = mysqli_query($conn, "DELETE FROM pc WHERE id_pc = '$_GET[id]'");
				if($hard_delete){
					echo
						"<script>
							alert('PC deleted!');
							document.location = '/pc/listKompi.php'
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
	<title>List PC</title>
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
					<th scope="col">Aksi</th>
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
						<td><?=$item['operator']?></td>
						<td class="<?=isset($item['nama'])? 'text-danger' : 'text-success'?>" ><?=isset($item['nama'])? $item['nama'] : 'Kosong'?></td>
						<td>
							<a href="/pc/editKompi.php?id=<?=@$item['id_pc']?>" class="btn btn-warning">Edit PC</a>
							<?php if($item['status'] == 1): ?>
								<a href="/pc/editUser.php?id=<?=@$item['id_pc']?>" class="btn btn-primary">Edit User</a>
							<?php else: ?>
								<a href="#" class="btn btn-primary" onclick="return confirm('PC rusak! Tidak dapat mengeset user.')">Edit User</a>
							<?php endif; ?>
							<a href="/pc/listKompi.php?method=delete&id=<?=@$item['id_pc']?>" onclick="return confirm('Are you sure you want to delete this PC?')" class="btn btn-danger">Delete</a>
						</td>
					<tr>
				<?php endwhile; ?>
			</table>
		</section>
		<section class="mt-5">
			<a href="/pc/addKompi.php" class="btn btn-success">Tambah PC baru</a>
		</section>
	</main>
	<script type="text/javascript"> src="../js/bootstrap.min.js"></script>
</body>
</html>