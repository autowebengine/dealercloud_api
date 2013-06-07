<?php 
include '../config.php';
?>
<html><body>
<h2>vehicle.list</h2>
<form method="post">
<p>Keyword: <input type="text" name="keyword" /></p>
<p>ZipCode: <input type="text" name="zip_code" /></p>
<p>Mile Radius: <input type="text" name="mile_radius" /></p>
<p>Make: <input type="text" name="make" /></p>
<p>Model: <input type="text" name="model" /></p>
<p>Min Price: <input type="text" name="min_price" /></p>
<p>Max Price: <input type="text" name="max_price" /></p>
<p>Min Year: <input type="text" name="min_year" /></p>
<p>Max Year: <input type="text" name="max_year" /></p>
<p>Featured First?: <select name="featured_first">
<option value="1">Yes</option><option value="0">No</option>
</select></p>
<p>Only with Photos?: <select name="has_image">
<option value="1">Yes</option><option value="0" selected>No</option>
</select></p>
<p>Page: <input type="text" name="page" /></p>
<p>Page Size: <input type="text" name="page_size" /></p>
<p>Sort By: <select name="sort_by">
<option>make</option><option>model</option><option>year</option><option>mileage</option>
<option>pricenumber</option><option>stocktype</option><option>createdon</option>
<option>visits</option><option>popularity</option>
</select></p>
<p>Sort Type: <select name="sort_type">
<option>ASC</option><option>DESC</option>
</select></p>
<p><input type="submit" name="submit" value="Execute!" /></p>
</form>

<?php 
if (isset($_REQUEST['submit'])) {	
	$client = new Client($apiKey, $production);

	$rs = $client->GetVehicles($_REQUEST);

	print "<h1>Response</h1>";
	print "<pre>";
	if ($client->hasError)
		print "Error:" . $client->error;
	else {
		$count = $rs['total_count'];
		$vehicles = $rs['list'];
		print "Total vehicles found: {$count}\n";
		print "Vehicle list\n";
		foreach ($vehicles as $vehicle)
			print "ID:{$vehicle['id']} - Make:{$vehicle['make']} - Model: {$vehicle['model']}\n";
		print_r($vehicles);
	}
	print "</pre>";
}
?>
</body></html>