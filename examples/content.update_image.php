<?php 
include '../config.php';
?>
<html><body>
<h2>content.update_image</h2>
<form method="post">
<p>Photo: <input type="file" name="image" /></p>
<p>Sequence: <input type="text" name="seq" /></p>
<p>Title: <input type="text" name="title" /></p>
<p>Description: <input type="text" name="description" /></p>
<p><input type="submit" name="submit" value="Execute!" /></p>
</form>

<?php 
if (isset($_REQUEST['submit'])) {
	// first parameter is the API key
	// second parameter indicates if it'll run in production
	// or development mode
	$client = new Client($apiKey, $production);

	$rs = $client->UpdateContentImage($_FILES['image']['tmp_name'], $_REQUEST['seq'], $_REQUEST['title'], $_REQUEST['description']);

	print "<h1>Response</h1>";
	print "<pre>";
	if ($client->hasError)
		print "Error:" . $client->error;
	else
		print "Image updated successfully";
	print "</pre>";
}
?>
</body></html>