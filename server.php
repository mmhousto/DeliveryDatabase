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
	$Dfee1 = "";
	$Sfee1 = "";
	$Dfee2 = "";
	$Sfee2 = "";
	$Dfee3 = "";
	$Sfee3 = "";
	$tip1 = "";
	$tip2 = "";
	$tip3 = 0;
	$CN1 = "Door Dash";
	$CN2 = "Grub Hub";
	$CN3 = "Uber Eats";
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
		$Sfee1 = $price * .08517 + $price * .10;
		$Dfee3 = 3.49 + $distance * .50;
		$Sfee2 = $price * .08517 + $price * .0805 + $distance * .50;
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

		$tip1 = ($price + $Sfee1) * .20;
		$tip2 = ($price + $Dfee2 + $Sfee2) * .20;
	
		$total1 = $price + $tip1 + $Dfee1 + $Sfee1;
		$total2 = $price + $tip2 + $Dfee2 + $Sfee2;
		$total3 = $price + $Dfee3 + $Sfee3;

		$query1 = "INSERT INTO orders (RN, RA, subTotal, address, distance, CN, total)
		VALUES ('$name', '$RA', '$price', '$address', '$distance', '$CN1', '$total1'),
		('$name', '$RA', '$price', '$address', '$distance', '$CN2', '$total2'),
		('$name', '$RA', '$price', '$address', '$distance', '$CN3', '$total3')";
		mysqli_query($db, $query1);
		
		$ID = mysqli_insert_id($db);
		$queryC1 = "INSERT INTO company (CN, OID, price, tip, sFee)
		VALUES ('$CN1', '$ID', '$price', '$tip1', '$Sfee1')";
		mysqli_query($db, $queryC1);

		$queryR1 = "INSERT INTO restaurant (name, address, OID, price, dFee)
		VALUES ('$name', '$RA', '$ID', '$price', '$Dfee1')";
		mysqli_query($db, $queryR1);

		$ID = $ID + 1;
		$queryC2 = "INSERT INTO company (CN, OID, price, tip, sFee)
		VALUES ('$CN2', '$ID', '$price', '$tip2', '$Sfee2')";
		mysqli_query($db, $queryC2);

		$queryR2 = "INSERT INTO restaurant (name, address, OID, price, dFee)
		VALUES ('$name', '$RA', '$ID', '$price', '$Dfee2')";
		mysqli_query($db, $queryR2);

		$ID = $ID + 1;
		$queryC3 = "INSERT INTO company (CN, OID, price, tip, sFee)
		VALUES ('$CN3', '$ID', '$price', '$tip3', '$Sfee3')";
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
		$Sfee1 = $price * .08517 + $price * .10;
		$Dfee3 = 3.49 + $distance * .50;
		$Sfee2 = $price * .08517 + $price * .0805 + $distance * .50;
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

		$tip1 = ($price + $Sfee1) * .20;
		$tip2 = ($price + $Dfee2 + $Sfee2) * .20;

		$total1 = $price + $tip1 + $Dfee1 + $Sfee1;
		$total2 = $price + $tip2 + $Dfee2 + $Sfee2;
		$total3 = $price + $Dfee3 + $Sfee3;

		$update1 = "UPDATE orders
		SET RN = '$name', subTotal = '$price', distance='$distance', CN='$CN1', address='$address', total='$total1', RA='$RA'
		WHERE CN='$CN1'";
		mysqli_query($db, $update1);

		$update2 = "UPDATE orders
		SET RN = '$name', subTotal = '$price', distance='$distance', CN='$CN2', address='$address', total='$total2', RA='$RA'
		WHERE CN='$CN2'";
		mysqli_query($db, $update2);

		$update3 = "UPDATE orders
		SET RN = '$name', subTotal = '$price', distance='$distance', CN='$CN3', address='$address', total='$total3', RA='$RA'
		WHERE CN='$CN3'";
		mysqli_query($db, $update3);
		
		$updateC1 = "UPDATE company
		SET CN='$CN1', price='$price', tip='$tip1', sFee='$Sfee1'
		WHERE CN='$CN1'";
		mysqli_query($db, $updateC1);

		$updateR1 = "UPDATE restaurant
		SET name='$name', address='$RA', price='$price', dFee='$Dfee1'
		WHERE dFee='$Dfee1'";
		mysqli_query($db, $updateR1);

		$updateC2 = "UPDATE company
		SET CN='$CN2', price='$price', tip='$tip2', sFee='$Sfee2'
		WHERE CN='$CN2'";
		mysqli_query($db, $updateC2);

		$updateR2 = "UPDATE restaurant 
		SET name='$name', address='$RA', price='$price', dFee='$Dfee2'
		WHERE dFee='$Dfee2'";
		mysqli_query($db, $updateR2);

		$updateC3 = "UPDATE company
		SET CN='$CN3', price='$price', tip='$tip3', sFee='$Sfee3'
		WHERE CN='$CN3'";
		mysqli_query($db, $updateC3);

		$updateR3 = "UPDATE restaurant
		SET name='$name', address='$RA', price='$price', dFee='$Dfee3'
		WHERE dFee='$Dfee3'";
		mysqli_query($db, $updateR3);

		$_SESSION['message'] = "Order updated!"; 
		header('location: index.php');
	}

	// retrieve records
	$sql = "SELECT o.ID, r.name, o.subTotal, o.distance, r.dFee, c.sFee, c.tip, o.CN, o.total
		FROM orders o
		JOIN restaurant r ON o.ID = r.OID
		JOIN company c ON o.ID = c.OID
		ORDER BY o.ID";
	$result = mysqli_query($db, $sql);

	// delete records
	if (isset($_GET['del'])) {
	    $ID = $_GET['ID'];
	    mysqli_query($db, "DELETE * FROM orders
		WHERE ID = $ID");
	    $_SESSION['message'] = "Order deleted!"; 
	    header('location: index.php');
	}

?>