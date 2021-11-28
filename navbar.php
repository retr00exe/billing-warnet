<?php
	include_once("is_logged_in.php");
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="/">Dashboard</a>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="/pc/listKompi.php">List PC</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/billing/riwayatBilling.php">Riwayat Billing</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/promo/daftarPromo.php">Promo</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/logout.php">Log Out</a>
				</li>
			</ul>
			<form class="form-inline my-2 my-lg-0">
				<p class="mx-3 mt-2">Halo, <?= $_SESSION['nama'] ?>!</p>
				<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
				<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
			</form>
		</div>
	</nav>