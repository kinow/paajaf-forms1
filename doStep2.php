<?php
session_start();
# include the ActiveRecord library
require_once 'php-activerecord/ActiveRecord.php';
require_once 'model/projects.php';

ActiveRecord\Config::initialize(function($cfg)
{
	$cfg->set_model_directory('model');
	$cfg->set_connections(array('development' =>
					'mysql://root:admin@localhost/paajaf_forms'));
});

// required fields
$keys = array('title', 'location', 'category', 'summary', 'organization');
foreach($keys as $key) {
	if(!array_key_exists($key, $_POST) || empty($_POST[$key])) {
		$_SESSION['error'] = 'Missing required parameter.';
		header('Location: step2.php');
	} 
}

// CSRF
if (!isset($_SESSION['token'])){
	$_SESSION['error'] = 'Error CSRF.';
	$_SESSION['token'] = md5(uniqid(rand(), TRUE));
	$_SESSION['token_time'] = time();
}

// Protecting data inserted into MySQL
function filter_data($val) {
  return htmlentities($val,ENT_QUOTES);
}
$clean=array_map("filter_data",$_POST);

if ($clean['token'] == $_SESSION['token']) {
	$token_age = time() - $_SESSION['token_time'];
	if ($token_age <= 300) { // 5 min
		$title = $clean['title'];
		if(isset($title) && !empty($title)) {
			//$photo = $clean['photo']; // TODO: upload photoS
			$organization_id = $clean['organization'];
			$title = $clean['title'];
			$location_id = $clean['location'];
			$category_id = $clean['category'];
			$summary = $clean['summary'];
			$issue = $clean['question1'];
			$solution = $clean['question2'];
			$long_term = $clean['long_term'];
			$message = $clean['message'];
			$funding = $clean['funding'];
			$report_title = $clean['title2'];
			$report_message = $clean['report'];
			
			$attributes = array(
				'organization_id' => $organization_id,
				'title' => $title,
				'location_id' => $location_id, 
				'category_id' => $category_id, 
				'summary' => $summary, 
				'issue_problem_challenge' => $issue, 
				'how_this_project_helps' => $solution, 
				'long_term_impacts' => $long_term, 
				'message' => $message, 
				'funding_goal' => $funding, 
				'report_title' => $report_title, 
				'report_message' => $report_message
			);
			$error;
			try {
				$project = Project::create($attributes, true);
			} catch( Exception $e ) {
				$error = $e->getMessage();
			}
			if(isset($project) && $project) {
				$_SESSION['project'] = $project->id; // TBD: display in the UI?
				header('Location: thanks.php');
			} else {
				if(isset($error) && !empty($error)) {
					$_SESSION['error'] = 'Error inserting project : ' . $error;
				} else {
					$_SESSION['error'] = 'Error inserting project';
				}
				header( 'Location: step2.php' ) ;
			}
			// TODO redirect to step2, setting a flag in the session
			
		} else {
			$_SESSION['error'] = 'Invalid parameters';
			header( 'Location: step2.php' ) ;
		}
	} else {
		$_SESSION['error'] = 'Missing parameters';
		header( 'Location: step2.php' ) ;
	}
} else {
	header( 'Location: step2.php' ) ;
}
?>