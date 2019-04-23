<?php  include('server.php'); 

// gets record
		if (isset($_GET['edit'])) {
		$ID = $_GET['edit'];
		$update = true;
		$record = mysqli_query($db, "SELECT o.ID, r.name, o.subTotal, o.RA, o.address
						FROM orders o
						INNER JOIN restaurant r ON o.ID = r.OID
						INNER JOIN company c ON o.ID = c.OID
						WHERE ID=$ID");
		$n = mysqli_fetch_array($record);
		$name = $n['name'];
		$price = $n['subTotal'];
		$RA = $n['RA'];
		$address = $n['address'];
		$ID = $n['ID'];
	}

?>
<!DOCTYPE html>
<html>

  <head>
    <title>Del Delivery Drivers</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
<link rel ="stylesheet" type="text/css" href="style.css">
    <style>

	#map {
          height: 400px;  /* The height is 400 pixels */
          width: 75%;  /* The width is the width of the web page */
	}

	.pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }
</style>
</head>

<body>
<?php if (isset($_SESSION['message'])): ?>
	<div class="msg">
		<?php 
			echo $_SESSION['message']; 
			unset($_SESSION['message']);
		?>
	</div>
<?php endif ?>

<center>
<h1 style="color:red;"><b>Welcome to DDD's Database!</b></h1>
<p style="color:red; margin: -30px 10px 10px;">Here you can compare companies to find the best one for you!</p>
<h3 style="border-bottom-style: dotted; margin: 25px 190px 25px;">Select the restaurant you are ordering from</h3>
    	<!--The div element for the map -->
    		<div id="map"></div>
</center>

    	<script>
		// Initialize and add the map
	function initMap() {
  		// The location of Tulsa
  		var tulsa = {lat: 36.042805, lng: -95.888154};
  		// The map, centered at Tulsa
  		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 12, 
			center: tulsa
		});
  		// The marker, positioned at Tulsa
  		var marker = new google.maps.Marker({position: tulsa, map: map});
	}

      var request = {
   	 location: tulsa,
   	 type: ['restaurant']
  	};

 	infowindow = new google.maps.InfoWindow();
 	places = new google.maps.places.PlacesService(map);
	places.nearbySearch(request, callback);

	</script>

	<script async defer
		src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyCFPv2utTeUTL9ST4IGY0RRv7cCJiZHSFM&callback=initMap">
	</script>

	<table>
		<thead>
			<tr>	
				<th>Order ID</th>
				<th>Restaurant Name</th>
				<th>SubTotal</th>
				<th>Distance</th>
				<th>Delivery Fee</th>
				<th>Service Fee</th>
				<th>Tip</th>
				<th>Company Name</th>
				<th>Total Price</th>
				<th colspan="2">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php while ($row = mysqli_fetch_array($result)) { ?>
			<tr>
				<td><?php echo $row['ID']; ?></td>
				<td><?php echo $row['name']; ?></td>
				<td>$<?php echo $row['subTotal']; ?></td>
				<td><?php echo $row['distance']; ?></td>
				<td>$<?php echo $row['dFee']; ?></td>
				<td>$<?php echo $row['sFee']; ?></td>
				<td>$<?php echo $row['tip']; ?></td>
				<td><?php echo $row['CN']; ?></td>
				<td>$<?php echo $row['total']; ?></td>
				<td>
					<a href="index.php?edit=<?php echo $row['ID']; ?>" class="edit_btn">Edit</a>
				</td>
				<td>
					<a href="index.php?del=<?php echo $row['ID']; ?>" class="del_btn">Delete</a>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>

	<form action="server.php" method="post">
	<input type="hidden" name="ID" value="<?php echo $ID; ?>">

		<div class="input-group">
			<label>Restaurant Name</label>
			<input type="text" name="name" value="<?php echo $name; ?>">
		</div>

		<div class="input-group">
			<label>Restaurant Address</label>
			<input type="text" name="RA" value="<?php echo $RA; ?>">
		</div>

		<div class="input-group">
			<label>Your Address</label>
			<input type="text" name="address" value="<?php echo $address; ?>">
		</div>

		<div class="input-group">
			<label>Order Subtotal</label>
			<input type="text" name="price" value="<?php echo $price; ?>">
		</div>

		<div class="input-group">
		<?php if ($update == false): ?>
			<button type="submit" name="compare" class="btn">Compare</button>
		<?php else: ?>
			<button type="submit" name="update" class="btn">Update</button>
		<?php endif ?>
		</div>

	</form>

</body>
</html>