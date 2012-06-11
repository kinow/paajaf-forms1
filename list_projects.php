<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>PAAJAF FOUNDATION - REGISTERED PROJECTS</title>
<!-- Le styles -->
<link rel="stylesheet" href="css/bootstrap.css" />
<link rel="stylesheet" href="css/forms.css" />
</head>
<body>
	<div class="container-fluid">
		<div id="header">
			<h1>Registered projects</h1>
		</div>
		<hr/>
<?php
# include the ActiveRecord library
require_once 'php-activerecord/ActiveRecord.php';
require_once 'model/projects.php';

ActiveRecord\Config::initialize(function($cfg)
{
	$cfg->set_model_directory('model');
	$cfg->set_connections(array('development' =>
			'mysql://root:admin@localhost/paajaf_forms'));
});

$projects = Project::all();

?>
<table class='table table-striped table-bordered'>
	<thead>
		<tr>
			<th>ID</th>
			<th>Organization</th>
			<th>Title</th>
			<th>Summary</th>
			<th>Location</th>
			<th>Category</th>
			<th>Issue</th>
			<th>Solution</th>
			<th>Long term</th>
			<th>Message</th>
			<th>Funding goal</th>
			<th>Report Title</th>
			<th>Report Message</th>
		</tr>
	</thead>
	<tbody>
<?php 
if(isset($projects) && count($projects) > 0) {
	foreach($projects as $project) {
		echo "<tr>";
		echo "<td>$project->id</td>";
		echo "<td>$project->organization_id</td>";
		echo "<td>$project->title</td>";
		echo "<td>$project->summary</td>";
		echo "<td>$project->location_id</td>";
		echo "<td>$project->category_id</td>";
		echo "<td>$project->issue_problem_challenge</td>";
		echo "<td>$project->how_this_project_helps</td>";
		echo "<td>$project->long_term_impacts</td>";
		echo "<td>$project->message</td>";
		echo "<td>$project->funding_goal</td>";
		echo "<td>$project->report_title</td>";
		echo "<td>$project->report_message</td>";
		echo "</tr>";
	}
}
?>
	</tbody>
</table>
</div>
</body>
</html>