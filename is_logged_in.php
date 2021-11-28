<?php

session_start();

if (!isset($_SESSION['nama'])) {
   header("Location:/login.php");
}

if (!isset($_SESSION['login'])) {
   header("Location:/login.php");
}

if (!isset($_SESSION['id_operator'])) {
   header("Location:/login.php");
}

?>