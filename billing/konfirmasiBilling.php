<?php
	include_once("../is_logged_in.php");
	include_once("../config.php");

	// error_reporting(0);

	if(isset($_POST['submit'])){
		try{
			$billing = mysqli_query($conn, "SELECT * FROM billing WHERE id_billing = '$_GET[bill_id]'");
			$data_billing = mysqli_fetch_array($billing);

			$waktu = $data_billing['waktu'];
			$id_member = $data_billing['id_user'];

			$member = mysqli_query($conn, "SELECT * FROM member WHERE id_member = '$id_member'");
			$data_member = mysqli_fetch_array($member);
			
			$waktu_before = $data_member['waktu'];
			$waktu_total = $waktu_before + $waktu;
			
			$edit = mysqli_query($conn, 
				"UPDATE member SET
					waktu = '$waktu_total'
					WHERE id_member = '$id_member'
				"
			);

			if($edit){
				$ubah_status_pc = mysqli_query($conn, 
					"UPDATE pc SET
						user_id = '$id_member'
					WHERE id_pc = '$_POST[pc]'
					"
				);

				$ubah_status_billing = mysqli_query($conn, 
					"UPDATE billing SET
						status_billing = 1
					WHERE id_billing = '$_GET[bill_id]'
					"
				);
				if($ubah_status_billing){
					echo
					"<script>
						alert('Penambahan billing success!');
					</script>";
					header("Location:/");
				} else {
					echo
					"<script>
						alert('Penambahan billing gagal!');
					</script>";
				}
			} else {
				echo
				"<script>
					alert('Failed!');
				</script>";
			}
		} catch (Exception $e) {
			echo $e->getMessage();
			die();
		}
	}

	if(isset($_GET['bill_id'])){
		$billing = mysqli_query($conn, "SELECT * FROM billing WHERE id_billing = '$_GET[bill_id]'");
		$data_billing = mysqli_fetch_array($billing);

		$waktu = $data_billing['waktu'];
		$res_harga = mysqli_query($conn, "SELECT * FROM harga WHERE waktu = '$waktu'");
		$data_harga = mysqli_fetch_array($res_harga);
		$harga = $data_harga['harga'];

		$diskon = $data_billing['diskon'];
		$subtotal = ((100 - $diskon) / 100) * $harga;

		$ubah_status_harga = mysqli_query($conn, 
			"UPDATE billing SET
				harga = '$harga'
			WHERE id_billing = '$_GET[bill_id]'
			"
		);

		$detail_member = mysqli_query($conn, "SELECT
			m.nama, p.tier
			FROM member AS m 
			INNER JOIN promo AS p 
			ON 
			m.id_promo = p.id_promo
			WHERE
			m.id_member =$data_billing[id_user]
		");
		$data_array_member = mysqli_fetch_array($detail_member);

		$nama_pelanggan = $data_array_member['nama'];
		$member_pelanggan = $data_array_member['tier'];
	}

	$komputer = mysqli_query($conn, "SELECT * FROM pc");

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<title>Tambah Billing</title>
</head>
<body>
	<?php include('../navbar.php') ?>
	<main class="mx-5">
		<section>
			<div class="card mt-5">
				<div class="card-header bg-primary text-white">Buat billing baru</div>
				<div class="card-body">
					<form method="post" action="">
						<div class="form-group">
							<label for="price">Harga</label>
							<input type="text" name="price" class="form-control" id="price" value="<?=@$harga?>" disabled>
						</div>
						<div class="form-group">
							<label for="diskon">Diskon</label>
							<input type="text" name="diskon" class="form-control" id="diskon" value="<?=@$diskon?>" disabled>
						</div>
						<div class="form-group">
							<label for="subtotal">Subtotal</label>
							<input type="text" name="subtotal" class="form-control" id="subtotal" value="<?=@$subtotal?>" disabled>
						</div>
						<p>Pilih PC:</p>
						<select class="form-select mb-3" name="pc" aria-label="Default select example">
							<option selected>Komputer</option>
							<?php
								while($pc = mysqli_fetch_array($komputer)) :
							?>
							<?php if($pc['user_id'] == NULL && $pc['status'] == 1): ?>
								<option value="<?= $pc['id_pc'] ?>"><?= $pc['nomor'] ?> (<?= $pc['spesifikasi']?>)</option>
							<?php else: ?>
								<option disabled value="<?= $pc['id_pc'] ?>"><?= $pc['nomor'] ?> (<?= $pc['spesifikasi']?>)</option>
							<?php endif; ?>
							<?php endwhile; ?>
						</select>
						<div class="form-group">
							<label for="operator">Operator</label>
							<input type="text" name="operator" class="form-control" value="<?= $_SESSION['nama']?>" id="operator" disabled placeholder="Operator">
						</div>
						<div class="form-group">
							<label for="tanggal">Tanggal</label>
							<input type="text" name="tanggal" class="form-control" value="<?= date("Y/m/d") ?>" id="tanggal" disabled placeholder="Tanggal">
						</div>
						<h4>Atas nama: <?= $nama_pelanggan?></h4>
						<p>Jenis member: <?= $member_pelanggan?></p>
						<p class="text-danger">Bill: Rp.<?= @$harga?></p>
						<p class="text-success">Diskon: <?=@$diskon?>%</p>
						<p>Total harga: Rp.<?=@$subtotal?></p>
						<button type="submit" class="btn btn-primary" name="submit">Konfirmasi</button>
						<button type="reset" class="btn btn-danger text-white" name="reset">Reset</button>
					</form>
				</div>
			</div>
		</section>
	<script type="text/javascript" src="../js/bootstrap.min.js"></script>
</body>
</html>