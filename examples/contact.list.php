<?php 
include '../config.php';
?>
<html><body>
<h2>contact.list</h2>
<form method="post">
<p>Page: <input type="text" name="page" /></p>
<p>Page Size: <input type="text" name="page_size" /></p>
<p>Sort By: <select name="sort_by">
<option>createdon</option><option>lastname</option>
</select></p>
<p>Sort Type: <select name="sort_type">
<option>ASC</option><option>DESC</option>
</select></p>
<p><input type="submit" name="submit" value="Execute!" /></p>
</form>

<?php 
if (isset($_REQUEST['submit'])) {
	$client = new Client($apiKey, $production);

	$rs = $client->ContactList($_REQUEST);

	print "<h1>Response</h1>";
	print "<pre>";
	if ($client->hasError)
		print "Error:" . $client->error;
	else {
		$count = $rs['total_count'];
		$contacts = $rs['list'];
		print "Total contacts found: {$count}\n";
		print "Contact list\n";
		foreach ($contacts as $contact)
			print "ID:{$contact['id']} - Last Name:{$contact['last_name']} - Email: {$contact['email']}\n";
		print_r($contacts);
	}
	print "</pre>";
}
?>
</body></html>