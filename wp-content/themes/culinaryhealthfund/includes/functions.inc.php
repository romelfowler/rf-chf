<?php

if (!function_exists('getFormOptions')) {
    
    function getFormOptions($options, $default=null, $with_empty=true, $key=false)
	{
	  $s_options = '';
	
	  if ($with_empty)
	  {
	      $s_options .= '<option value="">Select one...</option>';
	  }
	
	  foreach ($options as $k => $v)
	  {
	    $theKey = $v;
	    if ($key) {
	      $theKey = $v[$key];
	    } 
	      $s_options .= '<option value="' . $k . '"' . getFormSelected($k, $default) . '>' . $theKey . '</option>';
	  }
	
	  return $s_options;
	}
}
	
if (!function_exists('getFormSelected')) {

	function getFormSelected($value, $default=false)
	{
	  if (strlen($default) > 0)
	  {
	      return $value == $default ? ' selected' : '';
	  }
	  else
	  {
	      return '';
	  }
	}
}

function htmlEncode($fields)
{
	if (is_array($fields))
	{
		$safe_fields = array();

		foreach ($fields as $k => $v)
		{
			$safe_fields[$k] = htmlEncode($v);
		}

		return $safe_fields;
	}
	else
	{
		$encodedHtml = htmlentities($fields, ENT_QUOTES, 'UTF-8');
		$encodedHtml = htmlentities($fields, ENT_QUOTES, 'ISO-8859-15');
		$encodedHtml = preg_replace('/(&amp;)(gt;|lt;|#(\d+);)/', '&$2', $encodedHtml);
		return $encodedHtml;
	}
}

function htmlDecode($fields)
{
	if (is_array($fields))
	{
		$safe_fields = array();

		foreach ($fields as $k => $v)
		{
			$safe_fields[$k] = htmlDecode($v);
		}

		return $safe_fields;
	}
	else
	{
		$decodedHtml = html_entity_decode($fields, ENT_QUOTES, 'UTF-8');
        $decodedHtml = html_entity_decode($fields, ENT_QUOTES, 'ISO-8859-15');
		return $decodedHtml;
	}
}

function boolToYesNo($value)
{
  return $value ? '<span class="true">Yes</span>' : '<span class="false">No</span>';
}

function getElapsedTime($value, $type='seconds', $shorthand = FALSE, $singleMeasure = NULL)
{
    if ($value == 0)
    {
        return 'Time Expired';
    }

        $elapsed['Days'] = (int)($value / 86400);
        $value = $value % 86400;

        $elapsed['Hours'] = (int)($value / 3600);
        $value = $value % 3600;

        $elapsed['Minutes'] = (int)($value / 60);
        $value = $value % 60;

        if ($singleMeasure) {
        	if (round($elapsed['Days'])) { return pluralize($elapsed['Days'], ' day', ' days') . ' ago'; }
        	if (round($elapsed['Hours'])) { return pluralize($elapsed['Hours'], ' hour', ' hours') . ' ago'; }
        	if (round($elapsed['Minutes'])) { return pluralize($elapsed['Minutes'], ' minute', ' minutes') . ' ago'; }
         	if (round($originalValue)) { return pluralize($originalValue, ' second', ' seconds') . ' ago'; }
        }
        	
        if ($type =='seconds')
        {
                $elapsed['Seconds'] = $value;        
        }
        
        $elapsed_time = '';
        
        if ($elapsed['Minutes'])
        {
                foreach ($elapsed as $k => $v)
                {
                        if ($v > 0) {
                          if ($shorthand) {
          $elapsed_time .= ', ' . $v . substr($k, 0, 1);
        } else {
          $elapsed_time .= ', ' . pluralize($v, substr($k, 0, strlen($k)-1), $k);
        }
                        }
                }        
                $elapsed_time = substr($elapsed_time, 2);
        }
        else
        {
                $elapsed_time = "Time Expired";
        }
        
        return $elapsed_time;
}

function pluralize($number, $singular, $plural)
{
        return $number . ' ' . ($number == 1 ? $singular : $plural);
}

function getMessageBox($message)
{
  $msgbox  = '<div class="msgbox">';
  $msgbox .= $message;
  $msgbox .= '</div>';

  return $msgbox;
}

function redirect($url)
{
	echo '<meta http-equiv="refresh" content="0; URL=' . $url . '">';
	exit;
}

function showManageRedirect($message, $url)
{
  include_once(ADMIN_PATH_INCLUDE . 'header.inc.php');

  echo '<meta http-equiv="refresh" content="1; URL=' . $url . '">';
  echo getMessageBox($message);

  include_once(ADMIN_PATH_INCLUDE . 'footer.inc.php');
  exit;
}

function tsDisplay($timestamp)
{
	$dateTime = date('M d Y g:i:s A', $timestamp);

	return $dateTime;
}



function timeDrop($fieldName, $defaultValue)
{
	$startTime = strtotime('12:00am');
	$endTime = strtotime('11:45pm');

	$dropDown =  '<select name="'.$fieldName.'" style="width:100px;">';
	for ($i = $startTime; $i <= $endTime; $i += 900)
	{
		$selectedTxt = (date('g:i a', $i) == $defaultValue) ? 'selected' : '';
		$dropDown .= '<option value="'.date('g:i a', $i).'" ' . $selectedTxt . '>' . date('g:i a', $i);
	}
	$dropDown .= '</select>';
	return $dropDown;
}

function prettyPrintJSON ($json) {
	$result = '';
    $level = 0;
    $prev_char = '';
    $in_quotes = false;
    $ends_line_level = NULL;
    $json_length = strlen( $json );

    for( $i = 0; $i < $json_length; $i++ ) {
        $char = $json[$i];
        $new_line_level = NULL;
        $post = "";
        if( $ends_line_level !== NULL ) {
            $new_line_level = $ends_line_level;
            $ends_line_level = NULL;
        }
        if( $char === '"' && $prev_char != '\\' ) {
            $in_quotes = !$in_quotes;
        } else if( ! $in_quotes ) {
            switch( $char ) {
                case '}': case ']':
                    $level--;
                    $ends_line_level = NULL;
                    $new_line_level = $level;
                    break;

                case '{': case '[':
                    $level++;
                case ',':
                    $ends_line_level = $level;
                    break;

                case ':':
                    $post = " ";
                    break;

                case " ": case "\t": case "\n": case "\r":
                    $char = "";
                    $ends_line_level = $new_line_level;
                    $new_line_level = NULL;
                    break;
            }
        }
        if( $new_line_level !== NULL ) {
            $result .= "\n".str_repeat( "\t", $new_line_level );
        }
        $result .= $char.$post;
        $prev_char = $char;
    }
    return $result;
}


function shortenURL($url)
{
    $bitlyAccessToken = "5f8ccda1039de0fc14261d8a4dc0e0df1c8a2542";
    $url = urlencode($url);
    
    $request = new HttpRequest();

    $requestURL="https://api-ssl.bitly.com/v3/shorten?access_token=".$bitlyAccessToken."&longUrl=".$url;
    $response = $request->get($requestURL, $params, true);
    
    $result = json_decode($response->body);
    
    return $result->data->url;

}


function time_passed($timestamp)
{
    $diff = time() - (int)$timestamp;

    if ($diff == 0) 
         return 'just now';

    $intervals = array
    (
        1                   => array('year',    31556926),
        $diff < 31556926    => array('month',   2628000),
        $diff < 2629744     => array('week',    604800),
        $diff < 604800      => array('day',     86400),
        $diff < 86400       => array('hour',    3600),
        $diff < 3600        => array('minute',  60),
        $diff < 60          => array('second',  1)
    );

     $value = floor($diff/$intervals[1][1]);
     return $value.' '.$intervals[1][0].($value > 1 ? 's' : '').' ago';
}

function getOrdinal($number, $format=false, $super=true)
{
    if ($number % 100 > 10 && $number %100 < 14)
  {
        $suffix = "th";
  }
  else
  {
        switch ($number % 10)
    {
            case 0:
                $suffix = "th";
                break;
            case 1:
                $suffix = "st";
                break;
            case 2:
                $suffix = "nd";
                break;
            case 3:
                $suffix = "rd";
                break;
            default:
                $suffix = "th";
                break;
        }
  }

  $num = $format ? number_format($number) : $number;
  
  if (!$num) {
	  return '-';
  }
  
  return $super ? $num . '<sup>' . $suffix . '</sup>' : $num . $suffix;
}

function logData($nameLog, $data) {
    $logPath = '/var/log/applogs/';
    $logFile = $nameLog.'.log';
    
    if (!is_dir($logPath)) {
            mkdir($logPath, 0775);
    }
    
    $dataString="";
    
    $cnt = 0;
    foreach ($data as $k => $v) {
        $cnt++;
        $delim = ($cnt == count($data)) ? '' : ', ';
        $dataString .= $k . ' = ' . $v . $delim;
    }
    
    $msg = $_SERVER['SERVER_ADDR'] . ':' . TIME_NOW . ': ' . $dataString;
    $fh = fopen($logPath.$logFile,'a');
    if($fh) {
            fputs($fh, $msg . "\n");
            fclose($fh);
    }
}

function getIPAddress()
{

  $ipAddr = $_SERVER['REMOTE_ADDR'];
  
  return $ipAddr;
  
}

function blockedOutEmail($email)
{

  $emailParts = explode("@", $email);
  
  $firstLetter = substr($emailParts[0], 0, 1);
  
  $lastLetter = substr($emailParts[0], (strlen($emailParts[0]) - 1), 1);
  
  $stars = strlen($emailParts[0]) - 2;
  $starsTxt = "";
  $x=0;
  While ($x != $stars) {
    $starsTxt.="*";
    $x++;
  }

  $blackedOutEmail =  $firstLetter.$starsTxt.$lastLetter."@".$emailParts[1];
  
  return $blackedOutEmail;

}

function getAvailableStates($default = NULL)
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

function arraySortByColumn(&$arr, $col, $dir = SORT_ASC) {
	
    $sort_col = array();
    
    foreach ($arr as $key => $row) {
    	$sort_col[$key] = $row[$col];
        
    }

    array_multisort($sort_col, $dir, $arr);
    
    return $arr;
    
}

function formatPhoneNumber($phoneNumber) {
    $phoneNumber = preg_replace('/[^0-9]/','',$phoneNumber);

    if(strlen($phoneNumber) > 10) {
        $countryCode = substr($phoneNumber, 0, strlen($phoneNumber)-10);
        $areaCode = substr($phoneNumber, -10, 3);
        $nextThree = substr($phoneNumber, -7, 3);
        $lastFour = substr($phoneNumber, -4, 4);

        $phoneNumber = '+'.$countryCode.' ('.$areaCode.') '.$nextThree.'-'.$lastFour;
    }
    else if(strlen($phoneNumber) == 10) {
        $areaCode = substr($phoneNumber, 0, 3);
        $nextThree = substr($phoneNumber, 3, 3);
        $lastFour = substr($phoneNumber, 6, 4);

        $phoneNumber = '('.$areaCode.') '.$nextThree.'-'.$lastFour;
    }
    else if(strlen($phoneNumber) == 7) {
        $nextThree = substr($phoneNumber, 0, 3);
        $lastFour = substr($phoneNumber, 3, 4);

        $phoneNumber = $nextThree.'-'.$lastFour;
    }

    return $phoneNumber;
}

?>