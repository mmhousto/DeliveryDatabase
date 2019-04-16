<?php 
	session_start();
	$db = mysqli_connect('192.168.0.20', 'root', '', 'database');

	// initialize variables
	$name = "";
	$price = "";
	$Dfee = "";
	$time = "";
	$Sfee = "";
	$Cname = "";
	$total = "";
	$id = 0;
	$update = false;

	if (isset($_POST['save'])) {
		$name = $_POST['name'];
		$price = $_POST['price'];
		$Dfee = $_POST['Dfee'];
		$time = $_POST['time'];
		$Sfee = $_POST['Sfee'];
		$Cname = $_POST['Cname'];
		$total = $_POST['total'];

		$query = "INSERT INTO 'compare' ('Restaurant Name', 'Items Price', 'Delivery Fee', 'Service Fee, 'Time', 'Company Name', 'Total') VALUES ('$name', '$price', '$Dfee', '$Sfee', '$time', '$Cname', '$total')"; 
		mysqli_query($db, $query);
		$_SESSION['message'] = "Address saved"; 
		header('location: index.php');
	}
?>