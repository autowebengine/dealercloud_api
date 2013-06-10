<?php 
include '../config.php';
?>
<html><body>
<h2>contact.view_message</h2>
<form method="post">
<p>Message ID: <input type="text" name="msg_id" /></p>
<p><input type="submit" name="submit" value="Execute!" /></p>
</form>

<?php 
if (isset($_REQUEST['submit'])) {
	$client = new Client($apiKey, $production);

	$rs = $client->ContactViewMessage($_REQUEST['msg_id']);

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