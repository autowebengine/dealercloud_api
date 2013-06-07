<?php 
include '../config.php';
?>
<html><body>
<h2>dealer.add</h2>
<form method="post">
<p>Username: <input type="text" name="user_name" /></p>
<p>Password: <input type="text" name="password" /></p>
<p>Email: <input type="text" name="email" /></p>
<p>First Name: <input type="text" name="first_name" /></p>
<p>Last Name: <input type="text" name="last_name" /></p>
<p>Address: <input type="text" name="address1" /></p>
<p>Address (second line): <input type="text" name="address2" /></p>
<p>City: <input type="text" name="city" /></p>
<p>State: <input type="text" name="state" /></p>
<p>Zip Code: <input type="text" name="zip_code" /></p>
<p>Phone Number: <input type="text" name="phone_number" /></p>
<p>Website: <input type="text" name="website" /></p>
<p>Company: <input type="text" name="company" /></p>
<p>Is Private Seller?: <select name="private_seller">
<option value="1">Yes</option><option value="0">No</option>
</select></p>
<p><input type="submit" name="submit" value="Execute!" /></p>
</form>

<?php 
if (isset($_REQUEST['submit'])) {	
	$client = new Client($apiKey, $production);

	$rs = $client->AddDealer($_REQUEST);

	print "<h1>Response</h1>";
	print "<pre>";
	if ($client->hasError)
		print "Error:" . $client->error;
	else
		print "Dealer added successfully";
	print "</pre>";
}
?>
</body></html>