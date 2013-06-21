<?php 
include '../config.php';
?>
<html><body>
<h2>vehicle.add</h2>
<form method="post">
<p>VIN: <input type="text" name="vin" /></p>
<p>Stock #: <input type="text" name="stock" /></p>
<p>Year: <input type="text" name="year" /></p>
<p>Make: <input type="text" name="make" /></p>
<p>Model: <input type="text" name="model" /></p>
<p>Price: <input type="text" name="price" /></p>
<p>Trim: <input type="text" name="trim" /></p>
<p>Mileage: <input type="text" name="mileage" /></p>
<p>Exterior Color: <input type="text" name="exterior_color" /></p>
<p>Interior Color: <input type="text" name="interior_color" /></p>
<p>Comments: <input type="text" name="comments" /></p>
<p>Standard_features: <input type="text" name="standard_features" /></p>
<p>Features: <input type="text" name="features" /></p>
<p>CMPG: <input type="text" name="cmpg" /></p>
<p>HMPG: <input type="text" name="hmpg" /></p>
<p>Engine: <input type="text" name="engine" /></p>
<p>Drive: <input type="text" name="drive" /></p>
<p>Transmission: <input type="text" name="trans" /></p>
<p>Stock Type: <select name="stock_type">
<option>Used</option><option>New</option>
</select></p>
<p>Payment: <input type="text" name="payment" /></p>
<p>Blue Book High: <input type="text" name="blue_book_high" /></p>
<p>Blue Book Low: <input type="text" name="blue_book_low" /></p>
<p>Type Code: <input type="text" name="type_code" /></p>
<p>Body Door Count: <input type="text" name="body_door_count" /></p>
<p>Seating Capacity: <input type="text" name="seating_capacity" /></p>
<p>Classification: <input type="text" name="classification" /></p>
<p><input type="submit" name="submit" value="Execute!" /></p>
</form>

<?php 
if (isset($_REQUEST['submit'])) {
	// first parameter is the API key
	// second parameter indicates if it'll run in production
	// or development mode
	$client = new Client($apiKey, $production);

	$rs = $client->AddVehicle($_REQUEST);

	print "<h1>Response</h1>";
	print "<pre>";
	if ($client->hasError)
		print "Error:" . $client->error;
	else
		print "Vehicle added successfully";
	print "</pre>";
}
?>
</body></html>