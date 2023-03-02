<?php  
// Koneksi ke database
$connection = mysqli_connect("localhost", "root", "", "phpdasar");


function query($query) {
	global $connection;
	$result = mysqli_query($connection, $query);
	$rows = [];
	while( $row = mysqli_fetch_row($result) ) {
		$rows[] = $row;
	}
	return $rows;


}


function tambah($data) {
	global $connection;
	// ambil data dari tiap elemen dalam form
	$nrp =  htmlspecialchars($data["nrp"]);
	$nama = htmlspecialchars($data["nama"]);
	$email = htmlspecialchars($data["email"]);
	$jurusan = htmlspecialchars($data["jurusan"]);

	// upload gambar
	$gambar = upload();
	if( !$gambar ) {
		return false;
	}


	// query insert data
	$query = "INSERT INTO mahasiswa
				VALUES
				('', '$nrp', '$nama', '$email', '$jurusan', '$gambar')
			";
	mysqli_query($connection, $query);
 
	return mysqli_affected_rows($connection);
}

function upload(){


	$namaFile = $_FILES['gambar']['name'];
	$ukuranFile = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpName = $_FILES['gambar']['tmp_name'];


	// cek apakah tidak ada gambar yang diupload
	if( $error === 4 ) {

		echo "<script>
				alert('pilih gambar terlebih dahulu!');
			</script>
			";
	}

	// cek apakah yang diupload adalah gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'gif'];
	$ekstensiGambar = explode('.',$namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if( !in_array($ekstensiGambar, $ekstensiGambarValid) ){

		echo "<script>
				alert('Yang anda upload bukan format gambar !!');
			</script>
			";
	}

	// cek jika ukurannya terlalu besar

	if( $ukuranFile > 10000000){

		echo "<script>
				alert('ukuran gambar terlalu besar !');
			</script>
			";
	}

	// jika lolos ketiga pengecekan, maka gambar siap diupload
	// generate nama gambar baru ( agar foto yang sudah terupload tidak ketimpa )
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;


	move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

	return $namaFileBaru;

}


function hapus($id){
	global $connection;
	mysqli_query($connection, "DELETE FROM mahasiswa WHERE id = $id");

		return mysqli_affected_rows($connection);

}


function ubah($data){
	global $connection;

	// ambil data dari tiap elemen dalam form
	$id = $data["id"];
	$nrp =  htmlspecialchars($data["nrp"]);
	$nama = htmlspecialchars($data["nama"]);
	$email = htmlspecialchars($data["email"]);
	$jurusan = htmlspecialchars($data["jurusan"]);

	$gambarLama = htmlspecialchars($data['gambarLama']);
	// cek apakah user pilih gambar baru atau tidak
	if($_FILES['gambar']['error'] === 4 ){
		$gambar = $gambarLama;
	} else{
		$gambar = upload();
	}

	
	// query insert data
	$query = "UPDATE mahasiswa SET
				nrp = '$nrp',
				nama = '$nama',
				email = '$email',
				jurusan = '$jurusan',
				gambar = '$gambar'
			WHERE id = $id
			";
	mysqli_query($connection, $query);

	return mysqli_affected_rows($connection);

}


function cari($keyword){
	$query = "SELECT * FROM mahasiswa
				WHERE
				nama LIKE '%$keyword%' OR
				nrp LIKE '%$keyword%' OR
				email LIKE '%$keyword%' OR
				jurusan LIKE '%$keyword%' 
				";
	return query($query);
}

function registrasi($data){

	global $connection;

	$username = strtolower(stripslashes($data["username"]));
	$password = mysqli_real_escape_string($connection, $data["password"]);
	$password2 = mysqli_real_escape_string($connection, $data["password2"]);

	// cek username sudah ada atau belum

	$result = mysqli_query($connection, "SELECT username FROM user WHERE username = '$username'");

	if( mysqli_fetch_assoc($result) ){

		echo "<script>
				aler('username yang dipilih sudah terdaftar!');
				</script>";
				return false;
	}


	// cek konfirmasi password 
	if( $password != $password2 ){
		echo "<script>
				alert('konfirmasi password tidak sesuai!!');
				</script>";
			return false;
	} 


	// enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);

	//tambahkan user baru ke database
	mysqli_query($connection, "INSERT INTO user VALUES('', '$username', '$password')");

	return mysqli_affected_rows($connection);





}







?>