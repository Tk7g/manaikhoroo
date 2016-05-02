<?php
error_reporting(0);
require(realpath(dirname(__FILE__))."/config/settings.php");
require_once(realpath(dirname(__FILE__))."/classes/Faq.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Sanal.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Link.class.php");
require_once(realpath(dirname(__FILE__))."/classes/User.class.php");
require_once(realpath(dirname(__FILE__))."/classes/District.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Region.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Marker.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Section.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Playground.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Torongarts.class.php");
require_once(realpath(dirname(__FILE__))."/classes/Risks.class.php");

session_start();

$action = isset( $_GET['page'] ) ? $_GET['page'] : "";

switch ( $action ) {
	case 'getRegionMarkers':
		getRegionMarkers();
		break;
	case 'regionBorder':
		regionBorder();
		break;
	case 'sectionBorder':
		sectionBorder();
		break;
	case 'playgroundBorder':
		playgroundBorder();
		break;
	case 'torongartsBorder':
		torongartsBorder();
		break;
	case 'risksBorder':
		risksBorder();
		break;
	case 'getNonPublishedRegionMarkers':
		getNonPublishedRegionMarkers();
		break;
	case 'saveMarker':
		saveMarker();
		break;
}

function risksBorder() {
	$results = Risks::getRisksBorder($_GET['risks']);
	preg_match_all("/\(([^\)]*)\)/", $results['coordinate'], $matches);
	$data['coordinate'] = array();
	$k = 0;
	foreach($matches[1] as $result) {
		$data['coordinate'][$k] = explode(',', $result, 2);
		$k = $k + 1;
	}
	header('Content-type: application/json');
	echo json_encode($data);
}

function torongartsBorder() {
	$results = Torongarts::getTorongartsBorder($_GET['torongarts']);
	preg_match_all("/\(([^\)]*)\)/", $results['coordinate'], $matches);
	$data['coordinate'] = array();
	$k = 0;
	foreach($matches[1] as $result) {
		$data['coordinate'][$k] = explode(',', $result, 2);
		$k = $k + 1;
	}
	header('Content-type: application/json');
	echo json_encode($data);
}

function playgroundBorder() {
	$results = Playground::getPlaygroundBorder($_GET['playground']);
	preg_match_all("/\(([^\)]*)\)/", $results['coordinate'], $matches);
	$data['coordinate'] = array();
	$k = 0;
	foreach($matches[1] as $result) {
		$data['coordinate'][$k] = explode(',', $result, 2);
		$k = $k + 1;
	}
	header('Content-type: application/json');
	echo json_encode($data);
}

function SectionBorder() {
	$results = Section::getSectionBorder($_GET['section']);
	preg_match_all("/\(([^\)]*)\)/", $results['coordinate'], $matches);
	$data['coordinate'] = array();
	$k = 0;
	foreach($matches[1] as $result) {
		$data['coordinate'][$k] = explode(',', $result, 2);
		$k = $k + 1;
	}
	header('Content-type: application/json');
	echo json_encode($data);
}

function saveMarker() {
	User::allowExecute(4);
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$_POST['region_id'] = $_GET['r'];
		$_POST['district_id'] = $_GET['d'];
		$marker = Marker::userSaveMarker($_GET['type'], $_POST, $_SESSION['login']['username']);
		if($marker == FALSE) {
			echo "Хадгалах явцад алдаа гарлаа.";
		} else {
			echo "Тэмдэглэгээ амжилттай хадгалагдлаа";	
		}
	}
}

function getNonPublishedRegionMarkers() {
	User::allowExecute(4);
	$results = Marker::nonPublishedRegionMarker($_GET['type'], $_GET['r'], $_GET['id']);
	if($results == NULL) {
		$results = Marker::PublishedRegionMarker($_GET['type'], $_GET['r'], $_GET['id']);
	}
	$data['coordinate'] = array();
	$k = 0;
	foreach($results as $result) {
		$data['coordinate'][$k][] = $result['latitude'];
		$data['coordinate'][$k][] = $result['longitude'];
		$k = $k + 1;
	}
	header('Content-type: application/json');
	echo json_encode($data);
}

function getRegionMarkers() {
	User::allowExecute(4);
	$results = Marker::regionMarkers($_GET['type'], $_GET['r']);
	$data['coordinate'] = array();
	$k = 0;
	foreach($results as $result) {
		$data['coordinate'][$k][] = $result['latitude'];
		$data['coordinate'][$k][] = $result['longitude'];
		$k = $k + 1;
	}
	header('Content-type: application/json');
	echo json_encode($data);
}

function regionBorder() {
		User::allowExecute(4);
		$results = Marker::getRegionborder($_GET['region']);
		$data['coordinate'] = array();
		$k = 0;
		foreach($results as $result) {
			$data['coordinate'][$k] = explode(',', $result['coordinate'], 2);
			$k = $k + 1;
		}
		header('Content-type: application/json');
		echo json_encode($data);
}

?>