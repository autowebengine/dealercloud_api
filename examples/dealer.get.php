<?php 
include '../config.php';
?>
<html><body>
<h2>dealer.get</h2>
<form method="post">
<p>Dealer ID: <input type="text" name="id" /></p>
<p><input type="submit" name="submit" value="Execute!" /></p>
</form>

<?php 
if (isset($_REQUEST['submit'])) {
	// first parameter is the API key
	// second parameter indicates if it'll run in production
	// or development mode
	$client = new Client($apiKey, $production);

	$dealer = $client->GetDealer($_REQUEST['id']);

	print "<h1>Response</h1>";
	print "<pre>";
	if ($client->hasError)
		print "Error:" . $client->error;
	else {
		print "Dealer details\n\n";
		print "ID:{$dealer['id']}\n";
		print "Company:{$dealer['company']}\n";
		print_r($dealer);
	}
	print "</pre>";
}
?>
</body></html>