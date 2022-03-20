<?php 

session_start();

// ------AWAL FUNGSI KONEKSI KE DAN AMBIL DATA DARI DATABASE ------------

// masuk ke database - urutan parameter hostname, username, password, databasename
$conn = mysqli_connect("localhost", "root","12345", "universitas"); 


// ------AKHIR FUNGSI KONEKSI KE DAN AMBIL DATA DARI DATABASE ------------

#2
// cek cookie berdasarkan id dan username
if (isset($_COOKIE['info']) && isset($_COOKIE['key'])){

	$id = $_COOKIE['info'];
	$key = $_COOKIE['username'];

	// ambil username dari database berdasarkan id
	$result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");

	// username berbentuk array associative
	$row = mysqli_fetch_assoc($result);

	// jika cookie username masukan yang sudah diacak sama dengan username dari database setelah di enkripsi, maka buat session (bernama login) 
	if ($key === hash('sha224', $row['username']) ){
		$_SESSION['login'] = true;
	}

}

// jika session login sudah true, maka arahkan ke halaman index.php
if (isset($_SESSION["login"])) {
	header("Location:index.php");
	exit;

}

#1
/* jika tombol sign in ditekan, 
tangkap data username dan password yang disubmit via method post
*/
if (isset($_POST["login"])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	// cari di database, adakah username yang didalam database yang sama dengan diinputkan via HTML form
	$result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

	// var_dump(mysqli_fetch_assoc($result));
	// die();


	//jika ada username yang dikembalikan
	if (mysqli_num_rows($result) === 1) {

		// ambil semua data user yang pernah registrasi per kolom (i.e., username, password, id) dari database berdasarkan query dan simpan dalam variabel $row (array associative) 
		$row = mysqli_fetch_assoc($result);

		// jika password hash yang didatabase apakah sama dengan password yang dimasukkan user, maka buat session login
		if (password_verify($password, $row["password"])){
			$_SESSION['login'] = true;

			// tambah pengecekan apakah checkbox remember me dicentang?
			if (isset($_POST['remember'])){
				//buat cookie berdasarkan 
				setcookie('info', $row['id']);
				setcookie('key', hash('sha224', $row['username']));
			}

			header("Location: index.php");
			exit;
		}

	}
	$error = true;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Halaman Login</title>
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
	

	<?php if (isset($error)) : ?>
		<p style="color:white; padding-top: 8%; text-align: center;">Username atau Password Salah!</p>
	<?php endif; ?>


 <!---------------- AWAL HTML FROM ---------------------> 

	<div class="container">
	<h2>Silahkan Sign In</h2>
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
				  	<div class="mb-3 form-check">
					    <input type="checkbox" name="remember" class="form-check-input" id="remember">
					    <label class="form-check-label" for="remember">Remember Me</label>
				  	</div>
				  <button type="submit" name="login" class="button1">Sign In</button>
				  <a href="registrasi.php"><button type="button" name="register" class="button2">Sign Up</button></a>
				</form>
			</div>
		</div>
	</div>

 <!---------------- AKHIR HTML FROM ---------------------> 

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>
</html>