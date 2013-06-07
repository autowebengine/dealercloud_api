<?php 
include '../config.php';
?>
<html><body>
<h2>vehicle.delete</h2>
<form method="post">
<p>Vehicle ID: <input type="text" name="id" /></p>
<p><input type="submit" name="submit" value="Execute!" /></p>
</form>

<?php 
if (isset($_REQUEST['submit'])) {	
	$client = new Client($apiKey, $production);

	$rs = $client->DeleteVehicle($_REQUEST['id']);

	print "<h1>Response</h1>";
	print "<pre>";
	if ($client->hasError)
		print "Error:" . $client->error;
	else
		print "Vehicle deleted successfully";
	print "</pre>";
}
?>
</body></html>