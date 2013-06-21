<?php 
include '../config.php';
?>
<html><body>
<h2>vehicle.list_related</h2>
<form method="post">
<p>Vehicle ID: <input type="text" name="id" /></p>
<p><input type="submit" name="submit" value="Execute!" /></p>
</form>

<?php 
if (isset($_REQUEST['submit'])) {
	// first parameter is the API key
	// second parameter indicates if it'll run in production
	// or development mode
	$client = new Client($apiKey, $production);

	$rs = $client->GetRelatedVehicles($_REQUEST['id']);

	print "<h1>Response</h1>";
	print "<pre>";
	if ($client->hasError)
		print "Error:" . $client->error;
	else {
		$count = $rs['total_count'];
		$vehicles = $rs['list'];
		print "Related vehicles found: {$count}\n";
		print "Vehicle list\n";
		foreach ($vehicles as $vehicle)
			print "ID:{$vehicle['id']} - Make:{$vehicle['make']} - Model: {$vehicle['model']}\n";
		print_r($vehicles);
	}
	print "</pre>";
}
?>
</body></html>