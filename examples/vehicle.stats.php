<?php 
include '../config.php';
?>
<html><body>
<h2>vehicle.stats</h2>
<form method="post">
<p>Vehicle ID: <input type="text" name="id" /></p>
<p>From Date (yyyy-mm-dd): <input type="text" name="from_date" /></p>
<p>To Date (yyyy-mm-dd): <input type="text" name="to_date" /></p>
<p><input type="submit" name="submit" value="Execute!" /></p>
</form>

<?php 
if (isset($_REQUEST['submit'])) {	
	$client = new Client($apiKey, $production);

	$stats = $client->GetVehicleStats($_REQUEST);

	print "<h1>Response</h1>";
	print "<pre>";
	if ($client->hasError)
		print "Error:" . $client->error;
	else {
		print "Vehicle stats in the given period\n\n";
		print "Web views:{$stats['web']}\n";
		print "Craigslist views:{$stats['craigslist']}\n";
		print "Clicked on url:{$stats['url']}\n";
		print "Clicked on phone number:{$stats['phone']}\n";
		print "Viewed video:{$stats['video']}\n";
		print "Contacted by email:{$stats['email']}\n";
		print "Used QR Code:{$stats['qr']}\n";
		print "Viewed iphone:{$stats['iphone']}\n";
		print "Viewed ipad:{$stats['ipad']}\n";
	}
	print "</pre>";
}
?>
</body></html>