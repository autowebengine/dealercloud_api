<?php 
include '../config.php';
?>
<html><body>
<h2>content.get_images</h2>
<form method="post">
<p><input type="submit" name="submit" value="Execute!" /></p>
</form>

<?php 
if (isset($_REQUEST['submit'])) {
	// first parameter is the API key
	// second parameter indicates if it'll run in production
	// or development mode
	$client = new Client($apiKey, $production);

	$rs = $client->GetContentImages();

	print "<h1>Response</h1>";
	print "<pre>";
	if ($client->hasError)
		print "Error:" . $client->error;
	else {
		$count = $rs['total_count'];
		$images = $rs['list'];
		print "Total images found: {$count}\n";
		print "Image list\n";
		foreach ($images as $image)
			print "Seq:{$image['seq']} - Title:{$image['title']} - Url:{$image['url']}\n";
		print_r($images);
	}
	print "</pre>";
}
?>
</body></html>