<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "tubespw";

// Membuat koneksi ta uyuuuu
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Memeriksa koneksi
if (!$connection) {
    die("Koneksi dengan database gagal: " . mysqli_connect_errno() . " - " . mysqli_connect_error());
}
?>