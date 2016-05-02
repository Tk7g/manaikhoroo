<?php
require_once(realpath(dirname(__FILE__))."/../config/config.php"); 
require_once(realpath(dirname(__FILE__))."/../config/Database.class.php");
define('TABLE_MARKERS', "kh_markers");

class Marker {
	
	public static function getTotalRows($district, $region, $type) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sqlAdd = "";
		if($district != NULL) {
			$sqlAdd .= "AND district_id = $district ";
		}
		if($region != NULL) {
			$sqlAdd .= "AND region_id = $region ";
		}
		if($type != NULL) {
			$sqlAdd .= "AND type_id = $type ";
		}
		$sql = "SELECT COUNT(*) FROM kh_markers WHERE civ_created = 0 AND created IS NOT NULL AND modified IS NOT NULL $sqlAdd";
		$rows = $db->query_first($sql);
		$db->close();
		return $rows;
	}
	
	public static function getDistrictHistoryList($type, $district, $region) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sqlAdd = '';
		if($region != NULL) {
			$sqlAdd .= "AND region_id = $region ";
		}
		$sql = "SELECT * FROM kh_markers WHERE civ_created = 0 AND created IS NOT NULL AND modified IS NOT NULL AND district_id = $district AND type_id = $type $sqlAdd ORDER BY created DESC";
		$results = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}
	
	public static function getHistoryList($from, $limit, $district, $region, $type) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		if($district != NULL) {
			$sqlAdd .= "AND district_id = $district ";
		}
		if($region != NULL) {
			$sqlAdd .= "AND region_id = $region ";
		}
		if($type != NULL) {
			$sqlAdd .= "AND type_id = $type ";
		}
		$sql = "SELECT * FROM kh_markers WHERE civ_created = 0 AND created IS NOT NULL AND modified IS NOT NULL $sqlAdd ORDER BY id DESC LIMIT $from, $limit";
		$results = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}
	
	public static function getMarkerGroups() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM group_types ORDER BY id ASC";
		$results = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}
	
	public static function getGroupMarkers($type) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_types WHERE group_type = $type ORDER BY queue ASC";
		$results = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}
	
	public static function getDistrictAreaLength($district, $year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_infos WHERE district_id LIKE ".$district." AND region_id IS NULL AND year LIKE ".$year."";
		$results = $db->query_first($sql);
		$db->close();
		return $results;
	}
	
	public static function getMarker($id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_markers WHERE id = ".$id."";
		$results = $db->query_first($sql);
		$db->close();
		return $results;
	}
	
	public static function getRegionAreaLength($region, $year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_infos WHERE region_id LIKE ".$region." AND section_id LIKE 0 AND year LIKE ".$year."";
		$results = $db->query_first($sql);
		$db->close();
		return $results;
	}

	public static function getCivDistrictMarker($id, $district_accept) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_markers.*, kh_types.title as typeTitle, kh_types.image as typeImage, kh_districts.title as districtTitle, kh_regions.title as regionTitle, kh_regions.image as regionImage, kh_users.firstname, kh_users.lastname, kh_users.identity, kh_users.phone, kh_users.email
				FROM kh_markers
				LEFT JOIN kh_types ON kh_markers.type_id=kh_types.id
				LEFT JOIN kh_regions ON kh_markers.region_id=kh_regions.id
				LEFT JOIN kh_districts ON kh_markers.district_id=kh_districts.id
				LEFT JOIN kh_users ON kh_markers.user_id=kh_users.id
				WHERE civ_created = 1 AND region_accepted = 1 AND kh_markers.district_accepted = ".$district_accept." AND kh_markers.id = ".$id."
				ORDER BY created DESC";
		$results = $db->query_first($sql);
		$db->close();
		return $results;
	}

	public static function getCivDistrictMarkers($district, $district_accept) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_markers.*, kh_types.title as typeTitle, kh_types.image as typeImage, kh_districts.title as districtTitle, kh_regions.title as regionTitle, kh_users.firstname, kh_users.lastname, kh_users.identity, kh_users.phone, kh_users.email
				FROM kh_markers
				LEFT JOIN kh_types ON kh_markers.type_id=kh_types.id
				LEFT JOIN kh_regions ON kh_markers.region_id=kh_regions.id
				LEFT JOIN kh_districts ON kh_markers.district_id=kh_districts.id
				LEFT JOIN kh_users ON kh_markers.user_id=kh_users.id
				WHERE civ_created = 1 AND region_accepted = 1 AND district_accepted = ".$district_accept." AND kh_markers.district_id = ".$district."
				ORDER BY created DESC";
		$results = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}

	public static function acceptDistrict($marker) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['district_accepted'] = 1;
		$data['published'] = 1;
		$db->query_update("kh_markers", $data, "id='".$marker['id']."'");
		$db->close();
	}

	public static function acceptRegion($marker) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['region_accepted'] = 1; 
		$db->query_update("kh_markers", $data, "id='".$marker['id']."'");
		$db->close();
	}
	
	public static function declineDistrict($marker) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['district_accepted'] = 0;
		$data['published'] = 0; 
		$db->query_update("kh_markers", $data, "id='".$marker['id']."'");
		$db->close();
	}
	
	public static function declineRegion($marker) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$data['region_accepted'] = 0; 
		$db->query_update("kh_markers", $data, "id='".$marker['id']."'");
		$db->close();
	}

	public static function getCivMarker($id, $region_accept) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_markers.*, kh_types.title as typeTitle, kh_types.image as typeImage, kh_districts.title as districtTitle, kh_regions.title as regionTitle, kh_regions.image as regionImage, kh_users.firstname, kh_users.lastname, kh_users.identity, kh_users.phone, kh_users.email
				FROM kh_markers
				LEFT JOIN kh_types ON kh_markers.type_id=kh_types.id
				LEFT JOIN kh_regions ON kh_markers.region_id=kh_regions.id
				LEFT JOIN kh_districts ON kh_markers.district_id=kh_districts.id
				LEFT JOIN kh_users ON kh_markers.user_id=kh_users.id
				WHERE civ_created = 1 AND region_accepted = ".$region_accept." AND kh_markers.id = ".$id."
				ORDER BY created DESC";
		$results = $db->query_first($sql);
		$db->close();
		return $results;
	}

	public static function getCivMarkers($region, $accepted) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_markers.*, kh_types.title as typeTitle, kh_types.image as typeImage, kh_districts.title as districtTitle, kh_regions.title as regionTitle, kh_users.firstname, kh_users.lastname, kh_users.identity, kh_users.phone, kh_users.email
				FROM kh_markers
				LEFT JOIN kh_types ON kh_markers.type_id=kh_types.id
				LEFT JOIN kh_regions ON kh_markers.region_id=kh_regions.id
				LEFT JOIN kh_districts ON kh_markers.district_id=kh_districts.id
				LEFT JOIN kh_users ON kh_markers.user_id=kh_users.id
				WHERE civ_created = 1 AND region_accepted = ".$accepted." AND kh_markers.region_id = ".$region." AND district_accepted = 0
				ORDER BY created DESC";
		$results = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}
	
	public static function getYears() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_years ORDER BY year DESC";
		$results = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}
	
	public static function myMarkers($userid) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_markers.*, kh_types.id as typeId, kh_types.title as typeTitle, kh_types.image as typeImage, kh_districts.title as districtTitle, kh_districts.id as districtId, kh_regions.id as regionid, kh_regions.title as regionTitle 
				FROM kh_markers 
				LEFT JOIN kh_types ON kh_markers.type_id=kh_types.id
				LEFT JOIN kh_regions ON kh_markers.region_id=kh_regions.id
				LEFT JOIN kh_districts ON kh_markers.district_id=kh_districts.id
				WHERE user_id = ".$userid." 
				ORDER BY created DESC";
		$results = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}

	public static function userSaveMarker($type, $marker, $username) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT id FROM kh_users WHERE username LIKE '".$username."'";
		$user = $db->query_first($sql);
		$data['type_id'] = $type; 
		$data['district_id'] = $marker['district_id'];
		$data['region_id'] = $marker['region_id'];
		$data['latitude'] = $marker['latitude'];
		$data['longitude'] = $marker['longitude'];
		$data['region_accepted'] = 0;
		$data['district_accepted'] = 0;
		$data['published'] = 0;
		$data['year'] = date('Y');
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$data['user_id'] = $user['id'];
		$data['civ_created'] = 1;
		$marker_id = $db->query_insert(TABLE_MARKERS, $data);
		$db->close();
		return $marker_id;
	}

	public static function getType($type) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_types WHERE id = ".$type;	
		$results = $db->query_first($sql);
		$db->close();
		return $results;
	}

	public static function getTypes() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_types ORDER BY queue ASC";	
		$results = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}
	
	public static function markerCount($type) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_types.title as type, kh_types.image as image, kh_types.id as typeid, COUNT(*)
				FROM ".TABLE_MARKERS."
				LEFT JOIN kh_types ON kh_markers.type_id=kh_types.id
				WHERE ".TABLE_MARKERS.".type_id LIKE ".$type."";	
		$results = $db->query_first($sql);
		$db->close();
		return $results;
	}
	
	public static function markerDistrictCount($type, $district) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_types.title as type, kh_types.image as image, kh_types.id as typeid, COUNT(*)
				FROM ".TABLE_MARKERS."
				LEFT JOIN kh_types ON kh_markers.type_id=kh_types.id
				WHERE ".TABLE_MARKERS.".district_id LIKE ".$district." AND type_id LIKE ".$type."";	
		$results = $db->query_first($sql);
		$db->close();
		return $results;
	}

	public static function cityTable($year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_infos WHERE district_id IS NULL AND region_id IS NULL AND year LIKE ".$year;
		$results['city'] = $db->query_first($sql);
		$db->close();
		return $results;
	}
	
	public static function getDistrictTableInfo($district) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$year_sql = "SELECT * FROM kh_years WHERE used = 1";
		$results['year'] = $db->query_first($year_sql);
		$sql = "SELECT * FROM kh_infos WHERE district_id LIKE ".$district." AND region_id IS NULL AND year LIKE ".$results['year']['year']."";
		$results['district_info'] = $db->query_first($sql);
		$sql = "SELECT *
				FROM kh_districts 
				WHERE id LIKE ".$district."";
		$results['district'] = $db->query_first($sql);
		$db->close();
		return $results;
	}

	public static function getRegionTableInfo($region) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$year_sql = "SELECT * FROM kh_years WHERE used = 1";
		$results['year'] = $db->query_first($year_sql);
		$sql = "SELECT * FROM kh_infos WHERE region_id LIKE ".$region." AND section_id LIKE 0 AND year LIKE ".$results['year']['year']."";
		$results['region_info'] = $db->query_first($sql);
		$sql = "SELECT kh_regions.*, kh_districts.title as districtTitle 
				FROM kh_regions 
				LEFT JOIN kh_districts ON kh_regions.district_id=kh_districts.id
				WHERE kh_regions.id LIKE ".$region."";
		$results['region'] = $db->query_first($sql);
		$db->close();
		return $results;
	}

	public static function addDistrictBorder($district) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_districtlines WHERE district_id LIKE ".$district." AND region_id IS NULL";
		$results['border'] = $db->fetch_all_array($sql);
		$sql = "SELECT * FROM kh_districts WHERE id LIKE ".$district."";
		$results['image'] = $db->query_first($sql);
		$db->close();
		return $results;
	}
	
	public static function regionView($district) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$year_sql = "SELECT * FROM kh_years WHERE used = 1";
		$results['year'] = $db->query_first($year_sql);
		$sql = "SELECT * FROM kh_districts WHERE id LIKE ".$district."";
		$results['district'] = $db->query_first($sql);
		$sql = "SELECT * FROM kh_regions WHERE district_id LIKE ".$district."";
		$results['regions'] = $db->fetch_all_array($sql);
		$sql = "SELECT * FROM kh_types ORDER BY queue";
		$results['types'] = $db->fetch_all_array($sql);
		foreach($results['regions'] as $region) {
			$sql = "SELECT * FROM kh_infos WHERE district_id LIKE ".$district." AND region_id LIKE ".$region['id']." AND section_id LIKE 0 AND year LIKE ".$results['year']['year']."";
			$results['region_infos'][$region['id']] = $db->query_first($sql);
		}
		$sql = "SELECT * FROM kh_districts ORDER BY title ASC";
		$results['districts'] = $db->fetch_all_array($sql);
		foreach($results['districts'] as $dist) {
			$sql = "SELECT * FROM kh_regions WHERE district_id LIKE ".$dist['id']." ORDER BY title ASC";
			$results[$dist['id']] = $db->fetch_all_array($sql);
		}
		$sql = "SELECT * FROM kh_infos WHERE district_id IS NULL AND region_id IS NULL AND year LIKE ".$results['year']['year'];
		$results['city'] = $db->query_first($sql);
		$sql = "SELECT * FROM kh_infos WHERE district_id LIKE ".$district." AND region_id IS NULL AND year LIKE ".$results['year']['year'];
		$results['district_info'] = $db->query_first($sql);
		$db->close();
		return $results;
	}
	
	public static function chartData($type) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$year_sql = "SELECT * FROM kh_years WHERE used = 1";
		$results['year'] = $db->query_first($year_sql);
		$sql = "SELECT * FROM kh_districts ORDER BY id ASC";
		$results['districts'] = $db->query_first($sql);
		foreach($results['districts'] as $district) {
			$sql = "SELECT * FROM kh_infos WHERE district_id LIKE ".$district." AND region_id IS NULL AND year LIKE ".$results['year']['year']."";
			$results[$district['id']]['info'] = $db->query_first($sql);
		}
		$db->close();
		return $results;
	}
	
	public static function homeView() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$year_sql = "SELECT * FROM kh_years WHERE used = 1";
		$results['year'] = $db->query_first($year_sql);
		$sql = "SELECT * FROM kh_districts ORDER BY title";
		$results['districts'] = $db->fetch_all_array($sql);
		$sql = "SELECT * FROM kh_types ORDER BY queue";
		$results['types'] = $db->fetch_all_array($sql);
		/*foreach($results['districts'] as $district) {
			$sql = "SELECT * FROM kh_infos WHERE district_id IS NOT NULL AND region_id IS NULL AND year LIKE ".$results['year']['year']."";
			$results['district_infos'][$district['id']] = $db->query_first($sql);
		}*/
		$sql = "SELECT * FROM kh_infos WHERE district_id IS NULL AND region_id IS NULL AND year LIKE ".$results['year']['year'];
		$results['city'] = $db->query_first($sql);
		foreach($results['districts'] as $district) {
			$sql = "SELECT * FROM kh_infos WHERE district_id LIKE ".$district['id']." AND region_id IS NULL AND year LIKE ".$results['year']['year'];
			$results[$district['id']]['info'] = $db->query_first($sql);
		}
		$db->close();
		return $results;
	}

	public static function districtView() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$year_sql = "SELECT * FROM kh_years WHERE used = 1";
		$results['year'] = $db->query_first($year_sql);
		$sql = "SELECT * FROM kh_districts ORDER BY title";
		$results['districts'] = $db->fetch_all_array($sql);
		$sql = "SELECT * FROM kh_types ORDER BY queue";
		$results['types'] = $db->fetch_all_array($sql);
		/*foreach($results['districts'] as $district) {
			$sql = "SELECT * FROM kh_infos WHERE district_id IS NOT NULL AND region_id IS NULL AND year LIKE ".$results['year']['year']."";
			$results['district_infos'][$district['id']] = $db->query_first($sql);
		}*/
		$sql = "SELECT * FROM kh_infos WHERE district_id IS NULL AND region_id IS NULL AND year LIKE ".$results['year']['year'];
		$results['city'] = $db->query_first($sql);
		foreach($results['districts'] as $district) {
			$sql = "SELECT * FROM kh_infos WHERE district_id LIKE ".$district['id']." AND region_id IS NULL AND year LIKE ".$results['year']['year'];
			$results[$district['id']]['info'] = $db->query_first($sql);
		}
		$db->close();
		return $results;
	}
	
	public static function deleteMyMarker($id, $user_id) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "DELETE FROM ".TABLE_MARKERS." WHERE id='".$id."' AND user_id = '".$user_id."'";
		$marker_id = $db->query($sql);
		$db->close();
		return $marker_id;
	}

	public static function deleteMarker($type, $marker) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "DELETE FROM ".TABLE_MARKERS." WHERE type_id='".$type."' AND latitude = '".$marker['latitude']."' AND longitude = '".$marker['longitude']."'";
		$marker_id = $db->query($sql);
		$db->close();
		return $marker_id;
	}
	
	function img_attachment($file) {
		$file_extension = pathinfo($file['name']);
		$new_name = rand(100, 999).'_'.date('YmdHis').'.'.$file_extension['extension'];
		move_uploaded_file($file['tmp_name'], realpath(dirname(__FILE__)).'/../webroot/marker_img/'.$new_name);
		return $new_name;
	}
	
	public function saveDesc($type, $marker, $username, $file) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM ".TABLE_MARKERS." WHERE type_id='".$type."' AND latitude = '".$marker['latitude']."' AND longitude = '".$marker['longitude']."'";
		$marker_info = $db->query_first($sql);
		if($marker_info != NULL) {
			$sql = "SELECT id FROM kh_users WHERE username LIKE '".$username."'";
			$user = $db->query_first($sql);
			$data['type_id'] = $type;
			if($marker['markertitle'] != NULL) {
				if($marker['markertitle'] != 'nothing') {
					$data['title'] = $marker['markertitle'];
				}	
			}
			if($marker['markerphone'] != NULL) {
				if($marker['markerphone'] != 'nothing') {
					$data['phone'] = $marker['markerphone'];
				}
			}
			if($marker['markeremail'] != NULL) {
				if($marker['markeremail'] != 'nothing') {
					$data['email'] = $marker['markeremail'];
				}
			}
			if($marker['markertext'] != NULL) {
				if($marker['markertext'] != 'nothing') {
					$data['description'] = $marker['markertext'];
				}
			}
			if(file_exists($file['image']['tmp_name'])) {
				$data['image'] =  $this->img_attachment($file['image']);	
			}
			$data['modified'] = date('Y-m-d H:i:s');
			$data['user_id'] = $user['id'];	
			$marker_id = $db->query_update(TABLE_MARKERS, $data, "id='".$marker_info['id']."'");
		}
		$db->close();
		return $marker_id;
	}
	
	public function saveDescription($type, $marker, $username, $file) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM ".TABLE_MARKERS." WHERE type_id='".$type."' AND latitude = '".$marker['latitude']."' AND longitude = '".$marker['longitude']."'";
		$marker_info = $db->query_first($sql);
		if($marker_info != NULL) {
			$sql = "SELECT id FROM kh_users WHERE username LIKE '".$username."'";
			$user = $db->query_first($sql);
			$data['type_id'] = $type;
			$data['title'] = $marker['title'];
			$data['phone'] = $marker['phone'];
			$data['email'] = $marker['email'];
			$data['description'] = $marker['description'];
			if(file_exists($file['image']['tmp_name'])) {
				$data['image'] =  $this->img_attachment($file['image']);	
			}
			$data['modified'] = date('Y-m-d H:i:s');
			$data['user_id'] = $user['id'];	
			$marker_id = $db->query_update(TABLE_MARKERS, $data, "id='".$marker_info['id']."'");
		}
		$db->close();
		return $marker_id;
	}

	public static function saveMarker($type, $marker, $username) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT id FROM kh_users WHERE username LIKE '".$username."'";
		$user = $db->query_first($sql);
		$data['type_id'] = $type; 
		$data['district_id'] = $marker['district_id'];
		$data['region_id'] = $marker['region_id'];
		$data['latitude'] = $marker['latitude'];
		$data['longitude'] = $marker['longitude'];
		$data['region_accepted'] = 1;
		$data['district_accepted'] = 1;
		$data['published'] = 1;
		$data['created'] = date('Y-m-d H:i:s');
		$data['modified'] = date('Y-m-d H:i:s');
		$data['user_id'] = $user['id'];
		$data['year'] = $marker['year'];
		$marker_id = $db->query_insert(TABLE_MARKERS, $data);
		$db->close();
		return $marker_id;
	}
	
	public static function civRegionMarkers($type, $region, $region_accept) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT latitude, longitude FROM ".TABLE_MARKERS."
				WHERE region_id LIKE ".$region." AND type_id LIKE ".$type." AND published LIKE 0 AND civ_created LIKE 1 AND region_accepted LIKE ".$region_accept."";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function civRegionMarkers1($type, $region, $region_accept) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT latitude, longitude FROM ".TABLE_MARKERS."
				WHERE region_id LIKE ".$region." AND type_id LIKE ".$type." AND published LIKE 1 AND civ_created LIKE 1 AND region_accepted LIKE ".$region_accept."";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function PublishedRegionMarker($type, $region, $user) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT latitude, longitude FROM ".TABLE_MARKERS."
				WHERE region_id LIKE ".$region." AND type_id LIKE ".$type." AND published LIKE 1 AND user_id LIKE ".$user."";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function nonPublishedRegionMarker($type, $region) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT latitude, longitude FROM ".TABLE_MARKERS."
				WHERE region_id LIKE ".$region." AND type_id LIKE ".$type." AND published LIKE 0";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function regionPanelMarkers($type, $region) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM ".TABLE_MARKERS."
				WHERE region_id LIKE ".$region." AND type_id LIKE ".$type." AND published LIKE 1";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function regionMarkers($type, $region) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT latitude, longitude FROM ".TABLE_MARKERS."
				WHERE region_id LIKE ".$region." AND type_id LIKE ".$type." AND published LIKE 1";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function regionYearMarkers($type, $region, $year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT latitude, longitude FROM ".TABLE_MARKERS."
				WHERE region_id LIKE ".$region." AND type_id LIKE ".$type." AND district_accepted = 1 AND region_accepted = 1 AND published LIKE 1 AND year <= ".$year."";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function getRegionMarkerInfo($type, $district) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_regions WHERE district_id LIKE ".$district."";
		$results['districts'] = $db->fetch_all_array($sql);
		foreach($results['districts'] as $district) {
			$sql = "SELECT kh_types.title as type, kh_types.image as image, COUNT(*)
				FROM ".TABLE_MARKERS."
				LEFT JOIN kh_types ON kh_markers.type_id=kh_types.id
				WHERE ".TABLE_MARKERS.".region_id LIKE ".$district['id']." AND type_id LIKE ".$type."";	
				$results[$district['id']]['count'] = $db->query_first($sql);
		}	
		$sql = "SELECT title, id, image, color FROM kh_types WHERE id LIKE ".$type."";
		$results['type'] =  $db->query_first($sql);
		$db->close();
		return $results;
	}
	
	public static function getMarkerInfo($type) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_districts";
		$results['districts'] = $db->fetch_all_array($sql);
		foreach($results['districts'] as $district) {
			$sql = "SELECT kh_types.title as type, kh_types.image as image, COUNT(*)
				FROM ".TABLE_MARKERS."
				LEFT JOIN kh_types ON kh_markers.type_id=kh_types.id
				WHERE ".TABLE_MARKERS.".district_id LIKE ".$district['id']." AND type_id LIKE ".$type."";	
				$results[$district['id']]['count'] = $db->query_first($sql);
		}	
		$sql = "SELECT title, id, image, color FROM kh_types WHERE id LIKE ".$type."";
		$results['type'] =  $db->query_first($sql);
		$db->close();
		return $results;
	}
	
	public static function allMarkers($type) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT image FROM kh_types WHERE id LIKE ".$type."";
		$results['image'] = $db->query_first($sql);
		$sql = "SELECT latitude, longitude FROM ".TABLE_MARKERS."
				WHERE type_id LIKE ".$type." AND published LIKE 1";
		$results['coordinate'] = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}
	
	public static function getDistrictInfoMarkers($type, $district, $year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_types WHERE id LIKE ".$type."";
		$results['type'] = $db->query_first($sql);
		$sql = "SELECT latitude, longitude, title, description, phone, email FROM ".TABLE_MARKERS."
				WHERE district_id LIKE ".$district." AND type_id LIKE ".$type." AND published LIKE 1 AND year <= ".$year."";
		$results['marker'] = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}
	
	public static function getDistrictMarkers($type, $district, $year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM kh_types WHERE id LIKE ".$type."";
		$results['type'] = $db->query_first($sql);
		$sql = "SELECT latitude, longitude FROM ".TABLE_MARKERS."
				WHERE district_id LIKE ".$district." AND type_id LIKE ".$type." AND published LIKE 1 AND year <= ".$year."";
		$results['marker'] = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}

	public static function districtMarkers($type, $district) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT * FROM ".TABLE_MARKERS."
				WHERE district_id LIKE ".$district." AND type_id LIKE ".$type." AND published LIKE 1";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public static function addRegionMarker($marker, $district, $region) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$results = array();
		$sql = "SELECT id, title FROM kh_districts
				WHERE id LIKE ".$district."";
		$results['district'] = $db->query_first($sql);
		$sql = "SELECT id, title, image FROM kh_regions
				WHERE id LIKE ".$region."";
		$results['region'] = $db->query_first($sql);
		$sql = "SELECT id, title, image FROM kh_types
				WHERE id LIKE ".$marker."";
		$results['type'] = $db->query_first($sql);
		$db->close();
		return $results;
	}

	public static function addDistrictMarker($marker, $district) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$results = array();
		$sql = "SELECT * FROM kh_districts
				WHERE id LIKE ".$district."";
		$results['district'] = $db->query_first($sql);
		$sql = "SELECT * FROM kh_regions
				WHERE district_id LIKE ".$district."
				ORDER BY kh_regions.title ASC";
		$results['regions'] = $db->fetch_all_array($sql);
		$sql = "SELECT id, title, image FROM kh_types
				WHERE id LIKE ".$marker."";
		$results['type'] = $db->query_first($sql);
		$db->close();
		return $results;
	}
	
	public static function getRegionborder($region) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT coordinate FROM kh_regionlines
				WHERE region_id LIKE ".$region."";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}

	public static function selectType($district) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$results = array();
		$sql = "SELECT id, title FROM kh_districts
				WHERE id LIKE ".$district."";
		$results['district'] = $db->query_first($sql);
		$sql = "SELECT id, title FROM kh_types
				ORDER BY kh_types.queue ASC";
		$results['types'] = $db->fetch_all_array($sql);
		$db->close();
		return $results;
	}
	
	public static function countRegionMarkers($district, $region) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT id, title FROM kh_districts WHERE id LIKE ".$district."";
		$results['district'] = $db->query_first($sql);
		$sql = "SELECT id, title FROM kh_regions 
				WHERE id LIKE ".$region."";
		$results['region'] = $db->query_first($sql);
		$sql = "SELECT kh_types.title as type, kh_types.image as image, kh_types.id as num, COUNT(*)
				FROM ".TABLE_MARKERS."
				LEFT JOIN kh_types ON kh_markers.type_id=kh_types.id
				WHERE ".TABLE_MARKERS.".region_id LIKE ".$region." AND kh_markers.district_accepted = 1 AND kh_markers.region_accepted = 1
				GROUP BY ".TABLE_MARKERS.".type_id";
		$results['count'] = $db->fetch_all_array($sql);	
		$db->close();
		return $results;
	}
	
	public static function countRegionMarks($district, $region, $type, $year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*)
				FROM kh_markers
				WHERE kh_markers.region_id LIKE ".$region." AND kh_markers.type_id LIKE ".$type." AND kh_markers.district_id LIKE ".$district." AND kh_markers.year <= ".$year."";
		$results = $db->query_first($sql);	
		$db->close();
		return $results;
	}

public static function countRegionMarkersAll($district, $region, $type, $year) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*)
				FROM kh_markers
				WHERE kh_markers.region_id LIKE ".$region." AND kh_markers.type_id LIKE ".$type." AND kh_markers.district_id LIKE ".$district." AND kh_markers.year <= ".$year." AND kh_markers.region_accepted = 1 AND kh_markers.district_accepted = 1";
		$results = $db->query_first($sql);	
		$db->close();
		return $results;
	}
	
	public static function countRegionYearMarkers($district, $region, $type) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*)
				FROM kh_markers
				WHERE kh_markers.region_id LIKE ".$region." AND kh_markers.type_id LIKE ".$type." AND kh_markers.district_id LIKE ".$district." AND kh_markers.region_accepted = 1 AND kh_markers.district_accepted = 1";
		$results = $db->query_first($sql);	
		$db->close();
		return $results;
	}
	
	public static function regionCountYearMarkers($region, $year, $type) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*)
				FROM kh_markers
				WHERE kh_markers.region_id LIKE ".$region." AND kh_markers.year <= ".$year." AND kh_markers.type_id LIKE ".$type."";
		$results = $db->query_first($sql);	
		$db->close();
		return $results;
	}
	
	public static function countDistrictYearMarkers($district, $year, $type) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*)
				FROM kh_markers
				WHERE kh_markers.year <= ".$year." AND kh_markers.type_id LIKE ".$type." AND kh_markers.district_id LIKE ".$district."";
		$results = $db->query_first($sql);	
		$db->close();
		return $results;
	}
	
	public static function countCityYearMarkers($year, $type) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT COUNT(*)
				FROM kh_markers
				WHERE kh_markers.year <= ".$year." AND kh_markers.type_id LIKE ".$type."";
		$results = $db->query_first($sql);	
		$db->close();
		return $results;
	}
	
	public static function countMarkers($district) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT id, title FROM kh_districts WHERE id LIKE ".$district."";
		$results['district'] = $db->query_first($sql);
		$sql = "SELECT kh_types.title as type, kh_types.id as typeid, kh_types.image as image, COUNT(*)
				FROM ".TABLE_MARKERS."
				LEFT JOIN kh_types ON kh_markers.type_id=kh_types.id
				WHERE ".TABLE_MARKERS.".district_id LIKE ".$district."
				GROUP BY ".TABLE_MARKERS.".type_id";
		$results['count'] = $db->fetch_all_array($sql);	
		$db->close();
		return $results;
	}
	
	public static function countAllMarkers() {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_types.title as type, kh_types.id as typeid, kh_types.image as image, COUNT(*)
				FROM ".TABLE_MARKERS."
				LEFT JOIN kh_types ON kh_markers.type_id=kh_types.id
				GROUP BY ".TABLE_MARKERS.".type_id";
		$results = $db->fetch_all_array($sql);	
		$db->close();
		return $results;
	}
	
	public function latestDistrictMarkers($limit, $district) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_districts.title as district, kh_regions.title as region, kh_types.title as type_title, kh_types.image as type_image, ".TABLE_MARKERS.".created FROM ".TABLE_MARKERS." 
				LEFT JOIN kh_regions ON ".TABLE_MARKERS.".region_id=kh_regions.id 
				LEFT JOIN kh_districts ON ".TABLE_MARKERS.".district_id=kh_districts.id
				LEFT JOIN kh_types ON ".TABLE_MARKERS.".type_id=kh_types.id
				WHERE kh_markers.district_id = ".$district."
				ORDER BY ".TABLE_MARKERS.".created DESC
				LIMIT ".$limit."";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
	public function latestMarkers($limit) {
		$db = new Database( DB_SERVER, DB_USER, DB_PASS, DB_DATABASE );
		$db->connect();
		$sql = "SELECT kh_districts.title as district, kh_regions.title as region, kh_types.title as type_title, kh_types.image as type_image, ".TABLE_MARKERS.".created FROM ".TABLE_MARKERS." 
				LEFT JOIN kh_regions ON ".TABLE_MARKERS.".region_id=kh_regions.id 
				LEFT JOIN kh_districts ON ".TABLE_MARKERS.".district_id=kh_districts.id
				LEFT JOIN kh_types ON ".TABLE_MARKERS.".type_id=kh_types.id
				ORDER BY ".TABLE_MARKERS.".created DESC
				LIMIT ".$limit."";
		$rows = $db->fetch_all_array($sql);
		$db->close();
		return $rows;
	}
	
} 

?>