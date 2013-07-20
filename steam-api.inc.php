<?php

class steamAPI {

	public $extraCURLOptions = null;

	function __construct() {

	}

	/**
		* makeCURLCall
		*
		* Makes the specified CURL request - this is the meat of the class!
		*
		* @param string $url - The URL to for the CURL request
		*
		* @return json/bool - data if we have it, otherwise false
		*
		*/
	public function makeCURLCall($url)
	{
		// Initialise CURL
		$handle = curl_init();

		// Do we have any extra CURL options?
		if (is_array($this->extraCURLOptions) and !empty($this->extraCURLOptions))
		{
			// Set any extra CURL options
			curl_setopt_array($handle, $this->extraCURLOptions);
		}

		// Set the CURL options we need
		curl_setopt($handle, CURLOPT_URL, $url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);

		// Grab the data
		$data = curl_exec($handle);

		// Grab the CURL error code and message
		$errorCode = curl_errno($handle);
		$errorMessage = curl_error($handle);

		// Close the CURL connection
		curl_close($handle);

		// Check our error code is 0 (0 means OK!)
		if ($errorCode == 0)
		{
			// Decode the json response
			$data = json_decode($data, true);

			// Check we don't have an error code
			if (isset($data['code']) and isset($data['reason']))
			{
				// API error - make a note of it and return false
				error_log('API error: '. $data['code'] .' - '. $data['reason'] .' ('. $url .')!');
				return false;
			}
			// No errors - cache and return the data
			else
			{
				// Return the data
				return $data;
			}
		}
		// CURL error - make a note of it and return false
		else
		{
			error_log('CURL error "'. $errorCode .'" ('. $errorMessage .').');
			return false;
		}
	}
}