<?php
	include_once("../is_logged_in.php");
	include_once("../config.php");

	$history = mysqli_query($conn, "SELECT
		b.harga, b.diskon, b.waktu, b.tanggal, b.status_billing, m.nama, m.username, o.nama AS operator
		FROM billing AS b
		INNER JOIN member AS m
		ON 
		b.id_user = m.id_member
		INNER JOIN operator AS o
		ON 
		b.id_operator = o.id_operator
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
	<h1 class="text-center mt-5">Warnet Liyue</h1>
		<section>
			<h3 class="my-5">Riwayat transaksi billing</h3>
			<table width='80%' class="table mt-5">
				<tr>
					<th scope="col">No.</th>
					<th scope="col">Nama</th>
					<th scope="col">Username</th>
					<th scope="col">Penambahan Waktu</th>
					<th scope="col">Harga</th>
					<th scope="col">Diskon</th>
					<th scope="col">Subtotal</th>
					<th scope="col">Tanggal Cetak</th>
					<th scope="col">Operator</th>
					<th scope="col">Status Billing</th>
				</tr>
				<?php
					$no = 1;
					while($item = mysqli_fetch_array($history)) :
				?>
					<tr>
						<td><?=$no++?></td>
						<td><?=$item['nama']?></td>
						<td><?=$item['username']?></td>
						<td><?=$item['waktu']?> Jam</td>
						<td>Rp.<?=$item['harga']?></td>
						<td><?=$item['diskon']?>%</td>
						<td>Rp.<?= ((100 - $item['diskon']) / 100) * $item['harga']?></td>
						<td><?=$item['tanggal']?></td>
						<td><?=$item['operator']?></td>
						<td class="<?=$item['status_billing'] == 1 ? 'text-success' : 'text-danger' ?>"><?=$item['status_billing'] == 1 ? 'Success' : 'Failed' ?></td>
					<tr>
				<?php endwhile; ?>
			</table>
		</section>
	</main>
	<script type="text/javascript"> src="../js/bootstrap.min.js"></script>
</body>
</html>