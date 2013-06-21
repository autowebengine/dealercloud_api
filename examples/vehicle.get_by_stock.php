<?php 
include '../config.php';
?>
<html><body>
<h2>vehicle.get_by_stock</h2>
<form method="post">
<p>Stock: <input type="text" name="stock" /></p>
<p><input type="submit" name="submit" value="Execute!" /></p>
</form>

<?php 
if (isset($_REQUEST['submit'])) {	
	// first parameter is the API key
	// second parameter indicates if it'll run in production 
	// or development mode
	$client = new Client($apiKey, $production);

	// first parameter indicates the stock number for the vehicle in
	// inventory
	// second parameter, used on broker accounts, indicates the dealer id
	// where the vehicle can be found
	// third parameter indicates if it should track the view
	// in the statistics
	$vehicle = $client->GetVehicleByStock($_REQUEST['stock'], false, true);

	print "<h1>Response</h1>";
	print "<pre>";
	if ($client->hasError)
		print "Error:" . $client->error;
	else {
		print "ID:{$vehicle['id']}\n";
		print "Make:{$vehicle['make']}\n";
		print "Model:{$vehicle['model']}\n";
		print "Year:{$vehicle['year']}\n";
		print_r($vehicle);
	}
	print "</pre>";
}
?>
</body></html>