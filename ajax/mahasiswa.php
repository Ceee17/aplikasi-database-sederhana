<?php 
require '../functions.php';
$keyword = $_GET["keyword"];
$query = "SELECT * FROM mahasiswa
				WHERE
				nama LIKE '%$keyword%' OR
				nrp LIKE '%$keyword%' OR
				email LIKE '%$keyword%' OR
				jurusan LIKE '%$keyword%' 
				";
$mahasiswa = query($query);
?>

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