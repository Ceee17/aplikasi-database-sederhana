<?php 
// memulai session
session_start();
//cek jika tidak ada data login maka tendang ke login.php
if( !isset($_SESSION["login"])){
	header("Location: login.php");
	exit;
}


require 'functions.php';

$mahasiswa = query("SELECT * FROM mahasiswa");

//tombol cari ditekan

if( isset($_POST["cari"] ) ){
	$mahasiswa = cari($_POST["keyword"]);
	


}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Halaman Admin</title>

	<style>
		
		.loader{
			width: 100px;
			position: absolute;
			left: 247px;
			display: none;
		}

	</style>

</head>
<body>

<a href="logout.php">Logout</a><br>

<h1>Daftar Mahasiswa</h1>

<a href="tambah.php">Tambah data mahasiswa</a>
<br></br>

<form action="" method="post">
	
	<input type="text" name="keyword" size="30" autofocus placeholder="Masukkan keyword pencarian...." autocomplete="off" id="keyword">
	<button type="submit" name="cari" id="tombol-cari">Cari!</button>

	<img src="img/loader.gif" class="loader">

</form>

<br>
<div id="container">
<table border="1" cellpadding="10" cellspacing="0">
	
<tr>
	<th>No.</th>
	<th>Aksi</th>
	<th>Gambar</th>
	<th>NRP</th>
	<th>Nama</th>
	<th>Email</th>
	<th>Jurusan</th>

</tr>
<?php $i = 1; ?>
<?php foreach( $mahasiswa as $row) : ?>
<tr>
	<td><?php echo $i ?></td>
	<td>
		<a href="ubah.php?id=<?php echo $row[0]; ?>">ubah</a> |
		<a href="hapus.php?id=<?php echo $row[0]; ?>" onclick ="return confirm('yakin?'); ">hapus</a>
	</td>
	<td><img src="img/<?php echo $row[5]; ?>" width="50"></td>
	<td><?php echo $row[1] ?></td>
	<td><?php echo $row[2] ?></td>
	<td><?php echo $row[3] ?></td>
	<td><?php echo $row[4] ?></td>

</tr>
<?php $i++; ?>
<?php endforeach; ?>

</table>
</div>

	 <!-- // pemanggilan script jquery boleh dimana saja, bole diatas bole dibwh -->
	<script src="js/jquery.min.js"></script>
	<script src="js/script.js"></script>

</body>
</html>