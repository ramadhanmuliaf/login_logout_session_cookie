<?php 

session_start();

if(!isset($_SESSION['login'])){
	header("Location:login.php");
	exit;
}



// ------AWAL FUNGSI KONEKSI KE DAN AMBIL DATA DARI DATABASE ------------

// masuk ke database
$conn = mysqli_connect("localhost", "root","12345", "universitas"); //hostname, username, password, databasename

// fungsi untuk query database
function query($query){
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while( $row = mysqli_fetch_assoc($result)){
		$rows[] = $row;
	}
	return $rows;
 }


// data diambil dalam bentuk array untuk ditampilkan pada halaman index
$mahasiswa = query("SELECT * FROM mahasiswa ORDER BY id DESC");


// ------AKHIR FUNGSI KONEKSI KE DAN AMBIL DATA DARI DATABASE ------------


 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Halaman List Mahasiswa</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
 	<style>
		 body {
        font-family: verdana;
        background-color: #E7E6E1;
        margin: 0;
    }
	.container{
		padding-top: 30px;
	}
	.button {
        background-color: #F05454;
        width: 100px;
        border: none;
        color: white;
		margin-top: 10px;
        padding: 6px 6px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 10px;
        cursor: pointer;
    }
	 </style>
</head>
<body>

<div class="container">
	<div class="row">
		<div class="col">
		</div>
	</div>
</div>


 <!---------------- AWAL TABEL  ---------------------> 

<div class="container">
	<div class="card">
	  <div class="card-header text-black bg-light">
	    List Mahasiswa
	  </div>
	<div class="card-body" id="container">
		<table class="table table-striped text-center ">
			<tr align="center">
				<th>Id</th>
				<th>Nama</th>
				<th>Email</th>
				<th>Fakultas</th>
				<th>Program Studi</th>
			</tr>


			<?php $i = 1; ?>
			<?php foreach ($mahasiswa as $orang) :
			?>
			<tr>
				<td><?php echo $orang["id"]; ?></td>
				<td><?php echo $orang["nama"]; ?></td>
				<td><?php echo $orang["email"]; ?></td>
				<td><?php echo $orang["fakultas"]; ?></td>
				<td><?php echo $orang["prodi"]; ?></td>
			</tr>
			<?php $i++; ?>
			<?php endforeach; ?>
		</table>
	</div>
</div>

<a href="logout.php"><button type="button" class="button">Logout</button></a>

</div>

<script src="js/jquery-3.6.0.min.js"></script>
<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>
</html>
