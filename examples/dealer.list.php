<?php 
include '../config.php';
?>
<html><body>
<h2>dealer.list</h2>
<form method="post">
<p>ZipCode: <input type="text" name="zip_code" /></p>
<p>Mile Radius: <input type="text" name="mile_radius" /></p>
<p>City: <input type="text" name="city" /></p>
<p>Page: <input type="text" name="page" /></p>
<p>Page Size: <input type="text" name="page_size" /></p>
<p>Sort By: <select name="sort_by">
<option>id</option><option>active</option><option>address1</option><option>city</option>
<option>state</option><option>zip</option><option>email</option>
<option>featured</option><option>company</option>
</select></p>
<p>Sort Type: <select name="sort_type">
<option>ASC</option><option>DESC</option>
</select></p>
<p><input type="submit" name="submit" value="Execute!" /></p>
</form>

<?php 
if (isset($_REQUEST['submit'])) {
	// first parameter is the API key
	// second parameter indicates if it'll run in production
	// or development mode
	$client = new Client($apiKey, $production);

	$rs = $client->GetDealers($_REQUEST);

	print "<h1>Response</h1>";
	print "<pre>";
	if ($client->hasError)
		print "Error:" . $client->error;
	else {
		$count = $rs['total_count'];
		$dealers = $rs['list'];
		print "Total dealers found: {$count}\n";
		print "Dealer list\n";
		foreach ($dealers as $dealer)
			print "ID:{$dealer['id']} - Company:{$dealer['company']} - Email: {$dealer['email']}\n";
		print_r($dealers);
	}
	print "</pre>";
}
?>
</body></html>