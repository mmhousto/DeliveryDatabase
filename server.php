<?php 
	session_start();
	$db = mysqli_connect('127.0.0.1', 'root', '', 'database');

	// initialize variables
	$name = "";
	$price = "";
	$RA = "";
	$address = "";
	$Dfee = "";
	$Sfee = "";
	$tip = "price * .20";
	$Cname = "";
	$total = "price + tip + Dfee + Sfee";
	$id = 0;
	$update = false;

	if (isset($_POST['compare'])) {
		$name = $_POST['name'];
		$price = $_POST['price'];
		$RA = $_POST['RA'];
		$address = $_POST['address'];

		$query = "INSERT INTO orders (RN, RA, subTotal, address) VALUES ('$name', '$RA', '$price', '$address')"; 
		mysqli_query($db, $query);
		$_SESSION['message'] = "Address saved"; 
		header('location: index.php');
	}
?>