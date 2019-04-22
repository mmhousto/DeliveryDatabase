<?php 
include 'get_Distance.php';
	session_start();
	$db = mysqli_connect('127.0.0.1', 'root', '', 'database');

	// initialize variables
	$name = "";
	$price = "";
	$RA = "";
	$address = "";
	$distance = "";
	$Dfee1 = "";
	$Sfee1 = "";
	$Dfee2 = "";
	$Sfee2 = "";
	$Dfee3 = "";
	$Sfee3 = "";
	$tip = "";
	$CN1 = "Door Dash";
	$CN2 = "Grub Hub";
	$CN3 = "Uber Eats";
	$total1 = "";
	$total2 = "";
	$total3 = "";
	$id = "";
	$update = false;

	

	if (isset($_POST['compare'])) {
		$name = $_POST['name'];
		$price = $_POST['price'];
		$RA = $_POST['RA'];
		$address = $_POST['address'];
		$addressFrom = $address;
		$addressTo = $RA;
		$distance = getDistance($addressFrom, $addressTo, "");
		$tip = $price * .20;
		$Sfee1 = $price * .08517 + $price * .10;
		$Dfee3 = $Dfee3 + .50 * $distance;
		$Sfee2 = $price * .08517 + $price * .1305 + $distance * .50;
		$Sfee3 = $price * .08517 + $price * .15;

		if($distance > 7.00) {
			$Dfee1 = $Dfee1 + .50 * $distance;
			$Dfee2 = $Dfee2 + .50 * $distance;
		}

		if($price < 10.00){
		$Sfee1 = $Sfee1 + 2.00;
		$Sfee3 = $Sfee3 + 2.00;
		} else if($price <5.00){
		$Dfee2 = $Dfee2 + 2.00;
		}	
	
		$total1 = $price + $tip + $Dfee1 + $Sfee1;
		$total2 = $price + $tip + $Dfee2 + $Sfee2;
		$total3 = $price + $Dfee3 + $Sfee3;

		$query1 = "INSERT INTO orders (RN, RA, subTotal, address, CN, total)
		VALUES ('$name', '$RA', '$price', '$address', '$CN1', '$total1'),
		('$name', '$RA', '$price', '$address', '$CN2', '$total2'),
		('$name', '$RA', '$price', '$address', '$CN3', '$total3')";
		mysqli_multi_query($db, $query1);

		$id = mysqli_insert_id($db);		
		$queryC1 = "INSERT INTO company (CN, OID, price, tip, sFee)
		VALUES ('$CN1', '$id', '$price', '$tip', '$Sfee1')";
		mysqli_multi_query($db, $queryC1);

		$queryR1 = "INSERT INTO restaurant (name, address, OID, price, dFee)
		VALUES ('$name', '$RA', '$id', '$price', '$Dfee1')";
		mysqli_multi_query($db, $queryR1);

		$id = $id + 1;	
		$queryC2 = "INSERT INTO company (CN, OID, price, tip, sFee)
		VALUES ('$CN2', '$id', '$price', '$tip', '$Sfee2')";
		mysqli_multi_query($db, $queryC2);

		$queryR2 = "INSERT INTO restaurant (name, address, OID, price, dFee)
		VALUES ('$name', '$RA', '$id', '$price', '$Dfee2')";
		mysqli_multi_query($db, $queryR2);

		$id = $id + 1;	
		$tip = "0";
		$queryC3 = "INSERT INTO company (CN, OID, price, tip, sFee)
		VALUES ('$CN3', '$id', '$price', '$tip', '$Sfee3')";
		mysqli_multi_query($db, $queryC3);

		$queryR3 = "INSERT INTO restaurant (name, address, OID, price, dFee)
		VALUES ('$name', '$RA', '$id', '$price', '$Dfee3')";
		mysqli_multi_query($db, $queryR3);

		$_SESSION['message'] = "Order being compared"; 
		header('location: index.php');
	}
?>