<?php 
include '../config.php';
?>
<html><body>
<h2>content.update</h2>
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

	$rs = $client->ContentUpdate($_REQUEST['section'], $_REQUEST['content'], !empty($_REQUEST['title'])?$_REQUEST['title']:false, !empty($_REQUEST['subtitle'])?$_REQUEST['subtitle']:false);

	print "<h1>Response</h1>";
	print "<pre>";
	if ($client->hasError)
		print "Error:" . $client->error;
	else
		print "Content updated successfully";
	print "</pre>";
}
?>
</body></html>