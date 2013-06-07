<?php 
include '../config.php';
?>
<html><body>
<h2>vehicle.list_makes</h2>
<form method="post">
<p><input type="submit" name="submit" value="Execute!" /></p>
</form>

<?php 
if (isset($_REQUEST['submit'])) {	
	$client = new Client($apiKey, $production);

	$makes = $client->GetVehicleMakes();

	print "<h1>Response</h1>";
	print "<pre>";
	if ($client->hasError)
		print "Error:" . $client->error;
	else {
		foreach ($makes as $make)
			print "Make: " . $make . "\n";
	}
	print "</pre>";
}
?>
</body></html>