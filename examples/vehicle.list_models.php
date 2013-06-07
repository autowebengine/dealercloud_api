<?php 
include '../config.php';
?>
<html><body>
<h2>vehicle.list_models</h2>
<form method="post">
<p>Make: <input type="text" name="make" /></p>
<p><input type="submit" name="submit" value="Execute!" /></p>
</form>

<?php 
if (isset($_REQUEST['submit'])) {	
	$client = new Client($apiKey, $production);

	$models = $client->GetVehicleModels($_REQUEST['make']);

	print "<h1>Response</h1>";
	print "<pre>";
	if ($client->hasError)
		print "Error:" . $client->error;
	else {
		foreach ($models as $model)
			print "Model: " . $model . "\n";
	}
	print "</pre>";
}
?>
</body></html>