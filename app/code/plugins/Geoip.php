<?php
namespace App\Plugin;
use GeoIp2\Database\Reader;

/*
 * DOCUMENTATION:
 * https://github.com/maxmind/GeoIP2-php
 */
class Geoip extends \GeoIp2\Database\Reader {
	# Database access needed for some calculations
	/**
	 * @var mixed
	 */
	private $db;
	# Search radius properties
	/**
	 * @var array
	 */
	public $radius = [];
	# Use MaxMind GeoIP data to determine user location
	/**
	 * @var mixed
	 */
	private $record;
	/**
	 * @var mixed
	 */
	public $ip_address;
	/**
	 * @var mixed
	 */
	public $latitude;
	/**
	 * @var mixed
	 */
	public $longitude;
	/**
	 * @var mixed
	 */
	public $city;
	/**
	 * @var mixed
	 */
	public $state;
	/**
	 * @var mixed
	 */
	public $state_abbr;
	/**
	 * @var mixed
	 */
	public $zipcode;
	/**
	 * @var mixed
	 */
	public $country;
	/**
	 * @var mixed
	 */
	public $country_abbr;

	/**
	 * @param $geo_db_file
	 * @param $db
	 */
	public function __construct($geo_db_file, $db) {
		$this->db         = $db;
		$reader           = new Reader($geo_db_file);
		$ip               = MY_IP4;
		$this->ip_address = $ip;

		$record = $reader->city($ip);

		$this->record = $reader->city($ip);
		// City name
		$this->city = $this->record->city->name;
		// State name
		$this->state = $this->record->mostSpecificSubdivision->name;
		// Two letter abbreviation for state
		$this->state_abbr = $this->record->mostSpecificSubdivision->isoCode;
		// Five digit zip code
		$this->zipcode = $this->record->postal->code;
		// Country name
		$this->country = $record->country->name;
		// Two letter abbreviation for country
		$this->country_abbr = $record->country->isoCode;
		// Latitude and longitude
		$this->latitude  = $this->record->location->latitude;
		$this->longitude = $this->record->location->longitude;
	}

	/**
	 * @return mixed
	 */
	public function ip() {
		return $this->ip_address;
	}

	/**
	 * @param $lat1
	 * @param $lon1
	 * @param $lat2
	 * @param $lon2
	 * @param $unit
	 * @return mixed
	 */
	public function distance($lat1, $lon1, $lat2, $lon2, $unit = "M") {
		$theta = $lon1 - $lon2;
		$dist  = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist  = acos($dist);
		$dist  = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$unit  = strtoupper($unit);

		if ($unit == "K") {
			return ($miles * 1.609344);
		} else if ($unit == "N") {
			return ($miles * 0.8684);
		} else {
			if ($miles < 10) {
				$miles = number_format($miles, 1, '.', '');
			} else {
				$miles = number_format($miles);
			}

			return $miles;
		}
	}

	/**
	 * @param $miles
	 * @return mixed
	 */
	public function search_radius($miles): \PDOStatement{
		# This function will try to find all cities within a given radius based on
		# the current visitor's location
		$query = "SELECT DISTINCT citycode, statecode, code,
		(
			3959 * acos( cos( radians( ? ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians( ? ) ) + sin( radians( ? ) ) * sin( radians( latitude ) ) )
		)
		AS distance
		FROM zips
		HAVING distance <= $miles ORDER BY distance ASC;
";

		$cities_in_radius = $this->db->prepare($query);
		$cities_in_radius->execute([$this->latitude, $this->longitude, $this->latitude]);

		return $cities_in_radius;
	}

	/**
	 * @param $zip
	 * @return mixed
	 */
	public function cities($zip) {
		# Return a list of cities for the specified state or zip code
		if (strlen($zip) === 5) {
			# Search by zip code
			$q = "SELECT citycode, statecode FROM zips WHERE code = ? ";
			$s = $this->db->prepare($q);
			$s->execute([$zip]);
		} else {
			# Search by state
			$q = "SELECT citycode FROM zips WHERE statecode = ? ";
			$s = $this->db->prepare($q);
			$s->execute([$zip]);
		}

		if ($s) {
			return $s;
		}

		return false;
	}

	/**
	 * @param $zip
	 * @return mixed
	 */
	public function states($zip) {
		$q = "SELECT statecode FROM zips WHERE code = ? ";
		$s = $this->db->prepare($q);
		$s->execute([$zip]);

		return $s;
	}

	/**
	 * @param $city
	 * @param $state
	 * @return mixed
	 */
	public function zipcode($city, $state) {
		$q = "SELECT code FROM zips WHERE citycode = ? AND statecode = ? ";
		$s = $this->db->prepare($q);
		$s->execute([$city, $state]);
		return $s['code'];
	}

}
