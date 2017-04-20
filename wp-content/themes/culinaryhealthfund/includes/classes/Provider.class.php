<?php
include_once (PATH_CLASS . 'Geocoder.class.php');

class Provider
{
	const HOME_ZIP = '89104';

	public function __construct()
	{
		global $db, $geoCoder;

		$this->db = $db;
		$this->geo = $geoCoder;

	}

	public function getDoctorTypes() {

		$sql = "SELECT Description as type
				FROM PpoNetwork
				GROUP BY Description
				";
		$types = $this->db->safeReadQueryAll($sql);

		foreach ($types as $t) {
			$drTypes[$t['type']] = $t['type'];
		}

		return $drTypes;

	}

	public function validZip($zip)
	{
		$sql = "SELECT zipcode, lattitude, longitude
				FROM zipcodes
				WHERE zipcode = %s";

		$zipCodeData = $this->db->safeReadQueryFirst($sql, $zip);

		if ($zipCodeData) {
			return true;
		}

		return false;

	}

	public function getZipDataGoogle($address, $city, $state, $zip)
	{
		$geoCoder = new GeoCoder();
		$completeAddress = $address . ' ' . $city . ', ' . $state . ' ' . $zip;
		$geoInfo = $geoCoder->getLocation($completeAddress);

		$geoInfo['lattitude'] = $geoInfo['lat'];
		$geoInfo['longitude'] = $geoInfo['lng'];

		return $geoInfo;

	}

	public function getZipCodeData($zip)
	{
		$sql = "SELECT zipcode, lattitude, longitude
				FROM zipcodes
				WHERE zipcode = %s";

		$zipCodeData = $this->db->safeReadQueryFirst($sql, $zip);

		return $zipCodeData;


	}

	public function getDistance($fromZip, $toZip)
	{

		$fromZipInfo = $this->getZipCodeData($fromZip);
		$toZipInfo = $this->getZipCodeData($toZip);

	    $radius      = 3958;      // Earth's radius (miles)
	    $deg_per_rad = 57.29578;  // Number of degrees/radian (for conversion)

	    $distance = ($radius * pi() * sqrt(
	                ($fromZipInfo['lattitude'] - $toZipInfo['lattitude'])
	                * ($fromZipInfo['lattitude'] - $toZipInfo['lattitude'])
	                + cos($fromZipInfo['lattitude'] / $deg_per_rad)  // Convert these to
	                * cos($toZipInfo['lattitude'] / $deg_per_rad)  // radians for cos()
	                * ($fromZipInfo['longitude'] - $toZipInfo['longitude'])
	                * ($fromZipInfo['longitude'] - $toZipInfo['longitude'])
	        ) / 180);

	    return $distance;  // Returned using the units used for $radius.
	}

	public function filterOutDistance($results, $zipCode, $range)
	{

	}

	public function searchProviders($facility='', $type='', $language='', $address='', $city='', $state='', $zip='', $range='', $page, $perPage, $print=0)
	{
		$geoInfo = $this->getZipDataGoogle($address, $city, $state, $zip);

		if (!$geoInfo) {
			$geoInfo = $this->getZipDataGoogle($address, $city, $state, self::HOME_ZIP);
		}

		$startRec = ($page - 1) * $perPage;
		$startRec = ($print == 1) ? 0 : $startRec;
		$perPage = ($print == 1) ? 10000 : $perPage;

		$language = ($language == "ALL") ? "" : $langauge;
		$type = ($type == "0") ? "" : $type;


		$arguments = array();
		$colString = "";
		if (strlen($facility)) {
			$colString .= sprintf(" AND p.Name like '%s' || p.Practice like '%s'", "%%".$facility."%%", "%%".$facility."%%");
		}

		if (strlen($type)) {
			$colString .= sprintf(" AND p.Description like '%s", "%%".$type."%%'");
		}

		if (strlen($language)) {
			$colString .= sprintf(" AND p.Languages like '%s", "%%".$language."%%'");
		}


		$sql = "SELECT SQL_CALC_FOUND_ROWS
				p.RowId as id, p.name, p.Practice as practice, p.Description as type, p.Address as address, p.City as city, p.State as state, p.Zip as zip, p.Phone as phone, p.Languages as languages, p.DirectoryComments as directorycomments,

				acos(
				        ( sin(p.Latitude * 0.017453293)*sin({$geoInfo['lattitude']} * 0.017453293) )
				    +
				        ( cos(p.Latitude * 0.017453293) *
				          cos({$geoInfo['lattitude']} * 0.017453293) *
				          cos(({$geoInfo['longitude']}*0.017453293)-(p.Longitude*0.017453293))
				        )
				    )
				* 3956 as distance

				FROM PpoNetwork AS p

				WHERE 1=1{$colString}
				HAVING distance < %d
				ORDER BY distance asc
				LIMIT {$startRec}, {$perPage}
				";

		array_unshift($arguments, $sql);
		array_push($arguments, $range);

		$results['results'] = call_user_func_array(array($this->db, "safeQuery"), $arguments);
		$results['count'] = $this->db->foundRows();

		return $results;

	}

	public function getDistances() {
		$distance     = array("2" => "2 Miles",
						  "5"    => "5 Miles",
						  "10"    => "10 Miles",
						  "25"    => "25 Miles",
						  "100"   => "100 Miles");
		return $distance;
	}

	public function getLanguages() {

		$languages = array(
		'ALL'                         => 'ALL',
		'AFRIKAANS'               => 'AFRIKAANS',
		'AMERICAN SIGN LANGUAGE'  => 'AMERICAN SIGN LANGUAGE',
		'AMHARIC'                 => 'AMHARIC',
		'ARABIC'                  => 'ARABIC',
		'ARMENIAN'                => 'ARMENIAN',
		'BANGLA'                  => 'BANGLA',
		'BENGALI'                 => 'BENGALI',
		'BISAYA'                  => 'BISAYA',
		'BOSNIAN'                 => 'BOSNIAN',
		'BULGARIAN'               => 'BULGARIAN',
		'BURMESE'                 => 'BURMESE',
		'CANTONESE'               => 'CANTONESE',
		'CASTILIAN'               => 'CASTILIAN',
		'CEBUANA'                 => 'CEBUANA',
		'CHINESE'                 => 'CHINESE',
		'CROATIAN'                => 'CROATIAN',
		'CZECH'                   => 'CZECH',
		'DUTCH'                   => 'DUTCH',
		'FARSI'                   => 'FARSI',
		'FINNISH'                 => 'FINNISH',
		'FRENCH'                  => 'FRENCH',
		'GEORGIAN'                => 'GEORGIAN',
		'GERMAN'                  => 'GERMAN',
		'GREEK'                   => 'GREEK',
		'GUJARATI'                => 'GUJARATI',
		'HATIAN CREOLE'           => 'HATIAN CREOLE',
		'HAWAIIAN'                => 'HAWAIIAN',
		'HEBREW'                  => 'HEBREW',
		'HINDI'                   => 'HINDI',
		'HUNGARIAN'               => 'HUNGARIAN',
		'IBO'                     => 'IBO',
		'IGBO'                    => 'IGBO',
		'ILOCANO'                 => 'ILOCANO',
		'INDONESIAN'              => 'INDONESIAN',
		'IRANIAN'                 => 'IRANIAN',
		'IRISH'                   => 'IRISH',
		'ITALIAN'                 => 'ITALIAN',
		'JAPANESE'                => 'JAPANESE',
		'KANNADA'                 => 'KANNADA',
		'KESHMIRI'                => 'KESHMIRI',
		'KOREAN'                  => 'KOREAN',
		'LLAKANO'                 => 'LLAKANO',
		'LOATIAN'                 => 'LOATIAN',
		'MACEDONIAN'              => 'MACEDONIAN',
		'MALAY'                   => 'MALAY',
		'MANDARIN'                => 'MANDARIN',
		'MARATHI'                 => 'MARATHI',
		'NAVAJO'                  => 'NAVAJO',
		'NIGERIAN'                => 'NIGERIAN',
		'NORWEGIAN'               => 'NORWEGIAN',
		'PAKISTANI'               => 'PAKISTANI',
		'PASHTO'                  => 'PASHTO',
		'PASHTO'                  => 'PASHTO',
		'PERSIAN'                 => 'PERSIAN',
		'POLISH'                  => 'POLISH',
		'PORTUGUESE'              => 'PORTUGUESE',
		'PUNJABI'                 => 'PUNJABI',
		'ROMAINIAN'               => 'ROMAINIAN',
		'RUSSIAN'                 => 'RUSSIAN',
		'SERBIAN'                 => 'SERBIAN',
		'SERBO-CROATION'          => 'SERBO-CROATION',
		'SIGN LANGUAGE (ASL)'     => 'SIGN LANGUAGE (ASL)',
		'SINGALESE'               => 'SINGALESE',
		'SLOVAK'                  => 'SLOVAK',
		'SPANISH'                 => 'SPANISH',
		'SWAHILI'                 => 'SWAHILI',
		'SWEDISH'                 => 'SWEDISH',
		'SWISS'                   => 'SWISS',
		'TAGALOG'                 => 'TAGALOG',
		'TAIWANESE'               => 'TAIWANESE',
		'TAMIL'                   => 'TAMIL',
		'TELUGU'                  => 'TELUGU',
		'THAI'                    => 'THAI',
		'TURKISH'                 => 'TURKISH',
		'UKRANIAN'                => 'UKRANIAN',
		'URAN'                    => 'URAN',
		'URDU'                    => 'URDU',
		'VIETNAMESE'              => 'VIETNAMESE',
		'VISCAYAN'                => 'VISCAYAN',
		'YIDDISH'                 => 'YIDDISH',
		'YORUBA'                  => 'YORUBA');

		return $languages;



	}

	function getAvailableStates()
	{

		$statesList = array(

			'AL'=>"Alabama",
			'AK'=>"Alaska",
			'AZ'=>"Arizona",
			'AR'=>"Arkansas",
			'CA'=>"California",
			'CO'=>"Colorado",
			'CT'=>"Connecticut",
			'DE'=>"Delaware",
			'DC'=>"District Of Columbia",
			'FL'=>"Florida",
			'GA'=>"Georgia",
			'HI'=>"Hawaii",
			'ID'=>"Idaho",
			'IL'=>"Illinois",
			'IN'=>"Indiana",
			'IA'=>"Iowa",
			'KS'=>"Kansas",
			'KY'=>"Kentucky",
			'LA'=>"Louisiana",
			'ME'=>"Maine",
			'MD'=>"Maryland",
			'MA'=>"Massachusetts",
			'MI'=>"Michigan",
			'MN'=>"Minnesota",
			'MS'=>"Mississippi",
			'MO'=>"Missouri",
			'MT'=>"Montana",
			'NE'=>"Nebraska",
			'NV'=>"Nevada",
			'NH'=>"New Hampshire",
			'NJ'=>"New Jersey",
			'NM'=>"New Mexico",
			'NY'=>"New York",
			'NC'=>"North Carolina",
			'ND'=>"North Dakota",
			'OH'=>"Ohio",
			'OK'=>"Oklahoma",
			'OR'=>"Oregon",
			'PA'=>"Pennsylvania",
			'RI'=>"Rhode Island",
			'SC'=>"South Carolina",
			'SD'=>"South Dakota",
			'TN'=>"Tennessee",
			'TX'=>"Texas",
			'UT'=>"Utah",
			'VT'=>"Vermont",
			'VA'=>"Virginia",
			'WA'=>"Washington",
			'WV'=>"West Virginia",
			'WI'=>"Wisconsin",
			'WY'=>"Wyoming");

		return $statesList;

	}

}

?>
