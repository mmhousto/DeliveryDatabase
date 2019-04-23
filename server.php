<?php 
include 'get_Distance.php';
	session_start();

	// initialize variables
	$db = mysqli_connect('127.0.0.1', 'root', '', 'database');
	$name = "";
	$price = "";
	$RA = "";
	$address = "";
	$distance = "";
	$Dfee = "";
	$Sfee = "";
	$Dfee1 = "";
	$Sfee1 = "";
	$Dfee2 = "";
	$Sfee2 = "";
	$Dfee3 = "";
	$Sfee3 = "";
	$tip = "";
	$CN = "";
	$CN1 = "Door Dash";
	$CN2 = "Grub Hub";
	$CN3 = "Uber Eats";
	$total = "";
	$total1 = "";
	$total2 = "";
	$total3 = "";
	$ID = 0;
	$update = false;

	
	// if compare button clicked
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

		$query1 = "INSERT INTO orders (RN, RA, subTotal, address, distance, CN, total)
		VALUES ('$name', '$RA', '$price', '$address', '$distance', '$CN1', '$total1'),
		('$name', '$RA', '$price', '$address', '$distance', '$CN2', '$total2'),
		('$name', '$RA', '$price', '$address', '$distance', '$CN3', '$total3')";
		mysqli_multi_query($db, $query1);

		$ID = mysqli_insert_id($db);		
		$queryC1 = "INSERT INTO company (CN, OID, price, tip, sFee)
		VALUES ('$CN1', '$ID', '$price', '$tip', '$Sfee1')";
		mysqli_query($db, $queryC1);

		$queryR1 = "INSERT INTO restaurant (name, address, OID, price, dFee)
		VALUES ('$name', '$RA', '$ID', '$price', '$Dfee1')";
		mysqli_query($db, $queryR1);

		$ID = $ID + 1;	
		$queryC2 = "INSERT INTO company (CN, OID, price, tip, sFee)
		VALUES ('$CN2', '$ID', '$price', '$tip', '$Sfee2')";
		mysqli_query($db, $queryC2);

		$queryR2 = "INSERT INTO restaurant (name, address, OID, price, dFee)
		VALUES ('$name', '$RA', '$ID', '$price', '$Dfee2')";
		mysqli_query($db, $queryR2);

		$ID = $ID + 1;	
		$tip = "0";
		$queryC3 = "INSERT INTO company (CN, OID, price, tip, sFee)
		VALUES ('$CN3', '$ID', '$price', '$tip', '$Sfee3')";
		mysqli_query($db, $queryC3);

		$queryR3 = "INSERT INTO restaurant (name, address, OID, price, dFee)
		VALUES ('$name', '$RA', '$ID', '$price', '$Dfee3')";
		mysqli_query($db, $queryR3);

		$_SESSION['message'] = "Order being compared"; 
		header('location: index.php');
	}

	// update records
	if (isset($_POST['update'])) {
		$name = $_POST['name'];
		$address = $_POST['address'];
		$price = $_POST['price'];
		$RA = $_POST['RA'];
		$ID = $_POST['ID'];
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

		if($CN1 = "Door Dash"){
			$Dfee = $Dfee1;
			$Sfee = $Sfee1;
			$CN = $CN1;
			$total = $total1;
		}else if($CN2 = "Grub Hub"){
			$Dfee = $Dfee2;
			$Sfee = $Sfee2;
			$CN = $CN2;
			$total = $total2;
		}else if($CN3 = "Uber Eats"){
			$Dfee = $Dfee3;
			$Sfee = $Sfee3;
			$CN = $CN3; 
			$total = $total3;
		}	

		mysqli_query($db, "UPDATE o
				SET o.name = '$name', o.subTotal = '$price', distance='$distance', dFee='$Dfee', sFee='$Sfee', tip='$tip', CN='$CN', address='$address', total='$total', RA='$RA'
				From orders o
				INNER JOIN restaurant r ON o.ID = r.OID
				INNER JOIN company c ON o.ID = c.OID
				WHERE ID=$ID");
		$_SESSION['message'] = "Order updated!"; 
		header('location: index.php');
	}

	// retrieve records
	$sql = "SELECT o.ID, r.name, o.subTotal, o.distance, r.dFee, c.sFee, c.tip, o.CN, o.total
		FROM orders o
		INNER JOIN restaurant r ON o.ID = r.OID
		INNER JOIN company c ON o.ID = c.OID
		ORDER BY o.RN";
	$result = mysqli_query($db, $sql);

	// delete records
	if (isset($_GET['del'])) {
	    $ID = $_GET['ID'];
	    mysqli_query($db, "DELETE * FROM orders o
		INNER JOIN restaurant r ON r.OID = o.ID
		INNER JOIN company c ON c.OID = o.ID
		WHERE ID = $ID");
	    $_SESSION['message'] = "Order deleted!"; 
	    header('location: index.php');
	}

?>