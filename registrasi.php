<?php 

// ------AWAL FUNGSI KONEKSI KE DAN AMBIL DATA DARI DATABASE ------------

// masuk ke database
$conn = mysqli_connect("localhost", "root","12345", "universitas"); //hostname, username, password, databasename

// query database
// function query($query){
// 	global $conn;
// 	$result = mysqli_query($conn, $query);
// 	$rows = [];
// 	while( $row = mysqli_fetch_assoc($result)){
// 		$rows[] = $row;
// 	}
// 	return $rows;
//  }

// ------AKHIR FUNGSI KONEKSI KE DAN AMBIL DATA DARI DATABASE ------------


// -------------- AWAL FUNGSI REGISTRASI ---------------------

function registrasi($data){
	global $conn;

	$username = strtolower(stripslashes($data["username"]));
	$password = mysqli_real_escape_string($conn, $data['password']);
	$konfirmasi = mysqli_real_escape_string($conn, $data['konfirmasi']);

	// cek apakah form username dan password diisi
	if (empty($username) or empty($password)) {
		echo 
		"<script>
			alert('silahkan masukkan username / password');
		</script>";
	return false;
	}


	// cari username didatabase yang sama dengan yang dimasuukan user via form
	$result = mysqli_query($conn, "SELECT username FROM user WHERE username ='$username'");
	
	// cek apakah username sudah ada, jika sudah ada maka echo username sudah terdaftar
	if (mysqli_fetch_assoc($result)) {
		echo 
		"<script>
			alert('username is already registered!');
		</script>";

	// hentikan script
	return false;
	}

	// cek kesesuaian antara masukan password dengan masukan konfirmasi password
	if ($password !== $konfirmasi) {
		echo 
		"<script>
			alert('passwords do no match!');
		</script>";
	return false;
	}

	// enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);

	// jika semua proses diatas sesuai, maka tambahkan userbaru ke database
	mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");
	
	return mysqli_affected_rows($conn);

}
// koneksi dengan database dan fungsi-fungsi lainnya
// require 'functions.php';

// jika button post ditekan
// jika ada data (> 1) yang dikembalikan fungsi registrasi, maka echo berhasil
// jika tidak ada data yang dikembalikan, maka echo error

if (isset($_POST['register'])) {
	if (registrasi($_POST) > 0) {
		echo 
		"<script>
			alert('user baru berhasil ditambahkan');
		</script>";
	} else {
		echo mysqli_error($conn);
	}
}

// -------------- AKHIR FUNGSI REGISTRASI ---------------------

 ?>

 <!---------------- AKHIR HTML FROM ---------------------> 

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1.0">

 	<title>Halaman Registrasi</title>
 	<style>
    body {
        font-family: verdana;
        background-color: #F05454;
        margin: 0;
    }

    header {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: #548CA8;
    }

    h3 {
        margin-left: 10px;
        color: white;
        text-align: center;
    }

    .container {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        padding: 20px 25px;
        width: 300px;
        border-radius: 20px;
        background-color: #F5F5F5;
    }

    .button1 {
        background-color: #4CAF50;
        width: 290px;
        border: none;
        color: white;
        padding: 10px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
		margin-top: 5px;
        margin-left: 4px;
        border-radius: 20px;
        cursor: pointer;
    }
	.button2 {
        background-color: #008CBA;
        width: 290px;
        border: none;
        color: white;
        padding: 10px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
		margin-top: 5px;
        margin-left: 4px;
        border-radius: 20px;
        cursor: pointer;
    }

    input[type=text],
    select {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

	input[type=password],
    select {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

	h2{
		color: #30475E;
		text-align: center;
	}
 	</style>

 </head>
 <body>

	<div class="container">
		<div class="row mt-4 text-center">

		</div>
	</div>
 	

 	<div class="container">
	 <h2>Please Register</h2>
		<div class="row justify-content-center">
		  	<div class="col-md-6">
		  		<form action="" method="post">
		  			<div class="mb-3">
					    <label for="username" class="form-label">Username</label>
					    <input type="text" name="username" class="form-control" id="username">
				  	</div>
				  	<div class="mb-3">
					    <label for="password" class="form-label">Password</label>
					    <input type="password" name="password" class="form-control" id="password">
				 	</div>
				 	<div class="mb-3">
					    <label for="konfirmasi" class="form-label">Konfirmasi Password</label>
					    <input type="password" name="konfirmasi" class="form-control" id="konfirmasi">
				 	</div>
				  	<div class="mb-3 form-check">
					    <input type="checkbox" name="remember" class="form-check-input" id="remember">
					    <label class="form-check-label" for="remember">Remember Me</label>
				  	</div>
				  <button type="submit" name="register" class="button1">Sign Up</button>
				  <a href="login.php"><button type="button" name="login" class="button2">Sign In</button></a>
				</form>
			</div>
		</div>
	</div>

<!---------------- AKHIR HTML FROM ---------------------> 
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
 </body>
 </html>