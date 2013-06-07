<?php
class Client
{
	private $debug = false;

	public static $devDomain = "http://developer.dealercloud.com";
	public static $prodDomain = "http://www.dealercloud.com";
	public static $aweAPIURL = "/api/1.0/xml-in";

	public $hasError;
	public $error;
	private $productionMode = false;
	private $apiKey = false;
	private $data;

	function __construct($apiKey = '', $productionMode = false)
	{
		$this->apiKey = $apiKey;
		$this->productionMode = $productionMode;
	}

	/**************************************************************************
	*
	* Function:
	*   UserLogin()
	* Description:
	*   Validates user login
	* Input:
	*   username: username used to log in
	*   password: password used to log in
	* Output:
	*   Array of user parameters:
	*       id: internal AWE user id
	*       user_role: role of this user (2: dealer, 3: broker, 4: private seller)
	*       token: user token, used on all api methods
	*
	*   Note: If id = 0 validation was not successful, either wrong username,
	*         password or both.
	*/
	public function UserLogin($username, $password)
	{
		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= '<request method="user.login">';
		$xml .= "<username>$username</username>";
		$xml .= "<password>$password</password>";
		$xml .= '</request>';

		$this->handleResponse($this->sendRequest($xml));

		$user = array();
		if (!$this->hasError)
		{
			foreach($this->data->user[0] as $key=>$val)
				$user[(string)$key] = (string)$val;
		}
		return $user;
	}

	/**************************************************************************
	*
	* Function:
	*   GetDealers()
	* Description:
	*   BROKER only function. Get broker dealers depending on given search
	*   parameters.
	* Input:
	*   Array of parameters:
	*       zip_code: zip code to search
	*       mile_radius: Search for within miles from zip code
	*       city: city to search (if zip_code and mile_radius are not defined above)
	*       page: page number to return
	*       page_size: number of dealers per page to return
	*       sort_by: sort data by: ID, Active, Address1, Address2, City, State,
	*                ZIP, PhoneNumber, Email, Website, Company, Featured
	*       sort_type: sort type: ASC, DESC
	* Output:
	*   Array:
	*       list: list of dealer parameters (see GetDealer() function)
	*       total_count: total number of dealer found given search parameters
	*/
	public function GetDealers($params)
	{
		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= '<request method="dealer.list">';
		foreach($params as $key=>$val) {
			$xml .= "<$key>" . htmlspecialchars(utf8_encode($val)) . "</$key>";
		}
		$xml .= '</request>';

		$this->handleResponse($this->sendRequest($xml));

		$dealers = array(
			'list' => array(),
			'total_count' => 0
		);

		if (!$this->hasError)
		{
			foreach($this->data->dealers[0]->dealer as $d) {
				$dealer = array();
				foreach($d as $key=>$val) {
					$key = (string)$key;
					$dealer[$key] = (string)$val;
				}
	
				$dealers["list"][] = $dealer;
			}

			$dealers["total_count"] = (string)$this->data->meta[0]->total;
		}

		return $dealers;
	}

	/**************************************************************************
	*
	* Function:
	*   GetDealer()
	* Description:
	*   BROKER only function. Get dealer settings.
	* Input:
	*   id: dealer id to get settings for
	* Output:
	*   Array of dealer settings:
	*       id: internal AWE dealer id
	*       company: dealer name
	*       first_name: contact first name
	*       last_name: contact last name
	*       address1: dealer address line 1
	*       address2: dealer address line 2
	*       city: dealer city
	*       state: dealer state
	*       zip: dealer zip
	*       phone_number: dealer phone number
	*       website: dealer website address
	*       email: contact email
	*       vr_active: vr actice
	*       featured: dealer featured flag
	*/
	public function GetDealer($id)
	{
		$xml = "<?xml version='1.0' encoding='utf-8'?>";
		$xml .= "<request method='dealer.get'>";
		$xml .= "<dealer_id>$id</dealer_id>";
		$xml .= "</request>";

		$this->handleResponse($this->sendRequest($xml));

		$dealer = array();
		if (!$this->hasError)
		{
			foreach($this->data->dealer[0] as $key=>$val)
				$dealer[(string)$key] = (string)$val;
		}

		return $dealer;
	}

	/**************************************************************************
	*
	* Function:
	*   AddDealer()
	* Description:
	*   BROKER only function. Add dealer.
	* Input:
	*   Array of dealer settings:
	*       user_name: username for user log in (required)
	*       password: password for user log in (required)
	*       email: contact email (required)
	*       company: dealer name (required)
	*       first_name: contact first name (required)
	*       last_name: contact last name (required)
	*       address1: dealer address line 1 (required)
	*       address2: dealer address line 2
	*       city: dealer city (required)
	*       state: dealer state (required)
	*       zip: dealer zip (required)
	*       phone_number: dealer phone number (required)
	*       website: dealer website address (required)
	*       private_seller: private seller flag
	* Output:
	*   boolean; true if successful, false if not
	*/
	public function AddDealer($params)
	{
		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= '<request method="dealer.add">';
		foreach($params as $key=>$val) {
			$xml .= "<$key>" . htmlspecialchars(utf8_encode($val)) . "</$key>";
		}
		$xml .= '</request>';

		$this->handleResponse($this->sendRequest($xml));

		return !$this->hasError;
	}

	/**************************************************************************
	*
	* Function:
	*   UpdateDealer()
	* Description:
	*   BROKER only function. Update dealer.
	* Input:
	*   Array of dealer settings:
	*       dealer_id: internal AWE dealer id to update (required)
	*       company: dealer name (required)
	*       first_name: contact first name (required)
	*       last_name: contact last name (required)
	*       address1: dealer address line 1 (required)
	*       address2: dealer address line 2
	*       city: dealer city (required)
	*       state: dealer state (required)
	*       zip: dealer zip (required)
	*       phone_number: dealer phone number (required)
	*       website: dealer website address (required)
	* Output:
	*   boolean; true if successful, false if not
	*/
	public function UpdateDealer($params) {

		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= '<request method="dealer.update">';
		foreach($params as $key=>$val) {
			$xml .= "<$key>" . htmlspecialchars(utf8_encode($val)) . "</$key>";
		}
		$xml .= '</request>';

		$this->handleResponse($this->sendRequest($xml));

		return !$this->hasError;
	}

	/**************************************************************************
	*
	* Function:
	*   DeleteDealer()
	* Description:
	*   BROKER only function. Delete dealer.
	* Input:
	*   id: dealer id to delete
	* Output:
	*   boolean; true if successful, false if not
	*/
	public function DeleteDealer($id)
	{
		$xml = "<?xml version='1.0' encoding='utf-8'?>";
		$xml .= "<request method='dealer.delete'>";
		$xml .= "<dealer_id>$id</dealer_id>";
		$xml .= "</request>";

		$this->handleResponse($this->sendRequest($xml));

		return !$this->hasError;
	}

	/**************************************************************************
	*
	* Function:
	*   GetVehicleMakes()
	* Description:
	*   Get all vehicle makes.
	* Input:
	*   none
	* Output:
	*   Array of vehicle makes
	*/
	public function GetVehicleMakes() {

		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= '<request method="vehicle.list_makes">';
		$xml .= '</request>';
		$this->handleResponse($this->sendRequest($xml));

		$makesArray = array();
		if (!$this->hasError)
		{
			foreach($this->data->makes->make as $make)
				$makesArray[] = (string)$make;
		}

		return $makesArray;
	}

	/**************************************************************************
	*
	* Function:
	*   GetVehicleModels()
	* Description:
	*   Get all vehicles models for given make
	* Input:
	*   Vehicle make
	* Output:
	*   Array of vehicle models
	*/
	public function GetVehicleModels($make) {

		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= '<request method="vehicle.list_models">';
		$xml .= '<make>' . htmlspecialchars(utf8_encode($make)) . '</make>';
		$xml .= '</request>';
		$this->handleResponse($this->sendRequest($xml));

		$modelsArray = array();
		if (!$this->hasError)
		{
			foreach($this->data->models->model as $model)
				$modelsArray[] = (string)$model;
		}

		return $modelsArray;
	}

	/**************************************************************************
	*
	* Function:
	*   GetVehicles()
	* Description:
	*   Get vehicles depending on given search parameters.
	* Input:
	*   Array of parameters:
	*       dealer_id: dealer id to get vehicles for (BROKER account only)
	*       zip_code: zip code to search
	*       mile_radius: Search for within miles from zip code
	*       make: vehicle make
	*       model: vehicle model
	*       min_price: minimum price
	*       max_price: maximum price
	*       min_year: minimum year
	*       max_year: maximum year
	*       featured_first: flag to return featured vehicles first in the list
	*       page: page number to return
	*       page_size: number of dealers per page to return
	*       sort_by: sort data by: ID, Active, Address1, Address2, City, State,
	*                ZIP, PhoneNumber, Email, Website, Company, Featured
	*       sort_type: sort type: ASC, DESC
	* Output:
	*   Array:
	*       list: list of vehicle parameters (see GetVehicle() function)
	*       total_count: total number of vehicles found given search parameters
	*/
	public function GetVehicles($params) {

		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= '<request method="vehicle.list">';
		if (empty($params['page']))
			$params['page'] = 1;
		if (empty($params['page_size']))
			$params['page_size'] = 10;
		foreach($params as $key=>$val) {
			$xml .= "<$key>" . htmlspecialchars(utf8_encode($val)) . "</$key>";
		}
		$xml .= "<extra_columns>vin,trans,engine,drive,created_on,dealer_name,dealer_phone,dealer_city,dealer_state</extra_columns>";
		$xml .= '</request>';

		$this->handleResponse($this->sendRequest($xml));

		$vehicles = array(
			'list' => array(),
			'total_count' => 0
		);

		if (!$this->hasError)
		{
			foreach($this->data->vehicles[0]->vehicle as $veh) {
				$vehicle = array();
				$vehicle["photos"] = array();
				$vehicle["thumbs"] = array();
				$vehicle["dealer"] = array();
				foreach($veh as $key=>$val) {
					$key = (string)$key;
					if($key != "dealer" && $key != "photos" && $key != "thumbs") {
						$vehicle[$key] = (string)$val;
					}
				}
				foreach($veh->photos[0] as $key=>$val) {
					$vehicle["photos"][] = (string)$val;
				}

				foreach($veh->thumbs[0] as $key=>$val) {
					$vehicle["thumbs"][] = (string)$val;
				}

				foreach($veh->dealer[0] as $key=>$val) {
					$vehicle["dealer"][(string)$key] = (string)$val;
				}
	
				$vehicles["list"][] = $vehicle;
			}
	
			$vehicles["total_count"] = (string)$this->data->meta[0]->total;
		}

		return $vehicles;
	}

	/**************************************************************************
	*
	* Function:
	*   GetVehicle()
	* Description:
	*   Get vehicle settings.
	* Input:
	*   id: vehicle id to get settings for
	*   trackstat: flag to set vehicle view stat when true
	* Output:
	*   Array of vehicle settings:
	*       id (internal AWE vehicle id)
	*       vin
	*       stock
	*       year
	*       make
	*       model
	*       trim
	*       price
	*       mileage
	*       exterior_color
	*       interior_color
	*       comments
	*       standard_features
	*       features
	*       cmpg (city MPG)
	*       hmpg (highway MPG)
	*       engine
	*       drive (drivetrain)
	*       trans (transmission)
	*       stock_type (used, new)
	*       payment
	*       blue_book_high
	*       blue_book_low
	*       type_code
	*       body_door_count
	*       seating_capacity
	*       classification
	*/
	public function GetVehicle($id, $trackstat = false) {
		$xml = "<?xml version='1.0' encoding='utf-8'?>";
		$xml .= "<request method='vehicle.get'>";
		$xml .= "<veh_id>$id</veh_id>";
		$xml .= "<track_stats>" . ($trackstat ? "1" : "0") . "</track_stats>";
		$xml .= "<remote_ip>" . $_SERVER["REMOTE_ADDR"] . "</remote_ip>";
		$xml .= "<extra_columns></extra_columns>";
		$xml .= "</request>";

		$this->handleResponse($this->sendRequest($xml));

		$vehicle = array();
		if (!$this->hasError)
		{
			foreach($this->data->vehicle[0] as $key=>$val) {
				$vehicle[(string)$key] = (string)$val;
			}
	
			foreach($this->data->vehicle[0]->dealer[0] as $key=>$val) {
				$vehicle["dealer"][(string)$key] = (string)$val;
			}
	
			foreach($this->data->vehicle[0]->carfax[0] as $key=>$val) {
				$vehicle["carfax"][(string)$key] = (string)$val;
			}
	
			$count = 0;
			foreach($this->data->vehicle[0]->photos[0] as $key=>$val) {
				$vehicle["photos"][$count++] = (string)$val;
			}
			$count = 0;
			foreach($this->data->vehicle[0]->thumbs[0] as $key=>$val) {
				$vehicle["thumbs"][$count++] = (string)$val;
			}
		}
		return $vehicle;
	}

	/**************************************************************************
	*
	* Function:
	*   GetVehicleByStock()
	* Description:
	*   Get vehicle by stock number.
	* Input:
	*   stock: stock number
	*   dealer_id: optional for broker accounts
	*   trackstat: flag to set vehicle view stat when true
	* Output:
	*   Array of vehicle settings:
	*       id (internal AWE vehicle id)
	*       vin
	*       stock
	*       year
	*       make
	*       model
	*       trim
	*       price
	*       mileage
	*       exterior_color
	*       interior_color
	*       comments
	*       standard_features
	*       features
	*       cmpg (city MPG)
	*       hmpg (highway MPG)
	*       engine
	*       drive (drivetrain)
	*       trans (transmission)
	*       stock_type (used, new)
	*       payment
	*       blue_book_high
	*       blue_book_low
	*       type_code
	*       body_door_count
	*       seating_capacity
	*       classification
	*/
	public function GetVehicleByStock($stock, $dealerId = false, $trackstat = false) {
		$xml = "<?xml version='1.0' encoding='utf-8'?>";
		$xml .= "<request method='vehicle.get_by_stock'>";
		$xml .= "<stock>$stock</stock>";
		if (!empty($dealerId))
			$xml .= "<dealer_id>$dealerId</dealer_id>";
		$xml .= "<track_stats>" . ($trackstat ? "1" : "0") . "</track_stats>";
		$xml .= "<remote_ip>" . $_SERVER["REMOTE_ADDR"] . "</remote_ip>";
		$xml .= "<extra_columns></extra_columns>";
		$xml .= "</request>";

		$this->handleResponse($this->sendRequest($xml));

		$vehicle = array();
		if (!$this->hasError)
		{
			foreach($this->data->vehicle[0] as $key=>$val) {
				$vehicle[(string)$key] = (string)$val;
			}
	
			foreach($this->data->vehicle[0]->dealer[0] as $key=>$val) {
				$vehicle["dealer"][(string)$key] = (string)$val;
			}
	
			foreach($this->data->vehicle[0]->carfax[0] as $key=>$val) {
				$vehicle["carfax"][(string)$key] = (string)$val;
			}
	
			$count = 0;
			foreach($this->data->vehicle[0]->photos[0] as $key=>$val) {
				$vehicle["photos"][$count++] = (string)$val;
			}
			$count = 0;
			foreach($this->data->vehicle[0]->thumbs[0] as $key=>$val) {
				$vehicle["thumbs"][$count++] = (string)$val;
			}
		}
		return $vehicle;
	}

	/**************************************************************************
	*
	* Function:
	*   GetRelatedVehicles()
	* Description:
	*   Get related vehicles
	* Input:
	*   id: vehicle id to get settings for
	* Output:
	*   Array:
	*       list: list of vehicle parameters (see GetVehicle() function)
	*       total_count: total number of vehicles found given search parameters
	*/
	public function GetRelatedVehicles($relVehId)
	{
		$xml = "<?xml version='1.0' encoding='utf-8'?>";
		$xml .= "<request method='vehicle.list_related'>";
		$xml .= "<veh_id>$relVehId</veh_id>";
		$xml .= "</request>";
	
		$this->handleResponse($this->sendRequest($xml));

		$vehicles = array(
			'list' => array(),
			'total_count' => 0
		);
		
		if (!$this->hasError)
		{
			foreach($this->data->vehicles[0]->vehicle as $veh) {
				$vehicle = array();
				$vehicle["photos"] = array();
				$vehicle["thumbs"] = array();
				$vehicle["dealer"] = array();
				foreach($veh as $key=>$val) {
					$key = (string)$key;
					if($key != "dealer" && $key != "photos") {
						$vehicle[$key] = (string)$val;
					}
				}
				foreach($veh->photos[0] as $key=>$val) {
					$vehicle["photos"][] = (string)$val;
				}
		
				foreach($veh->dealer[0] as $key=>$val) {
					$vehicle["dealer"][(string)$key] = (string)$val;
				}

				foreach($veh->thumbs[0] as $key=>$val) {
					$vehicle["thumbs"][] = (string)$val;
				}
		
				$vehicles["list"][] = $vehicle;
			}
			$vehicles["total_count"] = (string)$this->data->meta[0]->total;
		}

		return $vehicles;
	}

	/**************************************************************************
	*
	* Function:
	*   AddVehicle()
	* Description:
	*   Add vehicle.
	* Input:
	*   Array of vehicle settings:
	*       dealer_id (AWE dealer id; only required if BROKER account)
	*           vin (required)
	*           stock (required)
	*           year (required)
	*           make (required)
	*           model (required)
	*           price (required)
	*           trim
	*           mileage
	*           exterior_color
	*           interior_color
	*           comments
	*           standard_features
	*           features
	*           cmpg
	*           hmpg
	*           engine
	*           drive
	*           trans
	*           stock_type
	*           payment
	*           blue_book_high
	*           blue_book_low
	*           type_code
	*           body_door_count
	*           seating_capacity
	*           classification
	*
	* Output:
	*   boolean; true if successful, false if not
	*/
	public function AddVehicle($params) {

		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= '<request method="vehicle.add">';
		foreach($params as $key=>$val) {
			$xml .= "<$key>" . htmlspecialchars(utf8_encode($val)) . "</$key>";
		}
		$xml .= '</request>';

		$this->handleResponse($this->sendRequest($xml));

		return !$this->hasError;
	}

	/**************************************************************************
	*
	* Function:
	*   UpdateVehicle()
	* Description:
	*   Update vehicle.
	* Input:
	*   Array of vehicle settings:
	*           id (vehicle id; required)
	*           vin
	*           stock
	*           year
	*           make
	*           model
	*           price
	*           trim
	*           mileage
	*           exterior_color
	*           interior_color
	*           comments
	*           standard_features
	*           features
	*           cmpg
	*           hmpg
	*           engine
	*           drive
	*           trans
	*           stock_type
	*           payment
	*           blue_book_high
	*           blue_book_low
	*           type_code
	*           body_door_count
	*           seating_capacity
	*           classification
	*
	* Output:
	*   boolean; true if successful, false if not
	*/
	public function UpdateVehicle($params) {

		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= '<request method="vehicle.update">';
		foreach($params as $key=>$val) {
			$xml .= "<$key>" . htmlspecialchars(utf8_encode($val)) . "</$key>";
		}
		$xml .= '</request>';

		$this->handleResponse($this->sendRequest($xml));

		return !$this->hasError;
	}

	/**************************************************************************
	* Function:
	*   GetVehicleStats()
	* Description:
	*   Get vehicle stats for the given search parameters.
	* Input:
	*   Array of search parameters:
	*       id (vehicle id; required)
	*       from_date (format YYYY-MM-DD; if left blank date will be 1 week from current)
	*       to_date (format YYYY-MM-DD; if left blank date will be todays date)
	*
	* Output:
	*   Array of stats:
	*       web (total web views)
	*       craigslist (total craigslist views)
	*       url (total url link clicks)
	*       phone (total phone link clicks)
	*       video (total video link clicks)
	*       email (total email link clicks)
	*       qr (total qr code views)
	*       iphone (total iphone app views)
	*       ipad (total ipad app views)
	*/
	public function GetVehicleStats($params) {
		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= '<request method="vehicle.stats">';
		foreach($params as $key=>$val) {
			$xml .= "<$key>" . htmlspecialchars(utf8_encode($val)) . "</$key>";
		}
		$xml .= '</request>';

		$this->handleResponse($this->sendRequest($xml));

		$stats = array();
		if (!$this->hasError)
		{
			foreach($this->data->stats[0] as $key=>$val)
				$stats[(string)$key] = (string)$val;
		}

		return $stats;
	}

	/**************************************************************************
	*
	* Function:
	*   DeleteVehicle()
	* Description:
	*   Delte vehicle.
	* Input:
	*   id: vehicle id to delete
	* Output:
	*   boolean; true if successful, false if not
	*/
	public function DeleteVehicle($id) {
		$xml = "<?xml version='1.0' encoding='utf-8'?>";
		$xml .= "<request method='vehicle.delete'>";
		$xml .= "<veh_id>$id</veh_id>";
		$xml .= "</request>";

		$this->handleResponse($this->sendRequest($xml));

		return !$this->hasError;
	}

	/**************************************************************************
	*
	* Function:
	*   AddVehicleImage()
	* Description:
	*   Add a vehicle image
	* Input:
	*   id: vehicle id
	*   image: full path of image to add
	*   seq: sequence number (image position)
	* Output:
	*   boolean; true if successful, false if not
	*/
	public function AddVehicleImage($id, $image, $seq)
	{
		$xml = "<?xml version='1.0' encoding='utf-8'?>";
		$xml .= "<request method='vehicle.add_image'>";
		$xml .= "<veh_id>$id</veh_id>";
		$xml .= "<seq>$seq</seq>";
		$xml .= "</request>";
		$post = array(
			'image' => '@' . $image,
			'xml' => $xml
		);
		error_reporting(E_ALL);
		$this->handleResponse($this->sendRequest($post));

		return !$this->hasError;
	}

	/**************************************************************************
	*
	* Function:
	*   DeleteVehicleImage()
	* Description:
	*   Delete a vehicle image
	* Input:
	*   id: vehicle id
	*   seq: sequence number (image position)
	* Output:
	*   boolean; true if successful, false if not
	*/
	public function DeleteVehicleImage($id, $seq)
	{
		$xml = "<?xml version='1.0' encoding='utf-8'?>";
		$xml .= "<request method='vehicle.delete_image'>";
		$xml .= "<veh_id>$id</veh_id>";
		$xml .= "<seq>$seq</seq>";
		$xml .= "</request>";

		$this->handleResponse($this->sendRequest($xml));

		return !$this->hasError;
	}

	/**************************************************************************
	 * Private functions.
	*/

	private function handleResponse($resp) {
		$this->hasError = false;
		$this->error = "";
		$this->data = false;

		if ($resp != "") {
			$xml = simplexml_load_string($resp);
			$attr = $xml->attributes();
			$status = $attr["status"];
			if($status == "fail") {
				$this->hasError = true;
				$this->error = $xml->error;
			} else if ($status == "ok") {
				$this->data = $xml;
			}
		}
	}

	private function sendRequest($xml)
	{
		if ($this->productionMode)
			$url = self::$prodDomain;
		else
			$url = self::$devDomain;
		$url .= self::$aweAPIURL;
		$options = array(
			CURLOPT_RETURNTRANSFER  => true,
			CURLOPT_CONNECTTIMEOUT  => 120,
			CURLOPT_TIMEOUT         => 120,
			CURLOPT_POST            => true,
			CURLOPT_USERAGENT       => 'AWE Client 1.0',
			CURLOPT_USERPWD         => $this->apiKey,
			CURLOPT_URL             => $url,
			CURLOPT_POSTFIELDS      => $xml
		);
		$ch = curl_init();
		curl_setopt_array($ch, $options);
		$content = curl_exec($ch);
		curl_close($ch);
		return trim($content);
	}
}