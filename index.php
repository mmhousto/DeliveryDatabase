<?php  include('server.php'); 

// gets record
		if (isset($_GET['edit'])) {
		$ID = $_GET['edit'];
    $total = $_GET['edit'];
		$update = true;
		$record = mysqli_query($db, "SELECT o.ID, r.name, o.subTotal, r.RA, o.address
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- Latest compiled JavaScript -->

    <style>
	    #map {
          height: 400px;  /* The height is 400 pixels */
          width: 75%;  /* The width is the width of the web page */
	    }
      #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }
      #infowindow-content .title {
        font-weight: bold;
      }
      #infowindow-content {
        display: none;
      }
      #map #infowindow-content {
        display: inline;
      }
      table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
      }
      tr:hover {
        background: #0066ff;
      }
      body {
        background-color: #ffff66;
      }
    </style>

    <style>
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
      #type-selector {
	      width: 401px;
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }
      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
      .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }
#locationField, #controls {
        position: relative;
        width: 480px;
      }
      #autocomplete {
        position: absolute;
        top: 0px;
        left: 0px;
        width: 99%;
      }
      .label {
        text-align: right;
        font-weight: bold;
        width: 100px;
        color: #303030;
        font-family: "Roboto";
      }
      #address {
        border: 1px solid #000090;
        background-color: #f0f9ff;
        width: 480px;
        padding-right: 2px;
      }
      #address td {
        font-size: 10pt;
      }
      .field {
        width: 99%;
      }
      .slimField {
        width: 80px;
      }
      .wideField {
        width: 200px;
      }
      #locationField {
        height: 20px;
        margin-bottom: 2px;
      }
      #cbtn { 
        display: flex; 
        justify-content: center; 
      }
      #cform {
        width: 125px;
        height: 32px;
        background: transparent;
        border: none;
      }
      .btn {
         padding: 10px;
         font-size: 16px;
         color: white;
         background: #0066ff;
         border: none;
         border-radius: 5px;
      }
      .cbtn {
        margin-top: -26px;
        font-size: 32px;
        padding: 12px;
        color: white;
        background: #0066ff;
        border: none;
        border-radius: 16px;
      }

.input-group {
    margin: 10px 0px 10px 0px;
}
.input-group label {
    display: block;
    text-align: left;
    margin: 3px;
}
.input-group input {
    height: 30px;
    width: 93%;
    padding: 5px 10px;
    font-size: 16px;
    border-radius: 5px;
    border: 1px solid gray;
}

.edit_btn {
    text-decoration: none;
    padding: 2px 5px;
    background: #2E8B57;
    color: white;
    border-radius: 3px;
}

.del_btn {
    text-decoration: none;
    padding: 2px 5px;
    color: white;
    border-radius: 3px;
    background: #800000;
}

.msg {
    margin: 30px auto; 
    padding: 10px; 
    border-radius: 5px; 
    color: #3c763d; 
    background: #dff0d8; 
    border: 1px solid #3c763d;
    width: 50%;
    text-align: center;
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
<h1 style="color:black;"><b><font size="+7">Welcome to DDD's Database!</font></b></h1>
<p style="color:black; margin: -30px 10px 10px;"><font size="+2">Here you can compare companies to find the best one for you!</font></p>
<h3 style="border-bottom-style: dotted; margin: 25px 190px 25px;"><font size="+2">Use the map to find restaurants and their addresses</font></h3>

<input id="pac-input" class="controls" type="text" placeholder="Enter a Restaurant">
<div id="map"></div>
    <div id="infowindow-content">
      <img id="place-icon" src="" height="16" width="16">
      <span id="place-name"  class="title"></span><br>
      <span id="place-address"></span>
    </div>

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

      sA(map);
      setMarkers(map);


	   var clickHandler = new ClickEventHandler(map, tulsa);
}
//=================================================================================//
//search box creates markers for restaurant
 	// Create the search box and link it to the UI element.
function setMarkers(map) {
        var infowindow = new google.maps.InfoWindow();
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
          for (let i = 0; i < places.length; i++) {
            let marker = new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            });

            marker.addListener('click', (function(marker, i) {
              return function() {
                var RN = document.getElementById('RN');         
                var RA = document.getElementById('RA');
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({ 'latLng': marker.getPosition() }, function (results, status) {
                 if (status == google.maps.GeocoderStatus.OK) {
                      if (results[1]) {
                          var Raddress = results[1].formatted_address;
                         RA.value = Raddress;
                      }
                  }
                });
                RN.value = marker.title;
                infowindow.setContent('Name: ' + marker.title + '<br>Address: ' + RA.value);
                infowindow.open(map, marker);
              }
            })(marker, i));
            bounds.extend(marker.getPosition());
            markers.push(marker);
          }


            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
}

function sA(map) {
        var infoWindow = new google.maps.InfoWindow();
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var YA = document.getElementById('address');
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': pos }, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[1]) {
                            var Yaddress = results[1].formatted_address;
                            YA.value = Yaddress;
                        }
                    }
                });

            var marker = new google.maps.Marker({position: pos, map: map});
            marker.addListener('click', function() {
              map.setZoom(14);
              map.setCenter(marker.getPosition());
            });
            infoWindow.setPosition(pos);
            infoWindow.setContent('Your Location');
            infoWindow.open(map);
            map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }

}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
}
//===============================================================================================//
//autocomplete restaurant search

//===========================================================================================//


	</script>

	<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFPv2utTeUTL9ST4IGY0RRv7cCJiZHSFM&libraries=places&callback=initMap">
	</script>

	<table id="myTable2">
		<thead>
			<tr>	
				<th onclick="sortTable(0)">Order ID</th>
				<th onclick="sortTable(1)">Restaurant Name</th>
				<th onclick="sortTable(2)">SubTotal</th>
				<th onclick="sortTable(3)">Distance</th>
				<th onclick="sortTable(4)">Delivery Fee</th>
				<th onclick="sortTable(5)">Service Fee</th>
				<th onclick="sortTable(6)">Tip</th>
				<th onclick="sortTable(7)">Company Name</th>
				<th onclick="sortTable(8)">Total Price</th>
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
					<a class="edit_btn" href="index.php?edit=<?php echo $row['ID']; ?>">Edit</a>
				</td>
				<td>
					<a class="del_btn" href="server.php?del=<?php echo $row['ID']; ?>">Delete</a>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>

<script>

function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable2");
  switching = true;
  // Set the sorting direction to ascending:
  dir = "asc"; 
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /* Check if the two rows should switch place,
      based on the direction, asc or desc: */
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++; 
    } else {
      /* If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}
</script>

	<form action="server.php" method="post">
	<input type="hidden" name="ID" value="<?php echo $ID; ?>">

		<div class="input-group">
			<label>Restaurant Name</label>
			<input id="RN" type="text" name="name" value="<?php echo $name; ?>">
		</div>

		<div class="input-group">
			<label>Restaurant Address (Address Format: Street, City, State Zip, Country)</label>
			<input id="RA" type="text" name="RA" value="<?php echo $RA; ?>">
		</div>

		<div class="input-group">
			<label>Your Address</label>
			<input id="address" type="text" name="address" value="<?php echo $address; ?>">
		</div>

		<div class="input-group">
			<label>Order Subtotal</label>
			<input type="text" name="price" value="<?php echo $price; ?>">
		</div>

		<div class="input-group">
		<?php if ($update == false): ?>
			<button type="submit" name="submit" class="btn">Submit</button>
		<?php else: ?>
			<button type="submit" name="update" class="btn">Update</button>
		<?php endif ?>
		</div>

	</form>


<center><form action="server.php" method="post" id="cform"><div class="input-group" id="cbtn">
    <button type="submit" name="compare" class="cbtn">Compare</button>
  </div></form></center>
</body>
</html>