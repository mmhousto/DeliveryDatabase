<?php  include('server.php'); ?>
<!DOCTYPE html>
<html>

<head>
<title>Del Delivery Drivers</title>
<link rel ="stylesheet" type="text/css" href="style.css">
<style>
 #map {
        height: 400px;  /* The height is 400 pixels */
        width: 75%;  /* The width is the width of the web page */
       }
body {
	
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
<p style="color:red;">Here you can compare companies to find the best one for you!</p>
<h3>Select the Restuarant you are ordering from</h3>
    	<!--The div element for the map -->
    		<div id="map"></div>
</center>

    	<script>
		// Initialize and add the map
	function initMap() {
  		// The location of Uluru
  		var tulsa = {lat: 36.042805, lng: -95.888154};
  		// The map, centered at Tulsa
  		var map = new google.maps.Map(document.getElementById('map'), {
			zoom: 4, 
			center: tulsa
		});
  		// The marker, positioned at Tulsa
  		var marker = new google.maps.Marker({position: tulsa, map: map});
	}
	</script>

	<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJUpM9g_PozdAc_G4PW9_C4Y2L87JYsrs&callback=initMap">
	</script>

	<form action="server.php" method="post">
		<div class="input-group">
			<label>Restuarant Name</label>
			<input type="text" name="name">
		</div>
		<div class="input-group">
			<label>Restuarant Address</label>
			<input type="text" name="raddress">
		</div>
		<div class="input-group">
			<label>Your Address</label>
			<input type="text" name="address">
		</div>
		<div class="input-group">
			<label>Order Subtotal</label>
			<input type="text" name="price">
		</div>
		<div class="input-group">
			<button type="submit" name="save" class="btn">Save</button>
		</div>
	</form>

	<table>
		<thead>
			<tr>
				<th>Restuarnt Name</th>
				<th>Items Price</th>
				<th>Delivery Fee</th>
				<th>Service Fee</th>
				<th>Tip</th>
				<th>Est. Time</th>
				<th>Company Name</th>
				<th>Total Price</th>
				<th colspan="2">Action</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>On the Border</td>
				<td>$15.39</td>
				<td>Free</td>
				<td>$1.06</td>
				<td>$1.06</td>
				<td>20 - 25 minutes</td>
				<td>DoorDash</td>
				<td>$17.51</td>
				<td>
					<a href="#">Edit</a>
				</td>
				<td>
					<a href="#">Delete</a>
				</td>
			</tr>
		</tbody>
	</table>

</body>
</html>