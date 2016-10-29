<?php
require_once 'config.php';
function curl_url($url) {
	$ch = curl_init(); 
	$timeout = 5; 
	curl_setopt ($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_HEADER, 0); 
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
	$contents = curl_exec($ch);
	return $contents;
}

function transform_date($date) {
	$year = substr($date, 0, 4);
	$month = substr($date, 4, 2);
	$day = substr($date, 6, 2);
	$hour = substr($date, 8, 2);
	$minute = substr($date, 10, 2);
	$second = substr($date, 12, 2);
	return $year.'-'.$month.'-'.$day.' '.$hour.':'.$minute.':'.$second;
}
$xml_url = XML_URL;

$file_is_exists = true;
if (stripos($xml_url, 'http') === false) {
	$xml_info = @file_get_contents($xml_url);
	if (empty($xml_info)) {
		$file_is_exists = false;
	}
} else { 
	$xml_info = curl_url($xml_url);
	if (preg_match('/404/', $xml_info)) {
		$file_is_exists = false;
	} 
}

$mediaserver_arr = array();
$logserver_arr = array();
$lastuploadtime = 0;
$lastprocesstime = 0;
$nextuploadtime = 0;
$hourline = array();
if ($file_is_exists) {
	$xml_info = strtolower($xml_info);
	$xml_info = iconv('gbk', 'utf-8', $xml_info);
	$simplexml = simplexml_load_string($xml_info);

	if (isset($simplexml->mediaserver)) {
		foreach ($simplexml->mediaserver as $mediaserver) {
			$mediaserver_arr[] = $mediaserver;
		}
	}

	if (isset($simplexml->logserver)) {
		foreach ($simplexml->logserver as $logserver) {
			$logserver_arr[] = $logserver;
		}
	}

	if (isset($simplexml->lastuploadtime)) {
		$lastuploadtime = $simplexml->lastuploadtime;
	}

	if (isset($simplexml->lastprocesstime)) {
		$lastprocesstime = $simplexml->lastprocesstime;
	}

	if (isset($simplexml->nextuploadtime)) {
		$nextuploadtime = $simplexml->nextuploadtime;
	}

	if (isset($simplexml->hourline)) {
		$hourline = $simplexml->hourline;
	}
}

$ajax_info = array(
	'status'	=> $file_is_exists ? 1 : 0,
	'mediaserver' => $mediaserver_arr,
	'logserver'	 => $logserver_arr,
	'lastuploadtime'	=> transform_date($lastuploadtime),
	'lastprocesstime' => transform_date($lastprocesstime),
	'nextuploadtime'	=> transform_date($nextuploadtime),
	'hourline'	=> $hourline,
);
echo json_encode($ajax_info);