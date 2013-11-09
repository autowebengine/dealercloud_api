<?php 
include '../config.php';
?>
<html><body>
<h2>content.delete</h2>
<form method="post">
<p>Section: <input type="text" name="section" /></p>
<p><input type="submit" name="submit" value="Execute!" /></p>
</form>

<?php 
if (isset($_REQUEST['submit'])) {
	// first parameter is the API key
	// second parameter indicates if it'll run in production
	// or development mode
	$client = new Client($apiKey, $production);

	$rs = $client->ContentDelete($_REQUEST['section']);

	print "<h1>Response</h1>";
	print "<pre>";
	if ($client->hasError)
		print "Error:" . $client->error;
	else
		print "Content deleted successfully";
	print "</pre>";
}
?>
</body></html>