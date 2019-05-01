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
	$tip1 = "";
	$tip2 = "";
	$tip3 = 0;
	$CN = "";
	$total = "";
	$total1 = "";
	$total2 = "";
	$total3 = "";
	$ID = 0;
	$update = false;

	
	// if submit button clicked
	if (isset($_POST['submit'])) {
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
		}
		if($price < 5.00){
		$Dfee2 = $Dfee2 + 2.00;
		}	

		$tip1 = ($price + $Sfee1) * .20;
		$tip2 = ($price + $Dfee2 + $Sfee2) * .20;
	
		$total1 = $price + $tip1 + $Dfee1 + $Sfee1;
		$total2 = $price + $tip2 + $Dfee2 + $Sfee2;
		$total3 = $price + $Dfee3 + $Sfee3;

$query1 = "INSERT INTO orders (subTotal, address, distance, total)
		VALUES ('$price', '$address', '$distance', '$total1'),
		('$price', '$address', '$distance', '$total2'),
		('$price', '$address', '$distance', '$total3')";
		mysqli_query($db, $query1);
		
		$ID = mysqli_insert_id($db);
		$queryC1 = "INSERT INTO company (CN, OID, tip, sFee)
		VALUES ('Door Dash', '$ID', '$tip1', '$Sfee1')";
		mysqli_query($db, $queryC1);
		$queryR1 = "INSERT INTO restaurant (name, RA, OID, dFee)
		VALUES ('$name', '$RA', '$ID', '$Dfee1')";
		mysqli_query($db, $queryR1);
		$ID = $ID + 1;
		$queryC2 = "INSERT INTO company (CN, OID, tip, sFee)
		VALUES ('Grub Hub', '$ID', '$tip2', '$Sfee2')";
		mysqli_query($db, $queryC2);
		$queryR2 = "INSERT INTO restaurant (name, RA, OID, dFee)
		VALUES ('$name', '$RA', '$ID', '$Dfee2')";
		mysqli_query($db, $queryR2);
		$ID = $ID + 1;
		$queryC3 = "INSERT INTO company (CN, OID, tip, sFee)
		VALUES ('Uber Eats', '$ID', '$tip3', '$Sfee3')";
		mysqli_query($db, $queryC3);
		$queryR3 = "INSERT INTO restaurant (name, RA, OID, dFee)
		VALUES ('$name', '$RA', '$ID', '$Dfee3')";
		mysqli_query($db, $queryR3);

		$_SESSION['message'] = "Order submitted!"; 
		header('location: index.php');
	}

	// update records
	if (isset($_POST['update'])) {
		$name = $_POST['name'];
		$address = $_POST['address'];
		$price = $_POST['price'];
		$RA = $_POST['RA'];
		$ID = $_POST['ID'];
		$record1 = mysqli_query($db, "SELECT c.CN
				FROM orders o
				INNER JOIN restaurant r ON o.ID = r.OID
				INNER JOIN company c ON o.ID = c.OID
				WHERE ID=$ID");
		$n = mysqli_fetch_array($record1);
		$CN = $n['CN'];
		$addressFrom = $address;
		$addressTo = $RA;
		$distance = getDistance($addressFrom, $addressTo, "");

		if($CN == 'Door Dash'){
			$Sfee = $price * .08517 + $price * .10;
			if($distance > 7.00) {
			$Dfee = $Dfee + .50 * $distance;
			}
			if($price < 10.00){
				$Sfee = $Sfee + 2.00;
			}
			$tip = ($price + $Sfee) * .20;
			$total = $price + $tip + $Dfee + $Sfee;
		} else if($CN == 'Grub Hub') {
			$Sfee = $price * .08517 + $price * .0805 + $distance * .50;
			if($price <5.00){
				$Dfee = $Dfee + 2.00;
			}
			$tip = ($price + $Dfee + $Sfee) * .20;
			$total = $price + $tip + $Dfee + $Sfee;
		} else if($CN == 'Uber Eats') {
		$Dfee = 3.49 + $distance * .50;
		$Sfee = $price * .08517 + $price * .15;
			if($price < 10.00){
				$Sfee = $Sfee + 2.00;
			}
		$tip = 0;
		$total = $price + $Dfee + $Sfee;
		}

		$update1 = "UPDATE orders
		SET subTotal = '$price', distance='$distance',  address='$address', total='$total'
		WHERE ID = '$ID'";
		mysqli_query($db, $update1);
		
		$updateC1 = "UPDATE company
		SET CN='$CN', tip='$tip', sFee='$Sfee'
		WHERE OID='$ID'";
		mysqli_query($db, $updateC1);

		$updateR1 = "UPDATE restaurant
		SET name='$name', RA='$RA', dFee='$Dfee'
		WHERE OID='$ID'";
		mysqli_query($db, $updateR1);

		$_SESSION['message'] = "Order updated!"; 
		header('location: index.php');
	}

	// retrieve records
	$sql = "SELECT o.ID, r.name, o.subTotal, o.distance, r.dFee, c.sFee, c.tip, c.CN, o.total
		FROM orders o
		INNER JOIN restaurant r ON o.ID = r.OID
		INNER JOIN company c ON o.ID = c.OID
		ORDER BY o.ID";
	$result = mysqli_query($db, $sql);

	// delete records
	if (isset($_GET['del'])) {
	    $ID = $_GET['del'];

	    mysqli_query($db, "DELETE FROM orders
		WHERE ID = '$ID'");
	    mysqli_query($db, "DELETE FROM company
		WHERE OID = '$ID'");
	    mysqli_query($db, "DELETE FROM restaurant
		WHERE OID = '$ID'");

	    $_SESSION['message'] = "Order deleted!"; 
	    header('location: index.php');
	}

if (isset($_POST['compare'])) {
    $dd = "SELECT AVG(o.total) AS ddavg
    FROM orders o
    INNER JOIN restaurant r ON o.ID = r.OID
    INNER JOIN company c ON o.ID = c.OID
    WHERE c.CN = 'Door Dash'";
    $ddavg = mysqli_query($db, $dd);
    $row1 = mysqli_fetch_assoc($ddavg);
    $DDAvg = $row1['ddavg'];
    $gh = "SELECT AVG(o.total) AS ghavg
    FROM orders o
    INNER JOIN restaurant r ON o.ID = r.OID
    INNER JOIN company c ON o.ID = c.OID
    WHERE c.CN = 'Grub Hub'";
    $ghavg = mysqli_query($db, $gh);
    $row2 = mysqli_fetch_assoc($ghavg);
    $GHAvg = $row2['ghavg'];
    $ue = "SELECT AVG(o.total) AS ueavg
    FROM orders o
    INNER JOIN restaurant r ON o.ID = r.OID
    INNER JOIN company c ON o.ID = c.OID
    WHERE c.CN = 'Uber Eats'";
    $ueavg = mysqli_query($db, $ue);
    $row3 = mysqli_fetch_assoc($ueavg);
    $UEAvg = $row3['ueavg'];

    if($DDAvg < $GHAvg AND $DDAvg < $UEAvg) {
    	$_SESSION['message'] = "Door Dash is usually cheapest for you!"; 
    	header('location: index.php');
    }else if ($GHAvg < $DDAvg AND $GHAvg < $UEAvg) {
   	 	$_SESSION['message'] = "Grub Hub is usually cheapest for you!"; 
    	header('location: index.php');
    }else if ($UEAvg < $DDAvg AND $UEAvg < $GHAvg) {
    	$_SESSION['message'] = "Uber Eats is usually cheapest for you!"; 
    	header('location: index.php');    
    }
}

?>