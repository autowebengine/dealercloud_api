<?php 
include '../config.php';
?>
<html><body>
<h2>contact.view</h2>
<form method="post">
<p>Contact ID: <input type="text" name="contact_id" /></p>
<p><input type="submit" name="submit" value="Execute!" /></p>
</form>

<?php 
if (isset($_REQUEST['submit'])) {
	// first parameter is the API key
	// second parameter indicates if it'll run in production
	// or development mode
	$client = new Client($apiKey, $production);

	$contact = $client->ContactView($_REQUEST['contact_id']);

	print "<h1>Response</h1>";
	print "<pre>";
	if ($client->hasError)
		print "Error:" . $client->error;
	else {
		print "Contact details\n";
		print "ID:{$contact['id']}\n";
		print "First Name:{$contact['first_name']}\n";
		print "Last Name:{$contact['last_name']}\n";
		print "Email:{$contact['email']}\n";
		print_r($contact);
	}
	print "</pre>";
}
?>
</body></html>