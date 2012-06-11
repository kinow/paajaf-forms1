<?php
session_start();
# include the ActiveRecord library
require_once 'php-activerecord/ActiveRecord.php';
require_once 'model/organizations.php';

ActiveRecord\Config::initialize(function($cfg)
{
	$cfg->set_model_directory('model');
	$cfg->set_connections(array('development' =>
					'mysql://root:admin@localhost/paajaf_forms'));
});

$keys = array('title', 'summary', 'address');
foreach($keys as $key) {
	if(!array_key_exists($key, $_POST) || empty($_POST[$key])) {
		$_SESSION['error'] = 'Missing required parameter.';
		header('Location: index.php');
	} 
}

if (!isset($_SESSION['token'])){
	$_SESSION['error'] = 'Error CSRF.';
	$_SESSION['token'] = md5(uniqid(rand(), TRUE));
	$_SESSION['token_time'] = time();
}

function filter_data($val) {
  return htmlentities($val,ENT_QUOTES);
}

$clean=array_map("filter_data",$_POST);

if ($clean['token'] == $_SESSION['token']) {
	$token_age = time() - $_SESSION['token_time'];
	if ($token_age <= 300) { // 5 min
		$title = $clean['title'];
		if(isset($title) && !empty($title)) {
			//$photo = $clean['photo']; // TODO: upload photo
			$summary = $clean['summary'];
			$day = $clean['day'];
			$month = $clean['month'];
			$year = $clean['year'];
			$employee = $clean['employee'];
			$volunteer = $clean['volunteer'];
			$address = $clean['address'];
			$website = $clean['website'];
			$director = $clean['director'];
			$management = $clean['management'];
			$board = $clean['board'];
			$missions = $clean['missions'];
			$programs = $clean['programs'];
			$report_title = $clean['title2'];
			$report_message = $clean['report'];
			
			$date = null;
			if($day > 0 && $month > 0 && $year > 0 ) {
				$date = new DateTime("$year-$month-$day");
			}
						
			$attributes = array(
				'title' => $title,
				//'logo_location' => $photo,
				'summary' => $summary, 
				'founded_date' => $date, 
				'employee' => $employee, 
				'volunteer' => $volunteer, 
				'address' => $address, 
				'url' => $website, 
				'executive_director' => $director, 
				'management_team' => $management, 
				'board_director' => $board, 
				'missions' => $missions, 
				'programs' => $programs, 
				'report_title' => $report_title, 
				'report_message' => $report_message
			);
			$error;
			try {
				$organization = Organization::create($attributes, true);
			} catch( Exception $e ) {
				$error = $e->getMessage();
			}
			if($organization) {
				$_SESSION['organization'] = $organization->id;
				header('Location: step2.php');
			} else {
				if(isset($error) && !empty($error)) {
					$_SESSION['error'] = 'Error inserting organization : ' . $error;
				} else {
					$_SESSION['error'] = 'Error inserting organization';
				}
				header( 'Location: index.php' ) ;
			}
			// TODO redirect to step2, setting a flag in the session
			
		} else {
			$_SESSION['error'] = 'Invalid parameters';
			header( 'Location: index.php' ) ;
		}
	} else {
		$_SESSION['error'] = 'Missing parameters';
		header( 'Location: index.php' ) ;
	}
} else {
	header( 'Location: index.php' ) ;
}
?>