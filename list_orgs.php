<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>PAAJAF FOUNDATION - REGISTERED ORGANIZATIONS</title>
<!-- Le styles -->
<link rel="stylesheet" href="css/bootstrap.css" />
<link rel="stylesheet" href="css/forms.css" />
</head>
<body>
	<div class="container-fluid">
		<div id="header">
			<h1>Registered organizations</h1>
		</div>
		<hr/>
<?php
# include the ActiveRecord library
require_once 'php-activerecord/ActiveRecord.php';
require_once 'model/organizations.php';

ActiveRecord\Config::initialize(function($cfg)
{
	$cfg->set_model_directory('model');
	$cfg->set_connections(array('development' =>
			'mysql://root:admin@localhost/paajaf_forms'));
});

$orgs = Organization::all();

?>
<table class='table table-striped table-bordered'>
	<thead>
		<tr>
			<th>ID</th>
			<th>Title</th>
			<th>Logo</th>
			<th>Summary</th>
			<th>Foundation</th>
			<th>Employee</th>
			<th>Volunteer</th>
			<th>Address</th>
			<th>URL</th>
			<th>Executive Director</th>
			<th>Management Team</th>
			<th>Board Director</th>
			<th>Missions</th>
			<th>Programs</th>
			<th>Report Title</th>
			<th>Report Message</th>
		</tr>
	</thead>
	<tbody>
<?php 
if(isset($orgs) && count($orgs) > 0) {
	foreach($orgs as $org) {
		echo "<tr>";
		echo "<td>$org->id</td>";
		echo "<td>$org->title</td>";
		echo "<td>$org->logo_location</td>";
		echo "<td>$org->summary</td>";
		if(isset($org->founded_date) && $org->founded_date) {
			echo "<td>". $org->founded_date->format( 'Y-m-d' )."</td>";
		}else {
			echo "<td></td>";
		}
		echo "<td>$org->employee</td>";
		echo "<td>$org->volunteer</td>";
		echo "<td>$org->address</td>";
		echo "<td>$org->url</td>";
		echo "<td>$org->executive_director</td>";
		echo "<td>$org->management_team</td>";
		echo "<td>$org->board_director</td>";
		echo "<td>".html_entity_decode($org->missions)."</td>";
		echo "<td>$org->programs</td>";
		echo "<td>$org->report_title</td>";
		echo "<td>$org->report_message</td>";
		echo "</tr>";
	}
}
?>
	</tbody>
</table>
</div>
</body>
</html>