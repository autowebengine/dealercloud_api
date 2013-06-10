<?php 
include '../config.php';
?>
<html><body>
<h2>contact.delete</h2>
<form method="post">
<p>Contact ID: <input type="text" name="contact_id" /></p>
<p><input type="submit" name="submit" value="Execute!" /></p>
</form>

<?php 
if (isset($_REQUEST['submit'])) {
	$client = new Client($apiKey, $production);

	$rs = $client->ContactDelete($_REQUEST['contact_id']);

	print "<h1>Response</h1>";
	print "<pre>";
	if ($client->hasError)
		print "Error:" . $client->error;
	else
		print "Contact deleted successfully";
	print "</pre>";
}
?>
</body></html>