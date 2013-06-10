<?php 
include '../config.php';
?>
<html><body>
<h2>contact.list_messages</h2>
<form method="post">
<p>Page: <input type="text" name="page" /></p>
<p>Page Size: <input type="text" name="page_size" /></p>
<p>Sort By: <select name="sort_by">
<option>createdon</option><option>from</option>
</select></p>
<p>Sort Type: <select name="sort_type">
<option>ASC</option><option>DESC</option>
</select></p>
<p><input type="submit" name="submit" value="Execute!" /></p>
</form>

<?php 
if (isset($_REQUEST['submit'])) {
	$client = new Client($apiKey, $production);

	$rs = $client->ContactListMessages($_REQUEST);

	print "<h1>Response</h1>";
	print "<pre>";
	if ($client->hasError)
		print "Error:" . $client->error;
	else {
		$count = $rs['total_count'];
		$messages = $rs['list'];
		print "Total messages found: {$count}\n";
		print "Message list\n";
		foreach ($messages as $message)
			print "ID:{$message['id']} - From:{$message['from']} - Subject: {$message['subject']}\n";
		print_r($messages);
	}
	print "</pre>";
}
?>
</body></html>