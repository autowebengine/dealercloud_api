<?php 
include '../config.php';
?>
<html><body>
<h2>contact.add</h2>
<form method="post">
<p>Vehicle ID: <input type="text" name="veh_id" /></p>
<p>First Name: <input type="text" name="first_name" /></p>
<p>Last Name: <input type="text" name="last_name" /></p>
<p>Email: <input type="text" name="email" /></p>
<p>Address: <input type="text" name="address" /></p>
<p>City: <input type="text" name="city" /></p>
<p>State: <input type="text" name="state" /></p>
<p>Zip Code: <input type="text" name="zip_code" /></p>
<p>Phone Number: <input type="text" name="phone_number" /></p>
<p>Message: <textarea name="message"></textarea></p>
<p>Source: <input type="text" name="source" /></p>
<p>IP Address: <input type="text" name="ip_address" value="<?= $_SERVER['REMOTE_ADDR'] ?>" /></p>
<p><input type="submit" name="submit" value="Execute!" /></p>
</form>

<?php 
if (isset($_REQUEST['submit'])) {
	// first parameter is the API key
	// second parameter indicates if it'll run in production
	// or development mode
	$client = new Client($apiKey, $production);

	$rs = $client->ContactAdd($_REQUEST);

	print "<h1>Response</h1>";
	print "<pre>";
	if ($client->hasError)
		print "Error:" . $client->error;
	else
		print "Contact added successfully";
	print "</pre>";
}
?>
</body></html>