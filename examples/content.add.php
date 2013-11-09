<?php 
include '../config.php';
?>
<html><body>
<h2>content.add</h2>
<form method="post">
<p>Section: <input type="text" name="section" /></p>
<p>Title: <input type="text" name="title" /></p>
<p>Subtitle: <input type="text" name="subtitle" /></p>
<p>Content: <textarea name="content"></textarea></p>
<p><input type="submit" name="submit" value="Execute!" /></p>
</form>

<?php 
if (isset($_REQUEST['submit'])) {
	// first parameter is the API key
	// second parameter indicates if it'll run in production
	// or development mode
	$client = new Client($apiKey, $production);

	$rs = $client->ContentAdd($_REQUEST['section'], $_REQUEST['content'], $_REQUEST['title'], $_REQUEST['subtitle']);

	print "<h1>Response</h1>";
	print "<pre>";
	if ($client->hasError)
		print "Error:" . $client->error;
	else
		print "Content added successfully";
	print "</pre>";
}
?>
</body></html>