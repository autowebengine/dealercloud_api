<?php 
include '../config.php';
?>
<html><body>
<h2>vehicle.delete_image</h2>
<form method="post" enctype="multipart/form-data">
<p>Vehicle ID: <input type="text" name="id" /></p>
<p>Sequence: <input type="text" name="seq" /></p>
<p><input type="submit" name="submit" value="Execute!" /></p>
</form>

<?php 
if (isset($_REQUEST['submit'])) {	
	$client = new Client($apiKey, $production);

	$rs = $client->DeleteVehicleImage($_REQUEST['id'], $_REQUEST['seq']);

	print "<h1>Response</h1>";
	print "<pre>";
	if ($client->hasError)
		print "Error:" . $client->error;
	else
		print "Vehicle image deleted successfully";
	print "</pre>";
}
?>
</body></html>