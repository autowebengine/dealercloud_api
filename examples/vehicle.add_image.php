<?php 
include '../config.php';
?>
<html><body>
<h2>vehicle.add_image</h2>
<form method="post" enctype="multipart/form-data">
<p>Vehicle ID: <input type="text" name="id" /></p>
<p>Photo: <input type="file" name=image /></p>
<p>Sequence: <input type="text" name="seq" /></p>
<p><input type="submit" name="submit" value="Execute!" /></p>
</form>

<?php 
if (isset($_REQUEST['submit'])) {
	// first parameter is the API key
	// second parameter indicates if it'll run in production
	// or development mode
	$client = new Client($apiKey, $production);

	$rs = $client->AddVehicleImage($_REQUEST['id'], $_FILES['image']['tmp_name'], $_REQUEST['seq']);

	print "<h1>Response</h1>";
	print "<pre>";
	if ($client->hasError)
		print "Error:" . $client->error;
	else 
		print "Vehicle image added successfully";
	print "</pre>";
}
?>
</body></html>